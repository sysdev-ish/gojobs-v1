<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\datetime\DateTimePicker;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use app\models\Transrincian;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\psikotest */
/* @var $form yii\widgets\ActiveForm */
$url = \yii\helpers\Url::to(['transrincian/recreqlist']);
?>

<div class="psikotest-form">
  <?php $form = ActiveForm::begin([
    'options'=>[
      'enctype'=>'multipart/form-data'
    ]
  ]); ?>

    <div class="box-body table-responsive">
      <blockquote>
                  <p>Psikotes Process for Recruitment request by No Jo <?php echo $modelrecreq->nojo; ?>.</p>
                  <small>Job detail for <cite title="Source Title"><?php
                  echo   (is_numeric($modelrecreq->jabatan)) ? $modelrecreq->jobfunc->jobcat->name_job_function_category.' - '.$modelrecreq->jobfunc->name_job_function : $modelrecreq->jabatan;?></cite></small>
      </blockquote>

        <?= $form->field($model, 'userid')->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'recruitmentcandidateid')->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'fullname')->textInput(['disabled' => true]) ?>


            <?= $form->field($model, 'documentpsikotest')->widget(FileInput::classname(), [
              'options' => ['accept' => ''],
              'pluginOptions' => [
                'showUpload' => false,
                'showCaption' => true,
                'showRemove' => true,
                'allowedExtensions' => ['jpg','png','jpeg', 'pdf'],
              ]
            ]); ?>

        <?php
        echo   $form->field($model, 'status')->widget(Select2::classname(), [
          'data' => ['2'=>'Pass','3'=>'Fail'],
          // 'initValueText' => $recruitreqs, // set the initial display text
          'options' => ['placeholder' => '- select -'],
          'pluginOptions' => [
              // 'dropdownParent' => new yii\web\JsExpression('$("#invite-modal")'),
              'allowClear' => true,
          ],
        ])->label('Psikotest result');
        ?>


    </div>
    <div class="box-footer">
        <?= Html::submitButton('Confirm', ['class' => 'btn btn-success btn-flat pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
