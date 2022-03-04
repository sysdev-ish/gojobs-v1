<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Masterpic;

/**
 * Masterpicsearch represents the model behind the search form of `app\models\Masterpic`.
 */
class Masterpicsearch extends Masterpic
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'masterofficeid', 'userid'], 'integer'],
            [['createtime', 'updatetime'], 'safe'],
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
        $query = Masterpic::find();

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
            'userid' => $this->userid,
        ]);

        return $dataProvider;
    }
}
