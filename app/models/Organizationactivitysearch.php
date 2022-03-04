<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Organizationactivity;

/**
 * Organizationactivitysearch represents the model behind the search form of `app\models\Organizationactivity`.
 */
class Organizationactivitysearch extends Organizationactivity
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid'], 'integer'],
            [['createtime', 'updatetime', 'organizationname', 'organizationplace', 'organizationskill', 'duration', 'position'], 'safe'],
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
        $query = Organizationactivity::find();

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
        ]);

        $query->andFilterWhere(['like', 'organizationname', $this->organizationname])
            ->andFilterWhere(['like', 'organizationplace', $this->organizationplace])
            ->andFilterWhere(['like', 'organizationskill', $this->organizationskill])
            ->andFilterWhere(['like', 'duration', $this->duration])
            ->andFilterWhere(['like', 'position', $this->position]);

        return $dataProvider;
    }
}
