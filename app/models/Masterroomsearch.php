<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Masterroom;

/**
 * Masterroomsearch represents the model behind the search form of `app\models\Masterroom`.
 */
class Masterroomsearch extends Masterroom
{
  public $office;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'masterofficeid'], 'integer'],
            [['createtime', 'updatetime', 'room', 'floor','office'], 'safe'],
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
        $query = Masterroom::find();
        $query->joinWith('masteroffice');

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
            'masterofficeid' => $this->masterofficeid,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
        ]);

        $query->andFilterWhere(['like', 'room', $this->room])
            ->andFilterWhere(['like', 'floor', $this->floor])
            ->andFilterWhere(['like', 'officename', $this->office]);

        return $dataProvider;
    }
}
