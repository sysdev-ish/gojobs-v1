<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\datetime\DateTimePicker;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Interview */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="interview-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="box-body">
      <div class="row">
        <div class="col-sm-12">
      <blockquote>
                  <p>Invitation <span class="label label-danger"><?php echo $invitefor; ?></span> for Recruitment request by No Jo <?php echo $modelrecreq->nojo; ?>.</p>
                  <small>Job detail for <cite title="Source Title"><?php
                  echo   (is_numeric($modelrecreq->jabatan)) ? $modelrecreq->jobfunc->jobcat->name_job_function_category.' - '.$modelrecreq->jobfunc->name_job_function : $modelrecreq->jabatan;?></cite></small>
      </blockquote>

        <?= $form->field($model, 'userid')->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'recruitmentcandidateid')->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'fullname')->textInput(['disabled' => true]) ?>
      </div>
      <div class="col-sm-12">
      <?= $form->field($model, 'scheduledate')->widget(
        DateTimePicker::className(), [
          'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
          'options' => ['placeholder' => 'Date'],
          'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd hh:ii:00',
            'todayHighlight' => true
          ]
        ])->label('Schedule For '.$invitefor);
        ?>
      </div>
      <?php if ($modelreccan->status == 0): ?>
        <div class="col-sm-12">
        <?php

        echo   $form->field($model, 'method')->widget(Select2::classname(), [
          'data' => ['1' =>'Offline', '2' =>'Online'],
          // 'initValueText' => $recruitreqs, // set the initial display text
          'options' => ['placeholder' => '- select -', 'id'=>'method',
          'onChange' =>'
          var x = document.getElementById("kodtok");
          var y = document.getElementById("place");
          var xx = document.getElementById("method").value;
            if (xx === "1") {
              x.style.display = "none";
              y.style.display = "block";
            } else {
              x.style.display = "block";
              y.style.display = "none";
            }
          '
          ],

          'pluginOptions' => [
              'dropdownParent' => new yii\web\JsExpression('$("#invite-modal")'),
              'allowClear' => true,
          ],
        ]);
        ?>
      </div>
      <div class="col-sm-12" id="kodtok" style="display:none;">
        <?= $form->field($model, 'kodetoken')->textInput()->label('Kode Token') ?>

      </div>
    <?php endif; ?>

        <div id="place">
        <div class="col-sm-12">
        <?php

        echo   $form->field($model, 'officeid')->widget(Select2::classname(), [
          'data' => $office,
          // 'initValueText' => $recruitreqs, // set the initial display text
          'options' => ['placeholder' => '- select -', 'id'=>'officeid'],
          'pluginOptions' => [
              'dropdownParent' => new yii\web\JsExpression('$("#invite-modal")'),
              'allowClear' => true,
              'width' => null,
          ],
        ]);
        ?>
      </div>

      <div class="col-sm-6">
        <?= Html::hiddenInput('model_id2', $model->roomid, ['id'=>'model_id2']) ?>
        <?php echo $form->field($model, 'roomid')->widget(DepDrop::classname(), [
          'data'=> [''=>''],
          'type' => DepDrop::TYPE_SELECT2,
          'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
          'pluginOptions'=>[
            'dropdownParent' => new yii\web\JsExpression('$("#invite-modal")'),
            'depends'=>['officeid'],
            'placeholder'=>'Select room',
            'url'=>Url::to(['/masterroom/getroom']),
            'loadingText' => 'Loading ...',
            'params'=>['model_id2'],
            'initialize' => true,
            'width' => null,
          ],


        ]); ?>
      </div>
      <div class="col-sm-6">
        <?= Html::hiddenInput('model_id3', $model->officepic, ['id'=>'model_id3']) ?>
        <?php echo $form->field($model, 'officepic')->widget(DepDrop::classname(), [
          'data'=> [''=>''],
          'type' => DepDrop::TYPE_SELECT2,
          'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
          'pluginOptions'=>[
            'dropdownParent' => new yii\web\JsExpression('$("#invite-modal")'),
            'depends'=>['officeid'],
            'placeholder'=>'Select PIC',
            'url'=>Url::to(['/masterpic/getpic']),
            'loadingText' => 'Loading ...',
            'params'=>['model_id3'],
            'initialize' => true,
            'width' => null,
          ],


        ]); ?>


    </div>
    </div>
    </div>
    <div class="box-footer">
        <?= Html::submitButton('Send Invitation', ['class' => 'btn btn-success btn-flat pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
