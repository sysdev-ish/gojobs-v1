<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chagerequestdata".
 *
 * @property int $id
 * @property int $userid
 * @property string $createtime
 * @property string $updatetime
 * @property string $approvedtime
 * @property int $createdby
 * @property int $updatedby
 * @property int $approvedby
 * @property int $kategorydata
 */
class Chagerequestdata extends \yii\db\ActiveRecord
{
  public $approvedbyname;
  public $approvedby2name;
  public $personaldatafill;
  public $cekemp;
  public $checkperner;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chagerequestdata';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userid', 'createdby', 'updatedby', 'approvedby', 'kategorydata','cekemp','statusresign', 'checkperner'], 'integer'],
            [['status','remarks'], 'required', 'on' => 'approve'],
            [['checkperner'], 'required', 'message' => 'This perner has been on processed Change Data Bank', 'on' => 'createupdate'],
            [['approvedby','personaldatafill'], 'required', 'on' => 'submit'],
            [['createtime', 'updatetime', 'approvedtime','resigndate'], 'safe'],
            [['resignreason'], 'string', 'max' => 445],

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
            'createtime' => 'Create Date',
            'updatetime' => 'Update Date',
            'approvedtime' => 'Approved Date',
            'createdby' => 'Created by',
            'updatedby' => 'Updated by',
            'approvedby' => 'Approved by',
            'kategorydata' => 'Category data',
            'personaldatafill' => 'Change request data',
            'cekemp' => 'Data Pekerja',
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
    public function getApproveduser2()
    {
        return $this->hasOne(User::className(), ['id' => 'approvedby2']);
    }
    public function getCrtransdata()
    {
        return $this->hasOne(Crdtransaction::className(), ['crdid' => 'id']);
    }
    public function getStatusprocess()
    {
        return $this->hasOne(Masterstatuscr::className(), ['id' => 'status']);
    }
}
