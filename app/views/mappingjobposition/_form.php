<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use app\models\Sapjob;
use yii\helpers\ArrayHelper;

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
        <?php
        echo   $form->field($model, 'kodejabatan')->widget(Select2::classname(), [
            'data' => $kodejabatan,
            // 'initValueText' => $recruitreqs, // set the initial display text
            'options' => ['placeholder' => '- Select -', 'id' => 'kodejabatan'],
            'pluginOptions' => [
                'dropdownParent' => $dropdownparent,
                'allowClear' => true,
                // 'minimumInputLength' => 5,
            ],
        ]);
        ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>