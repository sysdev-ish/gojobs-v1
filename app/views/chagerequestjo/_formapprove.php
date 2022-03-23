<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use kartik\select2\Select2;
use linslin\yii2\curl;

/* @var $this yii\web\View */
/* @var $model app\models\Chagerequestjo */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
  <div class="col-sm-12">
    <blockquote>
      <p>Approval Stop Job order for Recruitment request by No Jo <?php echo $modelrecreq->nojo; ?>.</p>
      <?php if ($modelrecreq->typejo == 2): ?>
      <small>Perner Replaced <cite title="Source Title"><?php echo $modelrecreq->perner->perner; ?></cite></small>
      <?php endif; ?>
      <br>

      <small>Personal Area (SAP) <cite title="Source Title"><b><?php echo (Yii::$app->utils->getpersonalarea($modelrecreq->persa_sap))?Yii::$app->utils->getpersonalarea($modelrecreq->persa_sap) : "";?></b></cite></small>

      <small>Area (SAP) <cite title="Source Title"><b><?php echo (Yii::$app->utils->getarea($modelrecreq->area_sap))?Yii::$app->utils->getarea($modelrecreq->area_sap) : "";?></b></cite></small>

      <small>Skill Layanan (SAP) <cite title="Source Title"><b><?php echo (Yii::$app->utils->getskilllayanan($modelrecreq->skill_sap))?Yii::$app->utils->getskilllayanan($modelrecreq->skill_sap) : "";?></b></cite></small>

      <small>Payroll Area (SAP) <cite title="Source Title"><b><?php echo (Yii::$app->utils->getpayrollarea($modelrecreq->abkrs_sap))?Yii::$app->utils->getpayrollarea($modelrecreq->abkrs_sap) : "";?></b></cite></small>

      <small>Jabatan (SAP) <cite title="Source Title"><b><?php echo (Yii::$app->utils->getjabatan($modelrecreq->hire_jabatan_sap))?Yii::$app->utils->getjabatan($modelrecreq->hire_jabatan_sap) : "";?></b></cite></small>
      <?php
      $curl = new curl\Curl();
      $getlevels = $curl->setPostParams([
        'level' => $modelrecreq->level_sap,
        'token' => 'ish**2019',
      ])
      ->post('http://192.168.88.5/service/index.php/sap_profile/getlevel');
      $level  = json_decode($getlevels);
      ?>
      <small>level (SAP) <cite title="Source Title"><b><?php echo ($level)?$level : "";?></b></cite></small>

    </blockquote>
  </div>
<div class="col-md-12">
  <div class="chagerequestjo-form">
      <?php $form = ActiveForm::begin([
        'options'=>[
          'enctype'=>'multipart/form-data',
          'id'=>'stopjo-form'
        ]
      ]); ?>
      <div class="box-body table-responsive">

          <?php
          if($model->status == 1 and $model->typeapproval == 2){
            $data = [2 => 'Approve',4 => 'Reject'];
          }else if($model->status == 2 and $model->typeapproval == 2){
            $data = [3 => 'Approve',4 => 'Reject'];
          }else if($model->status == 1 and $model->typeapproval == 1){
            $data = [3 => 'Approve',4 => 'Reject'];
          }
          echo   $form->field($model, 'status')->widget(Select2::classname(), [
            'data' => $data,
            'options' => ['placeholder' => '- select -'],
            'pluginOptions' => [
                'allowClear' => false,
                'initialize' => true,
            ],
          ])->label('');
          ?>
      </div>
      <br>
      <div class="box-footer">
          <?= Html::submitButton('Submit', ['class' => 'btn btn-success btn-flat pull-right']) ?>
      </div>
      <?php ActiveForm::end(); ?>
  </div>
</div>
</div>
