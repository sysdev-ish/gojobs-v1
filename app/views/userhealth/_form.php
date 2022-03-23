<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Userhealth */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="userhealth-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'userid')->textInput() ?>

        <?= $form->field($model, 'createtime')->textInput() ?>

        <?= $form->field($model, 'updatetime')->textInput() ?>

        <?= $form->field($model, 'sick')->textInput() ?>

        <?= $form->field($model, 'when')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'effect')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'illnessdesc')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'accident')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'whenaccident')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'efffectaccident')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'accidentdesc')->textInput(['maxlength' => true]) ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
