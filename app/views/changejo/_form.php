<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Changejo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="changejo-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'recruitreqid')->textInput() ?>

        <?= $form->field($model, 'createtime')->textInput() ?>

        <?= $form->field($model, 'updatetime')->textInput() ?>

        <?= $form->field($model, 'approvedtime')->textInput() ?>

        <?= $form->field($model, 'approvedtime2')->textInput() ?>

        <?= $form->field($model, 'createdby')->textInput() ?>

        <?= $form->field($model, 'updatedby')->textInput() ?>

        <?= $form->field($model, 'approvedby')->textInput() ?>

        <?= $form->field($model, 'approvedby2')->textInput() ?>

        <?= $form->field($model, 'status')->textInput() ?>

        <?= $form->field($model, 'remarks')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'oldjumlah')->textInput() ?>

        <?= $form->field($model, 'jumlahstop')->textInput() ?>

        <?= $form->field($model, 'jumlah')->textInput() ?>

        <?= $form->field($model, 'documentevidence')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'reason')->textInput() ?>

        <?= $form->field($model, 'typeapproval')->textInput() ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
