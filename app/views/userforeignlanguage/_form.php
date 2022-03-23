<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Userforeignlanguage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="userforeignlanguage-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'userid')->textInput() ?>

        <?= $form->field($model, 'createtime')->textInput() ?>

        <?= $form->field($model, 'updatetime')->textInput() ?>

        <?= $form->field($model, 'language')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'speaking')->textInput() ?>

        <?= $form->field($model, 'writing')->textInput() ?>

        <?= $form->field($model, 'reading')->textInput() ?>

        <?= $form->field($model, 'understanding')->textInput() ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
