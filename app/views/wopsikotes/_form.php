<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\datetime\DateTimePicker;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Psikotest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="psikotest-form box box-primary">
  <?php $form = ActiveForm::begin(); ?>

  <div class="box-body table-responsive">
    <blockquote>
                <p>Invitation for Recruitment request by No Jo <?php echo $modelrecreq->nojo; ?>.</p>
                <small>Job detail for <cite title="Source Title"><?php
                echo   (is_numeric($modelrecreq->jabatan)) ? $modelrecreq->jobfunc->jobcat->name_job_function_category.' - '.$modelrecreq->jobfunc->name_job_function : $modelrecreq->jabatan;?></cite></small>
    </blockquote>

      <?= $form->field($model, 'userid')->hiddenInput()->label(false) ?>

      <?= $form->field($model, 'recruitmentcandidateid')->hiddenInput()->label(false) ?>

      <?= $form->field($model, 'fullname')->textInput(['disabled' => true]) ?>

      <?php
      echo   $form->field($model, 'officeid')->widget(Select2::classname(), [
        'data' => $office,
        // 'initValueText' => $recruitreqs, // set the initial display text
        'options' => ['placeholder' => '- select -'],
        'pluginOptions' => [
            'dropdownParent' => new yii\web\JsExpression('$("#confirmpskotest-modal")'),
            'allowClear' => true,
        ],
      ]);
      ?>
      <?= Html::hiddenInput('model_id2', ' ', ['id'=>'model_id2']) ?>
      <?php echo $form->field($model, 'roomid')->widget(DepDrop::classname(), [
        'data'=> [''=>''],
        'type' => DepDrop::TYPE_SELECT2,
        'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
        'pluginOptions'=>[
          'dropdownParent' => new yii\web\JsExpression('$("#confirmpskotest-modal")'),
          'depends'=>['psikotest-officeid'],
          'placeholder'=>'Select room',
          'url'=>Url::to(['/masterroom/getroom']),
          'loadingText' => 'Loading ...',
          'params'=>['model_id2'],
          'initialize' => true,
        ],


      ]); ?>

      <?php
      echo   $form->field($model, 'pic')->widget(Select2::classname(), [
        'data' => $pic,
        // 'initValueText' => $recruitreqs, // set the initial display text
        'options' => ['placeholder' => '- select -'],
        'pluginOptions' => [
            'dropdownParent' => new yii\web\JsExpression('$("#confirmpskotest-modal")'),
            'allowClear' => true,
        ],
      ]);
      ?>
      


  </div>
  <div class="box-footer">
      <?= Html::submitButton('Confirm', ['class' => 'btn btn-success btn-flat pull-right']) ?>
  </div>
  <?php ActiveForm::end(); ?>
</div>
