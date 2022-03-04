<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "taktif".
 *
 * @property int $id
 * @property int $userid
 * @property string $createtime
 * @property string $updatetime
 * @property string $scheduledate
 * @property string $date
 * @property int $status
 * @property int $recruitmentcandidateid
 * @property int $officeid
 * @property int $roomid
 * @property int $pic
 * @property string $desc
 * @property string $addinfo
 * @property int $officepic
 */
class Taktif extends \yii\db\ActiveRecord
{
  public $fullname;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'taktif';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
          [['scheduledate'], 'required'],
          [['status','enddate'], 'required', 'on'=>'tproc'],
            [['userid', 'createtime', 'updatetime', 'scheduledate'], 'required'],
            [['userid', 'status', 'recruitmentcandidateid', 'officeid', 'roomid', 'pic', 'officepic'], 'integer'],
            [['createtime', 'updatetime', 'scheduledate', 'date','enddate'], 'safe'],
            [['desc', 'addinfo'], 'string', 'max' => 1045],
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
            'scheduledate' => 'Scheduledate',
            'date' => 'Date',
            'enddate' => 'End Date',
            'status' => 'Status',
            'recruitmentcandidateid' => 'Recruitmentcandidateid',
            'officeid' => 'Officeid',
            'roomid' => 'Roomid',
            'pic' => 'Pic',
            'desc' => 'Desc',
            'addinfo' => 'Addinfo',
            'officepic' => 'Officepic',
        ];
    }
    public function getUserprofile()
    {
        return $this->hasOne(Userprofile::className(), ['userid' => 'userid']);
    }
    public function getUserdata()
    {
        return $this->hasOne(Userdata::className(), ['id' => 'userid']);
    }
    public function getUserpic()
    {
        return $this->hasOne(Userdata::className(), ['id' => 'pic']);
    }
    public function getReccandidate()
    {
        return $this->hasOne(Recruitmentcandidate::className(), ['id' => 'recruitmentcandidateid']);
    }
    public function getMasteroffice()
    {
        return $this->hasOne(Masteroffice::className(), ['id' => 'officeid']);
    }
    public function getMasterroom()
    {
        return $this->hasOne(Masterroom::className(), ['id' => 'roomid']);
    }
    public function getStatusprocess()
    {
        return $this->hasOne(Masterstatusprocess::className(), ['id' => 'status']);
    }
}
