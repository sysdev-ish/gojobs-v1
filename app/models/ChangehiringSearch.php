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
            [['id', 'userid', 'perner', 'recruitreqid', 'newrecruitreqid', 'createdby', 'updatedby', 'approvedby', 'approvedby2', 'status', 'reason'], 'integer'],
            [['createtime', 'updatetime', 'approvedtime', 'approvedtime2', 'documentevidence', 'remarks', 'userremarks','fullname','cancelhiring'], 'safe'],
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
            'fullname' => $this->fullname,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
            'approvedtime' => $this->approvedtime,
            'approvedtime2' => $this->approvedtime2,
            'createdby' => $this->createdby,
            'updatedby' => $this->updatedby,
            'approvedby' => $this->approvedby,
            'approvedby2' => $this->approvedby2,
            'status' => $this->status,
            'reason' => $this->reason,
        ]);

        $query->andFilterWhere(['like', 'documentevidence', $this->documentevidence])
            ->andFilterWhere(['like', 'remarks', $this->remarks])
            ->andFilterWhere(['like', 'userremarks', $this->userremarks]);

        return $dataProvider;
    }
}
