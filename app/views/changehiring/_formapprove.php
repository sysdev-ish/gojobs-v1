<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use kartik\select2\Select2;
use linslin\yii2\curl;

/* @var $this yii\web\View */
/* @var $model app\models\Changehiring */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
  <div class="col-sm-12">
    <blockquote>
      <p>Approval Change Hiring for  <b><?php echo $model->fullname; ?></b>.</p>
    </blockquote>
  </div>
<div class="col-md-12">
  <div class="changehiring-form">
      <?php $form = ActiveForm::begin([
        'options'=>[
          'enctype'=>'multipart/form-data',
          'id'=>'stopjo-form'
        ]
      ]); ?>
      <div class="box-body table-responsive">

          <?php
          $data = [8 => 'Approve', 5 => 'Reject', 6=>'Revise'];
          echo   $form->field($model, 'status')->widget(Select2::classname(), [
            'data' => $data,
            'options' => ['placeholder' => '- select -'],
            'pluginOptions' => [
                'allowClear' => false,
                'initialize' => true,
            ],
          ])->label('');
          ?>
          <?= $form->field($model, 'userremarks')->textArea(['maxlength' => true]) ?>
      </div>
      <br>
      <div class="box-footer">
          <?= Html::submitButton('Submit', ['class' => 'btn btn-success btn-flat pull-right']) ?>
      </div>
      <?php ActiveForm::end(); ?>
  </div>
</div>
</div>
