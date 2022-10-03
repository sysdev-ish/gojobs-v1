<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Changecanceljoin;

/**
 * Changecanceljoinsearch represents the model behind the search form of `app\models\Changecanceljoin`.
 */
class Changecanceljoinsearch extends Changecanceljoin
{
    // public $approveduser;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid', 'createdby', 'perner', 'reason', 'approvedby', 'status'], 'integer'],
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
        $query = Changecanceljoin::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if(Yii::$app->user->isGuest){
          $role = null;
          $userid = null;
        }else{
          $userid = Yii::$app->user->identity->id;
          $role = Yii::$app->user->identity->role;
        }
        if($role == 20 or $role == 3 or $role == 10){
            $query->andWhere(['changecanceljoin.approvedby'=>$userid]);
        //   $query->andWhere('changecanceljoin.status >= 2');
        }else{
            if($role <> 1){
                $query->andWhere(['changecanceljoin.createdby'=>$userid]);
            }
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'changecanceljoin.id' => $this->id,
            'changecanceljoin.userid' => $this->userid,
            'changecanceljoin.createtime' => $this->createtime,
            'changecanceljoin.updatetime' => $this->updatetime,
            'changecanceljoin.approvedtime' => $this->approvedtime,
            'changecanceljoin.createdby' => $this->createdby,
            'changecanceljoin.perner' => $this->perner,
            'changecanceljoin.reason' => $this->reason,
            'changecanceljoin.approvedby' => $this->approvedby,
            'changecanceljoin.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'changecanceljoin.fullname', $this->fullname])
            ->andFilterWhere(['like', 'changecanceljoin.remarks', $this->remarks])
            // ->andFilterWhere(['like', 'user.name', $this->approveduser])
            ;

        return $dataProvider;
    }
}
