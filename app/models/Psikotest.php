<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "psikotest".
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
 */
class Psikotest extends \yii\db\ActiveRecord
{
  public $fullname;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'psikotest';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userid', 'createtime', 'updatetime'], 'required'],
            // [['status','documentpsikotest'], 'required', 'on'=>'psiproc'],
            [['status'], 'required', 'on'=>'psiproc'],
            [['documentpsikotest'], 'required', 'on'=>'psiupload'],
            [['pic'], 'required', 'on'=>'updatepsi'],
            [['userid', 'status', 'recruitmentcandidateid', 'officeid', 'roomid', 'pic','officepic','method'], 'integer'],
            [['kodetoken'], 'string', 'max' => 45],

            [['createtime', 'updatetime', 'scheduledate', 'date'], 'safe'],
            [['documentpsikotest'], 'file', 'skipOnEmpty' => 'true', 'maxSize' => 3072000, 'tooBig' => 'Limit is 3Mb', 'extensions' => 'png, jpg, jpeg, pdf'],
            // [['documentpsikotest'], 'image', 'skipOnEmpty' => 'true', 'maxWidth' => 1024, 'maxHeight' => 1024, 'tooBig' => 'Limit is 3Mb', 'extensions' => 'png, jpg, jpeg'],
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
          'scheduledate' => 'Schedule for Psikotest',
          'date' => 'Date of Psikotest',
          'status' => 'Status',
          'recruitmentcandidateid' => 'Recruitmentcandidateid',
          'officeid' => 'Office',
          'officepic' => 'Office PIC',
          'roomid' => 'Room',
          'fullname' => 'Full Name',
          'pic' => 'PIC Psikotest',
          'roomid' => 'Room',
          'documentpsikotest' => 'Psychogram',
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
