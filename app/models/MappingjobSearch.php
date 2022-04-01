<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Mappingjob;

/**
 * MappingjobSearch represents the model behind the search form of `app\models\Mappingjob`.
 */
class MappingjobSearch extends Mappingjob
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'subjobfamilyid', 'kodejabatan', 'status'], 'integer'],
            [['jabatansap', 'createtime', 'updatetime'], 'safe'],
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
        $query = Mappingjob::find();

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
            'subjobfamilyid' => $this->subjobfamilyid,
            'kodejabatan' => $this->kodejabatan,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
        ]);

        $query->andFilterWhere(['like', 'jabatansap', $this->jabatansap])
        ->andFilterWhere(['like', 'status', $this->status])
        ;

        return $dataProvider;
    }
}
