<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "trans_perner".
 *
 * @property int $id
 * @property string $nojo
 * @property string $perner
 * @property string $nama
 * @property string $area
 * @property string $nm_area
 * @property string $persa
 * @property string $nm_persa
 * @property string $skilllayanan
 * @property string $nm_skilllayanan
 * @property string $level
 * @property string $nm_level
 * @property string $jabatan
 * @property string $nm_jabatan
 * @property string $komentar
 * @property int $skema
 * @property string $upd
 * @property string $lup
 * @property int $flag_app
 * @property string $upd_app
 * @property string $ket_rej
 * @property string $tgl_resign
 * @property string $status_rekrut
 * @property string $ket_rekrut
 * @property string $upd_rekrut
 * @property string $ket_done
 * @property int $finish_view_manar
 * @property int $flagrekrut
 */
class Transperner extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trans_perner';
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
            [['area', 'nm_area', 'nm_persa', 'skilllayanan', 'nm_skilllayanan', 'level', 'nm_level', 'jabatan', 'nm_jabatan', 'ket_rej', 'ket_rekrut', 'ket_done'], 'string'],
            [['skema', 'flag_app', 'finish_view_manar', 'flagrekrut'], 'integer'],
            [['lup', 'tgl_resign'], 'safe'],
            [['nojo', 'perner', 'nama', 'upd', 'upd_app', 'upd_rekrut'], 'string', 'max' => 50],
            [['persa'], 'string', 'max' => 200],
            [['komentar'], 'string', 'max' => 250],
            [['status_rekrut'], 'string', 'max' => 20],
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
            'perner' => 'Perner',
            'nama' => 'Nama',
            'area' => 'Area',
            'nm_area' => 'Nm Area',
            'persa' => 'Persa',
            'nm_persa' => 'Nm Persa',
            'skilllayanan' => 'Skilllayanan',
            'nm_skilllayanan' => 'Nm Skilllayanan',
            'level' => 'Level',
            'nm_level' => 'Nm Level',
            'jabatan' => 'Jabatan',
            'nm_jabatan' => 'Nm Jabatan',
            'komentar' => 'Komentar',
            'skema' => 'Skema',
            'upd' => 'Upd',
            'lup' => 'Lup',
            'flag_app' => 'Flag App',
            'upd_app' => 'Upd App',
            'ket_rej' => 'Ket Rej',
            'tgl_resign' => 'Tgl Resign',
            'status_rekrut' => 'Status Rekrut',
            'ket_rekrut' => 'Ket Rekrut',
            'upd_rekrut' => 'Upd Rekrut',
            'ket_done' => 'Ket Done',
            'finish_view_manar' => 'Finish View Manar',
            'flagrekrut' => 'Flagrekrut',
        ];
    }
}
