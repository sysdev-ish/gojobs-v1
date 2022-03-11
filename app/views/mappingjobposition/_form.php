<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MappingJobPosition */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mapping-job-position-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'jabatan_sap')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'kode_jabatan')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'kode_posisi')->textInput(['maxlength' => true]) ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
