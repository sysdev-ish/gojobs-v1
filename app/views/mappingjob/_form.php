<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Mappingjob */
/* @var $form yii\widgets\ActiveForm */

if ($model->isNewRecord) {
    $dropdownparent = new yii\web\JsExpression('$("#createmappingjob-modal")');
} else {
    $dropdownparent = new yii\web\JsExpression('$("#updatemappingjob-modal")');
}
?>

<div class="mappingjob-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->errorSummary($model) ?>
    <div class="box-body table-responsive">
        <?php echo $form->field($model, 'status')->widget(Select2::classname(), [
            'data' => [1 => 'Publish', 0 => 'Unpublish'],
            'options' => ['placeholder' => '- Select Status -'],
        ])
        ?>
        <?php
        echo   $form->field($model, 'subjobfamilyid')->widget(Select2::classname(), [
            'data' => $subjobfamilyid,
            // 'initValueText' => $recruitreqs, // set the initial display text
            'options' => ['placeholder' => '- Select Sub Jobfamily -'],
            'pluginOptions' => [
                'dropdownParent' => $dropdownparent,
                'allowClear' => true,
            ],
        ]);
        ?>
        <?= $form->field($model, 'kodejabatan')->textInput() ?>

        <?= $form->field($model, 'jabatansap')->textInput(['maxlength' => true]) ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>