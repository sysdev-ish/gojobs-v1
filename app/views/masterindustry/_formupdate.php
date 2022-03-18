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
        <?php echo $form->field($model, 'status')->dropdownList([1 => 'Publish',0 => 'Unpublish'],['prompt'=>'Select']);?>
        <?= $form->field($model, 'industry_type')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>