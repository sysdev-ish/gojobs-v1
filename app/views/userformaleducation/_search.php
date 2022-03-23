<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Userformaleducationsearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="userformaleducation-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'userid') ?>

    <?= $form->field($model, 'createtime') ?>

    <?= $form->field($model, 'updatetime') ?>

    <?= $form->field($model, 'educationallevel') ?>

    <?php // echo $form->field($model, 'institutions') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'majoring') ?>

    <?php // echo $form->field($model, 'startdate') ?>

    <?php // echo $form->field($model, 'enddate') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'gpa') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
