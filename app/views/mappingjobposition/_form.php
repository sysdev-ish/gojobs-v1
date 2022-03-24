<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Mappingjobposition */
/* @var $form yii\widgets\ActiveForm */

if ($model->isNewRecord) {
    $dropdownparent = new yii\web\JsExpression('$("#createmappingjobposition-modal")');
} else {
    $dropdownparent = new yii\web\JsExpression('$("#updatemappingjobposition-modal")');
}
?>

<div class="mappingjobposition-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->errorSummary($model) ?>
    <div class="box-body table-responsive">
        <?php echo $form->field($model, 'status')->dropdownList([1 => 'Publish', 0 => 'Unpublish'], ['prompt' => 'Select']); ?>
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
        <?php
        echo   $form->field($model, 'kodejabatan')->widget(Select2::classname(), [
            'data' => $kodejabatan,
            // 'initValueText' => $recruitreqs, // set the initial display text
            'options' => ['placeholder' => '- 2XXXXXXX -'],
            'pluginOptions' => [
                'dropdownParent' => $dropdownparent,
                'allowClear' => true,
                'minimumInputLength' => 5,
            ],
        ]);
        ?>
        <?php
        echo   $form->field($model, 'jabatansap')->widget(Select2::classname(), [
            'data' => $jabatansap,
            // 'initValueText' => $recruitreqs, // set the initial display text
            'options' => ['placeholder' => '- Select -'],
            'pluginOptions' => [
                'dropdownParent' => $dropdownparent,
                'allowClear' => true,
            ],
        ]);
        ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>