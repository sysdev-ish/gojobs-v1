<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wo_recruitment_interview".
 *
 * @property int $id
 * @property int $user_id
 * @property int $candidate_id
 * @property string $create_time
 * @property string $update_time
 * @property string $schedule_date
 * @property string $schedulte_time
 * @property int $office_id
 * @property int $room_id
 * @property int $pic_id
 * @property string $rating
 * @property string $description
 * @property string $additional_info
 * @property int $form_id
 * @property string $document_interview
 *
 * @property WoRecruitmentForm $form
 * @property User $user
 */
class WoRecruitmentInterview extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wo_recruitment_interview';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'candidate_id', 'office_id', 'room_id', 'pic_id', 'form_id'], 'integer'],
            [['candidate_id', 'create_time'], 'required'],
            [['create_time', 'update_time', 'schedule_date', 'schedulte_time'], 'safe'],
            [['rating'], 'string', 'max' => 45],
            [['description', 'additional_info', 'document_interview'], 'string', 'max' => 255],
            [['form_id'], 'exist', 'skipOnError' => true, 'targetClass' => WoRecruitmentForm::className(), 'targetAttribute' => ['form_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'schedule_date' => 'Schedule Date',
            'schedulte_time' => 'Schedulte Time',
            'office_id' => 'Office ID',
            'room_id' => 'Room ID',
            'pic_id' => 'Pic ID',
            'rating' => 'Rating',
            'description' => 'Description',
            'additional_info' => 'Additional Info',
            'form_id' => 'Form ID',
            'document_interview' => 'Document Interview',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForm()
    {
        return $this->hasOne(WoRecruitmentForm::className(), ['id' => 'form_id']);
    }

    public function getUserprofile()
    {
        return $this->hasOne(Userprofile::className(), ['userid' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getCandidate()
    {
        return $this->hasOne(WoRecruitmentCandidate::className(), ['id' => 'candidate_id']);
    }
}
