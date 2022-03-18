<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MasterJobFamily */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-job-family-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->errorSummary($model) ?>
    <div class="box-body table-responsive">
        <?php echo $form->field($model, 'status')->dropdownList([1 => 'Publish', 0 => 'Unpublish'], ['prompt' => 'Select']); ?>
        <?= $form->field($model, 'jobfamily')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>