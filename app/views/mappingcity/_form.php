<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MappingCity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mapping-city-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'city_id')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'city_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'province_id')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'manar')->textInput() ?>

        <?= $form->field($model, 'manar2')->textInput() ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
