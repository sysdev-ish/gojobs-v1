<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Englishskillsearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="englishskill-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'userid') ?>

    <?= $form->field($model, 'createtime') ?>

    <?= $form->field($model, 'updatetime') ?>

    <?= $form->field($model, 'havetoefl') ?>

    <?php // echo $form->field($model, 'testtoefldate') ?>

    <?php // echo $form->field($model, 'institutions') ?>

    <?php // echo $form->field($model, 'toeflscore') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
