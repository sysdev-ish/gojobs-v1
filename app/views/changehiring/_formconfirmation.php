<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use kartik\select2\Select2;
use linslin\yii2\curl;

/* @var $this yii\web\View */
/* @var $model app\models\Chagerequestjo */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
  <div class="col-sm-12">
    <blockquote>
      <p>Confirmation Change Hiring for  <b><?php echo $model->fullname; ?></b>.</p>
    </blockquote>
  </div>
<div class="col-md-12">
  <div class="chagerequestjo-form">
      <?php $form = ActiveForm::begin([
        'options'=>[
          'enctype'=>'multipart/form-data',
          'id'=>'stopjo-form'
        ]
      ]); ?>
      <div class="box-body table-responsive">
          <?php
          $data = [4 => 'Confirm Change Hiring', 5 => 'Reject Change Hiring', 6 => 'Revise Change Hiring'];
          echo   $form->field($model, 'status')->widget(Select2::classname(), [
            'data' => $data,
            'options' => ['placeholder' => '- select -'],
            'pluginOptions' => [
                'allowClear' => false,
                'initialize' => true,
            ],
          ])->label('Select Confirmation');
          ?>
      </div>
      <div class="box-footer">
          <?= Html::submitButton('Submit', ['class' => 'btn btn-success btn-flat pull-right']) ?>
      </div>
      <?php ActiveForm::end(); ?>
  </div>
</div>
</div>
