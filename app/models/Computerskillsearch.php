<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Computerskill;

/**
 * Computerskillsearch represents the model behind the search form of `app\models\Computerskill`.
 */
class Computerskillsearch extends Computerskill
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid', 'msword', 'msexcel', 'mspowerpoint', 'sql', 'lan', 'wan', 'pascal', 'clanguage', 'internetknowledge'], 'integer'],
            [['createtime', 'updatetime', 'others', 'usinginternetpurpose', 'usinginternetfrequency'], 'safe'],
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
        $query = Computerskill::find();

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
            'msword' => $this->msword,
            'msexcel' => $this->msexcel,
            'mspowerpoint' => $this->mspowerpoint,
            'sql' => $this->sql,
            'lan' => $this->lan,
            'wan' => $this->wan,
            'pascal' => $this->pascal,
            'clanguage' => $this->clanguage,
            'internetknowledge' => $this->internetknowledge,
        ]);

        $query->andFilterWhere(['like', 'others', $this->others])
            ->andFilterWhere(['like', 'usinginternetpurpose', $this->usinginternetpurpose])
            ->andFilterWhere(['like', 'usinginternetfrequency', $this->usinginternetfrequency]);

        return $dataProvider;
    }
}
