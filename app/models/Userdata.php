<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $username
 * @property string $name
 * @property string $email
 * @property string $mobile
 * @property string $password_hash
 * @property int $status
 * @property string $verify_code
 * @property string $auth_key
 * @property string $role
 * @property int $verify_status
 */
class Userdata extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'username', 'email', 'mobile', 'password_hash'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['status', 'verify_status'], 'integer'],
            [['username', 'email', 'mobile', 'verify_code'], 'string', 'max' => 75],
            [['name'], 'string', 'max' => 225],
            [['password_hash'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['role'], 'string', 'max' => 45],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['mobile'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'username' => 'Username',
            'name' => 'Name',
            'email' => 'Email',
            'mobile' => 'Mobile',
            'password_hash' => 'Password Hash',
            'status' => 'Status',
            'verify_code' => 'Code',
            'auth_key' => 'Auth Key',
            'role' => 'Role',
            'verify_status' => 'Verify Status',
        ];
    }
}
