<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mappingjob_position".
 *
 * @property int $id
 * @property string $jabatan_sap
 * @property string $kode_jabatan
 * @property string $kode_posisi
 * @property int $id_subjobfamily
 */
class Mappingjobposition extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mappingjob_position';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jabatan_sap', 'kode_jabatan', 'kode_posisi', 'id_subjobfamily'], 'required'],
            [['id_subjobfamily'], 'integer'],
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
            'id_subjobfamily' => 'Id Subjobfamily',
        ];
    }
}
