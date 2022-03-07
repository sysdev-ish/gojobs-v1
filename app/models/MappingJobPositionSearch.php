<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Mappingjobposition;

/**
 * MappingjobpositionSearch represents the model behind the search form of `app\models\Mappingjobposition`.
 */
class Mappingjobpositionsearch extends Mappingjobposition
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_subjobfamily'], 'integer'],
            [['jabatan_sap', 'kode_jabatan', 'kode_posisi'], 'safe'],
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
        $query = Mappingjobposition::find();

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
            'id_subjobfamily' => $this->id_subjobfamily,
        ]);

        $query->andFilterWhere(['like', 'jabatan_sap', $this->jabatan_sap])
            ->andFilterWhere(['like', 'kode_jabatan', $this->kode_jabatan])
            ->andFilterWhere(['like', 'kode_posisi', $this->kode_posisi]);

        return $dataProvider;
    }
}
