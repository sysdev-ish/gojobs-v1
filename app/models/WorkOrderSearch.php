<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WorkOrder;

/**
 * WorkOrderSearch represents the model behind the search form of `app\models\WorkOrder`.
 */
class WorkOrderSearch extends WorkOrder
{
    public $jobfunc;
    public $jobfunclike;
    public $project;
    public $city;
    public $status_recruitment;
    public $yeardata;
    public $start_date;
    public $end_date;
    public $project_recruitment;
    public $jabatan_sap;
    public $area_sap;
    public $persa_sap;
    public $jobfamily;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'recruitreq_id', 'type_wo', 'total_job', 'dynamic_process_id', 'dynamic_notification_id', 'flag_recruitment', 'flag_wo', 'created_by', 'updated_by'], 'integer'],
            [['wo_number', 'location', 'type_contract', 'note', 'project_name', 'project_end', 'level', 'skill_layanan', 'personal_area', 'area', 'job', 'payroll_area', 'job_code', 'created_time', 'updated_time'], 'safe'],
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
        $query = WorkOrder::find();
        // $query->andWhere('work_order.skema = 1');
        // $query->andWhere('work_order.typejo <> 3');

        //Add by kaha 2022-06-1
        $subQuery = 'SELECT kodejabatan 
        FROM recruitment.mappingjob
        LEFT JOIN recruitment.mastersubjobfamily ON mastersubjobfamily.id = mappingjob.subjobfamilyid
        LEFT JOIN recruitment.masterjobfamily ON masterjobfamily.id = mastersubjobfamily.jobfamily_id';

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['wo_number' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // Add by kaha 2023-10-13
        if ($this->jobfunction) {
            $query->joinWith("jobfunction");
        }
        if ($this->city) {
            $query->joinWith("city")->distinct();
        }
        if ($this->jobsap) {
            $query->joinWith("jobsap");
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'recruitreq_id' => $this->recruitreq_id,
            'type_wo' => $this->type_wo,
            'type_contract' => $this->type_contract,
            'dynamic_process_id' => $this->dynamic_process_id,
            'dynamic_notification_id' => $this->dynamic_notification_id,
            'flag_recruitment' => $this->flag_recruitment,
            'flag_wo' => $this->flag_wo,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by
        ]);

        $query->andFilterWhere(['like', 'wo_number', $this->wo_number])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'project_name', $this->project_name])
            ->andFilterWhere(['like', 'project_end', $this->project_end])
            ->andFilterWhere(['like', 'level', $this->level])
            ->andFilterWhere(['like', 'skill_layanan', $this->skill_layanan])
            ->andFilterWhere(['like', 'job', $this->job])
            ->andFilterWhere(['like', 'payroll_area', $this->payroll_area])
            ->andFilterWhere(['like', 'area', $this->area])
            ->andFilterWhere(['like', 'personal_area', $this->personal_area])
            ->andFilterWhere(['like', 'job_code', $this->job_code])
            ->andFilterWhere(['like', 'created_time', $this->created_time])
            ->andFilterWhere(['like', 'updated_time', $this->updated_time]);

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
