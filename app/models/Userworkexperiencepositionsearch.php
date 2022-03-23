<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Userworkexperienceposition;

/**
 * Userworkexperiencepositionsearch represents the model behind the search form of `app\models\Userworkexperienceposition`.
 */
class Userworkexperiencepositionsearch extends Userworkexperienceposition
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'idworkexperience', 'salary'], 'integer'],
            [['createtime', 'updatetime', 'position', 'jobdesc'], 'safe'],
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
        $query = Userworkexperienceposition::find();

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
            'idworkexperience' => $this->idworkexperience,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
            'salary' => $this->salary,
        ]);

        $query->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'jobdesc', $this->jobdesc]);

        return $dataProvider;
    }
}
