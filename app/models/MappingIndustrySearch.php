<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MappingIndustrySearch represents the model behind the search form of `app\models\MappingIndustry`.
 */
class MappingIndustrySearch extends MappingIndustry
{
  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['id', 'category_company', 'created_by', 'updated_by'], 'integer'],
      [['company_name', 'client_name', 'category_segment', 'description', 'created_at', 'updated_at'], 'safe'],
    ];
  }

  /**
   * Creates data provider instance with search query applied.
   *
   * @param array $params
   *
   * @return ActiveDataProvider
   */
  public function search($params)
  {
    $query = MappingIndustry::find();

    // Add sorting
    $dataProvider = new ActiveDataProvider([
      'query' => $query,
    ]);

    $this->load($params);

    if (!$this->validate()) {
      // If validation fails, return all records
      return $dataProvider;
    }

    // Filter the query based on the search criteria
    $query->andFilterWhere(['id' => $this->id])
      ->andFilterWhere(['category_company' => $this->category_company])
      ->andFilterWhere(['created_by' => $this->created_by])
      ->andFilterWhere(['updated_by' => $this->updated_by])
      ->andFilterWhere(['like', 'company_name', $this->company_name])
      ->andFilterWhere(['like', 'client_name', $this->client_name])
      ->andFilterWhere(['like', 'category_segment', $this->category_segment])
      ->andFilterWhere(['like', 'description', $this->description])
      ->andFilterWhere(['like', 'created_at', $this->created_at])
      ->andFilterWhere(['like', 'updated_at', $this->updated_at]);

    return $dataProvider;
  }
}
