<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "trans_komponen".
 *
 * @property int $id
 * @property string $nojo
 * @property string $area
 * @property string $area_txt
 * @property string $jabatan
 * @property string $jabatan_txt
 * @property string $level
 * @property string $level_txt
 * @property string $skill
 * @property string $skill_text
 * @property int $jumlah
 * @property int $ump
 * @property string $komponen
 * @property string $komponen_txt
 * @property string $value
 * @property string $hk_pembagi
 * @property string $keterangan
 * @property string $persentase
 * @property string $perusahaan
 * @property string $karyawan
 * @property string $jkk
 * @property string $jkm
 * @property string $jht_per
 * @property string $jht_kar
 * @property string $upd
 * @property string $lup
 */
class Transkomponen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trans_komponen';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('dbjo');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jumlah', 'ump'], 'integer'],
            [['lup'], 'safe'],
            [['nojo', 'area', 'skill', 'value', 'perusahaan', 'karyawan', 'jkk', 'jkm', 'jht_per', 'jht_kar', 'upd'], 'string', 'max' => 50],
            [['area_txt', 'jabatan_txt', 'level_txt', 'skill_text', 'komponen_txt', 'keterangan'], 'string', 'max' => 150],
            [['jabatan', 'level'], 'string', 'max' => 100],
            [['komponen'], 'string', 'max' => 255],
            [['hk_pembagi', 'persentase'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nojo' => 'Nojo',
            'area' => 'Area',
            'area_txt' => 'Area Txt',
            'jabatan' => 'Jabatan',
            'jabatan_txt' => 'Jabatan Txt',
            'level' => 'Level',
            'level_txt' => 'Level Txt',
            'skill' => 'Skill',
            'skill_text' => 'Skill Text',
            'jumlah' => 'Jumlah',
            'ump' => 'Ump',
            'komponen' => 'Komponen',
            'komponen_txt' => 'Komponen Txt',
            'value' => 'Value',
            'hk_pembagi' => 'Hk Pembagi',
            'keterangan' => 'Keterangan',
            'persentase' => 'Persentase',
            'perusahaan' => 'Perusahaan',
            'karyawan' => 'Karyawan',
            'jkk' => 'Jkk',
            'jkm' => 'Jkm',
            'jht_per' => 'Jht Per',
            'jht_kar' => 'Jht Kar',
            'upd' => 'Upd',
            'lup' => 'Lup',
        ];
    }
}
