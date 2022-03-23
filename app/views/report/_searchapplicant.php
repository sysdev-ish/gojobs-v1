<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Hiringsearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hiring-search">
  <div class="row">
    <?php $form = ActiveForm::begin([
      'action' => ['reportapplicant'],
      'method' => 'get',
    ]); ?>

    <div class="col-md-12">
      <div class="col-md-12">
      <?= $form->field($model, 'registerstart')->widget(
        DatePicker::className(), [
          'type' => DatePicker::TYPE_RANGE,
          'options' => ['placeholder' => 'Date','autocomplete' => 'off'],
          'readonly' => true,
          'removeButton' => false,
          'attribute2' => 'registerend',
          'pluginOptions' => [
            'autoclose' => true,
            'startDate'=>'-1y',
            'endDate'=>'-0y',
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true
          ]
        ]);
        ?>
      </div>
      <div class="col-md-6">
        <?php
        echo   $form->field($model, 'education')->widget(Select2::classname(), [
          'data' => $education,
          'options' => ['placeholder' => '- select -', 'id'=>'education'],
          'pluginOptions' => [
            'allowClear' => true,
          ],
        ]);
        ?>
      </div>
      <div class="col-md-6">
        <?php
        echo  $form->field($model, 'jurusan');
        ?>
      </div>
    </div>
    <div class="col-md-12">
      <div class="col-md-6">
        <?php
        echo   $form->field($model, 'havenpwp')->widget(Select2::classname(), [
          'data' => [1=>'Yes',2=>'No'],
          'options' => ['placeholder' => '- select -', 'id'=>'havenpwp'],
          'pluginOptions' => [
            'allowClear' => true
          ],
        ]);
        ?>
      </div>
      <div class="col-md-6">
        <?php
        echo   $form->field($model, 'applicantstatus')->widget(Select2::classname(), [
          // 'data' => $statuscandidate,
          'data' => [1=>'Candidate', 2=> 'Not in candidate'],
          'options' => ['placeholder' => '- select -', 'id'=>'applicantstatus'],
          'pluginOptions' => [
            'allowClear' => true,
            'initialize' => false,
          ],
        ]);
        ?>
      </div>
      <div class="col-md-12">
        <?php
        echo   $form->field($model, 'cityid')->widget(Select2::classname(), [
          'data' => $mastercity,
          'options' => ['placeholder' => '- select -', 'id'=>'cityid'],
          'pluginOptions' => [
            'allowClear' => true
          ],
        ]);
        ?>
      </div>
    </div>
    <div class="col-md-12">
      <div class="col-md-12">
        <div class="form-group">
          <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
          <?= Html::a('Reset', ['/report/reportapplicant'],['class' => 'btn btn-default','id'=>'resethiringreport']) ?>
        </div>
      </div>
    </div>

    <?php ActiveForm::end(); ?>
  </div>
</div>
