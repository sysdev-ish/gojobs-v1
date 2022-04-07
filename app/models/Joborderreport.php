<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Hiring;
use app\models\Mappingregionarea;
use app\models\Masterjobfamily;
use app\models\Mastersubjobfamily;

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
            [['typejo','status'], 'integer'],
            [['startjo','endjo','area','personalarea','tanggal','areaish','region','jobfamily','subjobfamily'], 'safe'],
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
        if($this->region <> 0){
          $query->andFilterWhere([
              'saparea.regionalid' => $this->region,
          ]);
        }
        // $query->andFilterWhere(['like', 'jobfamily', $this->jobfamilyid])
        // ->andFilterWhere(['like', 'subjobfamily', $this->subjobfamilyid]);

        if($this->area){
          $areas = '"'.implode('","', $this->area).'"';
          $query->andWhere('trans_rincian_rekrut.area_sap IN (' . $areas . ')');
        }
        $totalkebutuhan = $this->totalkebutuhan($dataProvider);
        $alldata = [
          'dataProvider' => $dataProvider,
          'totalkebutuhan' => $totalkebutuhan,
          // 'totalpemenuhan' => $totalpemenuhan,
        ];

        if ($this->jobfamily) {
          $getjobfamilyid = $this->byjobfamily();
          if ($getjobfamilyid) {
            $getjobfamilyid = '"' . implode('","', $getjobfamilyid) . '"';
            $query->andWhere('id IN (' . $getjobfamilyid . ')');
          }
        }

        if ($this->subjobfamily) {
          $getsubjobfamilyid = $this->bysubjobfamily();
          if ($getsubjobfamilyid) {
            $getsubjobfamilyid = '"' . implode('","', $getsubjobfamilyid) . '"';
            $query->andWhere('id IN (' . $getsubjobfamilyid . ')');
          }
        }

        return $alldata;
    }

    //search value from db byvalue()
    protected function byjobfamily()
    {
      $ret = null;
      // $jobfamily = Masterjobfamily::find();
      if ($this->jobfamily) {
        $getjobfamilyid = Masterjobfamily::find()->andWhere('jobfamily LIKE :jobfamily', [':jobfamily' => '%' . $this->jobfamily . '%'])->all();
        if ($getjobfamilyid) {
          $jobfamilyid = array();
          foreach ($getjobfamilyid as $value) {
            $jobfamilyid[] = $value->id;
          }
          $ret = $jobfamilyid;
        }
      }
      return $ret;
    }

    protected function bysubjobfamily()
    {
      $ret = null;
      // $jobfamily = Mastersubjobfamily::find();
      if ($this->subjobfamily) {
        $getsubjobfamilyid = Mastersubjobfamily::find()->andWhere('subjobfamily LIKE :subjobfamily', [':subjobfamily' => '%' . $this->subjobfamily . '%'])->all();
        if ($getsubjobfamilyid) {
          $subjobfamilyid = array();
          foreach ($getsubjobfamilyid as $value) {
            $subjobfamilyid[] = $value->id;
          }
          $ret = $subjobfamilyid;
        }
      }
      return $ret;
    }

    protected function byregionarea(){
        $ret = null;
        $mappingregionarea = Mappingregionarea::find();

        if($this->region <> "all"){
          $mappingregionarea->andWhere([
              'areaishid' => $this->areaish,
              'regionid' => $this->region,
          ]);
        }else{
          $mappingregionarea->andWhere([
              'areaishid' => $this->areaish,
          ]);
        }
        $mappingregionareaquery = $mappingregionarea->all();
        if($mappingregionareaquery){
            $areaid = array();
            foreach($mappingregionareaquery as $value){
                $areaid[] = $value->areaid;
            }
            $ret = $areaid;
        }
      return $ret;
    }

    protected function totalkebutuhan($dataProvider){
      $mySum = $dataProvider->query->sum('jumlah');
      return $mySum;
    }

    protected function totalpemenuhan($dataProvider){
      $trincian = $dataProvider->query->all();
      $mySum = 0;
      foreach ($trincian as $item) {
        $checkhiring = Hiring::find()->where(['recruitreqid'=>$item['id'],'statushiring'=>[3,4,7,8]])->count();
        // var_dump($item['lup']);die;\
        if($checkhiring > 0){
          $mySum += $checkhiring;
        }
      }

      return $mySum;
    }
    public function attributeLabels()
    {
        return [
            'typejo' => 'Type JO',
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
