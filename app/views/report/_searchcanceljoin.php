<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\canceljoinsearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="canceljoin-search">
  <div class="row">
    <?php $form = ActiveForm::begin([
      'action' => ['reportcanceljoin'],
      'method' => 'get',
    ]); ?>

    <div class="col-md-12">
      <div class="col-md-4">
        <?= $form->field($model, 'startdate')->widget(
          DatePicker::className(),
          [
            'type' => DatePicker::TYPE_RANGE,
            'options' => ['placeholder' => 'Date', 'autocomplete' => 'off'],
            'readonly' => false,
            'removeButton' => false,
            'attribute2' => 'enddate',
            'pluginOptions' => [
              'autoclose' => true,
              'startDate' => '2019-01-01',
              'endDate' => '-0y',
              'format' => 'yyyy-mm-dd',
              'todayHighlight' => true
            ]
          ]
        );
        ?>
      </div>
      <div class="col-md-4">
        <?php echo $form->field($model, 'status')->widget(Select2::classname(), [
          'data' => $status,
          'options' => ['placeholder' => '- select -', 'id' => 'status'],
          'pluginOptions' => [
            'allowClear' => true
          ],
        ]);
        ?>
      </div>
      <div class="col-md-4">
        <?php echo $form->field($model, 'segmen')->widget(Select2::classname(), [
          'data' => $segmen,
          'options' => ['placeholder' => '- select -', 'id' => 'segmen'],
          'pluginOptions' => [
            'allowClear' => true
          ],
        ]);
        ?>
      </div>
    </div>

    <div class="col-md-12">
      <div class="col-md-12">
        <div class="form-group pull-right">
          <?= Html::submitButton('Search', [
            'class' => 'btn btn-primary', 'onClick' => '
          var startdate = $("#canceljoinreport-startdate").val();
          var enddate = $("#canceljoinreport-enddate").val();
          var date1 = new Date(startdate);
          var date2 = new Date(enddate);
          var Difference_In_Days = (date2.getTime() - date1.getTime()) / (1000 * 3600 * 24);
          var Difference_In_Daysr = (date2r.getTime() - date1r.getTime()) / (1000 * 3600 * 24);
          if(startdate && enddate){
            if (Difference_In_Days <= 60 ){
              return true;
            }else{
              alert("Periode awal kontrak tidak boleh melebihi 60 Hari");
              return false;
            }
          }
          if(startdater && enddater){
            if (Difference_In_Daysr <= 60 ){
              return true;
            }else{
              alert("Periode awal resign tidak boleh melebihi 60 Hari");
              return false;
            }
          }
          '
          ]) ?>
          <?= Html::a('Reset', ['/report/reportcanceljoin'], ['class' => 'btn btn-default', 'id' => 'resetcanceljoinreport']) ?>
        </div>
      </div>
    </div>

    <?php ActiveForm::end(); ?>
  </div>
</div>