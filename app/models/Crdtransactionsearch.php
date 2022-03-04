<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Crdtransaction;

/**
 * Crdtransactionsearch represents the model behind the search form of `app\models\Crdtransaction`.
 */
class Crdtransactionsearch extends Crdtransaction
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'crdid', 'status'], 'integer'],
            [['oldvalue', 'newvalue', 'olddoc', 'newdoc'], 'safe'],
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
        $query = Crdtransaction::find();

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
            'crdid' => $this->crdid,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'oldvalue', $this->oldvalue])
            ->andFilterWhere(['like', 'newvalue', $this->newvalue])
            ->andFilterWhere(['like', 'olddoc', $this->olddoc])
            ->andFilterWhere(['like', 'newdoc', $this->newdoc]);

        return $dataProvider;
    }
}
