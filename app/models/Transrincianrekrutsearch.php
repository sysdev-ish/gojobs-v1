<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Transrincianrekrut;

/**
 * Transrincianrekrutsearch represents the model behind the search form of `app\models\Transrincianrekrut`.
 */
class Transrincianrekrutsearch extends Transrincianrekrut
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'detail_komp', 'jumlah', 'skema', 'flag_jobs', 'flag_app', 'finish_view_manar', 'idtr', 'idtp', 'typejo'], 'integer'],
            [['nojo', 'jabatan', 'gender', 'pendidikan', 'lokasi', 'atasan', 'kontrak', 'waktu', 'komentar', 'ket_done', 'upd', 'lup', 'upd_jobs', 'lup_jobs', 'upd_app', 'ket_rej', 'status_rekrut', 'ket_rekrut', 'upd_rekrut', 'pic_hi', 'n_pic_hi', 'pic_manar', 'n_pic_manar', 'pic_rekrut', 'n_pic_rekrut', 'level', 'level_txt', 'skilllayanan', 'skilllayanan_txt', 'level_sap', 'persa_sap', 'skill_sap', 'area_sap', 'jabatan_sap', 'jabatan_sap_nm', 'jenis_pro_sap', 'skema_sap', 'abkrs_sap', 'hire_jabatan_sap', 'zparam', 'lup_skema', 'upd_skema'], 'safe'],
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
        $query = Transrincianrekrut::find();

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
            'detail_komp' => $this->detail_komp,
            'jumlah' => $this->jumlah,
            'skema' => $this->skema,
            'lup' => $this->lup,
            'flag_jobs' => $this->flag_jobs,
            'lup_jobs' => $this->lup_jobs,
            'flag_app' => $this->flag_app,
            'lup_skema' => $this->lup_skema,
            'finish_view_manar' => $this->finish_view_manar,
            'idtr' => $this->idtr,
            'idtp' => $this->idtp,
            'typejo' => $this->typejo,
        ]);

        $query->andFilterWhere(['like', 'nojo', $this->nojo])
            ->andFilterWhere(['like', 'jabatan', $this->jabatan])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'pendidikan', $this->pendidikan])
            ->andFilterWhere(['like', 'lokasi', $this->lokasi])
            ->andFilterWhere(['like', 'atasan', $this->atasan])
            ->andFilterWhere(['like', 'kontrak', $this->kontrak])
            ->andFilterWhere(['like', 'waktu', $this->waktu])
            ->andFilterWhere(['like', 'komentar', $this->komentar])
            ->andFilterWhere(['like', 'ket_done', $this->ket_done])
            ->andFilterWhere(['like', 'upd', $this->upd])
            ->andFilterWhere(['like', 'upd_jobs', $this->upd_jobs])
            ->andFilterWhere(['like', 'upd_app', $this->upd_app])
            ->andFilterWhere(['like', 'ket_rej', $this->ket_rej])
            ->andFilterWhere(['like', 'status_rekrut', $this->status_rekrut])
            ->andFilterWhere(['like', 'ket_rekrut', $this->ket_rekrut])
            ->andFilterWhere(['like', 'upd_rekrut', $this->upd_rekrut])
            ->andFilterWhere(['like', 'pic_hi', $this->pic_hi])
            ->andFilterWhere(['like', 'n_pic_hi', $this->n_pic_hi])
            ->andFilterWhere(['like', 'pic_manar', $this->pic_manar])
            ->andFilterWhere(['like', 'n_pic_manar', $this->n_pic_manar])
            ->andFilterWhere(['like', 'pic_rekrut', $this->pic_rekrut])
            ->andFilterWhere(['like', 'n_pic_rekrut', $this->n_pic_rekrut])
            ->andFilterWhere(['like', 'level', $this->level])
            ->andFilterWhere(['like', 'level_txt', $this->level_txt])
            ->andFilterWhere(['like', 'skilllayanan', $this->skilllayanan])
            ->andFilterWhere(['like', 'skilllayanan_txt', $this->skilllayanan_txt])
            ->andFilterWhere(['like', 'level_sap', $this->level_sap])
            ->andFilterWhere(['like', 'persa_sap', $this->persa_sap])
            ->andFilterWhere(['like', 'skill_sap', $this->skill_sap])
            ->andFilterWhere(['like', 'area_sap', $this->area_sap])
            ->andFilterWhere(['like', 'jabatan_sap', $this->jabatan_sap])
            ->andFilterWhere(['like', 'jabatan_sap_nm', $this->jabatan_sap_nm])
            ->andFilterWhere(['like', 'jenis_pro_sap', $this->jenis_pro_sap])
            ->andFilterWhere(['like', 'skema_sap', $this->skema_sap])
            ->andFilterWhere(['like', 'abkrs_sap', $this->abkrs_sap])
            ->andFilterWhere(['like', 'hire_jabatan_sap', $this->hire_jabatan_sap])
            ->andFilterWhere(['like', 'zparam', $this->zparam])
            ->andFilterWhere(['like', 'upd_skema', $this->upd_skema]);

        return $dataProvider;
    }
}
