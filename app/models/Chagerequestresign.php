<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chagerequestresign".
 *
 * @property int $id
 * @property int $userid
 * @property string $createtime
 * @property string $updatetime
 * @property string $approvedtime
 * @property string $approvedtime2
 * @property int $createdby
 * @property int $updatedby
 * @property int $perner
 * @property string $fullname
 * @property int $reason
 * @property string $resigndate
 * @property int $approvedby
 * @property int $approvedby2
 * @property int $status
 * @property string $remarks
 */
class Chagerequestresign extends \yii\db\ActiveRecord
{
  public $checkperner;
  public $file_upload;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chagerequestresign';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userid', 'createdby', 'updatedby', 'perner', 'reason', 'approvedby', 'status','checkperner'], 'integer'],
            [['status'], 'required', 'on'=>"approve"],
            [['createtime', 'updatetime', 'approvedtime',  'resigndate'], 'safe'],
            [['approvedby', 'resigndate', 'reason', 'perner'], 'required' , 'on'=>'createupdate'],
            // [['reason', 'resigndate','approvedby','perner'], 'required' , 'on'=>'createupdate'],
            [['checkperner'], 'required','message'=>'this perner has been on processed resign', 'on'=>'createupdate'],
            [['fullname', 'remarks','userremarks', 'file_upload'], 'string', 'max' => 255],
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
            'createtime' => 'Create time',
            'updatetime' => 'Update time',
            'approvedtime' => 'Approved time',
            'createdby' => 'Createdby',
            'updatedby' => 'Updatedby',
            'perner' => 'Perner',
            'fullname' => 'Fullname',
            'reason' => 'Reason',
            'resigndate' => 'Resign date',
            'approvedby' => 'Approved by',
            'status' => 'Status',
            'remarks' => 'Remarks',
            'file_upload' => 'File Upload',
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

    public function getHiring()
    {
        return $this->hasOne(Hiring::className(), ['userid' => 'userid']);
    }
}
