<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Userforeignlanguagesearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="userforeignlanguage-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'userid') ?>

    <?= $form->field($model, 'createtime') ?>

    <?= $form->field($model, 'updatetime') ?>

    <?= $form->field($model, 'language') ?>

    <?php // echo $form->field($model, 'speaking') ?>

    <?php // echo $form->field($model, 'writing') ?>

    <?php // echo $form->field($model, 'reading') ?>

    <?php // echo $form->field($model, 'understanding') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
