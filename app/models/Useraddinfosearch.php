<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Userhealth;

/**
 * Useraddinfosearch represents the model behind the search form of `app\models\Userhealth`.
 */
class Useraddinfosearch extends Userhealth
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid', 'sick'], 'integer'],
            [['createtime', 'updatetime', 'when', 'effect', 'illnessdesc', 'accident', 'whenaccident', 'efffectaccident', 'accidentdesc'], 'safe'],
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
        $query = Userhealth::find();

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
            'sick' => $this->sick,
        ]);

        $query->andFilterWhere(['like', 'when', $this->when])
            ->andFilterWhere(['like', 'effect', $this->effect])
            ->andFilterWhere(['like', 'illnessdesc', $this->illnessdesc])
            ->andFilterWhere(['like', 'accident', $this->accident])
            ->andFilterWhere(['like', 'whenaccident', $this->whenaccident])
            ->andFilterWhere(['like', 'efffectaccident', $this->efffectaccident])
            ->andFilterWhere(['like', 'accidentdesc', $this->accidentdesc]);

        return $dataProvider;
    }
}
