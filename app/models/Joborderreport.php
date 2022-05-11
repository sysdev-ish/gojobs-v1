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
          $getJobId = $this->byjobfamily($this->jobfamily);
          // var_dump($getJobId);die;
          if ($getJobId) {   
            $getJobid = implode(',', $getJobId);
            $query->andWhere('trans_rincian_rekrut.id IN (' . $getJobid . ')');
          }
        }

        if ($this->subjobfamily) {
          $getSubjobId = $this->bysubjobfamily($this->subjobfamily);
          if ($getSubjobId) {
            $getSubjobid = implode(',', $getSubjobId);
            $query->andWhere('trans_rincian_rekrut.id IN (' . $getSubjobid . ')');
          }
        }

        return $alldata;
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

    protected function byjobfamily($jobfamily = null)
    {
      $ret = null;
      if ($jobfamily) {

        $query = Transrincian::find();
        $query->leftJoin('recruitment_dev.mappingjob', 'mappingjob.kodejabatan = trans_rincian_rekrut.hire_jabatan_sap');
        $query->leftJoin('recruitment_dev.mastersubjobfamily', 'mastersubjobfamily.id = mappingjob.subjobfamilyid');
        $query->leftJoin('recruitment_dev.masterjobfamily', 'masterjobfamily.id = mastersubjobfamily.jobfamily_id');
        $query->where('masterjobfamily.id = :id', [':id' => $jobfamily]);
        $getJob = $query->all(); //var_dump($getJob);die;
        if ($getJob) {
          $transRincianIds = [];
          foreach ($getJob as $gs) {
            $transRincianIds[] = $gs->id;
          }
          $ret = $transRincianIds;
        }
      }
      return $ret;
    }

    protected function bysubjobfamily($subjobfamily = null)
    {
      $ret = null;
      if ($subjobfamily) {

        $query = Transrincian::find();
        $query->leftJoin('recruitment_dev.mappingjob', 'mappingjob.kodejabatan = trans_rincian_rekrut.hire_jabatan_sap');
        $query->leftJoin('recruitment_dev.mastersubjobfamily', 'mastersubjobfamily.id = mappingjob.subjobfamilyid');
        //$query->leftJoin('recruitment_dev.masterjobfamily', 'masterjobfamily.id = mastersubjobfamily.jobfamily_id'); 
        $query->where('mastersubjobfamily.id = :id', [':id' => $subjobfamily]);
        $getSub = $query->all(); //var_dump($getSub);die;
        if ($getSub) {
          $transRincianIds = [];
          foreach ($getSub as $gs) {
            $transRincianIds[] = $gs->id;
          }
          $ret = $transRincianIds;
        }
      }
      return $ret;
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
