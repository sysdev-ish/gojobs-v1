<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Hiring;
use app\models\Mappingregionarea;

/**
 * Hiringsearch represents the model behind the search form of `app\models\Hiring`.
 */
class Joborderreport extends Transrincian
{

  public $typejo;
  public $startjo;
  public $endjo;
  public $area;
  public $personalarea;
  public $status;
  public $areaish;
  public $region;
  public $jobfamily;
  public $subjobfamily;
  /**
   * @inheritdoc
   */
  public function rules()
  {
    return [
      // [['startjo','endjo'], 'required'],
      [['typejo', 'type_rekrut', 'status'], 'integer'],
      [['startjo', 'endjo', 'area', 'personalarea', 'tanggal', 'areaish', 'region', 'jobfamily', 'subjobfamily'], 'safe'],
    ];
  }

  /**
   * @inheritdoc
   */
  public function scenarios()
  {
    // bypass scenarios() implementation in the parent class
    return Model::scenarios();
  }

  /**
   * Creates data provider instance with search query applied
   *
   * @param array $params
   *
   * @return ActiveDataProvider
   */
  public function search($params)
  {
    $query = Transrincian::find();
    $query->joinWith("jobfunc");
    $query->joinWith("transjo");
    $query->joinWith("persasap");
    $query->joinWith("areasap");
    $query->andWhere('trans_rincian_rekrut.skema = 1');
    $query->andWhere('trans_rincian_rekrut.typejo <> 3');

    //Add by pwd
    //Add by pwd 2022-05-31
    // $query->leftJoin('recruitment.mappingjob', 'recruitment.mappingjob.kodejabatan = trans_rincian_rekrut.hire_jabatan_sap');
    // $query->leftJoin('recruitment.mastersubjobfamily', 'recruitment.mastersubjobfamily.id = mappingjob.subjobfamilyid');
    // $query->leftJoin('recruitment.masterjobfamily', 'recruitment.masterjobfamily.id = mastersubjobfamily.jobfamily_id');

    //Add by pwd 2022-05-31
    $subQuery = 'SELECT kodejabatan 
        FROM recruitment.mappingjob
        LEFT JOIN recruitment.mastersubjobfamily ON mastersubjobfamily.id = mappingjob.subjobfamilyid
        LEFT JOIN recruitment.masterjobfamily ON masterjobfamily.id = mastersubjobfamily.jobfamily_id';

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
      'sort' => ['defaultOrder' => ['nojo' => SORT_DESC]],
      'pagination' => [
        'pageSize' => 10,
      ],
    ]);
    $this->load($params);
    if (!$this->validate()) {
      return $dataProvider;
    }
    $query->andFilterWhere(['between', 'trans_jo.tanggal', $this->startjo, $this->endjo]);
    $query->andFilterWhere([
      'trans_rincian_rekrut.persa_sap' => $this->personalarea,
      'trans_rincian_rekrut.typejo' => $this->typejo,
      'trans_rincian_rekrut.status_rekrut' => $this->status,
      'saparea.areaid' => $this->areaish,
    ]);
    if ($this->region <> 0) {
      $query->andFilterWhere([
        'saparea.regionalid' => $this->region,
      ]);
    }
    if ($this->area) {
      $areas = '"' . implode('","', $this->area) . '"';
      $query->andWhere('trans_rincian_rekrut.area_sap IN (' . $areas . ')');
    }
    $totalkebutuhan = $this->totalkebutuhan($dataProvider);
    $alldata = [
      'dataProvider' => $dataProvider,
      'totalkebutuhan' => $totalkebutuhan,
      // 'totalpemenuhan' => $totalpemenuhan,
    ];

    //Add by pwd -> pakai relasi buat filternya karena jika implode parsing data bakal habisin memory & kurang optimal

    if ($this->subjobfamily) {
      //server sama
      // $query->andWhere('mastersubjobfamily.id = :id', [':id' => $this->subjobfamily]);

      //server beda
      //Add by pwd 2022-05-31
      $subQuery .= ' WHERE mastersubjobfamily.id = :id';
      $subQuery = Yii::$app->db->createCommand($subQuery)->bindValue(':id', $this->subjobfamily)->queryAll();
      // var_dump($subQuery);die;
      if ($subQuery) {
        $arrValue = [];
        //kalo arrValue null gabisa return kosong -> return data semuanya
        foreach ($subQuery as $sq) {
          $arrValue[] = $sq['kodejabatan'];
        }
        if (count($arrValue) > 0) {
          $query->andWhere('trans_rincian_rekrut.hire_jabatan_sap IN (' . implode(',', $arrValue) . ')', []);
        }
      }
      else {
        $query->andWhere('trans_rincian_rekrut.hire_jabatan_sap IN (null)');
      }
    } elseif ($this->jobfamily) {
      //server sama
      // $query->andWhere('masterjobfamily.id = :id', [':id' => $this->jobfamily]);
      
      //server beda
      //Add by pwd 2022-05-31
      $subQuery .= ' WHERE masterjobfamily.id = :id';
      $subQuery = Yii::$app->db->createCommand($subQuery)->bindValue(':id', $this->jobfamily)->queryAll();
      if ($subQuery) {
        $arrValue = [];
        foreach ($subQuery as $sq) {
          $arrValue[] = $sq['kodejabatan'];
        }
        if (count($arrValue) > 0) $query->andWhere('trans_rincian_rekrut.hire_jabatan_sap IN (' . implode(',', $arrValue) . ')', []);
      } else {
        $query->andWhere('trans_rincian_rekrut.hire_jabatan_sap IN (null)');
      }
    }

    return $alldata;
  }

  protected function byregionarea()
  {
    $ret = null;
    $mappingregionarea = Mappingregionarea::find();

    if ($this->region <> "all") {
      $mappingregionarea->andWhere([
        'areaishid' => $this->areaish,
        'regionid' => $this->region,
      ]);
    } else {
      $mappingregionarea->andWhere([
        'areaishid' => $this->areaish,
      ]);
    }
    $mappingregionareaquery = $mappingregionarea->all();
    if ($mappingregionareaquery) {
      $areaid = array();
      foreach ($mappingregionareaquery as $value) {
        $areaid[] = $value->areaid;
      }
      $ret = $areaid;
    }
    return $ret;
  }

  protected function totalkebutuhan($dataProvider)
  {
    $mySum = $dataProvider->query->sum('jumlah');
    return $mySum;
  }

  protected function totalpemenuhan($dataProvider)
  {
    $trincian = $dataProvider->query->all();
    $mySum = 0;
    foreach ($trincian as $item) {
      $checkhiring = Hiring::find()->where(['recruitreqid' => $item['id'], 'statushiring' => [3, 4, 7, 8]])->count();
      // var_dump($item['lup']);die;\
      if ($checkhiring > 0) {
        $mySum += $checkhiring;
      }
    }
    return $mySum;
  }

  public function attributeLabels()
  {
    return [
      'typejo' => 'Type JO',
      'type_rekrut' => 'Type Rekrut',
      'status' => 'Status',
      'startjo' => 'Periode Create Job Order',
      'area' => 'Area',
      'personalarea' => 'Personal Area',
      'areaish' => 'Area ISH',
      'region' => 'Region',
      'jobfamily' => 'Job Family',
      'subjobfamily' => 'Sub Job Family',
    ];
  }
}
