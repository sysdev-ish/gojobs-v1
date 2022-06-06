<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "changejo".
 *
 * @property int $id
 * @property int $recruitreqid
 * @property string $createtime
 * @property string $updatetime
 * @property string $approvedtime
 * @property string $approvedtime2
 * @property int $createdby
 * @property int $updatedby
 * @property int $approvedby
 * @property int $approvedby2
 * @property int $status
 * @property string $remarks
 * @property int $oldjumlah
 * @property int $jumlahstop
 * @property int $jumlah
 * @property string $documentevidence
 * @property int $reason
 * @property int $typeapproval
 */
class Changejo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'changejo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['recruitreqid', 'createdby', 'updatedby', 'approvedby', 'approvedby2', 'status', 'oldjumlah', 'jumlahstop', 'jumlah', 'reason', 'typeapproval'], 'integer'],
            [['createtime', 'updatetime', 'approvedtime', 'approvedtime2'], 'safe'],
            [['remarks'], 'string', 'max' => 445],
            [['documentevidence'], 'string', 'max' => 345],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'recruitreqid' => 'Recruitreqid',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
            'approvedtime' => 'Approvedtime',
            'approvedtime2' => 'Approvedtime2',
            'createdby' => 'Createdby',
            'updatedby' => 'Updatedby',
            'approvedby' => 'Approvedby',
            'approvedby2' => 'Approvedby2',
            'status' => 'Status',
            'remarks' => 'Remarks',
            'oldjumlah' => 'Oldjumlah',
            'jumlahstop' => 'Jumlahstop',
            'jumlah' => 'Jumlah',
            'documentevidence' => 'Documentevidence',
            'reason' => 'Reason',
            'typeapproval' => 'Typeapproval',
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
