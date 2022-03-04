<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Masteroffice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="masteroffice-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'officename')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'address')->textArea(['maxlength' => true]) ?>
        <?= $form->field($model, 'long')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'lat')->textInput(['maxlength' => true]) ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
