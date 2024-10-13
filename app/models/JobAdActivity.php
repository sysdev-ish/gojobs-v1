<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "workorder_activities".
 *
 * @property int $id
 * @property int $job_id
 * @property int $candidate_id
 * @property string $action_log
 * @property string $detail_log
 * @property int $created_by
 * @property int $update_by
 * @property string $created_at
 * @property string $updated_at
 */
class JobAdActivity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'workorder_activities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['job_id', 'candidate_id', 'created_by', 'update_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['action_log'], 'string', 'max' => 50],
            [['detail_log'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'job_id' => 'Job ID',
            'candidate_id' => 'Candidate ID',
            'action_log' => 'Action Log',
            'detail_log' => 'Detail Log',
            'created_by' => 'Created By',
            'update_by' => 'Update By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
