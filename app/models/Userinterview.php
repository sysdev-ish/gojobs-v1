<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "userinterview".
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
class Userinterview extends \yii\db\ActiveRecord
{
    public $fullname;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'userinterview';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userid', 'createtime', 'updatetime'], 'required'],
            [['status', 'desc'], 'required', 'on' => 'uintproc'],
            [['pic'], 'required', 'on' => 'updateuint'],
            [['userid', 'status', 'recruitmentcandidateid', 'officeid', 'roomid', 'pic', 'officepic'], 'integer'],
            [['createtime', 'updatetime', 'scheduledate', 'date'], 'safe'],
            [['desc', 'addinfo'], 'string', 'max' => 1045],
            [['penandatangan'], 'string', 'max' => 145],
            [['documentinterview'], 'file', 'skipOnEmpty' => 'true', 'maxSize' => 3072000, 'tooBig' => 'Limit is 3Mb', 'extensions' => 'png, jpg, jpeg, pdf'],
            ['documentinterview', 'required', 'when' => function ($model) {
                return $model->status;
            }, 'whenClient' => new \yii\web\JsExpression("
                function (attribute, value) {
                    return ($('#userinterview-status').val() == 2);
                }
            ")],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => 'User ID',
            'createtime' => 'Create Time',
            'updatetime' => 'Update Time',
            'scheduledate' => 'Schedule for User Interview',
            'date' => 'Date of User Interview',
            'status' => 'Status',
            'recruitmentcandidateid' => 'Recruitmentcandidateid',
            'officeid' => 'Office',
            'officepic' => 'Office PIC',
            'fullname' => 'Full Name',
            'pic' => 'PIC User Interview',
            'roomid' => 'Room',
            'desc' => 'Dekripsi',
            'addinfo' => 'Keterangan / Tambahan informasi hasil interview ',
            'penandatangan' => 'Nama Tandatangan Pewawancara',
            'documentinterview' => 'Upload Form Interview ',
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
