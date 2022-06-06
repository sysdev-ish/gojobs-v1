<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Changejo;

/**
 * ChangjoSearch represents the model behind the search form of `app\models\Changejo`.
 */
class ChangjoSearch extends Changejo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'recruitreqid', 'createdby', 'updatedby', 'approvedby', 'approvedby2', 'status', 'oldjumlah', 'jumlahstop', 'jumlah', 'reason', 'typeapproval'], 'integer'],
            [['createtime', 'updatetime', 'approvedtime', 'approvedtime2', 'remarks', 'documentevidence'], 'safe'],
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
        $query = Changejo::find();
        $query->joinWith("approveeduser");

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
            'recruitreqid' => $this->recruitreqid,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
            'approvedtime' => $this->approvedtime,
            'approvedtime2' => $this->approvedtime2,
            'createdby' => $this->createdby,
            'updatedby' => $this->updatedby,
            'approvedby' => $this->approvedby,
            'approvedby2' => $this->appreovedby2,
            'status' => $this->status,
            'oldjumlah' => $this->oldjumlah,
            'jumlahstop' => $this->jumlahstop,
            'jumlah' => $this->jumlah,
            'reason' => $this->reason,
            'typeapproval' => $this->typeapproval,
        ]);

        $query->andFilterWhere(['like', 'remarks', $this->remarks])
            ->andFilterWhere(['like', 'documentevidence', $this->documentevidence]);

        return $dataProvider;
    }
}
