<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Userfamily;

/**
 * Userfamilysearch represents the model behind the search form of `app\models\Userfamily`.
 */
class Userfamilysearch extends Userfamily
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid'], 'integer'],
            [['createtime', 'updatetime', 'fullname', 'gender', 'birthdate', 'birthplace', 'lasteducation', 'jobtitle', 'companyname', 'description', 'relationship'], 'safe'],
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
        $query = Userfamily::find();

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
            'birthdate' => $this->birthdate,
        ]);

        $query->andFilterWhere(['like', 'fullname', $this->fullname])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'birthplace', $this->birthplace])
            ->andFilterWhere(['like', 'lasteducation', $this->lasteducation])
            ->andFilterWhere(['like', 'jobtitle', $this->jobtitle])
            ->andFilterWhere(['like', 'companyname', $this->companyname])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'relationship', $this->relationship]);

        return $dataProvider;
    }
}
