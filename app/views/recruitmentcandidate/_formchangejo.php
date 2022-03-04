<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\datetime\DateTimePicker;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use app\models\Transrincian;

/* @var $this yii\web\View */
/* @var $model app\models\Interview */
/* @var $form yii\widgets\ActiveForm */
$url = \yii\helpers\Url::to(['transrincian/recreqlist']);
?>

<div class="interview-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="box-body">
      <div class="row">
        <div class="col-sm-12">
      <blockquote>
                  <p>Change Recruitment Request for Recruitment request by No Jo <?php echo $modelrecreq->nojo; ?>.</p>
                  <small>Job detail for <cite title="Source Title"><?php
                  echo   (is_numeric($modelrecreq->jabatan)) ? $modelrecreq->jobfunc->jobcat->name_job_function_category.' - '.$modelrecreq->jobfunc->name_job_function : $modelrecreq->jabatan;?></cite></small>
      </blockquote>

        <?= $form->field($model, 'userid')->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'fullname')->textInput(['disabled' => true]) ?>

        <?php
        // var_dump();
        echo   $form->field($modelreccan, 'recruitreqid')->widget(Select2::classname(), [
          // 'data' => $recruitreq,
          // 'model' => $modelrecreq,
          // 'value' => $modelrecreq->id,
          'initValueText' => empty($modelreccan->recruitreqid) ? '' : Transrincian::findOne($modelreccan->recruitreqid)->nojo.' | '.Transrincian::findOne($modelreccan->recruitreqid)->n_project.' | '.Transrincian::findOne($modelreccan->recruitreqid)->id, // set the initial display text
          // 'initValueText' => ' ', // set the initial display text
          'options' => ['placeholder' => '- select -', 'id'=>'recruitreqid'],
          'pluginOptions' => [
              'dropdownParent' => new yii\web\JsExpression('$("#changejo-modal")'),
              'allowClear' => true,
              'minimumInputLength' => 3,
              'language' => [
                  'errorLoading' => new \yii\web\JsExpression("function () { return 'No results...'; }"),
              ],
              'ajax' => [
                  'url' => $url,
                  'dataType' => 'json',
                  'data' => new \yii\web\JsExpression('function(params) { return {q:params.term}; }')
              ],
              'escapeMarkup' => new \yii\web\JsExpression('function (markup) { return markup; }'),
              'templateResult' => new \yii\web\JsExpression('function(a) {
                if(a.name_job_function){var jabatans = a.name_job_function}else{var jabatans =  a.jabatan}
                if(a.nojo == null){return "No Data";}else{return a.nojo+" <br> "+ jabatans + " - " + a.city_name+ " - " + a.id;}; }'),
              'templateSelection' => new \yii\web\JsExpression('function (a) {
                if(a.name_job_function){var jabatans = a.name_job_function}else{var jabatans =  a.jabatan}
                if(a.nojo == null){return "- select -";}else{ return a.nojo + " | " + jabatans + " | " + a.city_name+ " | " + a.id;}; }'),
          ],
        ])->label('Posisi yang disarankan');
        ?>
      </div>


    </div>
    <div class="box-footer">
        <?= Html::submitButton('Change', ['class' => 'btn btn-success btn-flat pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
