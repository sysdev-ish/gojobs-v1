<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wo_hiring".
 *
 * @property int $id
 * @property int $user_id
 * @property int $wo_id
 * @property string $create_time
 * @property string $update_time
 * @property int $type_wo
 * @property int $hiring_status
 * @property int $created_by
 * @property int $updated_by
 * @property int $approved_by
 * @property int $rejected_by
 * @property string $message
 *
 * @property User $user
 */
class WoHiring extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wo_hiring';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'wo_id', 'create_time', 'update_time'], 'required'],
            [['user_id', 'wo_id', 'type_wo', 'hiring_status', 'created_by', 'updated_by', 'approved_by', 'rejected_by'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['message'], 'string', 'max' => 255],
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
            'wo_id' => 'Wo ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'type_wo' => 'Type WO',
            'hiring_status' => 'Hiring Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'approved_by' => 'Approved By',
            'rejected_by' => 'Rejected By',
            'message' => 'Message',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
