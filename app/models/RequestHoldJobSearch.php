<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RequestHoldJob;

/**
 * RequestHoldJobSearch represents the model behind the search form of `app\models\RequestHoldJob`.
 */
class RequestHoldJobSearch extends RequestHoldJob
{

  public $nojo;
  public $approver;
  /**
   * @inheritdoc
   */
  public function rules()
  {
    return [
      [['id', 'recruitreqid', 'created_by', 'updated_by', 'approved_by', 'status', 'restored_by'], 'integer'],
      [['scheme_date_old', 'scheme_date_start', 'scheme_date_end', 'recipient'], 'string'],
      [['created_at', 'updated_at', 'approved_at', 'send_email_at', 'remarks', 'evidence', 'nojo', 'approver'], 'safe'],
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
    $query = RequestHoldJob::find();

    // add conditions that should always apply here

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
      'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
    ]);

    $this->load($params);

    if (!$this->validate()) {
      // uncomment the following line if you do not want to return any records when validation fails
      // $query->where('0=1');
      return $dataProvider;
    }
    if (Yii::$app->user->isGuest) {
      $role = null;
      $userid = null;
    } else {
      $userid = Yii::$app->user->identity->id;
      $role = Yii::$app->user->identity->role;
      $nik = Yii::$app->user->identity->username;
    }

    switch ($role) {
      case 3:
      case 22:
      case 23:
        $query->andWhere(['created_by' => $userid]);
        break;
      case 10:
        $query->andWhere([
          'OR',
          ['created_by' => $userid],
          ['approved_by' => $nik]
        ]);
        break;
      case 16:
        $query->andWhere([
          'OR',
          ['created_by' => $userid],
          ['approved_by' => $nik]
        ]);
        break;
      case 21:
        $query->andWhere([
          'OR',
          ['created_by' => $userid],
          ['approved_by' => $nik]
        ]);

      default:
        $viewallrole = [1, 10, 16, 20, 17, 33];
        if (!in_array($role, $viewallrole)) {
          $query->andWhere(['id' => 0]);
        }
        break;
    }

    // grid filtering conditions
    $query->andFilterWhere([
      'id' => $this->id,
      'recruitreqid' => $this->recruitreqid,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
      'approved_at' => $this->approved_at,
      'restored_at' => $this->restored_at,
      'send_email_at' => $this->send_email_at,
      'created_by' => $this->created_by,
      'updated_by' => $this->updated_by,
      'approved_by' => $this->approved_by,
      'recipient' => $this->recipient,
      'status' => $this->status,
      'scheme_date_old' => $this->scheme_date_old,
      'scheme_date_start' => $this->scheme_date_start,
      'scheme_date_end' => $this->scheme_date_end,
    ]);

    $query->andFilterWhere(['like', 'remarks', $this->remarks])
      ->andFilterWhere(['like', 'evidence', $this->evidence]);

    if ($this->nojo) {
      $getJoId = $this->joBynojo();
      // var_dump($getJoId);die;
      if ($getJoId) {
        $getJoid = implode(',', $getJoId);
        $query->andWhere('recruitreqid IN (' . $getJoid . ')');
      } else {
        $query->andWhere('recruitreqid IN (null)');
      }
    }
    return $dataProvider;
  }
  protected function joBynojo()
  {
    $ret = null;
    $nojo = $this->nojo;
    if ($nojo) {
      $transRincian = Transrincian::find()->andWhere('nojo like "%' . $nojo . '%"')->all();
      if ($transRincian) {
        $transRincianIds = array();
        foreach ($transRincian as $tr) {
          $transRincianIds[] = $tr->id;
        }
        $ret = $transRincianIds;
      }
    }
    return $ret;
  }
}
