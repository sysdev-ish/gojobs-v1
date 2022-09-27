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
 * @property string $fullname
 * @property string $cancelhiring
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
            [['createtime', 'updatetime', 'approvedtime', 'approvedtime2', 'cancelhiring'], 'safe'],
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
            'userid' => 'Userid',
            'perner' => 'Perner',
            'recruitreqid' => 'Recruitreqid',
            'newrecruitreqid' => 'New Recruitreqid',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
            'approvedtime' => 'Time Approved',
            'approvedtime2' => 'Time Approved 2',
            'createdby' => 'Createdby',
            'updatedby' => 'Updatedby',
            'approvedby' => 'Approved I',
            'approvedby2' => 'Approved II',
            'status' => 'Status',
            'documentevidence' => 'Document Evidence',
            'reason' => 'Reason',
            'remarks' => 'Remarks',
            'userremarks' => 'User Remarks',
            'fullname' => 'Fullname',
            'cancelhiring' => 'Cancel Hiring Date',
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
    public function getHiringreason()
    {
        return $this->hasOne(Masterreasonchangehiring::className(), ['id' => 'reason']);
    }
}
