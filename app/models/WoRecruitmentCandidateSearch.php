<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WoRecruitmentCandidate;

/**
 * WoRecruitmentCandidateSearch represents the model behind the search form of `app\models\WoRecruitmentCandidate`.
 */
class WoRecruitmentCandidateSearch extends WoRecruitmentCandidate
{
    public $fullname;
    public $wo_number;
    public $city;
    public $job;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'wo_id', 'type_interview', 'created_by', 'updated_by', 'approved_by', 'method', 'status'], 'integer'],
            [['created_time', 'updated_time', 'token', 'invitation_number', 'fullname', 'wo_number', 'city', 'job'], 'safe'],
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
        $query = WoRecruitmentCandidate::find();
        $query->joinWith("userprofile");

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
            'user_id' => $this->user_id,
            'wo_id' => $this->wo_id,
            'created_time' => $this->created_time,
            'updated_time' => $this->updated_time,
            'type_interview' => $this->type_interview,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'approved_by' => $this->approved_by,
            'method' => $this->method,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'invitation_number', $this->invitation_number]);

        // 
        if ($this->city) {
            $getJoId = $this->joByCity($this->city);
            if ($getJoId) {
                $getJoid = implode(',', $getJoId);
                $query->andWhere('recruitreqid IN (' . $getJoid . ')');
            } else {
                $query->andWhere('recruitreqid IN (null)');
            }
        }
        if ($this->wo_number) {
            $getJoId = $this->joBynojo();
            // var_dump($getJoId);die;
            if ($getJoId) {
                $getJoid = implode(',', $getJoId);
                $query->andWhere('recruitreqid IN (' . $getJoid . ')');
            } else {
                $query->andWhere('recruitreqid IN (null)');
            }
        }
        // var_dump($this->jabatans);die;

        if ($this->job) {
            $getJoId = $this->joByJabatansap($this->job);
            // var_dump($getJoId);die;

            if ($getJoId) {
                $getJoid = implode(',', $getJoId);
                $query->andWhere('recruitreqid IN (' . $getJoid . ')');
            }
        }

        return $dataProvider;
    }

    protected function joByCity($city = null)
    {
        $ret = null;

        if ($city) {
            $getCity = MappingCity::find()->andWhere('city_name LIKE :city_name', [':city_name' => '%' . $city . '%'])->all();
            if ($getCity) {
                $cityIds = array();
                foreach ($getCity as $gc) {
                    $cityIds[] = $gc->city_id;
                }

                if (count($cityIds) > 0) {
                    //$transRincian = Transrincian::find()->andWhere('lokasi = :lokasi', [':lokasi' => $getCity->city_id])->all();
                    $transRincian = Transrincian::find()->andWhere('lokasi IN ("' . implode('","', $cityIds) . '")', [])->all();
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
    protected function joBynojo()
    {
        $ret = null;
        $nojo = $this->nojo;
        if ($nojo) {
            $transRincian = Transrincian::find()->andWhere('nojo like "%' . $nojo . '%"')->all();
            if ($transRincian) {
                $transRincianIds = array();
                foreach ($transRincian as $tr) {
                    $transRincianIds[] = $tr->id;
                }
                $ret = $transRincianIds;
            }
        }
        return $ret;
    }
    protected function joByJabatansap($jabatan = null)
    {
        $ret = null;

        if ($jabatan) {
            // $getJabatan = Sapjob::find()->andWhere('value2 LIKE :value2', [':value2' => '%' . $jabatan . '%'])->all();
            // var_dump($jabatan);die;
            $getJabatan = Sapjob::find()->andWhere('value2 like "%' . $jabatan . '%"')->all();
            if ($getJabatan) {
                $jabatanid = array();
                foreach ($getJabatan as $gj) {
                    $jabatanid[] = $gj->value1;
                }

                if (count($jabatanid) > 0) {
                    //$transRincian = Transrincian::find()->andWhere('lokasi = :lokasi', [':lokasi' => $getCity->city_id])->all();
                    $transRincian = Transrincian::find()->andWhere('hire_jabatan_sap IN ("' . implode('","', $jabatanid) . '")', [])->all();
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
