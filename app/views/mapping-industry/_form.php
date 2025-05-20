<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Mappingindustry */
/* @var $form yii\widgets\ActiveForm */

if ($model->isNewRecord) {
    $dropdownparent = new yii\web\JsExpression('$("#createmappingindustry-modal")');
} else {
    $dropdownparent = new yii\web\JsExpression('$("#updatemappingindustry-modal")');
}
?>

<div class="mappingindustry-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->errorSummary($model) ?>
    <div class="box-body table-responsive">
        <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'client_name')->textInput(['maxlength' => true]) ?>
        <?php
        echo   $form->field($model, 'category_company')->widget(Select2::classname(), [
            'data' => $industry,
            // 'initValueText' => $recruitreqs, // set the initial display text
            'options' => ['placeholder' => '- Select Industry Type -'],
            'pluginOptions' => [
                'dropdownParent' => $dropdownparent,
                'allowClear' => true,
            ],
        ]);
        ?>
        <?php echo $form->field($model, 'category_segment')->widget(Select2::classname(), [
            'data' => [
                'telkom' => 'Telkom',
                'telkom_group' => 'Telkom Group',
                'enterprise' => 'Enterprise',
            ],
            'options' => [
                'placeholder' => '- Select Type Segment -',

            ],
        ])
        ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>