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
            [['jabatansap', 'kodejabatan', 'status','createtime', 'updatetime'], 'safe'],
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
            'subjobfamilyid' => $this->subjobfamilyid,
            // 'kodejabatan' => $this->kodejabatan,
            'status' => $this->status,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
        ]);

        $query->andFilterWhere(['like', 'kodejabatan', $this->kodejabatan])
        ->andFilterWhere(['like', 'jabatansap', $this->jabatansap]);
            // ->andFilterWhere(['like', 'kodeposisi', $this->kodeposisi]);
        if ($this->kodejabatan) {
            $getkodejabatan = $this->bykodejab();
            if ($getkodejabatan) {
                $getkodejabatan = '"' . implode('","', $getkodejabatan) . '"';
                $query->andWhere('kodejabatan IN (' . $getkodejabatan . ')');
            }
        }
        if ($this->jabatansap) {
            $getJoId = $this->joByjabatan();
            // var_dump($getJoId);die;
            if ($getJoId) {
                $getJoid = implode(',', $getJoId);
                $query->andWhere('recruitreqid IN (' . $getJoid . ')');
            } else {
                $query->andWhere('recruitreqid IN (null)');
            }
        }
        return $dataProvider;
    }
    //searchkodejabatan from Transrincianrekrut table trans_rincian_rekrut field hire_jabatan_sap
    protected function bykodejab()
    {
        $ret = null;
        if ($this->kodejab) {
            $getkodejabatan = Transrincianrekrut::find()->andWhere('kodejabatan LIKE :kodejabatan', [':kodejabatan' => '%' . $this->kodepos . '%'])->all();
            if ($getkodejabatan) {
                $kodejabatan = array();
                foreach ($getkodejabatan as $value) {
                    $kodejabatan[] = $value->hire_jabatan_sap;
                }
                $ret = $kodejabatan;
            }
        }
        return $ret;
    }
    protected function joByjabatan()
    {
        $ret = null;
        $jabatansap = $this->jabatansap;
        if ($jabatansap) {
            $getJabatan = Sapjob::find()->andWhere('value2 LIKE :value2', [':value2' => '%' . $jabatansap . '%'])->all();
            if ($getJabatan) {
                $jabatanIds = array();
                foreach ($getJabatan as $value) {
                    $jabatanIds[] = $value->value1;
                }

                if (count($jabatanIds) > 0) {
                    $transRincian = Transrincian::find()->andWhere('hire_jabatan_sap IN ("' . implode('","', $jabatanIds) . '")', [])->all();
                    if ($transRincian) {
                        $transRincianIds = array();
                        foreach ($transRincian as $tr) {
                            $transRincianIds[] = $tr->id;
                        }
                        $ret = $transRincianIds;
                    }
                }
            }
        }
        return $ret;
    }
}
