<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\MasterJobFamily */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="masterjobfamily-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">
        <?php echo $form->field($model, 'status')->widget(Select2::classname(), [
            'data' => [1 => 'Publish', 0 => 'Unpublish'],
            'options' => ['placeholder' => '- Select Status -'],
        ])
        ?>
        <?= $form->field($model, 'jobfamily')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>