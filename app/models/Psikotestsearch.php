<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Psikotest;

/**
 * Psikotestsearch represents the model behind the search form of `app\models\Psikotest`.
 */
class Psikotestsearch extends Psikotest
{
  public $fullname;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid', 'status', 'recruitmentcandidateid', 'officeid', 'roomid', 'pic'], 'integer'],
            [['createtime', 'updatetime', 'scheduledate', 'date','fullname'], 'safe'],
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
        $query = Psikotest::find();
        $query->joinWith("userprofile");

        // add conditions that should always apply here
        if(Yii::$app->user->isGuest){
          $userid = null;
          $role = null;
        }else{
          $userid = Yii::$app->user->identity->id;
          $role = Yii::$app->user->identity->role;
        }
        if ($role == 8){
          $query->where(['pic'=>$userid]);
        }

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'userid' => $this->userid,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
            'scheduledate' => $this->scheduledate,
            'date' => $this->date,
            'status' => $this->status,
            'recruitmentcandidateid' => $this->recruitmentcandidateid,
            'officeid' => $this->officeid,
            'roomid' => $this->roomid,
            'pic' => $this->pic,
        ]);

        $query->andFilterWhere(['like', 'fullname', $this->fullname]);

        return $dataProvider;
    }
}
