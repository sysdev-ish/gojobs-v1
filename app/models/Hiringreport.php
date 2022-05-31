<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Hiring;
use linslin\yii2\curl;


/**
 * Hiringsearch represents the model behind the search form of `app\models\Hiring`.
 */
class Hiringreport extends Hiring
{
  public $fullname;
  public $nojo;
  public $typejo;
  public $startawalkontrak;
  public $endawalkontrak;
  public $area;
  public $personalarea;
  public $jabatan;
  public $sap;
  public $status;
  public $areaish;
  public $region;
  public $statuspekerja;
  public $startresign;
  public $endresign;
  public $jobfamily;
  public $subjobfamily;

  /**
   * @inheritdoc
   */
  public function rules()
  {
    return [
      // [['startawalkontrak','endawalkontrak'], 'required'],
      [['id', 'userid', 'perner', 'statushiring', 'statusbiodata', 'typejo', 'nojo', 'sap', 'statuspekerja'], 'integer'],
      [[
        'createtime', 'updatetime', 'fullname', 'startawalkontrak', 'endawalkontrak', 'area', 'personalarea', 'jabatan', 'areaish', 'region', 'startresign', 'endresign', 'jobfamily', 'subjobfamily'
      ], 'safe'],
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
    $query = Hiring::find();
    $query->joinWith("userprofile");
    // $query->joinWith("useredu");
    // $query->joinWith("recrequest");

    //Add by pwd
    //Add by pwd 2022-05-31
    /*$query->leftJoin('ish_catalog_baru.trans_rincian_rekrut', 'trans_rincian_rekrut.id = hiring.recruitreqid');
        $query->leftJoin('mappingjob', 'mappingjob.kodejabatan = trans_rincian_rekrut.hire_jabatan_sap');
        $query->leftJoin('mastersubjobfamily', 'mastersubjobfamily.id = mappingjob.subjobfamilyid');
        $query->leftJoin('masterjobfamily', 'masterjobfamily.id = mastersubjobfamily.jobfamily_id');*/

    // add conditions that should always apply here

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
      'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
    ]);


    $this->load($params);
    // $query->where('statushiring = 7');

    if ($this->sap <> 2) {
      // var_dump($this->sap);die;
      //$query->where('statushiring = 4 or statushiring = 7 or (typejo = 2 and statushiring = 8)');
      //Add by pwd
      $query->where('statushiring = 4 or statushiring = 7 or (hiring.typejo = 2 and statushiring = 8)');
    } else {
      // var_dump($this->sap);die;
      $query->where('statushiring <> 5 and statushiring <> 1');
    }

    if (!$this->validate()) {
      return $dataProvider;
    }

    $datenow = date('Y-m-d');

    $query->andFilterWhere(['like', 'fullname', $this->fullname]);
    if ($this->startawalkontrak and $this->endawalkontrak) {
      $query->andFilterWhere(['between', 'awalkontrak', $this->startawalkontrak, $this->endawalkontrak]);
    } else {
      if (!$this->startresign and !$this->endresign) {
        //   $this->startawalkontrak = $datenow;
        //   $this->endawalkontrak = $datenow;
        //   $query->andFilterWhere(['between', 'awalkontrak', $datenow, $datenow]);
        $query->where('0=1');
      }
    }

    $query->andFilterWhere([
      'typejo' => $this->sap,
    ]);

    if ($this->area or $this->jabatan or $this->personalarea) {
      $param = [
        'area' => $this->area,
        'jabatan' => $this->jabatan,
        'personalarea' => $this->personalarea,
      ];
      $getJoId = $this->joBycriteria($params);
      if ($getJoId) {
        $getJoid = implode(',', $getJoId);
      } else {
        $getJoid = 0;
      }
      $query->andWhere('recruitreqid IN (' . $getJoid . ')');
    }
    if ($this->areaish or $this->region) {
      $getJoIdbyareaish = $this->byregionarea();
      // var_dump($getJoIdbyareaish);die;
      if ($getJoIdbyareaish) {
        $getJoIdbyareaish = implode(',', $getJoIdbyareaish);
      } else {
        $getJoIdbyareaish = 0;
      }
      $query->andWhere('recruitreqid IN (' . $getJoIdbyareaish . ')');
    }
    if ($this->startresign and $this->endresign) {
      $getPerner = $this->byResigndate();
      // var_dump($getJoIdbyareaish);die;
      if ($getPerner) {
        $getPerner = implode(',', $getPerner);
      } else {
        $getPerner = 0;
      }
      $query->andWhere('perner IN (' . $getPerner . ')');
    }

    //Add by pwd 2022-05-31
    $subQuery = 'SELECT kodejabatan 
        FROM recruitment_dev.mappingjob
        LEFT JOIN recruitment_dev.mastersubjobfamily ON mastersubjobfamily.id = mappingjob.subjobfamilyid
        LEFT JOIN recruitment_dev.masterjobfamily ON masterjobfamily.id = mastersubjobfamily.jobfamily_id';

    //Add by pwd -> pakai relasi buat filternya karena jika implode parsing data bakal habisin memory & kurang optimal
    if ($this->subjobfamily) {
      //$query->andWhere('mastersubjobfamily.id = :id', [':id' => $this->subjobfamily]);

      //Add by pwd 2022-05-31
      $subQuery .= ' WHERE mastersubjobfamily.id = :id';
      $subQuery = Yii::$app->db->createCommand($subQuery)->bindValue(':id', $this->subjobfamily)->queryAll();
      if ($subQuery) {

        $arrValue = [];
        foreach ($subQuery as $sq) {
          $arrValue[] = $sq['kodejabatan'];
        }

        if (count($arrValue) > 0) {
          $sQueryJo = 'SELECT id FROM trans_rincian_rekrut WHERE hire_jabatan_sap IN (' . implode(',', $arrValue) . ')';
          $getTrr = Yii::$app->dbjo->createCommand($sQueryJo)->queryAll();
          if ($getTrr) {
            $arrValueJo = [];
            foreach ($getTrr as $gttr) {
              $arrValueJo[] = $gttr['id'];
            }
            if (count($arrValueJo) > 0) $query->andWhere('hiring.recruitreqid IN (' . implode(',', $arrValueJo) . ')', []);
          }
        }
      }
    } elseif ($this->jobfamily) {
      //$query->andWhere('masterjobfamily.id = :id', [':id' => $this->jobfamily]);

      //Add by pwd 2022-05-31
      $subQuery .= ' WHERE masterjobfamily.id = :id';
      $subQuery = Yii::$app->db->createCommand($subQuery)->bindValue(':id', $this->jobfamily)->queryAll();
      if ($subQuery) {

        $arrValue = [];
        foreach ($subQuery as $sq) {
          $arrValue[] = $sq['kodejabatan'];
        }

        if (count($arrValue) > 0) {
          $sQueryJo = 'SELECT id FROM trans_rincian_rekrut WHERE hire_jabatan_sap IN (' . implode(',', $arrValue) . ')';
          $getTrr = Yii::$app->dbjo->createCommand($sQueryJo)->queryAll();
          if ($getTrr) {
            $arrValueJo = [];
            foreach ($getTrr as $gttr) {
              $arrValueJo[] = $gttr['id'];
            }
            if (count($arrValueJo) > 0) $query->andWhere('hiring.recruitreqid IN (' . implode(',', $arrValueJo) . ')', []);
          }
        }
      }
    }

    $bypersonalarea = $this->joGroupBypersa($params, $dataProvider);
    $byedusd = $this->dataGroupByedusd($params, $dataProvider, 1);
    $byedusmp = $this->dataGroupByedusd($params, $dataProvider, 2);
    $byedusma = $this->dataGroupByedusd($params, $dataProvider, 3);
    $byedusmp = $this->dataGroupByedusd($params, $dataProvider, 4);
    $byedud3 = $this->dataGroupByedusd($params, $dataProvider, 5);
    $byedus1 = $this->dataGroupByedusd($params, $dataProvider, 6);
    $byedus2 = $this->dataGroupByedusd($params, $dataProvider, 7);
    $byedus3 = $this->dataGroupByedusd($params, $dataProvider, 8);

    $alldata = [
      'dataProvider' => $dataProvider,
      'bypersonalarea' => $bypersonalarea,
      'byedusd' => $byedusd,
      'byedusmp' => $byedusmp,
      'byedusma' => $byedusma,
      'byedud3' => $byedud3,
      'byedus1' => $byedus1,
      'byedus2' => $byedus2,
      'byedus3' => $byedus3,
    ];

    return $alldata;
  }
  protected function byResigndate()
  {
    $ret = null;
    $start = str_replace("-", "", $this->startresign);
    $end = str_replace("-", "", $this->endresign);

    $curl = new curl\Curl();
    $getdatapekerjabyresigndate =  $curl->setPostParams([
      'token' => 'ish**2019',
      'start' => $start,
      'end' => $end,
    ])
      ->post('http://192.168.88.5/service/index.php/sap_profile/getdatabyresign');
    $datapekerjabyresigndate  = json_decode($getdatapekerjabyresigndate);
    // $datapekerjabyresigndate  = implode(',', $getdatapekerjabyresigndate);
    if ($datapekerjabyresigndate) {
      $ret = $datapekerjabyresigndate;
    }
    // var_dump($ret);die;
    return $ret;
  }
  protected function joGroupBypersa($param, $dataProvider)
  {

    $hiring = $dataProvider->query->all();
    $transRincianIds = array();
    if ($hiring) {

      foreach ($hiring as $tr) {
        $transRincianIds[] = $tr->recruitreqid;
      }
    }

    $transRincian = Transrincian::find();
    if ($transRincianIds) {
      $transRincianIds = implode(',', $transRincianIds);
    } else {
      $transRincianIds = 0;
    }
    $dataProvider = new ActiveDataProvider([
      'query' => $transRincian,
      'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
    ]);
    if (!$this->validate()) {
      // uncomment the following line if you do not want to return any records when validation fails

      return $dataProvider;
    }
    $transRincian->andWhere('id IN (' . $transRincianIds . ')');
    $transRincian->groupBy('persa_sap');
    // $transRincianquery = $transRincian->all();

    return $dataProvider;
  }

  protected function dataGroupByedusd($param, $dataProvider, $leveledu)
  {
    $hiring = $dataProvider->query->all();
    // var_dump($hiring);die;
    $useredu = array();
    if ($hiring) {
      foreach ($hiring as $val) {
        $useredu[] = $val->userid;
      }
    }

    $usereducation = Userformaleducation::find()->select('max(educationallevel) as maxedu, userid');
    if ($usereducation) {
      $usereducations = implode(',', $useredu);
    } else {
      $usereducations = 0;
    }
    // var_dump($usereducations);die;
    $dataProvider = new ActiveDataProvider([
      'query' => $usereducation,
    ]);
    if (!$this->validate()) {
      // uncomment the following line if you do not want to return any records when validation fails

      return $dataProvider;
    }
    if ($usereducations == 0) {
      $dataProvider = 0;
    } else {
      $usereducation->andWhere('userid IN (' . $usereducations . ')');
      $usereducation->groupBy('userid');
      $usereducation->having('maxedu = ' . $leveledu);
    }
    return $dataProvider;
  }

  protected function joBycriteria($param)
  {
    $ret = null;
    $transRincian = Transrincian::find();
    if ($this->area) {

      $areas = '"' . implode('","', $this->area) . '"';
      // var_dump($areas);die;
      // $transRincian->andWhere([
      //     'area_sap' => $this->area,
      // ]);
      $transRincian->andWhere('area_sap IN (' . $areas . ')');
    }
    if ($this->jabatan) {
      $transRincian->andWhere([
        'hire_jabatan_sap' => $this->jabatan,
      ]);
    }
    if ($this->personalarea) {
      $transRincian->andWhere([
        'persa_sap' => $this->personalarea,
      ]);
    }
    $transRincianquery = $transRincian->all();
    if ($transRincianquery) {
      $transRincianIds = array();
      foreach ($transRincianquery as $tr) {
        $transRincianIds[] = $tr->id;
      }
      $ret = $transRincianIds;
    }
    return $ret;
  }

  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'userid' => 'Userid',
      'createtime' => 'Hiring time',
      'updatetime' => 'Updatetime',
      'perner' => 'Perner',
      'statushiring' => 'Hiring Status',
      'statusbiodata' => 'Update Data Status',
      'message' => 'SAP Message',
      'keterangan' => 'Remarks',
      'fullname' => 'Full Name',
      'tglinput' => 'Join Date',
      'awalkontrak' => 'Awal Kontrak',
      'akhirkontrak' => 'Akhir Kontrak',
      'createdby' => 'Created by',
      'updateby' => 'Updated by',
      'approvedby' => 'Approve by',
      'startawalkontrak' => 'Periode Awal Kontrak',
      'sap' => 'SAP',
      'areaish' => 'Area ISH',
      'region' => 'Region',
      'startresign' => 'Periode Resign',
      'jobfamily' => 'Job Family',
      'subjobfamily' => 'Sub Job Family',
      'type_rekrut' => 'Type Rekrut',
    ];
  }
}
