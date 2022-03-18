<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Mappingjobposition */
/* @var $form yii\widgets\ActiveForm */

if ($model->isNewRecord) {
    $dropdownparent = new yii\web\JsExpression('$("#createmappingjobposition-modal")');
} else {
    $dropdownparent = new yii\web\JsExpression('$("#updatemappingjobposition-modal")');
}
?>

<div class="mappingjobposition-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->errorSummary($model) ?>
    <div class="box-body table-responsive">
        <?php
        echo   $form->field($model, 'subjobfamily_id')->widget(Select2::classname(), [
            'data' => $subjobfamily_id,
            // 'initValueText' => $recruitreqs, // set the initial display text
            'options' => ['placeholder' => '- select -'],
            'pluginOptions' => [
                'dropdownParent' => $dropdownparent,
                'allowClear' => true,
            ],
        ]);
        ?>
        <?php
        echo   $form->field($model, 'jabatan_sap')->widget(Select2::classname(), [
            'data' => $jabatan_sap,
            // 'initValueText' => $recruitreqs, // set the initial display text
            'options' => ['placeholder' => '- select -'],
            'pluginOptions' => [
                'dropdownParent' => $dropdownparent,
                'allowClear' => true,
            ],
        ]);
        ?>
        <?php
        echo   $form->field($model, 'kode_posisi')->widget(Select2::classname(), [
            'data' => $hire_jabatan_sap,
            // 'initValueText' => $recruitreqs, // set the initial display text
            'options' => ['placeholder' => '- select -'],
            'pluginOptions' => [
                'dropdownParent' => $dropdownparent,
                'allowClear' => true,
            ],
        ]);
        ?>

        <?= $form->field($model, 'kode_jabatan')->textInput(['maxlength' => true]) ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>