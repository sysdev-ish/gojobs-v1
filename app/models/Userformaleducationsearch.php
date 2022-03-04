<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Userformaleducation;

/**
 * Userformaleducationsearch represents the model behind the search form of `app\models\Userformaleducation`.
 */
class Userformaleducationsearch extends Userformaleducation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid'], 'integer'],
            [['createtime', 'updatetime', 'educationallevel', 'institutions', 'city', 'majoring', 'startdate', 'enddate', 'status'], 'safe'],
            [['gpa'], 'number'],
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
        $query = Userformaleducation::find();

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
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
            'startdate' => $this->startdate,
            'enddate' => $this->enddate,
            'gpa' => $this->gpa,
        ]);

        $query->andFilterWhere(['like', 'educationallevel', $this->educationallevel])
            ->andFilterWhere(['like', 'institutions', $this->institutions])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'majoring', $this->majoring])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
