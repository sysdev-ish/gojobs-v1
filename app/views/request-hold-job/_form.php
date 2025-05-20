<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use linslin\yii2\curl;
use kartik\file\FileInput;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\RequestHoldJob */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
  <div class="col-md-5">
    <?= DetailView::widget([
      'model' => $modelrecreq,
      'template' => '<tr><th width="30%" style="text-align:right;">{label}</th><td>{value}</td></tr>',
      'options' => ['class' => 'table table-striped detail-view'],
      'attributes' => [
        'id',
        'nojo',
        // 'jobfunc.jobcat.name_job_function_category',
        [
          'label' => 'Job Function',
          'attribute' => 'jobfunc',
          'format' => 'html',
          'value' => function ($data) {

            return (is_numeric($data->jabatan)) ? $data->jobfunc->name_job_function : $data->jabatan;
          }
        ],

        [
          'label' => 'Type Project',
          'format' => 'html',
          'value' => function ($data) {
            return ($data->typejo == 3) ? 'Temporary Request' : (($data->typejo == 1) ? "New Project" : "Replacement");
          }
        ],

        [
          'label' => 'Project',
          'format' => 'html',
          'value' => function ($data) {
            return $data->n_project;
          }
        ],

        [
          'label' => 'Lama Project',
          'format' => 'html',
          'value' => function ($data) {

            return ($data->transjo->lama) ? $data->transjo->lama . " Bulan" : "";
          }
        ],

        [
          'label' => 'Approved JO',
          'format' => 'html',
          'value' => function ($data) {

            if ($data->typejo == 1) {
              return ($data->transrincian) ? (($data->transrincian->lup_skema and $data->transrincian->lup_skema <> '0000-00-00') ? $data->transrincian->lup_skema : "") : '';
            } else {
              return ($data->transperner) ? (($data->transperner->lup_skema and $data->transperner->lup_skema <> '0000-00-00') ? $data->transperner->lup_skema : "") : '';
            }
          }
        ],

        [
          'label' => 'Tanggal Due Date JO Saat ini',
          'contentOptions' => ['style' => 'min-width: 100px;'],
          'format' => 'html',
          'value' => function ($data) {
            try {
              $today = new DateTime('today');

              if ($data->typejo == 1) {
                if ($data->transrincian && $data->transrincian->lup_skema) {
                  $dueDate = (new DateTime($data->transrincian->lup_skema))->modify('+14 days');
                } else {
                  return '-';
                }
              } else {
                if ($data->transperner && $data->transperner->lup_skema) {
                  $dueDate = (new DateTime($data->transperner->lup_skema))->modify('+6 days');
                } else {
                  return '-';
                }
              }

              $dueDateStr = $dueDate->format('Y-m-d');
              $isOverdue = $today > $dueDate && $data->status_rekrut == 1;

              return $isOverdue ? '<span class="text-red">' . $dueDateStr . '</span>' : $dueDateStr;
            } catch (\Exception $e) {
              return '-';
            }
          }
        ],
        [
          'label' => 'Over Due JO',
          'format' => 'html',
          'value' => function ($data) {
            try {
              $today = new DateTime('today');

              // Hitung due date
              if ($data->typejo == 1 && $data->transrincian && $data->transrincian->lup_skema) {
                $dueDate = (new DateTime($data->transrincian->lup_skema))->modify('+14 days');
              } elseif ($data->typejo != 1 && $data->transperner && $data->transperner->lup_skema) {
                $dueDate = (new DateTime($data->transperner->lup_skema))->modify('+6 days');
              } else {
                return '-';
              }

              // Cek apakah overdue
              if ($today <= $dueDate || $data->status_rekrut != 1) {
                return '-';
              }

              // Hitung interval selisih dari due date ke hari ini
              $interval = $dueDate->diff($today);

              $output = [];
              if ($interval->y > 0) $output[] = $interval->y . ' Tahun';
              if ($interval->m > 0) $output[] = $interval->m . ' Bulan';
              if ($interval->d > 0 || empty($output)) $output[] = $interval->d . ' Hari';

              return implode(' ', $output);
            } catch (\Exception $e) {
              return '-';
            }
          }
        ],


        'gender',
        'pendidikan',
        'city.city_name',
        'kontrak',
        'waktu',
        'jumlah',
        [
          'label' => 'Hired',
          'format' => 'html',
          'value' => function ($data) {

            return Yii::$app->check->checkJohired($data->id, 1);
          }
        ],

        [
          'label' => 'Status',
          'format' => 'html',
          'value' => function ($data) {

            return ($data->status_rekrut == 1) ? "On Progress" : "Done";
          }
        ],

        [
          'label' => 'Personal Area (SAP)',
          'format' => 'html',
          'value' => function ($data) {

            return (Yii::$app->utils->getpersonalarea($data->persa_sap)) ? Yii::$app->utils->getpersonalarea($data->persa_sap) : "";
          }
        ],

        [
          'label' => 'Area (SAP)',
          'format' => 'html',
          'value' => function ($data) {

            return (Yii::$app->utils->getarea($data->area_sap)) ? Yii::$app->utils->getarea($data->area_sap) : "";
          }
        ],

        [
          'label' => 'Skilllayanan (SAP)',
          'format' => 'html',
          'value' => function ($data) {

            return (Yii::$app->utils->getskilllayanan($data->skill_sap)) ? Yii::$app->utils->getskilllayanan($data->skill_sap) : "";
          }
        ],

        [
          'label' => 'Payroll Area (SAP)',
          'format' => 'html',
          'value' => function ($data) {

            return (Yii::$app->utils->getpayrollarea($data->abkrs_sap)) ? Yii::$app->utils->getpayrollarea($data->abkrs_sap) : "";
          }
        ],

        [
          'label' => 'Jabatan (SAP)',
          'format' => 'html',
          'value' => function ($data) {

            return (Yii::$app->utils->getjabatan($data->hire_jabatan_sap)) ? Yii::$app->utils->getjabatan($data->hire_jabatan_sap) : "";
          }
        ],


        // 'ket_rekrut:ntext',
        // 'upd_rekrut',
        // 'pic_hi',
        // 'n_pic_hi',
        // 'pic_manar',
        // 'n_pic_manar',
        // 'pic_rekrut',
        // 'n_pic_rekrut',
        [
          'label' => 'Level (SAP)',
          'format' => 'html',
          'value' => function ($data) {
            $curl = new curl\Curl();
            $getlevels = $curl->setPostParams([
              'level' => $data->level_sap,
              'token' => 'ish**2019',
            ])
              ->post('http://192.168.88.5/service/index.php/sap_profile/getlevel');
            $level  = json_decode($getlevels);
            return ($level) ? $level : "";
          }
        ],

        // 'level_txt',
        // 'skilllayanan',
        // 'skilllayanan_txt',
        // 'level_sap',
        // 'persa_sap',
        // 'skill_sap',
        // 'area_sap',
        // 'jabatan_sap',
        // 'jabatan_sap_nm',
        // 'jenis_pro_sap',
        // 'skema_sap',
        // 'abkrs_sap',
        // 'hire_jabatan_sap',
        // 'zparam',
        // 'lup_skema',
        // 'upd_skema',
      ],
    ]) ?>
  </div>
  <div class="col-md-7">
    <div class="request-hold-job-form">
      <?php $form = ActiveForm::begin([
        'options' => [
          'enctype' => 'multipart/form-data',
          'id' => 'hold-job-form'
        ]
      ]); ?>
      <div class="box-body table-responsive">

        <?php
        echo   $form->field($model, 'reason')->widget(Select2::classname(), [
          'data' => [
            1 => 'Permintaan User/ Client',
            2 => 'Proyek Terkait Ditunda',
            3 => 'Kebutuhan Sumber Daya Manusia Ditinjau Ulang',
            4 => 'Prioritas Rekrutmen Berubah',
          ],
          'options' => ['placeholder' => '- select -'],
          'pluginOptions' => [
            'allowClear' => false,
            'initialize' => true,
          ],
        ]);
        ?>

        <?= $form->field($model, 'scheme_date_start')->widget(
          DatePicker::className(),
          [
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'pluginOptions' => [
              'autoclose' => true,
              'format' => 'yyyy-mm-dd',
              'todayHighlight' => true
            ],
          ]
        );
        ?>

        <?= $form->field($model, 'scheme_date_end')->widget(
          DatePicker::className(),
          [
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'pluginOptions' => [
              'autoclose' => true,
              'format' => 'yyyy-mm-dd',
              'todayHighlight' => true
            ],
          ]
        );
        ?>

        <?php if (!$model->isNewRecord): ?>
          <?php

          $type = '';
          $file = '';
          $asdata = false;
          $assetUrl = Yii::$app->request->baseUrl;
          if (!empty($model->evidence)) {
            $type = substr($model->evidence, strrpos($model->evidence, '.') + 1);
            if ($type == 'pdf') {
              $asdata = true;
              $file = $assetUrl . '/app/assets/upload/holdjob/' . $model->evidence;
            } else {
              $asdata = false;
              $file = Html::img($assetUrl . '/app/assets/upload/holdjob/' . $model->evidence, ['width' => '150']);
            }
          }
          ?>

          <?= $form->field($model, 'evidence')->widget(FileInput::className(), [
            'options' => ['accept' => ''],
            'pluginOptions' => [
              'showRemove' => false,
              // 'theme' => 'explorer-fa',
              'showUpload' => false,
              'showCancel' => false,
              'showPreview' => true,
              'overwriteInitial' => true,
              'previewFileType' => 'any',
              'initialPreviewAsData' => $asdata,
              'initialPreview' => $file,
              'initialPreviewConfig' => [
                ['type' => $type, 'caption' => $model->evidence, 'deleteUrl' => false],
              ],
              'uploadAsync' => true,
              // 'maxFileSize' => 10*1024*1024,
              'allowedExtensions' => ['png, jpg, jpeg, pdf'],
            ]
          ]) ?>
        <?php else : ?>
          <?= $form->field($model, 'evidence')->widget(FileInput::classname(), [
            'options' => ['accept' => ''],
            'pluginOptions' => [
              'showUpload' => false,
              'showCaption' => true,
              'showRemove' => true,
            ]
          ]); ?>
        <?php endif; ?>

        <?= $form->field($model, 'remarks')->textInput(['maxlength' => true])->label('Keterangan') ?>
      </div>
      <br>
      <div class="box-footer">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success btn-flat']) ?>
      </div>
      <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>