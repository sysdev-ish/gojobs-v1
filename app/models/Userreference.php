<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "userreference".
 *
 * @property int $id
 * @property int $userid
 * @property string $createtime
 * @property string $updatetime
 * @property string $fullname
 * @property string $address
 * @property string $phone
 * @property string $jobtitle
 * @property string $relationship
 *
 * @property User $user
 */
class Userreference extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'userreference';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fullname', 'address', 'phone', 'jobtitle', 'relationship'], 'required'],
            [['userid'], 'integer'],
            [['createtime', 'updatetime'], 'safe'],
            [['fullname'], 'string', 'max' => 255],
            [['address'], 'string', 'max' => 500],
            [['phone'], 'string', 'max' => 45],
            [['jobtitle', 'relationship'], 'string', 'max' => 75],
            [['userid'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userid' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => 'Userid',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
            'fullname' => 'Fullname',
            'address' => 'Address',
            'phone' => 'Phone',
            'jobtitle' => 'Jobtitle',
            'relationship' => 'Relationship',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userid']);
    }
}
