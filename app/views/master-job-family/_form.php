<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MasterJobFamily */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-job-family-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'job_family')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'createtime')->textInput() ?>

        <?= $form->field($model, 'updatetime')->textInput() ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
