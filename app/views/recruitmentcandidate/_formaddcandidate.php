<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\Transrincian;

/* @var $this yii\web\View */
/* @var $model app\models\Recruitmentcandidate */
/* @var $form yii\widgets\ActiveForm */

$url = \yii\helpers\Url::to(['transrincian/recreqlist']);
$recruitreqs = empty($model->recruitreqid) ? '' : Transrincian::findOne($model->recruitreqid)->nojo;

?>

<div class="recruitmentcandidate-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'userid')->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'fullname')->textInput(['disabled' => true]) ?>

        <?php
        echo   $form->field($model, 'recruitreqid')->widget(Select2::classname(), [
            // 'data' => $recruitreq,
            'model' => $model,
            'attribute' => 'perner',
            'initValueText' => $recruitreqs, // set the initial display text
            'options' => ['placeholder' => '- select -', 'id' => 'recruitreqid'],
            'pluginOptions' => [
                'dropdownParent' => new yii\web\JsExpression('$("#addcandidate-modal")'),
                'allowClear' => true,
                'minimumInputLength' => 3,
                'language' => [
                    'errorLoading' => new \yii\web\JsExpression("function () { return 'Waiting for results...'; }"),
                ],
                'ajax' => [
                    'url' => $url,
                    'dataType' => 'json',
                    'data' => new \yii\web\JsExpression('function(params) { return {q:params.term}; }'),
                    // 'processResults'=> new \yii\web\JsExpression(' function (data) {
                    //     return data.nojo+" <br> "+ data.name_job_function + " - " + data.city_name;
                    //   }'),

                ],
                'escapeMarkup' => new \yii\web\JsExpression('function (markup) { return markup; }'),
                'templateResult' => new \yii\web\JsExpression('function(a) {
                if(a.sappersa){var projects = a.sappersa}else{var projects = "n/a"}
                if(a.sapjabatan){var jabatans = a.sapjabatan}else{var jabatans = "n/a"}
                if(a.sapskill){var skill = a.sapskill}else{var skill = "n/a"}
                if(a.nojo == null){return "No Data";}else{return a.nojo+" <br> "+ jabatans  + " - " + a.saparea + " - " + projects+ " - " + skill;};
              }'),
                // 'templateSelection' => new \yii\web\JsExpression('function (a) { return a.nojo + " | " + a.name_job_function + " | " + a.city_name; }'),
                'templateSelection' => new \yii\web\JsExpression('function (a) {

                if(a.sappersa){var projects = a.sappersa;}else{var projects = "n/a"}
                if(a.sapjabatan){var jabatans = a.sapjabatan;}else{var jabatans = "n/a"}
                if(a.nojo == null){return "No Data";}else{return a.nojo};
              }'),
            ],
        ]);
        ?>


    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>