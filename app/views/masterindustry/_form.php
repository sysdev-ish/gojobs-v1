<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Masterindustry */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="masterindustry-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'type_industry')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'createtime')->textInput() ?>

        <?= $form->field($model, 'updatetime')->textInput() ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
