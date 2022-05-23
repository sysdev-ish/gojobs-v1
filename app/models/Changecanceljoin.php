<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chagecanceljoin".
 *
 * @property int $id
 * @property int $userid
 * @property string $createtime
 * @property string $updatetime
 * @property int $createdby
 * @property int $updatedby
 * @property int $perner
 * @property string $fullname
 * @property int $reason
 * @property string $canceldate
 * @property int $approvedby
 * @property string $approvedtime
 * @property int $status
 * @property string $remarks
 * @property string $userremarks
 */
class Changecanceljoin extends \yii\db\ActiveRecord
{
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
            [['userid', 'createdby', 'updatedby', 'perner', 'reason', 'approvedby', 'status'], 'integer'],
            [['createtime', 'updatetime', 'canceldate', 'approvedtime'], 'safe'],
            [['reason', 'canceldate'], 'required'],
            [['fullname', 'remarks', 'userremarks'], 'string', 'max' => 445],
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
            'createtime' => 'Create Time',
            'updatetime' => 'Update Time',
            'createdby' => 'Created By',
            'updatedby' => 'Updated By',
            'perner' => 'Perner',
            'fullname' => 'Fullname',
            'reason' => 'Reason',
            'canceldate' => 'Cancel Date',
            'approvedby' => 'Approved By',
            'approvedtime' => 'Approved Time',
            'status' => 'Status',
            'remarks' => 'Remarks',
            'userremarks' => 'User Remarks',
        ];
    }
    public function getUserprofile()
    {
        return $this->hasOne(Userprofile::className(), ['userid' => 'userid']);
    }
    public function getCreateduser()
    {
        return $this->hasOne(User::className(), ['id' => 'createdby']);
    }
    public function getUpdateduser()
    {
        return $this->hasOne(User::className(), ['id' => 'updatedby']);
    }
    public function getApproveduser()
    {
        return $this->hasOne(User::className(), ['id' => 'approvedby']);
    }
    public function getStatusprocess()
    {
        return $this->hasOne(Masterstatuscr::className(), ['id' => 'status']);
    }
    public function getResignreason()
    {
        return $this->hasOne(Masterresignreason::className(), ['id' => 'reason']);
    }
}
