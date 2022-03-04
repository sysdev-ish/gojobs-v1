<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Chagerequestdata;

/**
 * Chagerequestdatasearch represents the model behind the search form of `app\models\Chagerequestdata`.
 */
class Chagerequestdatasearch extends Chagerequestdata
{
  public $fullname;
  public $createduser;
  public $approveduser;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid', 'createdby', 'updatedby', 'approvedby', 'kategorydata','status','perner'], 'integer'],
            [['createtime', 'updatetime', 'approvedtime','fullname','createduser','approveduser'], 'safe'],
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
        $query = Chagerequestdata::find();
        $query->joinWith("userprofile");
        $query->joinWith("createduser");
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
        $query->andWhere(['chagerequestdata.kategorydata'=>1]);
        if(Yii::$app->user->isGuest){
          $role = null;
          $userid = null;
        }else{
          $userid = Yii::$app->user->identity->id;
          $role = Yii::$app->user->identity->role;
        }
        $isapproved = [11,17,24,25];
        // if($role == 11 or $role == 17 or $role ){
        if (in_array($role, $isapproved)){
          $query->andWhere(['chagerequestdata.approvedby'=>$userid]);
          $query->andWhere('chagerequestdata.status >= 2');
        }else{
          if($role <> 1){
            $query->andWhere(['chagerequestdata.createdby'=>$userid]);
          }
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'perner' => $this->perner,
            'userid' => $this->userid,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
            'approvedtime' => $this->approvedtime,
            'createdby' => $this->createdby,
            'updatedby' => $this->updatedby,
            'approvedby' => $this->approvedby,
            'kategorydata' => $this->kategorydata,
            'chagerequestdata.status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'userprofile.fullname', $this->fullname])
              ->andFilterWhere(['like', 'name', $this->createduser]);
              // ->andFilterWhere(['like', 'approveduser.name', $this->approveduser]);

        return $dataProvider;
    }
}
