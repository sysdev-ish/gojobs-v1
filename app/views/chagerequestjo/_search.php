<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Chagerequestjosearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chagerequestjo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'recruitreqid') ?>

    <?= $form->field($model, 'createtime') ?>

    <?= $form->field($model, 'updatetime') ?>

    <?= $form->field($model, 'approvedtime') ?>

    <?php // echo $form->field($model, 'createdby') ?>

    <?php // echo $form->field($model, 'updatedby') ?>

    <?php // echo $form->field($model, 'approvedby') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'remarks') ?>

    <?php // echo $form->field($model, 'oldjumlah') ?>

    <?php // echo $form->field($model, 'jumlah') ?>

    <?php // echo $form->field($model, 'documentevidence') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
