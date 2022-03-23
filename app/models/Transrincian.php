<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "trans_rincian".
 *
 * @property int $id
 * @property string $nojo
 * @property string $jabatan
 * @property string $gender
 * @property string $pendidikan
 * @property string $lokasi
 * @property string $atasan
 * @property string $kontrak
 * @property string $waktu
 * @property int $jumlah
 * @property string $komentar
 * @property int $skema
 * @property string $ket_done
 * @property string $upd
 * @property string $lup
 * @property int $flag_jobs
 * @property string $upd_jobs
 * @property string $lup_jobs
 * @property int $flag_app
 * @property string $upd_app
 * @property string $ket_rej
 * @property string $status_rekrut
 * @property string $ket_rekrut
 * @property string $upd_rekrut
 * @property string $pic_hi
 * @property string $n_pic_hi
 * @property string $pic_manar
 * @property string $n_pic_manar
 * @property string $pic_rekrut
 * @property string $n_pic_rekrut
 * @property string $level
 * @property string $level_txt
 * @property string $skilllayanan
 * @property string $skilllayanan_txt
 * @property string $level_sap
 * @property string $persa_sap
 * @property string $skill_sap
 * @property string $area_sap
 * @property string $jabatan_sap
 * @property string $jabatan_sap_nm
 * @property string $jenis_pro_sap
 * @property string $skema_sap
 * @property string $abkrs_sap
 * @property string $hire_jabatan_sap
 * @property string $zparam
 * @property string $lup_skema
 * @property string $upd_skema
 */
class Transrincian extends \yii\db\ActiveRecord
{
  public $projectrekrut;
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
    public static function tableName()
    {
      // return '{{ish_catalog_baru}}.{{' . self::getDb()->getSchema()->getRawTableName(parent::tableName()) . '}}';
        return 'trans_rincian_rekrut';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jumlah', 'skema', 'flag_jobs', 'flag_app','train_soft','train_hard','tendem_pasif','tendem_aktif'], 'integer'],
            [['ket_done', 'ket_rej', 'ket_rekrut'], 'string'],
            [['lup', 'lup_jobs', 'lup_skema'], 'safe'],
            [['nojo', 'jabatan', 'gender', 'pendidikan', 'lokasi', 'atasan', 'kontrak', 'waktu', 'upd', 'upd_jobs', 'upd_app', 'upd_rekrut', 'pic_hi', 'pic_manar', 'pic_rekrut', 'level_txt', 'level_sap', 'persa_sap', 'skill_sap', 'area_sap', 'jabatan_sap', 'jenis_pro_sap', 'skema_sap', 'abkrs_sap', 'hire_jabatan_sap'], 'string', 'max' => 50],
            [['komentar'], 'string', 'max' => 250],
            [['n_project','projectrekrut'], 'string', 'max' => 245],
            [['status_rekrut'], 'string', 'max' => 20],
            [['n_pic_hi', 'n_pic_manar', 'n_pic_rekrut', 'zparam', 'upd_skema'], 'string', 'max' => 100],
            [['level', 'skilllayanan'], 'string', 'max' => 10],
            [['skilllayanan_txt', 'jabatan_sap_nm'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nojo' => 'No Job Order',
            'jabatan' => 'Jabatan',
            'gender' => 'Gender',
            'pendidikan' => 'Pendidikan',
            'lokasi' => 'Location',
            'atasan' => 'Atasan',
            'kontrak' => 'Kontrak',
            'waktu' => 'Waktu',
            'jumlah' => 'Jumlah Kebutuhan',
            'komentar' => 'Komentar',
            'skema' => 'Skema',
            'ket_done' => 'Ket Done',
            'upd' => 'Upd',
            'lup' => 'Lup',
            'flag_jobs' => 'Flag Jobs',
            'upd_jobs' => 'Upd Jobs',
            'lup_jobs' => 'Lup Jobs',
            'flag_app' => 'Flag App',
            'upd_app' => 'Upd App',
            'ket_rej' => 'Ket Rej',
            'status_rekrut' => 'Status Rekrut',
            'ket_rekrut' => 'Ket Rekrut',
            'upd_rekrut' => 'Upd Rekrut',
            'pic_hi' => 'Pic Hi',
            'n_pic_hi' => 'N Pic Hi',
            'pic_manar' => 'Pic Manar',
            'n_pic_manar' => 'N Pic Manar',
            'pic_rekrut' => 'Pic Rekrut',
            'n_pic_rekrut' => 'N Pic Rekrut',
            'level' => 'Level',
            'level_txt' => 'Level Txt',
            'skilllayanan' => 'Skilllayanan',
            'skilllayanan_txt' => 'Skilllayanan Txt',
            'level_sap' => 'Level Sap',
            'persa_sap' => 'Persa Sap',
            'skill_sap' => 'Skill Sap',
            'area_sap' => 'Area Sap',
            'jabatan_sap' => 'Jabatan Sap',
            'jabatan_sap_nm' => 'Jabatan Sap Nm',
            'jenis_pro_sap' => 'Jenis Pro Sap',
            'skema_sap' => 'Skema Sap',
            'abkrs_sap' => 'Abkrs Sap',
            'hire_jabatan_sap' => 'Hire Jabatan Sap',
            'zparam' => 'Zparam',
            'lup_skema' => 'Lup Skema',
            'upd_skema' => 'Upd Skema',
            'n_project' => 'Project',
        ];
    }
    public function getCity()
    {
        return $this->hasOne(MappingCity::className(), ['city_id' => 'lokasi']);
    }
    public function getJobfunc()
    {
        return $this->hasOne(Jobfunction::className(), ['id' => 'jabatan']);
    }
    public function getTransjo()
    {
        return $this->hasOne(Transjo::className(), ['nojo' => 'nojo']);
    }
    public function getTransperner()
    {
        return $this->hasOne(Transperner::className(), ['id' => 'idpktable']);
    }
    public function getTransrincian()
    {
        return $this->hasOne(Transrincianori::className(), ['id' => 'idpktable']);
    }
    public function getTranskomponen()
    {
        return $this->hasOne(Transkomponen::className(), ['nojo' => 'nojo']);
    }
    public function getJabatansap()
    {
        $get = $this->hasOne(Sapjob::className(), ['value1' => 'hire_jabatan_sap']);
        return ($get)?$get : '-';
    }
    public function getAreasap()
    {
        return $this->hasOne(Saparea::className(), ['value1' => 'area_sap']);
    }
    public function getSkillsap()
    {
         return $this->hasOne(Sapskilllayanan::className(), ['value1' => 'skill_sap']);
         // return ($get)?$get : '-';
    }
    public function getPersasap()
    {
        return $this->hasOne(Sappersonalarea::className(), ['value1' => 'persa_sap']);
    }
    public function getPerner()
    {
        return $this->hasOne(Transperner::className(), ['id' => 'idpktable']);
    }

}
