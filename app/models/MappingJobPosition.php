<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mappingjobposition".
 *
 * @property int $id
 * @property string $jabatansap
 * @property string $kodejabatan
 * @property string $kodeposisi
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
            [['jabatansap', 'kodejabatan', 'kodeposisi', 'subjobfamilyid'], 'required'],
            [['subjobfamilyid'], 'integer'],
            [['createtime', 'updatetime'], 'safe'],
            [['jabatansap', 'kodejabatan', 'kodeposisi'], 'string', 'max' => 50],
            [['jabatansap', 'kodejabatan', 'kodeposisi'], 'unique', 'targetAttribute' => ['jabatansap', 'kodejabatan', 'kodeposisi'], 'message' => 'Data sudah ada']
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
            'kodeposisi' => 'Kode Posisi',
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
        return $this->hasOne(Transrincianrekrut::className(), ['id' => 'jabatansap']);
    }
    
    public function getMasterkodeposisi()
    {
        return $this->hasOne(Transrincianrekrut::className(), ['id' => 'kodeposisi']);
    }

}
