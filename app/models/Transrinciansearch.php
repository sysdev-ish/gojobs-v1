<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Transrincian;

/**
 * Transrinciansearch represents the model behind the search form of `app\models\Transrincian`.
 */
class Transrinciansearch extends Transrincian
{
    public $jobfunc;
    public $jobfunclike;
    public $project;
    public $city;
    public $statusrekrut;
    public $yeardata;
    public $start_date;
    public $end_date;
    public $projectrekrut;
    public $jabatansap;
    public $areasap;
    public $persasap;
    public $jobfamily;
    // public $jocategory;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'jumlah', 'skema', 'flag_jobs', 'flag_app', 'idpktable', 'typejo'], 'integer'],
            [['nojo', 'jabatan', 'gender', 'pendidikan', 'lokasi', 'atasan', 'kontrak', 'waktu', 'komentar', 'ket_done', 'upd', 'lup', 'upd_jobs', 'lup_jobs', 'upd_app', 'ket_rej', 'status_rekrut', 'ket_rekrut', 'upd_rekrut', 'pic_hi', 'n_pic_hi', 'pic_manar', 'n_pic_manar', 'pic_rekrut', 'n_pic_rekrut', 'level', 'level_txt', 'skilllayanan', 'skilllayanan_txt', 'level_sap', 'persa_sap', 'skill_sap', 'area_sap', 'jabatan_sap', 'jabatan_sap_nm', 'jenis_pro_sap', 'skema_sap', 'abkrs_sap', 'hire_jabatan_sap', 'zparam', 'lup_skema', 'upd_skema', 'jobfunc', 'jobfunclike', 'project', 'city', 'statusrekrut', 'n_project', 'yeardata', 'jabatansap', 'areasap', 'persasap', 'jobfamily', 'jocategory', 'start_date', 'end_date'], 'safe'],
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
        $query = Transrincian::find();
        // $query->joinWith("jobfunc");
        // $query->joinWith("transjo");
        // $query->joinWith("city")->distinct();
        // $query->joinWith("jabatansap");
        $query->andWhere('trans_rincian_rekrut.skema = 1');
        $query->andWhere('trans_rincian_rekrut.typejo <> 3');

        //Add by kaha 2022-06-1
        $subQuery = 'SELECT kodejabatan 
        FROM recruitment.mappingjob
        LEFT JOIN recruitment.mastersubjobfamily ON mastersubjobfamily.id = mappingjob.subjobfamilyid
        LEFT JOIN recruitment.masterjobfamily ON masterjobfamily.id = mastersubjobfamily.jobfamily_id';

        //type jo
        // 1 = new rekrut, 2 = replace
        // type replace
        // 1 = no rekrut, 2 = rekrut
        // $query->andWhere('trans_jo.type_replace = 2');
        // $query->andWhere(['like', 'trans_komponen.komponen', 'biaya']);
        // $query->andWhere('approval <> 2');
        // $query->andWhere('trans_jo.approval = 5');
        // $query->andWhere('flag_app <> 2');
        // $query->andWhere('trans_jo.bekerja >= "2019-01-01" OR trans_jo.bekerja = ""');


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['nojo' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // Add by kaha 2023-10-13
        if ($this->jobfunclike) {
            $query->joinWith("jobfunc");
        }
        if ($this->city) {
            $query->joinWith("city")->distinct();
        }
        if ($this->project) {
            $query->joinWith("transjo");
        }
        if ($this->jabatansap) {
            $query->joinWith("jabatansap");
        }
        if ($this->areasap) {
            $query->joinWith("areasap");
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'trans_rincian_rekrut.id' => $this->id,
            'trans_rincian_rekrut.jumlah' => $this->jumlah,
            'trans_rincian_rekrut.skema' => $this->skema,
            'trans_rincian_rekrut.lup' => $this->lup,
            'trans_rincian_rekrut.flag_jobs' => $this->flag_jobs,
            'trans_rincian_rekrut.lup_jobs' => $this->lup_jobs,
            'trans_rincian_rekrut.flag_app' => $this->flag_app,
            'trans_rincian_rekrut.lup_skema' => $this->lup_skema,
            'trans_rincian_rekrut.typejo' => $this->typejo,
            'job_function.id' => $this->jobfunc,
            'sapjob.value2' => $this->jabatansap,
            'saparea.value1' => $this->areasap,
        ]);

        $query->andFilterWhere(['like', 'trans_rincian_rekrut.nojo', $this->nojo])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.jabatan', $this->jabatan])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.gender', $this->gender])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.pendidikan', $this->pendidikan])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.lokasi', $this->lokasi])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.atasan', $this->atasan])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.kontrak', $this->kontrak])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.waktu', $this->waktu])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.komentar', $this->komentar])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.ket_done', $this->ket_done])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.upd', $this->upd])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.upd_jobs', $this->upd_jobs])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.upd_app', $this->upd_app])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.ket_rej', $this->ket_rej])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.status_rekrut', $this->status_rekrut])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.ket_rekrut', $this->ket_rekrut])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.upd_rekrut', $this->upd_rekrut])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.pic_hi', $this->pic_hi])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.n_pic_hi', $this->n_pic_hi])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.pic_manar', $this->pic_manar])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.n_pic_manar', $this->n_pic_manar])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.pic_rekrut', $this->pic_rekrut])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.n_pic_rekrut', $this->n_pic_rekrut])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.level', $this->level])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.level_txt', $this->level_txt])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.skilllayanan', $this->skilllayanan])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.skilllayanan_txt', $this->skilllayanan_txt])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.level_sap', $this->level_sap])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.persa_sap', $this->persa_sap])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.skill_sap', $this->skill_sap])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.area_sap', $this->area_sap])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.jabatan_sap', $this->jabatan_sap])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.jabatan_sap_nm', $this->jabatan_sap_nm])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.jenis_pro_sap', $this->jenis_pro_sap])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.skema_sap', $this->skema_sap])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.abkrs_sap', $this->abkrs_sap])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.hire_jabatan_sap', $this->hire_jabatan_sap])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.zparam', $this->zparam])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.upd_skema', $this->upd_skema])
            ->andFilterWhere(['like', 'trans_rincian_rekrut.n_project', $this->n_project])
            ->andFilterWhere(['like', 'job_function.name_job_function', $this->jobfunclike])
            ->andFilterWhere(['like', 'mapping_city.city_name', $this->city])
            // ->andFilterWhere(['like', 'trans_jo.jumlah', $this->statusrekrut])
            ->andFilterWhere(['or', ['like', 'trans_jo.n_project', $this->project], ['like', 'trans_jo.project', $this->project]]);

        // if ($this->jobfamily) {
        //     $query->andWhere('masterjobfamily.id = :mjId', [':mjId' => $this->jobfamily]);
        // }

        //Add by kaha 2022-06-11
        if ($this->jobfamily) {
            $subQuery .= ' WHERE masterjobfamily.id = :id';
            $subQuery = Yii::$app->db->createCommand($subQuery)->bindParam(':id', $this->jobfamily)->queryAll();
            if ($subQuery) {
                $arrValue = [];
                foreach ($subQuery as $sq) {
                    $arrValue[] = $sq['kodejabatan'];
                }
                if (count($arrValue) > 0) $query->andWhere('trans_rincian_rekrut.hire_jabatan_sap IN (' . implode(',', $arrValue) . ')', []);
            }
        }

        return $dataProvider;
    }
}
