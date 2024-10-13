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
    public $nojo;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid', 'createdby', 'perner', 'reason', 'approvedby', 'status'], 'integer'],
            [['createtime', 'updatetime', 'approvedtime',  'fullname', 'remarks', 'nojo'], 'safe'],
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
        $isapproved = [3, 17, 10, 31, 25];
        if (in_array($role, $isapproved)) {
            // $query->andWhere(['changecanceljoin.approvedby'=>$userid]);
            $query->andWhere('changecanceljoin.status >= 2');
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

        if ($this->nojo) {
            $query->joinWith("userid");
            $getJoId = $this->joBynojo();
            // var_dump($getJoId);die;
            if ($getJoId) {
                $getJoid = implode(',', $getJoId);
                $query->andWhere('hiring.recruitreqid IN (' . $getJoid . ')');
            } else {
                $query->andWhere('hiring.recruitreqid IN (null)');
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
