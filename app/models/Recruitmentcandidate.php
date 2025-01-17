<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recruitmentcandidate".
 *
 * @property int $id
 * @property int $userid
 * @property string $createtime
 * @property string $updatetime
 * @property int $recruitreqid
 * @property int $status
 */
class Recruitmentcandidate extends \yii\db\ActiveRecord
{
  public $fullname;
  public $tglinput;
  public $awalkontrak;
  public $akhirkontrak;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recruitmentcandidate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['recruitreqid'], 'required'],
            [['userid', 'recruitreqid', 'status','method'], 'integer'],
            [['createtime', 'updatetime'], 'safe'],
            [['invitationnumber','kodetoken'], 'string', 'max' => 45],
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
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
            'recruitreqid' => 'Recruitment Request',
            'status' => 'Status',
            'fullname' => 'Full Name',
            'invitationnumber' => 'Invitation number',
            'typeinterview' => 'Type',
            'kodetoken' => 'Kode Token',
        ];
    }
    public function getUserprofile()
    {
        return $this->hasOne(Userprofile::className(), ['userid' => 'userid']);
    }
    public function getUserdata()
    {
        return $this->hasOne(Userdata::className(), ['id' => 'userid']);
    }
    public function getRecrequest()
    {
        return $this->hasOne(Transrincian::className(), ['id' => 'recruitreqid']);
    }
    public function getStatuscandidate()
    {
        return $this->hasOne(Masterstatuscandidate::className(), ['id' => 'status']);
    }
    public function getHiringproc()
    {
        return $this->hasMany(Hiring::className(), ['userid' => 'userid']);
    }
}
