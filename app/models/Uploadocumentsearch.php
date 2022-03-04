<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Uploadocument;

/**
 * Uploadocumentsearch represents the model behind the search form of `app\models\Uploadocument`.
 */
class Uploadocumentsearch extends Uploadocument
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid'], 'integer'],
            [['createtime', 'updatetime', 'ijazah', 'transkipnilai', 'suratketerangansehat', 'kartukeluarga', 'ktp', 'jamsostek', 'bpjskesehatan', 'npwp'], 'safe'],
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
        $query = Uploadocument::find();

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

        $query->andFilterWhere(['like', 'ijazah', $this->ijazah])
            ->andFilterWhere(['like', 'transkipnilai', $this->transkipnilai])
            ->andFilterWhere(['like', 'suratketerangansehat', $this->suratketerangansehat])
            ->andFilterWhere(['like', 'kartukeluarga', $this->kartukeluarga])
            ->andFilterWhere(['like', 'ktp', $this->ktp])
            ->andFilterWhere(['like', 'jamsostek', $this->jamsostek])
            ->andFilterWhere(['like', 'bpjskesehatan', $this->bpjskesehatan])
            ->andFilterWhere(['like', 'npwp', $this->npwp]);

        return $dataProvider;
    }
}
