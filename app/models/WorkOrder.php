<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "workorder".
 *
 * @property int $id
 * @property string $wo_number
 * @property int $client_id
 * @property string $project_name
 * @property string $job_description
 * @property string $job_requirement
 * @property int $recruitreq_id id pk table atau relasi ke JO yg mau dipilih by ID
 * @property int $type_wo
 * @property string $gender
 * @property string $education
 * @property string $location
 * @property string $contract
 * @property string $project_end
 * @property int $total_job
 * @property string $note
 * @property string $level
 * @property string $skill_layanan
 * @property string $personal_area
 * @property string $area
 * @property string $job
 * @property string $payroll_area
 * @property string $job_code
 * @property int $start_benefit
 * @property int $end_benefit
 * @property string $other_benefit
 * @property int $dynamic_process_id
 * @property int $dynamic_notification_id
 * @property int $flag_recruitment
 * @property int $flag_wo
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_time
 * @property string $updated_time
 *
 * @property WoRecruitmentCandidate[] $woRecruitmentCandidates
 */
class WorkOrder extends \yii\db\ActiveRecord
{
    public static function getDb()
    {
        return Yii::$app->get('db');
    }
    public static function getDb2()
    {
        return Yii::$app->get('dbjo');
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'workorder';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'project_name', 'type_contract', 'total_job', 'start_benefit', 'end_benefit', 'job_code', 'location', 'level'], 'required'],
            [['client_id', 'recruitreq_id', 'type_wo', 'type_contract', 'total_job', 'total_applied', 'start_benefit', 'end_benefit', 'dynamic_process_id', 'dynamic_notification_id', 'flag_recruitment', 'flag_wo', 'status', 'created_by', 'updated_by'], 'integer'],
            [['job_description', 'job_requirement'], 'string'],
            [['project_end', 'created_time', 'updated_time'], 'safe'],
            [['wo_number', 'skill_layanan', 'personal_area', 'area', 'job', 'payroll_area', 'job_code', 'level'], 'string', 'max' => 50],
            [['project_name', 'location', 'file_path'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'wo_number' => 'WO Number',
            'client_id' => 'Client',
            'project_name' => 'Project Name',
            'job_description' => 'Job Description',
            'job_requirement' => 'Job Requirement',
            'recruitreq_id' => 'Recruitreq',
            'type_wo' => 'Type WO',
            'type_contract' => 'Type Contract',
            'file_path' => 'File',
            'location' => 'Location',
            'project_end' => 'Duration',
            'total_job' => 'Total Job',
            'total_applied' => 'Total Apply',
            'level' => 'Level',
            'skill_layanan' => 'Skill Layanan',
            'personal_area' => 'Personal Area',
            'area' => 'Area',
            'job' => 'Job',
            'payroll_area' => 'Payroll Area',
            'job_code' => 'Job Code',
            'start_benefit' => 'Start Benefit',
            'end_benefit' => 'End Benefit',
            'dynamic_process_id' => 'Dynamic Process',
            'dynamic_notification_id' => 'Dynamic Notification',
            'flag_recruitment' => 'Flag Recruitment',
            'flag_wo' => 'Flag Wo',
            'status' => 'Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_time' => 'Created Time',
            'updated_time' => 'Updated Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWoRecruitmentCandidates()
    {
        return $this->hasMany(WoRecruitmentCandidate::className(), ['wo_id' => 'id']);
    }
    public function getJobfunction()
    {
        return $this->hasOne(Mappingjob::className(), ['kodejabatan' => 'job_code']);
    }
    public function getCity()
    {
        return $this->hasOne(MappingCity::className(), ['city_id' => 'location']);
    }
    public function getJobsap()
    {
        return $this->hasOne(Mappingjob::className(), ['kodejabatan' => 'job_code']);
    }
    public function getAreasap()
    {
        return $this->hasOne(Saparea::className(), ['value1' => 'area']);
    }
    public function getSkillsap()
    {
        return $this->hasOne(Sapskilllayanan::className(), ['value1' => 'skill_layanan']);
        // return ($get)?$get : '-';
    }
    public function getPersasap()
    {
        return $this->hasOne(Sappersonalarea::className(), ['value1' => 'personal_area']);
    }
    public function getStatuswo()
    {
        return $this->hasOne(WoStatus::className(), ['id' => 'status']);
    }
    public function getContract()
    {
        return $this->hasOne(Mastercontract::className(), ['id' => 'type_contract']);
    }
}
