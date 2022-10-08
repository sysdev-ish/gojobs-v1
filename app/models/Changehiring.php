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
 * @property string $createtime
 * @property string $updatetime
 * @property string $approvedtime
 * @property int $createdby
 * @property int $approvedby
 * @property int $status
 * @property string $documentevidence
 * @property int $reason
 * @property string $remarks
 * @property string $userremarks
 * @property string $fullname
 * @property string $cancelhiring
 * @property string $hiringdate
 * @property string $newhiringdate
 * @property string $contractperiode
 * @property string $newcontractperiode
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
            [['userid', 'perner', 'recruitreqid', 'newrecruitreqid', 'createdby', 'approvedby', 'status', 'reason'], 'integer'],
            [['newrecruitreqid', 'newhiringdate', 'newcontractperiode'], 'required'],
            [['createtime', 'updatetime', 'approvedtime', 'cancelhiring', 'hiringdate', 'newhiringdate', 'contractperiode', 'newcontractperiode'], 'safe'],
            [['documentevidence'], 'string', 'max' => 345],
            [['remarks'], 'string', 'max' => 225],
            [['checkperner'], 'required', 'message' => 'this perner has been on processed Change Hiring', 'on' => 'createupdate'],
            [['userremarks', 'fullname'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => 'User id',
            'perner' => 'Perner',
            'recruitreqid' => 'Recruitreqid',
            'newrecruitreqid' => 'New Recruitreqid',
            'createtime' => 'Create Time',
            'updatetime' => 'Update Time',
            'approvedtime' => 'Approved Time',
            'createdby' => 'Created by',
            'approvedby' => 'Approved by',
            'status' => 'Status',
            'documentevidence' => 'Document evidence',
            'reason' => 'Reason',
            'remarks' => 'Remarks',
            'userremarks' => 'User remarks',
            'fullname' => 'Fullname',
            'cancelhiring' => 'Cancel hiring',
            'hiringdate' => 'Hiring date',
            'newhiringdate' => 'New Hiring date',
            'contractperiode' => 'Contract periode',
            'newcontractperiode' => 'New contract periode',
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
