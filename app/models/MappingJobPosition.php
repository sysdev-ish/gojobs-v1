<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mappingjobposition".
 *
 * @property int $id
 * @property string $jabatan_sap
 * @property string $kode_jabatan
 * @property string $kode_posisi
 * @property int $subjobfamily_id
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
            [['jabatan_sap', 'kode_jabatan', 'kode_posisi', 'subjobfamily_id'], 'required'],
            [['subjobfamily_id'], 'integer'],
            [['jabatan_sap', 'kode_jabatan', 'kode_posisi'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jabatan_sap' => 'Jabatan Sap',
            'kode_jabatan' => 'Kode Jabatan',
            'kode_posisi' => 'Kode Posisi',
            'subjobfamily_id' => 'Id Subjobfamily',
        ];
    }
}
