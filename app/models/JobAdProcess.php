<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "workorder_setting_process".
 *
 * @property int $id
 * @property int $workorder_id
 * @property string $is_process_screening
 * @property string $is_process_psikotest
 * @property string $is_process_interview
 * @property string $is_process_user_interview
 * @property string $is_process_hiring
 * @property string $is_process_other
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class JobAdProcess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'workorder_setting_process';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['workorder_id', 'created_by', 'updated_by'], 'integer'],
            [['is_process_screening', 'is_process_psikotest', 'is_process_interview', 'is_process_user_interview', 'is_process_hiring', 'is_process_other'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'workorder_id' => 'Workorder ID',
            'is_process_screening' => 'Is Process Screening',
            'is_process_psikotest' => 'Is Process Psikotest',
            'is_process_interview' => 'Is Process Interview',
            'is_process_user_interview' => 'Is Process User Interview',
            'is_process_hiring' => 'Is Process Hiring',
            'is_process_other' => 'Is Process Other',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
