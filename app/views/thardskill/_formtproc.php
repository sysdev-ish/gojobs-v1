<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use app\models\Transrincian;
use app\models\Mastersubgrouppenilaian;
use app\models\Interviewform;

/* @var $this yii\web\View */
/* @var $model app\models\Interview */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="interview-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="box-body table-responsive">
      <blockquote>
                  <p>Training Hard skill Process for Recruitment request by No Jo <?php echo $modelrecreq->nojo; ?>.</p>
                  <small>Job detail for <cite title="Source Title"><?php
                  echo   (is_numeric($modelrecreq->jabatan)) ? $modelrecreq->jobfunc->jobcat->name_job_function_category.' - '.$modelrecreq->jobfunc->name_job_function : $modelrecreq->jabatan;?></cite></small>
      </blockquote>

        <?= $form->field($model, 'userid')->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'recruitmentcandidateid')->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'fullname')->textInput(['disabled' => true]) ?>

        <?= $form->field($model, 'enddate')->widget(
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
        <?php

        echo   $form->field($model, 'status')->widget(Select2::classname(), [
          'data' => ['2'=>'Pass','3'=>'Fail'],
          // 'initValueText' => $recruitreqs, // set the initial display text
          'options' => ['placeholder' => '- select -'],
          'pluginOptions' => [
              // 'dropdownParent' => new yii\web\JsExpression('$("#invite-modal")'),
              'allowClear' => true,
          ],
        ])->label('Training Hard Skill result');
        ?>


    </div>
    <div class="box-footer">
        <?= Html::submitButton('Confirm', ['class' => 'btn btn-success btn-flat pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
