<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Uploadocumentsearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="uploadocument-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'userid') ?>

    <?= $form->field($model, 'createtime') ?>

    <?= $form->field($model, 'updatetime') ?>

    <?= $form->field($model, 'ijazah') ?>

    <?php // echo $form->field($model, 'transkipnilai') ?>

    <?php // echo $form->field($model, 'suratketerangansehat') ?>

    <?php // echo $form->field($model, 'kartukeluarga') ?>

    <?php // echo $form->field($model, 'ktp') ?>

    <?php // echo $form->field($model, 'jamsostek') ?>

    <?php // echo $form->field($model, 'bpjskesehatan') ?>

    <?php // echo $form->field($model, 'npwp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
