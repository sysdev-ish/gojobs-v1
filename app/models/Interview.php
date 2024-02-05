<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "interview".
 *
 * @property int $id
 * @property int $userid
 * @property string $createtime
 * @property string $updatetime
 * @property string $scheduledate
 * @property string $date
 * @property int $status
 * @property int $recruitmentcandidateid
 * @property string $invitationnumber
 * @property string $documentinterview
 */
class Interview extends \yii\db\ActiveRecord
{
    public $fullname;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'interview';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['scheduledate', 'officeid'], 'required'],
            [['status'], 'required', 'on' => 'intproc'],
            [['documentinterview'], 'required', 'on' => 'intupload'],
            [['pic'], 'required', 'on' => 'update'],
            [['userid', 'status', 'recruitmentcandidateid', 'roomid', 'pic', 'officepic', 'formtypeid'], 'integer'],
            [['createtime', 'updatetime', 'scheduledate', 'date'], 'safe'],
            [['skalarating'], 'string', 'max' => 45],
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
            'scheduledate' => 'Schedule for Interview',
            'date' => 'Date of Interview',
            'status' => 'Status',
            'recruitmentcandidateid' => 'Recruitmentcandidateid',
            'officeid' => 'Office',
            'officepic' => 'Office PIC',
            'roomid' => 'Room',
            'fullname' => 'Full Name',
            'pic' => 'PIC Interview',
            'skalarating' => 'Skala Rating',
            'desc' => 'Dekripsi',
            'addinfo' => 'Keterangan/ Tambahan informasi hasil interview',
            'documentinterview' => 'Document Manual Interview'

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
