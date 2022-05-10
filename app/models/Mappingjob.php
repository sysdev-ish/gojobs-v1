<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mappingjob".
 *
 * @property int $id
 * @property int $subjobfamilyid
 * @property int $kodejabatan
 * @property string $jabatansap
 * @property int $status
 * @property string $createtime
 * @property string $updatetime
 */
class Mappingjob extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mappingjob';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subjobfamilyid', 'kodejabatan', 'jabatansap', 'status', 'createtime', 'updatetime'], 'required'],
            [['subjobfamilyid', 'kodejabatan', 'status'], 'integer'],
            [['createtime', 'updatetime'], 'safe'],
            [['jabatansap'], 'string', 'max' => 256],
            [['jabatansap', 'kodejabatan'], 'unique', 'targetAttribute' => ['jabatansap', 'kodejabatan'], 'message' => 'Data sudah ada']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subjobfamilyid' => 'Sub Job Family',
            'kodejabatan' => 'Kode Jabatan',
            'jabatansap' => 'Jabatan Sap',
            'status' => 'Status',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
        ];
    }
    public function getSubjobfam()
    {
        return $this->hasOne(Mastersubjobfamily::className(), ['id' => 'subjobfamilyid']);
    }

    public function getKodejabatan()
    {
        return $this->hasOne(Transrincian::className(), ['hire_jabatan_sap'=> 'kodejabatan']);
    }

    // public function getTransrincian()
    // {
    //     return $this->hasOne(Transrincian::className(), ['hire_jabatan_sap' => 'kodejabatan']);
    // }
}
