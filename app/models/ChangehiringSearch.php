<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Changehiring;

/**
 * ChangehiringSearch represents the model behind the search form of `app\models\Changehiring`.
 */
class ChangehiringSearch extends Changehiring
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid', 'perner', 'recruitreqid', 'newrecruitreqid', 'createdby', 'approvedby', 'status', 'reason'], 'integer'],
            [['createtime', 'updatetime', 'approvedtime', 'documentevidence', 'remarks', 'userremarks', 'fullname', 'cancelhiring', 'hiringdate', 'newhiringdate', 'contractperiode', 'newcontractperiode'], 'safe'],
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
        $query = Changehiring::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'userid' => $this->userid,
            'perner' => $this->perner,
            'recruitreqid' => $this->recruitreqid,
            'newrecruitreqid' => $this->newrecruitreqid,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
            'approvedtime' => $this->approvedtime,
            'createdby' => $this->createdby,
            'approvedby' => $this->approvedby,
            'status' => $this->status,
            'reason' => $this->reason,
            'cancelhiring' => $this->cancelhiring,
            'hiringdate' => $this->hiringdate,
            'newhiringdate' => $this->newhiringdate,
            'contractperiode' => $this->contractperiode,
            'newcontractperiode' => $this->newcontractperiode,
        ]);

        $query->andFilterWhere(['like', 'documentevidence', $this->documentevidence])
            ->andFilterWhere(['like', 'remarks', $this->remarks])
            ->andFilterWhere(['like', 'userremarks', $this->userremarks])
            ->andFilterWhere(['like', 'fullname', $this->fullname]);

        return $dataProvider;
    }
}
