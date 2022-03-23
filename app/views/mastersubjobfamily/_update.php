<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\MasterSubJobFamily */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mastersubjobfamily-form box box-primary">
  <?php $form = ActiveForm::begin(); ?>
  <div class="box-body table-responsive">
    <?php echo $form->field($model, 'status')->dropdownList([1 => 'Publish', 0 => 'Unpublish'], ['prompt' => 'Select']); ?>
    <?php echo $form->field($model, 'jobfamily_id')->widget(Select2::classname(), [
      'data' => $jobfamily,
      'options' => ['placeholder' => '- select -'],
    ]);
    ?>
    <?= $form->field($model, 'subjobfamily')->textInput(['maxlength' => true]) ?>

  </div>
  <div class="box-footer">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
  </div>
  <?php ActiveForm::end(); ?>
</div>