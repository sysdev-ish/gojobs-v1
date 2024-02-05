<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "userworkexperience".
 *
 * @property int $id
 * @property int $userid
 * @property string $createtime
 * @property string $updatetime
 * @property string $companyname
 * @property string $companyaddress
 * @property string $startdate
 * @property string $enddate
 *
 * @property User $user
 * @property Userworkexperienceposition[] $userworkexperiencepositions
 */
class Userworkexperience extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'userworkexperience';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['companyname', 'companyaddress', 'startdate', 'enddate','lastposition','salary','jobdesc'], 'required'],
            [['userid','salary'], 'integer'],
            [['createtime', 'updatetime', 'startdate', 'enddate'], 'safe'],
            [['companyname', 'companyaddress'], 'string', 'max' => 255],
            [['jobdesc'], 'string', 'max' => 500],
            [['lastposition','industry'], 'string', 'max' => 256],
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
            'createtime' => 'Create Time',
            'updatetime' => 'Update Time',
            'companyname' => 'Company name',
            'companyaddress' => 'Company address',
            'startdate' => 'Start date',
            'enddate' => 'End date',
            'lastposition' => 'Last Position',
            'industry' => 'Industry',
            'Salary' => 'Salary',
            'jobdesc' => 'Job Description',
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
    public function getUserworkexperiencepositions()
    {
        return $this->hasMany(Userworkexperienceposition::className(), ['idworkexperience' => 'id']);
    }
    public function getSubjobfam()
    {
        return $this->hasOne(Mastersubjobfamily::className(), ['subjobfamily' => 'lastposition']);
    }
}
