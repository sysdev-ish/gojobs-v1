<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Crdtransactionsearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="crdtransaction-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'crdid') ?>

    <?= $form->field($model, 'oldvalue') ?>

    <?= $form->field($model, 'newvalue') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'olddoc') ?>

    <?php // echo $form->field($model, 'newdoc') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
