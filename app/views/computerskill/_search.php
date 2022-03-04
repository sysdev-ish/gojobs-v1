<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Computerskillsearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="computerskill-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'userid') ?>

    <?= $form->field($model, 'createtime') ?>

    <?= $form->field($model, 'updatetime') ?>

    <?= $form->field($model, 'msword') ?>

    <?php // echo $form->field($model, 'msexcel') ?>

    <?php // echo $form->field($model, 'mspowerpoint') ?>

    <?php // echo $form->field($model, 'sql') ?>

    <?php // echo $form->field($model, 'lan') ?>

    <?php // echo $form->field($model, 'wan') ?>

    <?php // echo $form->field($model, 'pascal') ?>

    <?php // echo $form->field($model, 'clanguage') ?>

    <?php // echo $form->field($model, 'others') ?>

    <?php // echo $form->field($model, 'internetknowledge') ?>

    <?php // echo $form->field($model, 'usinginternetpurpose') ?>

    <?php // echo $form->field($model, 'usinginternetfrequency') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
