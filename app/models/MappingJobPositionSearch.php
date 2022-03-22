<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Mappingjobposition;

/**
 * MappingjobpositionSearch represents the model behind the search form of `app\models\Mappingjobposition`.
 */
class MappingjobpositionSearch extends Mappingjobposition
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'subjobfamilyid'], 'integer'],
            [['jabatansap', 'kodejabatan', 'kodeposisi'], 'safe'],
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
        // $query = Mappingjobposition::find();
        $query = Transrincianrekrut::find();
        $query->joinWith('jabatan_sap');
        $query->joinWith('hire_jabatan_sap');

        $query->andWhere('trans_rincian_rekrut.skema = 1');
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
            'trans_rincian_rekrut.jabatan_sap' => $this->jabatansap,
            'trans_rincian_rekrut.hire_jabatan_sap' => $this->kodejabatan,
            'subjobfamilyid' => $this->subjobfamilyid,
            'kodeposisi' => $this->kodeposisi,
        ]);            
        return $dataProvider;
    }
}
