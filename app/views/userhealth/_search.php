<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Userhealthsearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="userhealth-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'userid') ?>

    <?= $form->field($model, 'createtime') ?>

    <?= $form->field($model, 'updatetime') ?>

    <?= $form->field($model, 'sick') ?>

    <?php // echo $form->field($model, 'when') ?>

    <?php // echo $form->field($model, 'effect') ?>

    <?php // echo $form->field($model, 'illnessdesc') ?>

    <?php // echo $form->field($model, 'accident') ?>

    <?php // echo $form->field($model, 'whenaccident') ?>

    <?php // echo $form->field($model, 'efffectaccident') ?>

    <?php // echo $form->field($model, 'accidentdesc') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
