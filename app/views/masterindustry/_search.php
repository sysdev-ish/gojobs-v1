<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MasterindustrySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="masterindustry-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'createtime') ?>

    <?= $form->field($model, 'updatetime') ?>

    <?= $form->field($model, 'industry_type') ?>
    
    <?= $form->field($model, 'status') ?>


    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>