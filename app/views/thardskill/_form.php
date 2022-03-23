<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Thardskill */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="thardskill-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'userid')->textInput() ?>

        <?= $form->field($model, 'createtime')->textInput() ?>

        <?= $form->field($model, 'updatetime')->textInput() ?>

        <?= $form->field($model, 'scheduledate')->textInput() ?>

        <?= $form->field($model, 'date')->textInput() ?>

        <?= $form->field($model, 'status')->textInput() ?>

        <?= $form->field($model, 'recruitmentcandidateid')->textInput() ?>

        <?= $form->field($model, 'officeid')->textInput() ?>

        <?= $form->field($model, 'roomid')->textInput() ?>

        <?= $form->field($model, 'pic')->textInput() ?>

        <?= $form->field($model, 'desc')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'addinfo')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'officepic')->textInput() ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
