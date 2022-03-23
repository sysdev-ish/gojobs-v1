<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Computerskill */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="computerskill-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'userid')->textInput() ?>

        <?= $form->field($model, 'createtime')->textInput() ?>

        <?= $form->field($model, 'updatetime')->textInput() ?>

        <?= $form->field($model, 'msword')->textInput() ?>

        <?= $form->field($model, 'msexcel')->textInput() ?>

        <?= $form->field($model, 'mspowerpoint')->textInput() ?>

        <?= $form->field($model, 'sql')->textInput() ?>

        <?= $form->field($model, 'lan')->textInput() ?>

        <?= $form->field($model, 'wan')->textInput() ?>

        <?= $form->field($model, 'pascal')->textInput() ?>

        <?= $form->field($model, 'clanguage')->textInput() ?>

        <?= $form->field($model, 'others')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'internetknowledge')->textInput() ?>

        <?= $form->field($model, 'usinginternetpurpose')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'usinginternetfrequency')->textInput(['maxlength' => true]) ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
