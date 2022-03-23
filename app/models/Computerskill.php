<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "computerskill".
 *
 * @property int $id
 * @property int $userid
 * @property string $createtime
 * @property string $updatetime
 * @property int $msword
 * @property int $msexcel
 * @property int $mspowerpoint
 * @property int $sql
 * @property int $lan
 * @property int $wan
 * @property int $pascal
 * @property int $clanguage
 * @property string $others
 * @property int $internetknowledge
 * @property string $usinginternetpurpose
 * @property string $usinginternetfrequency
 *
 * @property User $user
 */
class Computerskill extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'computerskill';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['internetknowledge', 'usinginternetpurpose', 'usinginternetfrequency'], 'required'],
            [['userid', 'msword', 'msexcel', 'mspowerpoint', 'sql', 'lan', 'wan', 'pascal', 'clanguage', 'internetknowledge','android','php','java'], 'integer'],
            [['createtime', 'updatetime'], 'safe'],
            [['others'], 'string', 'max' => 500],
            [['usinginternetpurpose', 'usinginternetfrequency'], 'string', 'max' => 255],
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
            'msword' => 'Ms Word',
            'msexcel' => 'Ms Excel',
            'mspowerpoint' => 'Ms Power Point',
            'sql' => 'SQL',
            'lan' => 'LAN',
            'wan' => 'WAN',
            'pascal' => 'Pascal',
            'clanguage' => 'C Language',
            'android' => 'Android',
            'php' => 'PHP',
            'java' => 'Java',
			'others' => Yii::t('skill', 'Others (Mention it!)'),
            'internetknowledge' => Yii::t('skill', 'Internet knowledge'),
            'usinginternetpurpose' => Yii::t('skill', 'Purpose of using the internet'),
            'usinginternetfrequency' => Yii::t('skill', 'Frequency Using the Internet (State how many times in a certain period of time)'),
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
