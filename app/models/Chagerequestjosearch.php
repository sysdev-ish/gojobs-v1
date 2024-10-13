<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Chagerequestjo;

/**
 * Chagerequestjosearch represents the model behind the search form of `app\models\Chagerequestjo`.
 */
class Chagerequestjosearch extends Chagerequestjo
{

  public $nojo;
  public $approveduser;
  /**
   * @inheritdoc
   */
  public function rules()
  {
    return [
      [['id', 'recruitreqid', 'createdby', 'updatedby', 'approvedby', 'status', 'oldjumlah', 'jumlah', 'approvedby2'], 'integer'],
      [['createtime', 'updatetime', 'approvedtime', 'remarks', 'documentevidence', 'nojo', 'approveduser'], 'safe'],
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
    $query = Chagerequestjo::find()->where(['job_id' => null]);
    // $query->joinWith("approveduser");

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
      // $nik = ((Yii::$app->utils->getnamebynik($data->approvedby2))?Yii::$app->utils->getnamebynik($data->approvedby2):'-')
      $nik = Yii::$app->user->identity->username;
    }
    // var_dump($role);die;
    $query->andWhere(['chagerequestjo.job_id' => null]);

    switch ($role) {
      case 3:
        $query->andWhere(['createdby' => $userid]);
        break;
      case 18:
        $query->andWhere([
          'OR',
          ['createdby' => $userid],
          ['approvedby2' => $nik]
        ]);
        break;
      case 22:
        $query->andWhere([
          'OR',
          ['createdby' => $userid],
          ['approvedby2' => $nik]
        ]);
        break;
      case 23:
        $query->andWhere([
          'OR',
          ['createdby' => $userid],
          ['approvedby2' => $nik]
        ]);
      case 25:
        $query->andWhere([
          'OR',
          ['createdby' => $userid],
          ['approvedby2' => $nik]
        ]);
        break;

      default:
        // var_dump($role);die;
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
      'createtime' => $this->createtime,
      'updatetime' => $this->updatetime,
      'approvedtime' => $this->approvedtime,
      'createdby' => $this->createdby,
      'updatedby' => $this->updatedby,
      'approvedby' => $this->approvedby,
      // 'approvedby2' => $this->approvedby2,
      'status' => $this->status,
      'oldjumlah' => $this->oldjumlah,
      'jumlah' => $this->jumlah,
    ]);

    $query->andFilterWhere(['like', 'remarks', $this->remarks])
      ->andFilterWhere(['like', 'documentevidence', $this->documentevidence]);
      
    // if ($this->approvedby2) {
    //   $query->andFilterWhere(['user.username' => $this->approvedby2]);
    // }

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
