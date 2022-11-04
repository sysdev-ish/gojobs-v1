<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "changehiring".
 *
 * @property int $id
 * @property int $userid
 * @property int $newuserid
 * @property int $perner
 * @property int $recruitreqid
 * @property int $oldrecruitreqid
 * @property string $createtime
 * @property string $updatetime
 * @property string $approvedtime
 * @property int $createdby
 * @property int $approvedby
 * @property int $status
 * @property string $remarks
 * @property int $reason
 * @property string $fullname
 * @property string $cancelhiring
 * @property string $hiringdate
 * @property string $newhiringdate
 * @property string $contractperiode
 * @property string $newcontractperiode
 * @property int $typechangehiring
 * @property string $userremarks
 * @property int $flag
 */
class Changehiring extends \yii\db\ActiveRecord
{
    public $checkperner;
    public $persa;
    public $area;
    public $skilllayanan;
    public $payrollarea;
    public $jabatan;
    public $level;
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
            [['userid', 'perner', 'recruitreqid', 'oldrecruitreqid', 'createdby', 'approvedby', 'status', 'reason', 'typechangehiring', 'flag'], 'integer'],
            // [['oldrecruitreqid', 'newhiringdate', 'newcontractperiode'], 'required'],
            [['createtime', 'updatetime', 'approvedtime','remarks', 'userremarks', 'cancelhiring', 'hiringdate', 'newhiringdate', 'contractperiode', 'newcontractperiode'], 'safe'],
            [['checkperner'], 'required', 'message' => 'this perner has been on processed Change Hiring', 'on' => 'createupdate'],
            [['fullname'], 'string', 'max' => 255],
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
            'newuserid' => 'User id Replacement',
            'perner' => 'Perner',
            'recruitreqid' => 'Recruitreqid',
            'oldrecruitreqid' => 'Existing Recruitreqid',
            'createtime' => 'Create Time',
            'updatetime' => 'Update Time',
            'approvedtime' => 'Approved Time',
            'createdby' => 'Created by',
            'approvedby' => 'Approved by',
            'status' => 'Status',
            'remarks' => 'Remarks',
            'userremarks' => 'User Remarks',
            'reason' => 'Reason',
            'typechangehiring' => 'Type Change Hiring',
            'fullname' => 'Fullname',
            'cancelhiring' => 'Cancel hiring',
            'hiringdate' => 'Hiring date',
            'newhiringdate' => 'Existing Hiring date',
            'contractperiode' => 'Contract periode',
            'newcontractperiode' => 'Existing contract periode',
            'flag' => 'Flag',
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
    public function getChangehiringreason()
    {
        return $this->hasOne(Masterreasonchangehiring::className(), ['id' => 'reason']);
    }
    public function getReccan()
    {
        return $this->hasOne(Recruitmentcandidate::className(), ['userid' => 'userid']);
    }
    public function getUseredu()
    {
        return $this->hasOne(Userformaleducation::className(), ['userid' => 'userid']);
    }
    public function getStatushiring0()
    {
        return $this->hasOne(Masterstatushiring::className(), ['id' => 'statushiring']);
    }
    public function getStatusbiodata0()
    {
        return $this->hasOne(Masterstatushiring::className(), ['id' => 'statusbiodata']);
    }
    public function getRecrequest()
    {
        return $this->hasOne(Transrincian::className(), ['id' => 'recruitreqid']);
    }
    public function getoldrecrequest()
    {
        return $this->hasOne(Transrincian::className(), ['id' => 'oldrecruitreqid']);
    }
    public function getMail()
    {
        return $this->hasOne(Userlogin::className(), ['id' => 'userid']);
    }
    public function getCreatedbyu()
    {
        return $this->hasOne(Userlogin::className(), ['id' => 'createdby']);
    }
    public function getUpdatebyu()
    {
        return $this->hasOne(Userlogin::className(), ['id' => 'updateby']);
    }
    public function getApprovedbyu()
    {
        return $this->hasOne(Userlogin::className(), ['id' => 'approvedby']);
    }
    public function getRejectedbyu()
    {
        return $this->hasOne(Userlogin::className(), ['id' => 'rejectedby']);
    }
    public function getChangereqdata()
    {
        return $this->hasOne(Chagerequestdata::className(), ['userid' => 'userid']);
    }
    public function getChangecanceljoin()
    {
        return $this->hasOne(Changecanceljoin::className(), ['userid' => 'userid']);
    }
    public function getKodeJabatanSap()
    {
        return $this->hasMany(Transrincian::className(), ['jabatan_sap', 'hire_jabatan_sap']);
    }

}
