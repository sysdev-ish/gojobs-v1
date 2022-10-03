<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Chagerequestresign;

/**
 * Chagerequestresignsearch represents the model behind the search form of `app\models\Chagerequestresign`.
 */
class Chagerequestresignsearch extends Chagerequestresign
{
    public $approveduser;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid', 'createdby', 'updatedby', 'perner', 'reason', 'approvedby', 'status'], 'integer'],
            [['createtime', 'updatetime', 'approvedtime',  'fullname', 'remarks','approveduser'], 'safe'],
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
        $query = Chagerequestresign::find();
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

        if(Yii::$app->user->isGuest){
          $role = null;
          $userid = null;
        }else{
          $userid = Yii::$app->user->identity->id;
          $role = Yii::$app->user->identity->role;
        }
        if($role == 20 or $role == 17){
          $query->andWhere(['chagerequestresign.approvedby'=>$userid]);
          $query->andWhere('chagerequestresign.status >= 2');
        }else{
          if($role <> 1){
            $query->andWhere(['chagerequestresign.createdby'=>$userid]);
          }
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'chagerequestresign.id' => $this->id,
            'chagerequestresign.userid' => $this->userid,
            'chagerequestresign.createtime' => $this->createtime,
            'chagerequestresign.updatetime' => $this->updatetime,
            'chagerequestresign.approvedtime' => $this->approvedtime,
            'chagerequestresign.createdby' => $this->createdby,
            'chagerequestresign.updatedby' => $this->updatedby,
            'chagerequestresign.perner' => $this->perner,
            'chagerequestresign.reason' => $this->reason,
            // 'resigndate' => $this->resigndate,
            'chagerequestresign.approvedby' => $this->approvedby,
            'chagerequestresign.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'chagerequestresign.fullname', $this->fullname])
            ->andFilterWhere(['like', 'chagerequestresign.remarks', $this->remarks])
            ->andFilterWhere(['like', 'user.name', $this->approveduser]);

        return $dataProvider;
    }
}
