<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Userworkexperienceposition */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="userworkexperienceposition-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'idworkexperience')->textInput() ?>

        <?= $form->field($model, 'createtime')->textInput() ?>

        <?= $form->field($model, 'updatetime')->textInput() ?>

        <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'salary')->textInput() ?>

        <?= $form->field($model, 'jobdesc')->textInput(['maxlength' => true]) ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
