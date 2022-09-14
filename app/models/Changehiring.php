<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "changehiring".
 *
 * @property int $id
 * @property int $userid
 * @property int $perner
 * @property int $recruitreqid
 * @property int $newrecruitreqid
 * @property string $fullname
 * @property string $cancelhiring
 * @property string $createtime
 * @property string $updatetime
 * @property string $approvedtime
 * @property string $approvedtime2
 * @property int $createdby
 * @property int $updatedby
 * @property int $approvedby
 * @property int $approvedby2
 * @property int $status
 * @property string $documentevidence
 * @property int $reason
 * @property string $remarks
 * @property string $userremarks
 */
class Changehiring extends \yii\db\ActiveRecord
{
    public $checkperner;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'changehiring';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userid', 'perner', 'recruitreqid', 'newrecruitreqid', 'createdby', 'updatedby', 'approvedby', 'approvedby2', 'status', 'reason'], 'integer'],
            [['createtime', 'updatetime', 'approvedtime', 'approvedtime2','cancelhiring'], 'safe'],
            [['documentevidence'], 'string', 'max' => 345],
            [['reason', 'cancelhiring', 'documentevidence'], 'required'],
            [['remarks'], 'string', 'max' => 225],
            [['userremarks','fullname'], 'string', 'max' => 255],
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
            'perner' => 'Perner',
            'recruitreqid' => 'Recruitreqid',
            'newrecruitreqid' => 'Newrecruitreqid',
            'fullname' => 'Fullname',
            'cancelhiring' => 'Cancel Hiring',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
            'approvedtime' => 'Approvedtime',
            'approvedtime2' => 'Approvedtime2',
            'createdby' => 'Createdby',
            'updatedby' => 'Updatedby',
            'approvedby' => 'Approvedby',
            'approvedby2' => 'Approvedby2',
            'status' => 'Status',
            'documentevidence' => 'Documentevidence',
            'reason' => 'Reason',
            'remarks' => 'Remarks',
            'userremarks' => 'Userremarks',
        ];
    }
    public function getUserprofile()
    {
        return $this->hasOne(Userprofile::className(), ['userid' => 'userid']);
    }
    public function getRecruitreqid()
    {
        return $this->hasOne(Hiring::className(), ['userid' => 'recruitreqid']);
    }
    public function getCreateduser()
    {
        return $this->hasOne(User::className(), ['id' => 'createdby']);
    }
    public function getApproveduser()
    {
        return $this->hasOne(User::className(), ['id' => 'approvedby']);
    }
    public function getApproveduser2()
    {
        return $this->hasOne(User::className(), ['id' => 'approvedby2']);
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
