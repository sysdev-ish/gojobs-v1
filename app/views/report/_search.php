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
      'action' => ['reporthiring'],
      'method' => 'get',
    ]); ?>

    <div class="col-md-12">
      <!-- <div class="col-md-12">
        <?php //echo $form->field($model, 'fullname')->textInput(['maxlength' => true]) 
        ?>
      </div> -->
      <div class="col-md-4">
        <?= $form->field($model, 'startawalkontrak')->widget(
          DatePicker::className(),
          [
            'type' => DatePicker::TYPE_RANGE,
            'options' => ['placeholder' => 'Date', 'autocomplete' => 'off'],
            'readonly' => false,
            'removeButton' => false,
            'attribute2' => 'endawalkontrak',
            'pluginOptions' => [
              'autoclose' => true,
              'startDate' => '2019-01-01',
              'endDate' => '+5y', //where you define enddate more than today add by kaha 15/8/22
              // 'timePickerIncrement'=>60,
              'format' => 'yyyy-mm-dd',
              'todayHighlight' => true
            ]
          ]
        );
        ?>
      </div>
      <div class="col-md-4">
        <?= $form->field($model, 'startresign')->widget(
          DatePicker::className(),
          [
            'type' => DatePicker::TYPE_RANGE,
            'options' => ['placeholder' => 'Date', 'autocomplete' => 'off'],
            'readonly' => false,
            'removeButton' => false,
            'attribute2' => 'endresign',
            'pluginOptions' => [
              'autoclose' => true,
              'startDate' => '2019-01-01',
              'endDate' => '-0y',
              // 'timePickerIncrement'=>60,
              'format' => 'yyyy-mm-dd',
              'todayHighlight' => true
            ]
          ]
        );
        ?>
      </div>
      <div class="col-md-4">
        <?php
        echo   $form->field($model, 'sap')->widget(Select2::classname(), [
          'data' => [1 => "ISH", 2 => "Peralihan"],
          'options' => ['placeholder' => '- select -', 'id' => 'sap'],
          'pluginOptions' => [
            'allowClear' => true
          ],
        ]);
        ?>
      </div>
    </div>
    <div class="col-md-12">
      <div class="col-md-4">
        <?php
        echo   $form->field($model, 'jabatan')->widget(Select2::classname(), [
          'data' => $jabatan,
          'options' => ['placeholder' => '- select -', 'id' => 'jabatan'],
          'pluginOptions' => [
            'allowClear' => true
          ],
        ]);
        ?>
      </div>
      <div class="col-md-4">
        <?php
        echo   $form->field($model, 'jobfamily')->widget(Select2::className(), [
          'data' => $jobfamily,
          'options' => ['placeholder' => '- select -', 'id' => 'jobfamily'],
          'pluginOptions' => [
            'allowClear' => true
          ],
        ]);
        ?>
      </div>
      <div class="col-md-4">
        <?php echo Html::hiddenInput('model_id2', $model->subjobfamily, ['id' => 'model_id2']);
        echo $form->field($model, 'subjobfamily')->widget(DepDrop::classname(), [
          'data' => $subjobfamily,
          'type' => DepDrop::TYPE_SELECT2,
          'options' => ['id' => 'subjobfamily'],
          'select2Options' => ['pluginOptions' => ['allowClear' => true]],
          'pluginOptions' => [
            'depends' => ['jobfamily'],
            'placeholder' => '- select -',
            'url' => Url::to(['/report/gethiring']),
            'loadingText' => 'Loading ...',
            'params' => ['model_id2'],
            'initialize' => true,
          ],
        ]);
        ?>
      </div>
    </div>
    <div class="col-md-12">
      <div class="col-md-3">
        <?php
        echo   $form->field($model, 'personalarea')->widget(Select2::classname(), [
          'data' => $parea,
          'options' => ['placeholder' => '- select -', 'id' => 'personalarea'],
          'pluginOptions' => [
            'allowClear' => true,
            'initialize' => false,
          ],
        ])->label('Personal Area');
        ?>
      </div>
      <div class="col-md-3">
        <?php
        echo   $form->field($model, 'areaish')->widget(Select2::classname(), [
          'data' => $areaish,
          'options' => ['placeholder' => '- select -', 'id' => 'areaish'],
          'pluginOptions' => [
            'allowClear' => true,
            'initialize' => false,
          ],
        ]);
        ?>
      </div>
      <div class="col-md-3">
        <?php echo  Html::hiddenInput('model_id2', $model->region, ['id' => 'model_id2']);
        echo $form->field($model, 'region')->widget(DepDrop::classname(), [
          'data' => $region,
          'type' => DepDrop::TYPE_SELECT2,
          'options' => ['id' => 'region'],
          'select2Options' => ['pluginOptions' => ['allowClear' => true]],
          'pluginOptions' => [
            'depends' => ['areaish'],
            'placeholder' => 'Select Area ISH',
            'url' => Url::to(['/report/getregion']),
            'loadingText' => 'Loading ...',
            'params' => ['model_id2'],
            'initialize' => true,
          ],
        ]); ?>
      </div>
      <div class="col-md-3">
        <?php
        echo   $form->field($model, 'area')->widget(Select2::classname(), [
          'data' => $area,
          'options' => ['placeholder' => '- select -', 'id' => 'area'],
          'pluginOptions' => [
            'allowClear' => true,
            'multiple' => true
          ],
        ])->label('Kota');
        ?>
      </div>
    </div>
    <div class="col-md-12">
      <div class="col-md-12">
        <div class="form-group pull-right">
          <?php //Html::submitButton('Search', ['class' => 'btn btn-primary', 'onClick'=>'alert("test");return false;']) 
          ?>
          <?= Html::submitButton('Search', [
            'class' => 'btn btn-primary', 'onClick' => '
          var startdate = $("#hiringreport-startawalkontrak").val();
          var enddate = $("#hiringreport-endawalkontrak").val();
          var startdater = $("#hiringreport-startresign").val();
          var enddater = $("#hiringreport-endresign").val();
          var date1 = new Date(startdate);
          var date2 = new Date(enddate);
          var date1r = new Date(startdater);
          var date2r = new Date(enddater);
          var Difference_In_Days = (date2.getTime() - date1.getTime()) / (1000 * 3600 * 24);
          var Difference_In_Daysr = (date2r.getTime() - date1r.getTime()) / (1000 * 3600 * 24);
          if(startdate && enddate){
            if (Difference_In_Days <= 365 ){
              return true;
            }else{
              alert("Periode awal kontrak tidak boleh melebihi 365 Hari");
              return false;
            }
          }
          if(startdater && enddater){
            if (Difference_In_Daysr <= 365 ){
              return true;
            }else{
              alert("Periode awal resign tidak boleh melebihi 365 Hari");
              return false;
            }
          }
          '
          ]) ?>
          <?= Html::a('Reset', ['/report/reporthiring'], ['class' => 'btn btn-default', 'id' => 'resethiringreport']) ?>
        </div>
      </div>
    </div>

    <?php ActiveForm::end(); ?>
  </div>
</div>