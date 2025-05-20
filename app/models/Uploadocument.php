<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "uploadocument".
 *
 * @property int $id
 * @property int $userid
 * @property string $createtime
 * @property string $updatetime
 * @property string $ijazah
 * @property string $transkipnilai
 * @property string $suratketerangansehat
 * @property string $kartukeluarga
 * @property string $ktp
 * @property string $jamsostek
 * @property string $bpjskesehatan
 * @property string $npwp
 */
class Uploadocument extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'uploadocument';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ktp'], 'required', 'on' => 'create'],
            [['userid'], 'integer'],
            [['createtime', 'updatetime'], 'safe'],
            // [['ijazah', 'transkipnilai', 'suratketerangansehat', 'kartukeluarga', 'ktp', 'jamsostek', 'bpjskesehatan', 'npwp'], 'string', 'max' => 145],
            // [['ijazah', 'transkipnilai', 'suratketerangansehat', 'kartukeluarga', 'ktp', 'jamsostek', 'bpjskesehatan', 'npwp'], 'file', 'skipOnEmpty' => 'false', 'extensions' => 'png, jpg, jpeg, pdf'],
            [['ijazah', 'transkipnilai', 'suratketerangansehat', 'kartukeluarga', 'ktp', 'jamsostek', 'bpjskesehatan', 'npwp','suratlamarankerja'], 'file', 'skipOnEmpty' => 'true', 'maxSize' => 3072000, 'tooBig' => 'Limit is 3Mb', 'extensions' => 'png, jpg, jpeg, pdf'],
            // [['ijazah', 'transkipnilai', 'suratketerangansehat', 'kartukeluarga', 'ktp', 'jamsostek', 'bpjskesehatan', 'npwp'], 'image', 'skipOnEmpty' => 'true', 'maxWidth' => 1024, 'maxHeight' => 1024, 'tooBig' => 'Limit is 3Mb', 'extensions' => 'png, jpg, jpeg, pdf'],
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
            'ijazah' => 'Ijazah',
            'transkipnilai' => 'Transkipnilai',
            'suratketerangansehat' => 'Surat keterangan sehat',
            'kartukeluarga' => 'Kartu keluarga',
            'ktp' => 'KTP',
            'jamsostek' => 'Jamsostek',
            'bpjskesehatan' => 'BPJS Kesehatan',
            'npwp' => 'NPWP',
            'suratlamarankerja' => 'Surat Lamaran Kerja',
        ];
    }
}
