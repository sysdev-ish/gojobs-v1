<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\MasterSubJobFamily */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-sub-job-family-form box box-primary">
    <?= $form->errorSummary($model) ?>
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?php
        if (!$model->isNewRecord) {
            $dropdownparent = new yii\web\JsExpression('$("#updatemastersubjobfamily-modal")');
        } else {
            $dropdownparent = new yii\web\JsExpression('$("#createmastersubjobfamily-modal")');
        };
        echo   $form->field($model, 'jobfamily_id')->widget(Select2::classname(), [
            'data' => $jobfamily,
            'options' => ['placeholder' => '- select -'],
            'pluginOptions' => [
                'dropdownParent' => $dropdownparent,
                'allowClear' => true,
            ],
        ]);
        ?>
        <?= $form->field($model, 'subjobfamily')->textInput(['maxlength' => true]) ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>