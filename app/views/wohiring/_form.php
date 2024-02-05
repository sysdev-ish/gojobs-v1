<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use app\models\Userprofile;
use linslin\yii2\curl;

/* @var $this yii\web\View */
/* @var $model app\models\Hiring */
/* @var $form yii\widgets\ActiveForm */
$model->persa = ($modelrecreq->persa_sap=="NULL")?NULL:$modelrecreq->persa_sap;
$model->area = ($modelrecreq->area_sap=="NULL")?NULL:$modelrecreq->area_sap;
$model->skilllayanan = ($modelrecreq->skill_sap=="NULL")?NULL:$modelrecreq->skill_sap;
$model->payrollarea = ($modelrecreq->abkrs_sap=="NULL")?NULL:$modelrecreq->abkrs_sap;
$model->jabatan = ($modelrecreq->hire_jabatan_sap=="NULL")?NULL:$modelrecreq->hire_jabatan_sap;
$model->level = ($modelrecreq->level_sap=="NULL")?NULL:$modelrecreq->level_sap;
?>

<div class="hiring-form">
    <?php $form = ActiveForm::begin([
      'id' => 'approvehiring-form',
      'enableAjaxValidation' => false,
      'enableClientValidation' => true,
    ]); ?>
    <div class="box-body">
      <div class="row">
        <div class="col-sm-12">
          <blockquote>
                      <p>Approval Hiring for Recruitment request by No Jo <?php echo $modelrecreq->nojo; ?>.</p>
                      <?php if ($modelrecreq->typejo == 2):?>
                      <small>Perner Replaced <cite title="Source Title"><?php echo ($modelrecreq->perner)?$modelrecreq->perner->perner:'-'; ?></cite></small>
                      <?php endif; ?>
                      <small>Job detail for <cite title="Source Title"><?php echo   (is_numeric($modelrecreq->jabatan)) ? $modelrecreq->jobfunc->jobcat->name_job_function_category.' - '.$modelrecreq->jobfunc->name_job_function : $modelrecreq->jabatan; ?></cite></small>
                      <small>Applicant Name <cite title="Source Title"><?php echo $model->userprofile->fullname;?></cite></small><br>

                      <small>Personal Area (SAP) <cite title="Source Title"><b><?php echo (Yii::$app->utils->getpersonalarea($modelrecreq->persa_sap))?Yii::$app->utils->getpersonalarea($modelrecreq->persa_sap) : "";?></b></cite></small>
                      <?php echo $form->field($model, 'persa')->hiddenInput()->label(false); ?>

                      <small>Area (SAP) <cite title="Source Title"><b><?php echo (Yii::$app->utils->getarea($modelrecreq->area_sap))?Yii::$app->utils->getarea($modelrecreq->area_sap) : "";?></b></cite></small>
                      <?php echo $form->field($model, 'area')->hiddenInput()->label(false); ?>

                      <small>Skill Layanan (SAP) <cite title="Source Title"><b><?php echo (Yii::$app->utils->getskilllayanan($modelrecreq->skill_sap))?Yii::$app->utils->getskilllayanan($modelrecreq->skill_sap) : "";?></b></cite></small>
                      <?php echo $form->field($model, 'skilllayanan')->hiddenInput()->label(false); ?>

                      <small>Payroll Area (SAP) <cite title="Source Title"><b><?php echo (Yii::$app->utils->getpayrollarea($modelrecreq->abkrs_sap))?Yii::$app->utils->getpayrollarea($modelrecreq->abkrs_sap) : "";?></b></cite></small>
                      <?php echo $form->field($model, 'payrollarea')->hiddenInput()->label(false); ?>

                      <small>Jabatan (SAP) <cite title="Source Title"><b><?php echo (Yii::$app->utils->getjabatan($modelrecreq->hire_jabatan_sap))?Yii::$app->utils->getjabatan($modelrecreq->hire_jabatan_sap) : "";?></b></cite></small>
                      <?php echo $form->field($model, 'jabatan')->hiddenInput()->label(false); ?>
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
                      <?php echo $form->field($model, 'level')->hiddenInput()->label(false); ?>
          </blockquote>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
        <div class="col-sm-4">
          <?= $form->field($model, 'tglinput')->widget(
            DatePicker::className(), [
              'type' => DatePicker::TYPE_COMPONENT_APPEND,
              'options' => ['placeholder' => 'Date'],
              'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
              ]
            ]);
            ?>
          </div>
          <div class="col-sm-4">
          <?= $form->field($model, 'awalkontrak')->widget(
            DatePicker::className(), [
              'type' => DatePicker::TYPE_COMPONENT_APPEND,
              'options' => ['placeholder' => 'Date'],
              'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
              ]
            ]);
            ?>
          </div>
          <div class="col-sm-4">
          <?= $form->field($model, 'akhirkontrak')->widget(
            DatePicker::className(), [
              'type' => DatePicker::TYPE_COMPONENT_APPEND,
              'options' => ['placeholder' => 'Date'],
              'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
              ]
            ]);
            ?>
          </div>
          <div class="col-sm-12">
            <?= $form->field($model, 'keterangan')->textArea(['maxlength' => true]) ?>
          </div>

        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
      <?php
      // $modelprofile = Userprofile::find()->where(['userid'=>$model->userid])->one();
      // if($modelprofile){
      //   echo $this->render('/userprofile/view', [
      //       'model' => $modelprofile,
      //       'userid' => $model->userid,
      //   ]);
      // }else{
      // }
      ?>
    </div>
  </div>





    </div>
    <div class="box-footer">
        <?= Html::submitButton('Approve', ['class' => 'btn btn-success btn-flat pull-right']) ?>

        <?= Html::a('Reject', ['reject', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-flat pull-right',
            'style' => 'margin-right:10px',
            'data' => [
                'confirm' => 'Are you sure you want to reject this item?',
                'method' => 'post',
            ],
        ]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
