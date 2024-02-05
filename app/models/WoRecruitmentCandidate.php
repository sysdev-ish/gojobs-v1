<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wo_recruitment_candidate".
 *
 * @property int $id
 * @property int $user_id
 * @property int $wo_id
 * @property string $create_time
 * @property string $update_time
 * @property string $token
 * @property string $invitation_number
 * @property int $created_by
 * @property int $approved_by
 * @property int $method
 * @property int $status
 * @property int $type_interview
 *
 * @property User $user
 * @property Workorder $wo
 */
class WoRecruitmentCandidate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wo_recruitment_candidate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'wo_id', 'created_time', 'updated_time'], 'required'],
            [['user_id', 'wo_id', 'created_by', 'approved_by', 'method', 'status', 'type_interview'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['token', 'invitation_number'], 'string', 'max' => 45],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['wo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Workorder::className(), 'targetAttribute' => ['wo_id' => 'id']],
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
            'wo_id' => 'Wo ID',
            'created_time' => 'Create Time',
            'updated_time' => 'Update Time',
            'token' => 'Token',
            'invitation_number' => 'Invitation Number',
            'created_by' => 'Created By',
            'approved_by' => 'Approved By',
            'type_interview' => 'Type Interview',
            'method' => 'Method',
            'status' => 'Status',
            'created_time' => 'Created Time',
            'updated_time' => 'Updated Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserprofile()
    {
        return $this->hasOne(Userprofile::className(), ['userid' => 'user_id']);
    }
    public function getUserdata()
    {
        return $this->hasOne(Userdata::className(), ['id' => 'user_id']);
    }
    public function getWorkorder()
    {
        return $this->hasOne(Workorder::className(), ['id' => 'wo_id']);
    }
    public function getStatuscandidate()
    {
        return $this->hasOne(Masterstatuscandidate::className(), ['id' => 'status']);
    }
    public function getHiring()
    {
        return $this->hasMany(WoHiring::className(), ['userid' => 'user_id']);
    }
}
