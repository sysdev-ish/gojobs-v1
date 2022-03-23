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
            [['jabatansap', 'kodejabatan', 'kodeposisi','createtime', 'updatetime'], 'safe'],
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
        // $query = Transrincianrekrut::find();
        // $query->joinWith('jabatan_sap');
        // $query->joinWith('hire_jabatan_sap');

        // $query->andWhere('trans_rincian_rekrut.skema = 1');
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
            // 'trans_rincian_rekrut.jabatan_sap' => $this->jabatansap,
            // 'trans_rincian_rekrut.hire_jabatan_sap' => $this->kodejabatan,
            'subjobfamilyid' => $this->subjobfamilyid,
            'kodejabatan' => $this->kodejabatan,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
        ]);

        $query->andFilterWhere(['like', 'jabatansap', $this->jabatansap])
            ->andFilterWhere(['like', 'kodeposisi', $this->kodeposisi]);
        if ($this->jabatansap) {
            $getjabatansap = $this->byjabsap();
            if ($getjabatansap) {
                $getjabatansap = '"' . implode('","', $getjabatansap) . '"';
                $query->andWhere('jabatansap IN (' . $getjabatansap . ')');
            }
        }
        if ($this->kodeposisi) {
            $getkodeposisi = $this->bykodepos();
            if ($getkodeposisi) {
                $getkodeposisi = '"' . implode('","', $getkodeposisi) . '"';
                $query->andWhere('kodeposisi IN (' . $getkodeposisi . ')');
            }
        }

        return $dataProvider;
    }
    protected function byjabsap()
    {
        $ret = null;
        $jabsap = Transrincianrekrut::find();
        if ($this->jabsap) {
            $getjabatansap = Transrincianrekrut::find()->andWhere('jabatansap LIKE :jabatansap', [':jabatansap' => '%' . $this->jabsap . '%'])->all();
            if ($getjabatansap) {
                $jabatansap = array();
                foreach ($getjabatansap as $value) {
                    $jabatansap[] = $value->jabatan_sap;
                }
                $ret = $jabatansap;
            }
        }
        return $ret;
    }
    protected function bykodepos()
    {
        $ret = null;
        if ($this->kodepos) {
            $getkodeposisi = Transrincianrekrut::find()->andWhere('kodeposisi LIKE :kodeposisi', [':kodeposisi' => '%' . $this->kodepos . '%'])->all();
            if ($getkodeposisi) {
                $kodeposisi = array();
                foreach ($getkodeposisi as $value) {
                    $kodeposisi[] = $value->hire_jabatan_sap;
                }
                $ret = $kodeposisi;
            }
        }
        return $ret;
    }
}
