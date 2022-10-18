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
      [['perner', 'status', 'reason'], 'integer'],
      [[
        'createtime', 'updatetime', 'fullname', 'canceldate', 'createdby', 'segmen', 'startdate', 'enddate'
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
    // $query->joinWith('userid');

    //Add by pwd
    $subQuery = 'SELECT userid FROM recruitment.hiring
          LEFT JOIN ish_catalog_baru.trans_rincian_rekrut ON trans_rincian_rekrut.nojo = mappingjob.subjobfamilyid';

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
    if ($this->segmen) {
      //Add by kaha 2022-10-14
      $subQuery .= ' WHERE mappingsegmen.id = :id';
      $subQuery = Yii::$app->db->createCommand($subQuery)->bindValue(':id', $this->segmen)->queryAll();
      // var_dump($subQuery);die;
      if ($subQuery) {
        $arrValue = [];
        foreach ($subQuery as $sq) {
          $arrValue[] = $sq['id'];
        }
        if (count($arrValue) > 0) {
          $sQueryJo = 'SELECT nojo FROM trans_jo WHERE divisiid IN (' . implode(',', $arrValue) . ')';
          $getTrr = Yii::$app->dbjo->createCommand($sQueryJo)->queryAll();
          // var_dump($getTrr);die;
          if ($getTrr) {
            $arrValueJo = [];
            foreach ($getTrr as $gttr) {
              $arrValueJo[] = $gttr['nojo'];
            }
            if (count($arrValueJo) > 0) $query->andWhere('changecanceljoin.userid IN (' . implode(',', $arrValueJo) . ')', []);
          }
        }
      } else {
        $query->andWhere('changecanceljoin.userid IN (null)');
      }
    }

    if ($this->status) {
      if ($this->status == 9) {
        $query->andFilterWhere([
          'status' => 9,
        ]);
      } else if ($this->status == 8) {
        $query->andFilterWhere([
          'status' => 8,
        ]);
      } else if ($this->status == 5) {
        $query->andFilterWhere([
          'status' => 5,
        ]);
      } else if ($this->status == 4) {
        $query->andFilterWhere([
          'status' => 4,
        ]);
      } else {
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
