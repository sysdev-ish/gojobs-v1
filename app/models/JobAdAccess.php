<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "workorder_setting_access".
 *
 * @property int $id
 * @property int $workorder_id
 * @property string $user_pic_id
 * @property string $user_name
 * @property string $email
 * @property int $office_id
 * @property string $office_name
 * @property int $role_id
 * @property string $role_name
 * @property string $created_by
 * @property string $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class JobAdAccess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'workorder_setting_access';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['workorder_id', 'office_id', 'role_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_pic_id', 'user_name', 'email', 'office_name', 'role_name', 'created_by', 'updated_by'], 'string', 'max' => 255],
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
            'user_pic_id' => 'User Pic ID',
            'user_name' => 'User Name',
            'email' => 'Email',
            'office_id' => 'Office ID',
            'office_name' => 'Office Name',
            'role_id' => 'Role ID',
            'role_name' => 'Role Name',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
