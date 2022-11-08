<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Changehiring;

/**
 * ChangehiringSearch represents the model behind the search form of `app\models\Changehiring`.
 */
class Changehiringsearch extends Changehiring
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid', 'newuserid', 'perner', 'recruitreqid', 'oldrecruitreqid', 'createdby', 'approvedby', 'status', 'reason', 'typechangehiring'], 'integer'],
            [['createtime', 'updatetime', 'approvedtime', 'fullname', 'changehiring', 'tglinput', 'oldtglinput', 'awalkontrak','oldawalkontrak', 'akhirkontrak', 'oldakhirkontrak'], 'safe'],
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
            'oldrecruitreqid' => $this->oldrecruitreqid,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
            'approvedtime' => $this->approvedtime,
            'createdby' => $this->createdby,
            'approvedby' => $this->approvedby,
            'status' => $this->status,
            'reason' => $this->reason,
            'changehiring' => $this->changehiring,
            'tglinput' => $this->tglinput,
            'oldtglinput' => $this->oldtglinput,
            'awalkontrak' => $this->awalkontrak,
            'oldawalkontrak' => $this->oldawalkontrak,
            'akhirkontrak' => $this->akhirkontrak,
            'oldakhirkontrak' => $this->oldakhirkontrak,
            'typechangehiring' => $this->typechangehiring,
        ]);

        $query->andFilterWhere(['like', 'fullname', $this->fullname]);

        return $dataProvider;
    }
}
