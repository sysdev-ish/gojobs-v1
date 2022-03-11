<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Mastersubjobfamily;

/**
 * Mastersubjobfamilysearch represents the model behind the search form of `app\models\Mastersubjobfamily`.
 */
class Mastersubjobfamilysearch extends Mastersubjobfamily
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'jobfamily_id'], 'integer'],
            [['subjobfamily', 'createtime', 'updatetime'], 'safe'],
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
        $query = Mastersubjobfamily::find();

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
            'jobfamily_id' => $this->jobfamily_id,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
        ]);

        $query->andFilterWhere(['like', 'subjobfamily', $this->subjobfamily]);

        return $dataProvider;
    }
}
