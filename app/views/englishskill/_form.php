<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Englishskill */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="englishskill-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'userid')->textInput() ?>

        <?= $form->field($model, 'createtime')->textInput() ?>

        <?= $form->field($model, 'updatetime')->textInput() ?>

        <?= $form->field($model, 'havetoefl')->textInput() ?>

        <?= $form->field($model, 'testtoefldate')->textInput() ?>

        <?= $form->field($model, 'institutions')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'toeflscore')->textInput() ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
