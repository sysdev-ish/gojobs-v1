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
 */
class Changehiring extends \yii\db\ActiveRecord
{
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
            [['createtime', 'updatetime', 'approvedtime', 'approvedtime2'], 'safe'],
            [['documentevidence'], 'string', 'max' => 345],
            [['remarks'], 'string', 'max' => 225],
            [['userremarks'], 'string', 'max' => 255],
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
}
