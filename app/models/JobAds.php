<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "workorder".
 *
 * @property int $id
 * @property int $joborder_id id pk table atau relasi ke JO yg mau dipilih by ID
 * @property string $ref_id
 * @property string $job_number
 * @property string $job_title
 * @property int $jobfamily_id
 * @property string $jobfamily_name
 * @property string $job_description
 * @property string $job_requirement
 * @property int $type_job_ads
 * @property int $type_contract_id
 * @property string $type_contract_name
 * @property string $file_evidence
 * @property string $deadline_job
 * @property int $total_job
 * @property int $total_applied
 * @property int $location_job_id
 * @property string $location_job_name
 * @property int $level_job_id
 * @property string $level_job_name
 * @property int $salary_benefit
 * @property string $other_benefit
 * @property string $company_name
 * @property string $company_address
 * @property string $company_description
 * @property int $company_industry_id
 * @property string $company_industry_name
 * @property string $company_logo
 * @property int $expected_experience
 * @property int $status
 * @property int $flag_recruitment
 * @property int $flag_joborder
 * @property string $is_visible_company
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_time
 * @property string $updated_time
 */
class JobAds extends \yii\db\ActiveRecord
{
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
            [['joborder_id', 'jobfamily_id', 'type_job_ads', 'type_contract_id', 'total_job', 'total_applied', 'location_job_id', 'level_job_id', 'salary_benefit', 'company_industry_id', 'expected_experience', 'status', 'flag_recruitment', 'flag_joborder', 'created_by', 'updated_by'], 'integer'],
            [['ref_id'], 'required'],
            [['job_description', 'job_requirement', 'other_benefit', 'company_description', 'is_visible_company'], 'string'],
            [['deadline_job', 'created_time', 'updated_time'], 'safe'],
            [['ref_id', 'job_title', 'jobfamily_name', 'type_contract_name', 'file_evidence', 'location_job_name', 'level_job_name', 'company_name', 'company_address', 'company_industry_name', 'company_logo'], 'string', 'max' => 255],
            [['job_number'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'joborder_id' => 'Joborder ID',
            'ref_id' => 'Ref ID',
            'job_number' => 'Job Number',
            'job_title' => 'Job Title',
            'jobfamily_id' => 'Jobfamily ID',
            'jobfamily_name' => 'Jobfamily Name',
            'job_description' => 'Job Description',
            'job_requirement' => 'Job Requirement',
            'type_job_ads' => 'Type Job Ads',
            'type_contract_id' => 'Type Contract ID',
            'type_contract_name' => 'Type Contract Name',
            'file_evidence' => 'File Evidence',
            'deadline_job' => 'Deadline Job',
            'total_job' => 'Total Job',
            'total_applied' => 'Total Applied',
            'location_job_id' => 'Location Job ID',
            'location_job_name' => 'Location Job Name',
            'level_job_id' => 'Level Job ID',
            'level_job_name' => 'Level Job Name',
            'salary_benefit' => 'Salary Benefit',
            'other_benefit' => 'Other Benefit',
            'company_name' => 'Company Name',
            'company_address' => 'Company Address',
            'company_description' => 'Company Description',
            'company_industry_id' => 'Company Industry ID',
            'company_industry_name' => 'Company Industry Name',
            'company_logo' => 'Company Logo',
            'expected_experience' => 'Expected Experience',
            'status' => 'Status',
            'flag_recruitment' => 'Flag Recruitment',
            'flag_joborder' => 'Flag Joborder',
            'is_visible_company' => 'Is Visible Company',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_time' => 'Created Time',
            'updated_time' => 'Updated Time',
        ];
    }
}
