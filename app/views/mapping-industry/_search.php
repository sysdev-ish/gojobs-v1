<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MappingindustrySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mappingindustry-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'category_segment') ?>

    <?= $form->field($model, 'category_company') ?>

    <?= $form->field($model, 'descsription') ?>

    <?= $form->field($model, 'status') ?>


    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
