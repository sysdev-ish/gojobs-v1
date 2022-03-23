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
        echo   $form->field($model, 'subjobfamilyid')->widget(Select2::classname(), [
            'data' => $subjobfamilyid,
            // 'initValueText' => $recruitreqs, // set the initial display text
<<<<<<< HEAD
            'options' => ['placeholder' => '- select -'],
            'pluginOptions' => [
                'dropdownParent' => $dropdownparent,
                'allowClear' => true,
=======
            'options' => ['placeholder' => '- Select Sub Jobfamily -'],
            'pluginOptions' => [
                'dropdownParent' => $dropdownparent,
                'allowClear' => true,
                'minimumInputLength' => 1,
>>>>>>> origin/main
            ],
        ]);
        ?>
        <?php
        echo   $form->field($model, 'jabatansap')->widget(Select2::classname(), [
            'data' => $jabatansap,
            // 'initValueText' => $recruitreqs, // set the initial display text
<<<<<<< HEAD
            'options' => ['placeholder' => '- select -'],
            'pluginOptions' => [
                'dropdownParent' => $dropdownparent,
                'allowClear' => true,
=======
            'options' => ['placeholder' => '- 2XXXXXXX -'],
            'pluginOptions' => [
                'dropdownParent' => $dropdownparent,
                'allowClear' => true,
                'minimumInputLength' => 5,
>>>>>>> origin/main
            ],
        ]);
        ?>
        <?php
        echo   $form->field($model, 'kodeposisi')->widget(Select2::classname(), [
            'data' => $kodeposisi,
            // 'initValueText' => $recruitreqs, // set the initial display text
<<<<<<< HEAD
            'options' => ['placeholder' => '- select -'],
            'pluginOptions' => [
                'dropdownParent' => $dropdownparent,
                'allowClear' => true,
=======
            'options' => ['placeholder' => '- 2XXXXXXX -'],
            'pluginOptions' => [
                'dropdownParent' => $dropdownparent,
                'allowClear' => true,
                'minimumInputLength' => 5,
>>>>>>> origin/main
            ],
        ]);
        ?>

<<<<<<< HEAD
        <?= $form->field($model, 'kodejabatan')->textInput(['maxlength' => true]) ?>
=======
        <?= $form->field($model, 'kodejabatan')->textInput(['maxlength' => true])
        // ->input(['placeholder'=>"Kode Jabatan"]) 
        ?>
>>>>>>> origin/main

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>