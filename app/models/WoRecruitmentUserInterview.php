<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wo_recruitment_user_interview".
 *
 * @property int $id
 * @property int $user_id
 * @property int $candidate_id
 * @property string $created_time
 * @property string $updated_time
 * @property string $schedule_date
 * @property string $schedule_time
 * @property int $office_id
 * @property int $room_id
 * @property int $pic_id
 * @property string $rating
 * @property string $description
 * @property string $additional_info
 * @property int $signature_by
 * @property string $document_interview
 */
class WoRecruitmentUserInterview extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wo_recruitment_user_interview';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'candidate_id', 'created_time'], 'required'],
            [['user_id', 'candidate_id', 'office_id', 'room_id', 'pic_id', 'signature_by'], 'integer'],
            [['created_time', 'updated_time', 'schedule_date', 'schedule_time'], 'safe'],
            [['rating', 'description', 'additional_info', 'document_interview'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'candidate_id' => 'Candidate ID',
            'created_time' => 'Created Time',
            'updated_time' => 'Updated Time',
            'schedule_date' => 'Schedule Date',
            'schedule_time' => 'Schedule Time',
            'office_id' => 'Office ID',
            'room_id' => 'Room ID',
            'pic_id' => 'Pic ID',
            'rating' => 'Rating',
            'description' => 'Description',
            'additional_info' => 'Additional Info',
            'signature_by' => 'Signature By',
            'document_interview' => 'Document Interview',
        ];
    }
}
