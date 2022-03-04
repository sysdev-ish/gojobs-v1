<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "userformaleducation".
 *
 * @property int $id
 * @property int $userid
 * @property string $createtime
 * @property string $updatetime
 * @property int $educationallevel
 * @property string $institutions
 * @property string $city
 * @property string $majoring
 * @property string $startdate
 * @property string $enddate
 * @property string $status
 * @property double $gpa
 *
 * @property User $user
 * @property Mastereducation $educationallevel0
 */
class Userformaleducation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'userformaleducation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['educationallevel', 'institutions', 'city', 'startdate', 'enddate', 'status', 'gpa'], 'required'],
            [['userid', 'educationallevel'], 'integer'],
            [['createtime', 'updatetime'], 'safe'],
            // [['startdate', 'enddate'], 'date'],
            [['status'], 'string'],
            [['startdate', 'enddate'], 'default', 'value' => null],
            [['gpa'], 'number', 'min'=> 1],
            [['institutions', 'city', 'majoring'], 'string', 'max' => 75],
            [['userid'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userid' => 'id']],
            [['educationallevel'], 'exist', 'skipOnError' => true, 'targetClass' => Mastereducation::className(), 'targetAttribute' => ['educationallevel' => 'idmastereducation']],
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
            'educationallevel' => 'Educationallevel',
            'institutions' => 'Institutions',
            'city' => 'City',
            'majoring' => 'Majoring',
            'startdate' => 'Startdate',
            'enddate' => 'Enddate',
            'status' => 'Status',
            'gpa' => 'Gpa',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEducationallevel0()
    {
        return $this->hasOne(Mastereducation::className(), ['idmastereducation' => 'educationallevel']);
    }
}
