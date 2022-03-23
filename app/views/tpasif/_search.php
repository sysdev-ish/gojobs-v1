<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tpasifsearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tpasif-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'userid') ?>

    <?= $form->field($model, 'createtime') ?>

    <?= $form->field($model, 'updatetime') ?>

    <?= $form->field($model, 'scheduledate') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'recruitmentcandidateid') ?>

    <?php // echo $form->field($model, 'officeid') ?>

    <?php // echo $form->field($model, 'roomid') ?>

    <?php // echo $form->field($model, 'pic') ?>

    <?php // echo $form->field($model, 'desc') ?>

    <?php // echo $form->field($model, 'addinfo') ?>

    <?php // echo $form->field($model, 'officepic') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
