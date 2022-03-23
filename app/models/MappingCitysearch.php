<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MappingCity;

/**
 * MappingCitysearch represents the model behind the search form of `app\models\MappingCity`.
 */
class MappingCitysearch extends MappingCity
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'manar', 'manar2'], 'integer'],
            [['city_id', 'city_name', 'province_id'], 'safe'],
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
        $query = MappingCity::find();

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
            'manar' => $this->manar,
            'manar2' => $this->manar2,
        ]);

        $query->andFilterWhere(['like', 'city_id', $this->city_id])
            ->andFilterWhere(['like', 'city_name', $this->city_name])
            ->andFilterWhere(['like', 'province_id', $this->province_id]);

        return $dataProvider;
    }
}
