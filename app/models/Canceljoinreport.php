<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Changecanceljoin;

/**
 * Changecanceljoin represents the model behind the search form of `app\models\Changecanceljoin`.
 */
class Canceljoinreport extends Changecanceljoin
{
  public $fullname;
  public $perner;
  public $createtime;
  public $updatetime;
  public $createdby;
  public $reason;
  public $status;
  public $segmen;
  public $startdate;
  public $enddate;
  
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['perner', 'status','reason'], 'integer'],
            [['createtime', 'updatetime', 'fullname','canceldate','createdby','segmen','startdate','enddate'
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
        $query = Changecanceljoin::find();

        //Add by pwd
        // $query->leftJoin('ish_catalog_baru.trans_rincian_rekrut', 'trans_rincian_rekrut.id = hiring.recruitreqid');

        // add conditions that should always apply here
        
        $dataProvider = new ActiveDataProvider([
          'query' => $query,
          'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
          'pagination' => [
            'pageSize' => 10,
          ],
        ]);


        $this->load($params);
        //just view report if status > 2 / not in draft
        $query->where('status > 2 ');

        if (!$this->validate()) {
          return $dataProvider;
        }
        $query->andFilterWhere(['like', 'fullname', $this->fullname]);
        //range filter by date -> createtime
        $query->andFilterWhere(['between', 'createtime', $this->startdate, $this->enddate]);


        //Add by pwd -> pakai relasi buat filternya karena jika implode parsing data bakal habisin memory & kurang optimal
        // if ($this->subjobfamily) {
        //   $query->andWhere('mastersubjobfamily.id = :id', [':id' => $this->subjobfamily]);
        // } elseif ($this->jobfamily) {
        //   $query->andWhere('masterjobfamily.id = :id', [':id' => $this->jobfamily]);
        // }

        if($this->status){
          if($this->status == 9){
            $query->andFilterWhere([
                'status' => 9,
            ]);
          }else if($this->status == 8){
            $query->andFilterWhere([
                'status' => 8,
            ]);
          }else if($this->status == 5){
            $query->andFilterWhere([
                'status' => 5,
            ]);
          }else if($this->status == 4){
            $query->andFilterWhere([
                'status' => 4,
            ]);
          }else{
            $query->andWhere('status IN (null)');
          }
        }

        $alldata = [
          'dataProvider' => $dataProvider,
        ];

        return $alldata;
    }
    
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'createtime' => 'Hiring time',
            'updatetime' => 'Updatetime',
            'perner' => 'Perner',
            'status' => 'Status Cancel Join',
            'remarks' => 'Remarks',
            'fullname' => 'Full Name',
            'createdby' => 'Created by',
            'canceldate' => 'Cancel Join Date',
            'segmen' => 'Segmen',
        ];
    }
}
