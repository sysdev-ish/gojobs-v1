<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "trans_jo".
 *
 * @property string $nojo
 * @property string $tanggal
 * @property string $project
 * @property string $n_project
 * @property string $syarat
 * @property string $deskripsi
 * @property string $lama
 * @property string $latihan
 * @property string $bekerja
 * @property string $komponen
 * @property string $komponen_bak
 * @property string $komponen_other
 * @property string $type_jo
 * @property int $approval
 * @property int $approval_admin
 * @property string $jenis_project
 * @property string $komentar
 * @property int $skema
 * @property string $ket_atasan
 * @property string $ket_admin
 * @property string $ket_pm
 * @property string $upd
 * @property string $lup
 * @property int $flag_cancel
 * @property string $upd_cancel_rekrut
 * @property int $flag_cancel_sap
 * @property string $ket_cancel
 * @property int $flag_edit
 * @property string $upd_edit
 * @property int $type_replace
 * @property int $type_new
 * @property string $ket_done
 * @property string $no_bak
 * @property int $tgl_gajian
 * @property int $new_rekrut
 */
class Transjo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trans_jo';
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
            [['nojo'], 'required'],
            [['tanggal', 'latihan', 'lup'], 'safe'],
            [['syarat', 'deskripsi', 'komponen', 'ket_atasan', 'ket_admin', 'ket_pm', 'ket_cancel', 'ket_done', 'no_bak'], 'string'],
            [['approval', 'approval_admin', 'skema', 'flag_cancel', 'flag_cancel_sap', 'flag_edit', 'type_replace', 'type_new', 'tgl_gajian', 'new_rekrut'], 'integer'],
            [['nojo', 'lama', 'bekerja', 'jenis_project', 'upd'], 'string', 'max' => 50],
            [['project'], 'string', 'max' => 150],
            [['n_project', 'komponen_bak', 'komponen_other', 'upd_cancel_rekrut'], 'string', 'max' => 200],
            [['type_jo'], 'string', 'max' => 10],
            [['komentar'], 'string', 'max' => 250],
            [['upd_edit'], 'string', 'max' => 100],
            [['nojo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'nojo' => 'Nojo',
            'tanggal' => 'Tanggal',
            'project' => 'Project',
            'n_project' => 'N Project',
            'syarat' => 'Syarat',
            'deskripsi' => 'Deskripsi',
            'lama' => 'Lama',
            'latihan' => 'Latihan',
            'bekerja' => 'Bekerja',
            'komponen' => 'Komponen',
            'komponen_bak' => 'Komponen Bak',
            'komponen_other' => 'Komponen Other',
            'type_jo' => 'Type Jo',
            'approval' => 'Approval',
            'approval_admin' => 'Approval Admin',
            'jenis_project' => 'Jenis Project',
            'komentar' => 'Komentar',
            'skema' => 'Skema',
            'ket_atasan' => 'Ket Atasan',
            'ket_admin' => 'Ket Admin',
            'ket_pm' => 'Ket Pm',
            'upd' => 'Upd',
            'lup' => 'Lup',
            'flag_cancel' => 'Flag Cancel',
            'upd_cancel_rekrut' => 'Upd Cancel Rekrut',
            'flag_cancel_sap' => 'Flag Cancel Sap',
            'ket_cancel' => 'Ket Cancel',
            'flag_edit' => 'Flag Edit',
            'upd_edit' => 'Upd Edit',
            'type_replace' => 'Type Replace',
            'type_new' => 'Type New',
            'ket_done' => 'Ket Done',
            'no_bak' => 'No Bak',
            'tgl_gajian' => 'Tgl Gajian',
            'new_rekrut' => 'New Rekrut',
        ];
    }
}
