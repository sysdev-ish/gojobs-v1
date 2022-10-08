<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hiring".
 *
 * @property int $id
 * @property int $userid
 * @property string $createtime
 * @property string $updatetime
 * @property int $perner
 * @property int $statushiring
 * @property int $statusbiodata
 */
class Hiring extends \yii\db\ActiveRecord
{
  public $fullname;
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
        return 'hiring';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userid', 'createtime', 'updatetime', 'statushiring', 'statusbiodata'], 'required'],
            [['tglinput','awalkontrak','akhirkontrak','persa','area','skilllayanan','payrollarea','jabatan','level'], 'required', 'on'=>'approveish'],
            [['tglinput','awalkontrak','akhirkontrak'], 'required', 'on'=>'approvesso'],
            // ['recruitreqid' , 'jovalidation', 'on'=>'approve'],
            [['userid', 'perner', 'statushiring', 'statusbiodata','flaginfotype022','createdby','updateby','approvedby','rejectedby','recruitreqid'], 'integer'],
            [['message','keterangan'], 'string', 'max' => 445],
            [['createtime', 'updatetime','tglinput','awalkontrak','akhirkontrak'], 'safe'],
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
            'createtime' => 'Hiring time',
            'updatetime' => 'Updatetime',
            'perner' => 'Perner',
            'statushiring' => 'Hiring Status',
            'statusbiodata' => 'Update Data Status',
            'message' => 'SAP Message',
            'keterangan' => 'Remarks',
            'fullname' => 'Full Name',
            'tglinput' => 'Tanggal Hiring',
            'awalkontrak' => 'Awal Kontrak',
            'akhirkontrak' => 'Akhir Kontrak',
            'createdby' => 'Created by',
            'updateby' => 'Updated by',
            'approvedby' => 'Approve by',
            'recruitreqid' => 'Job Order',
        ];
    }
    public function jovalidation($attribute, $params)
    {
        $vartest = 1;
        if ($this->recruitreqid > $vartest ) {
            $this->addError($attribute, 'test salah.');
            return false;
        }
    }

    public static function getSubjob($id)
    {
        $data = Mastersubjobfamily::find()->where(['id' => $id])->select(['id', 'subjobfamily AS name'])->asArray()->all();
        return $data;
    }

    public function getUserprofile()
    {
        return $this->hasOne(Userprofile::className(), ['userid' => 'userid']);
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
    public function getChangehiring()
    {
        return $this->hasOne(Changehiring::className(), ['userid' => 'userid']);
    }
    public function getKodeJabatanSap()
    {
        return $this->hasMany(Transrincian::className(), ['jabatan_sap', 'hire_jabatan_sap']);
    }
}
