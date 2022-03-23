<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usernonformaleducation".
 *
 * @property int $id
 * @property int $userid
 * @property string $createtime
 * @property string $updatetime
 * @property string $type
 * @property string $institutions
 * @property string $startdate
 * @property string $enddate
 * @property int $iscertificate
 *
 * @property User $user
 */
class Usernonformaleducation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usernonformaleducation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'institutions', 'startdate', 'enddate','iscertificate'], 'required'],
            [['userid', 'iscertificate'], 'integer'],
            [['createtime', 'updatetime', 'startdate', 'enddate'], 'safe'],
            [['type'], 'string'],
            [['institutions'], 'string', 'max' => 75],
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
            'type' => 'Type',
            'institutions' => 'Institutions',
            'startdate' => 'Startdate',
            'enddate' => 'Enddate',
            'iscertificate' => 'Iscertificate',
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
