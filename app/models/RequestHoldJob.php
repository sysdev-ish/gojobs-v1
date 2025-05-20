<?php

namespace app\models;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "chagerequestjo".
 *
 * @property int $id
 * @property int $recruitreqid
 * @property string $created_at
 * @property string $updated_at
 * @property string $approved_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $approved_by
 * @property int $status
 * @property string $remarks
 * @property string $evidence
 */
class RequestHoldJob extends \yii\db\ActiveRecord
{
  public $counthiredtype1;
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'request_hold_job';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['scheme_date_old', 'scheme_date_start', 'scheme_date_end', 'recruitreqid', 'reason'], 'required', 'on' => "create"],
      [['status'], 'required', 'on' => "approve"],
      [['recruitreqid', 'created_by', 'updated_by', 'approved_by', 'status', 'reason'], 'integer'],
      [['scheme_date_old', 'scheme_date_start', 'scheme_date_end', 'created_at', 'updated_at', 'approved_at', 'restored_at', 'send_email_at'], 'safe'],
      [['approved_note', 'remarks'], 'string', 'max' => 445],
      [['evidence'], 'file', 'skipOnEmpty' => 'true', 'maxSize' => 3072000, 'tooBig' => 'Limit is 3Mb', 'extensions' => 'png, jpg, jpeg, pdf'],
      [['recipient'], 'string', 'max' => 255],
      // ['scheme_date_old', 'date', 'max' => $this->scheme_date, 'on' => "create"],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'recruitreqid' => 'No Job Order',
      'created_at' => 'Created at',
      'updated_at' => 'Updated at',
      'approved_at' => 'Approved at',
      'restored_at' => 'Restored at',
      'created_by' => 'Created by',
      'updated_by' => 'Updated by',
      'approved_by' => 'Approved by',
      'restored_by' => 'Restored by',
      'recipient' => 'Recipient',
      'status' => 'Status',
      'approved_mote' => 'Approved note',
      'remarks' => 'Remarks',
      'scheme_date_old' => 'Tanggal Due Date JO Sebelumnya',
      'scheme_date_start' => 'Start Hold JO',
      'scheme_date_end' => 'End Hold JO',
      'evidence' => 'Document evidence',
      'reason' => 'Alasan Hold JO',
    ];
  }

  public function getRecipientEmail($projectManagerId)
  {
    $checkUser = User::find()->select(['id', 'name', 'email', 'role'])->where(['id' => $projectManagerId])->one();

    if (!$checkUser) return 'proman@ish.co.id';

    if ($checkUser->role == 10 && !in_array($projectManagerId, [20973, 1095])) {
      return 'proman@ish.co.id';
    }

    if (in_array($checkUser->role, [21, 26]) || in_array($projectManagerId, [20973, 1095])) {
      return 'hc@ish.co.id';
    }

    return 'proman@ish.co.id';
    // return 'khusnul.hisyam@ish.co.id';
  }

  public function getReasonText()
  {
    return [
      1 => 'Permintaan User/ Client',
      2 => 'Proyek Terkait Ditunda',
      3 => 'Kebutuhan Sumber Daya Manusia Ditinjau Ulang',
      4 => 'Prioritas Rekrutmen Berubah'
    ][$this->reason] ?? 'Alasan tidak diketahui';
  }

  public function buildEmailBody($dataJob)
  {
    $layanan = $dataJob->transjo->n_project ?: $dataJob->transjo->project;
    $area = Yii::$app->utils->getarea($dataJob->area_sap) ?: '-';
    $jabatan = Yii::$app->utils->getjabatan($dataJob->hire_jabatan_sap) ?: '-';
    $body = Yii::$app->params['approvalHoldJob'];

    return strtr($body, [
      '{nojo}' => $dataJob->nojo,
      '{client}' => $layanan,
      '{area}' => $area,
      '{job}' => $jabatan,
      '{scheme_date_old}' => $this->scheme_date_old,
      '{scheme_date_start}' => $this->scheme_date_start,
      '{scheme_date_end}' => $this->scheme_date_end,
      '{remarks}' => $this->remarks,
      '{reason}' => $this->getReasonText(),
    ]);
  }

  public function handleFileUpload($attribute = 'evidence')
  {
    $uploadedFile = UploadedFile::getInstance($this, $attribute);
    if (!$uploadedFile) return false;

    $uploadPath = Yii::getAlias('@app/assets/upload/holdjob/');
    FileHelper::createDirectory($uploadPath);

    $fileName = sprintf('%s_hold_job_%s.%s', date('d_mY'), Yii::$app->security->generateRandomString(10), $uploadedFile->extension);

    if ($uploadedFile->saveAs($uploadPath . $fileName)) {
      $this->$attribute = $fileName;
      return true;
    }

    return false;
  }

  public function getCreator()
  {
    return $this->hasOne(Userlogin::className(), ['id' => 'created_by']);
  }

  public function getUpdater()
  {
    return $this->hasOne(Userlogin::className(), ['id' => 'updated_by']);
  }
  public function getApprover()
  {
    return $this->hasOne(Userlogin::className(), ['id' => 'approved_by']);
  }
  public function getRestorer()
  {
    return $this->hasOne(Userlogin::className(), ['id' => 'restored_by']);
  }
  public function getJo()
  {
    return $this->hasOne(Transrincian::className(), ['id' => 'recruitreqid']);
  }
  public function getJoReplacement()
  {
    return $this->hasOne(Transperner::className(), ['id' => 'idpktable']);
  }
  public function getJoNew()
  {
    return $this->hasOne(Transrincianori::className(), ['id' => 'idpktable']);
  }
}
