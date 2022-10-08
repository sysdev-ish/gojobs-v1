<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "changecanceljoin".
 *
 * @property int $id
 * @property int $userid
 * @property string $createtime
 * @property string $updatetime
 * @property int $createdby
 * @property int $perner
 * @property string $fullname
 * @property int $reason
 * @property string $canceldate
 * @property int $approvedby
 * @property string $approvedtime
 * @property int $status
 * @property string $documentevidence
 * @property string $remarks
 */
class Changecanceljoin extends \yii\db\ActiveRecord
{
    public $checkperner;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'changecanceljoin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userid', 'createdby', 'perner', 'reason', 'approvedby', 'status'], 'integer'],
            [['documentevidence', 'reason'], 'required', 'on' => "create"],
            [['status'], 'required', 'on' => "approve"],
            [['createtime', 'updatetime', 'canceldate', 'approvedtime'], 'safe'],
            [['reason', 'canceldate','documentevidence'], 'required'],
            [['fullname'], 'string', 'max' => 445],
            [['checkperner'], 'required', 'message' => 'this perner has been on processed Cancel Join', 'on' => 'createupdate'],
            [['documentevidence'], 'string', 'max' => 225],
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
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
            'createdby' => 'Created by',
            'perner' => 'Perner',
            'fullname' => 'Fullname',
            'reason' => 'Reason',
            'canceldate' => 'Canceldate',
            'approvedby' => 'Approved by',
            'approvedtime' => 'Time Approved',
            'status' => 'Status',
            'documentevidence' => 'Document Evidence',
        ];
    }

    public function getUserprofile()
    {
        return $this->hasOne(Userprofile::className(), ['userid' => 'userid']);
    }
    public function getUserid()
    {
        return $this->hasOne(Hiring::className(), ['userid' => 'userid']);
    }
    public function getCreateduser()
    {
        return $this->hasOne(User::className(), ['id' => 'createdby']);
    }
    public function getApproveduser()
    {
        return $this->hasOne(User::className(), ['id' => 'approvedby']);
    }
    public function getStatusprocess()
    {
        return $this->hasOne(Masterstatuscr::className(), ['id' => 'status']);
    }
    public function getCanceljoinreason()
    {
        return $this->hasOne(Masterreasoncanceljoin::className(), ['id' => 'reason']);
    }
}
