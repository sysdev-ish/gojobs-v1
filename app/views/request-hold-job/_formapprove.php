<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use kartik\select2\Select2;
use linslin\yii2\curl;

/* @var $this yii\web\View */
/* @var $model app\models\request-hold-job */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
  <div class="col-sm-12">
    <blockquote>
      <p>Approval Hold Job order for Recruitment request by No Jo <?php echo $modelrecreq->nojo; ?>.</p>
    </blockquote>
    <div class="box-body table-responsive no-padding">
      <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          'id',
          // [
          //   'attribute' => 'recruitreqid',
          //   'format' => 'html',
          //   'value' => function ($data) {
          //     return ($data->jo) ? $data->jo->nojo : '-';
          //   }
          // ],
          [
            'label' => 'Area',
            'format' => 'raw',
            'value' => function ($data) {
              return ($data->jo) ? $data->jo->areasap->value2 : '-';
            }
          ],
          [
            'label' => 'Job',
            'format' => 'raw',
            'value' => function ($data) {
              return ($data->jo) ? $data->jo->jabatansap->value2 : '-';
            }
          ],
          [
            'label' => 'Personal Area',
            'format' => 'raw',
            'value' => function ($data) {
              return (Yii::$app->utils->getpersonalarea($data->jo->persa_sap)) ? Yii::$app->utils->getpersonalarea($data->jo->persa_sap) : '-';
            }
          ],
          [
            'label' => 'Payroll Area',
            'format' => 'raw',
            'value' => function ($data) {
              return (Yii::$app->utils->getpayrollarea($data->jo->abkrs_sap)) ? Yii::$app->utils->getpayrollarea($data->jo->abkrs_sap) : '-';
            }
          ],
          [
            'label' => 'Level',
            'format' => 'raw',
            'value' => function ($data) {
              $curl = new curl\Curl();
              $getlevels = $curl->setPostParams([
                'level' => $data->jo->level_sap,
                'token' => 'ish**2019',
              ])
                ->post('http://192.168.88.5/service/index.php/sap_profile/getlevel');
              $level  = json_decode($getlevels);

              return $level ?? '-';
            }
          ],
          [
            'attribute' => 'created_by',
            'format' => 'html',
            'value' => function ($data) {
              return ($data->creator) ? $data->creator->name : '';
            }

          ],
          'created_at',
          [
            'attribute' => 'reason',
            'format' => 'html',
            'value' => function ($data) {
              $reasons = [
                1 => 'Permintaan User/ Client',
                2 => 'Proyek Terkait Ditunda',
                3 => 'Kebutuhan Sumber Daya Manusia Ditinjau Ulang',
                4 => 'Prioritas Rekrutmen Berubah'
              ];
              $stopReason = $reasons[$data->reason] ?? 'Alasan tidak diketahui';

              return $stopReason;
            }

          ],
          'remarks',
          'scheme_date_old',
          'scheme_date_start',
          'scheme_date_end',
          [
            'label' => 'Evidence',
            'format' => 'raw',
            'value' => function ($data) {
              return ($data->evidence) ? Html::a('<i class="fa fa-download"></i> Download', ['/app/assets/upload/holdjob/' . $data->evidence], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted']) : '-';
            }

          ],
        ],
      ]) ?>
    </div>
  </div>
  <div class="col-md-12">
    <div class="request-hold-job-form">
      <?php $form = ActiveForm::begin([
        'options' => [
          'enctype' => 'multipart/form-data',
          'id' => 'request-hold-job-form'
        ]
      ]); ?>
      <div class="box-body table-responsive">

        <?php
        echo   $form->field($model, 'status')->widget(Select2::classname(), [
          'data' => [
            '3' => 'Approve Permintaan',
            '2' => 'Reject Permintaan',
          ],
          'options' => ['placeholder' => '- select -'],
          'pluginOptions' => [
            'allowClear' => false,
            'initialize' => true,
          ],
        ])->label('Select Approve');
        ?>
        <?= $form->field($model, 'approved_note')->textInput(['maxlength' => true])->label('Keterangan') ?>
      </div>
      <br>
      <div class="box-footer">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success btn-flat pull-right']) ?>
      </div>
      <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>