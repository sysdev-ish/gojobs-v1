<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Hiringsearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hiring-search">
  <div class="row">
    <?php $form = ActiveForm::begin([
      'action' => ['reportjoborder'],
      'method' => 'get',
    ]); ?>

    <div class="col-md-12">
      <div class="col-md-6">
        <?= $form->field($model, 'startjo')->widget(
          DatePicker::className(), [
            'type' => DatePicker::TYPE_RANGE,
            'options' => ['placeholder' => 'Date','autocomplete' => 'off'],
            'readonly' => true,
            'removeButton' => false,
            'attribute2' => 'endjo',
            'pluginOptions' => [
              'autoclose' => true,
              'startDate'=>'-2y',
              'endDate'=>'-0y',
              'format' => 'yyyy-mm-dd',
              'todayHighlight' => true
            ]
          ]);
          ?>
      </div>
      <div class="col-md-6">
        <?php
        echo   $form->field($model, 'area')->widget(Select2::classname(), [
          'data' => $area,
          'options' => ['placeholder' => '- select -', 'id'=>'area'],
          'pluginOptions' => [
            'allowClear' => true,
            'multiple' => true
          ],
        ]);
        ?>
      </div>
    </div>
    <div class="col-md-12">
      <div class="col-md-3">
        <?php
        echo   $form->field($model, 'typejo')->widget(Select2::classname(), [
          'data' => [ 1 =>"New Project", 2 =>"Replacement"],
          'options' => ['placeholder' => '- select -', 'id'=>'typejo'],
          'pluginOptions' => [
            'allowClear' => true
          ],
        ]);
        ?>
      </div>
      <div class="col-md-3">
        <?php
        echo   $form->field($model, 'status')->widget(Select2::classname(), [
          'data' => ['1'=>'On Progress', '2' => 'Done', '3' => 'On Progress (Revised JO)','4' => 'Done (Revised JO)'],
          'options' => ['placeholder' => '- select -', 'id'=>'status'],
          'pluginOptions' => [
            'allowClear' => true
          ],
        ]);
        ?>
      </div>

      <div class="col-md-6">
        <?php
        echo   $form->field($model, 'personalarea')->widget(Select2::classname(), [
          'data' => $parea,
          'options' => ['placeholder' => '- select -', 'id'=>'personalarea'],
          'pluginOptions' => [
            'allowClear' => true,
            'initialize' => false,
          ],
        ]);
        ?>
      </div>
    </div>
    <div class="col-md-12">
      <div class="col-md-6">
        <?php
        echo   $form->field($model, 'areaish')->widget(Select2::classname(), [
          'data' => $areaish,
          'options' => ['placeholder' => '- select -', 'id'=>'areaish'],
          'pluginOptions' => [
            'allowClear' => true,
            'initialize' => false,
          ],
        ]);
        ?>
      </div>
      <div class="col-md-6">
        <?php echo  Html::hiddenInput('model_id2', $model->region, ['id'=>'model_id2']);
        echo $form->field($model, 'region')->widget(DepDrop::classname(), [
          'data'=> $region,
          'type' => DepDrop::TYPE_SELECT2,
          'options' => ['id'=>'region'],
          'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
          'pluginOptions'=>[
            'depends'=>['areaish'],
            'placeholder'=>'Select Area ISH',
            'url'=>Url::to(['/report/getregion']),
            'loadingText' => 'Loading ...',
            'params'=>['model_id2'],
            'initialize' => true,
          ],


        ]); ?>
      </div>
    </div>
    <div class="col-md-12">
      <div class="col-md-12">
        <div class="form-group">
          <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
          <?= Html::a('Reset', ['/report/reportjoborder'],['class' => 'btn btn-default','id'=>'resethiringreport']) ?>
        </div>
      </div>
    </div>

    <?php ActiveForm::end(); ?>
  </div>
</div>
