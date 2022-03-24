<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mappingjobposition".
 *
 * @property int $id
 * @property string $jabatansap
 * @property string $kodejabatan
 * @property int $status
 * @property int $subjobfamilyid
 */
class Mappingjobposition extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mappingjobposition';
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            [['jabatansap', 'kodejabatan', 'status', 'subjobfamilyid'], 'required'],
            [['subjobfamilyid', 'status'], 'integer'],
            [['createtime', 'updatetime'], 'safe'],
            [['jabatansap', 'kodejabatan'], 'string', 'max' => 50],
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
            'jabatansap' => 'Jabatan Sap',
            'kodejabatan' => 'Kode Jabatan',
            'status' => 'Status',
            'subjobfamilyid' => 'Sub Job Family',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
        ];
    }
    public function getMastersubjobfamily()
    {
        return $this->hasOne(Mastersubjobfamily::className(), ['id' => 'subjobfamilyid']);
    }

    public function getMasterjabatansap()
    {
        return $this->hasOne(Sapjob::className(), ['value1' => 'jabatansap']);
    }
    
    public function getMasterkodejabatan()
    {
        return $this->hasOne(Transrincianrekrut::className(), ['id' => 'kodejabatan']);
    }

}
