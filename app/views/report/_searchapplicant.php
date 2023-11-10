<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\helpers\Url;

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
      <div class="col-md-3">
        <?= $form->field($model, 'registerstart')->widget(
          DatePicker::className(),
          [
            'type' => DatePicker::TYPE_RANGE,
            'options' => ['placeholder' => 'Date', 'autocomplete' => 'off'],
            'readonly' => true,
            'removeButton' => false,
            'attribute2' => 'registerend',
            'pluginOptions' => [
              'autoclose' => true,
              'startDate' => '-4y',
              'endDate' => '-0y',
              'format' => 'yyyy-mm-dd',
              'todayHighlight' => true
            ]
          ]
        );
        ?>
      </div>
      <div class="col-md-3">
        <?php echo $form->field($model, 'education')->widget(Select2::classname(), [
          'data' => $education,
          'options' => ['placeholder' => '- select -', 'id' => 'education'],
          'pluginOptions' => [
            'allowClear' => true,
          ],
        ]);
        ?>
      </div>
      <div class="col-md-3">
        <?php
        echo  $form->field($model, 'jurusan');
        ?>
      </div>
      <div class="col-md-3">
        <?php echo $form->field($model, 'applicantstatus')->widget(Select2::classname(), [
          // 'data' => $statuscandidate,
          'data' => [1 => 'Candidate', 2 => 'Not in candidate'],
          'options' => ['placeholder' => '- select -', 'id' => 'applicantstatus'],
          'pluginOptions' => [
            'allowClear' => true,
            'initialize' => false,
          ],
        ]);
        ?>
      </div>
    </div>
    <div class="col-md-12">
      <div class="col-md-2">
        <?php echo $form->field($model, 'provinceid')->widget(Select2::classname(), [
          'data' => $province,
          'options' => ['placeholder' => '- select -', 'id' => 'provinceid'],
          'pluginOptions' => [
            'allowClear' => true
          ],
        ])->label('Province');
        ?>
      </div>
      <div class="col-md-2">
        <!-- <//?//php echo $form->field($model, 'cityid')->widget(Select2::classname(), [
          'data' => $mastercity,
          'options' => ['placeholder' => '- select -', 'id' => 'cityid'],
          'pluginOptions' => [
            'allowClear' => true
          ],
        ]);
        ?> -->
        <?= Html::hiddenInput('model_id2', $model->cityid, ['id' => 'model_id2']) ?>
        <?= $form->field($model, 'cityid')->widget(DepDrop::classname(), [
          'data' => $mastercity,
          'type' => DepDrop::TYPE_SELECT2,
          'options' => ['id' => 'cityid'],
          'select2Options' => ['pluginOptions' => ['allowClear' => true]],
          'pluginOptions' => [
            'depends' => ['provinceid'],
            'placeholder' => '- select -',
            'url' => Url::to(['/mastercity/getcity']),
            'loadingText' => 'Loading ...',
            'params' => ['model_id2'],
            'initialize' => true,
          ],
        ])->label('City'); ?>

      </div>
      <div class="col-md-2">
        <?php echo $form->field($model, 'gender')->widget(Select2::classname(), [
          'data' => ['male' => 'Male', 'female' => 'Female'],
          'options' => ['placeholder' => '- select -', 'id' => 'gender'],
          'pluginOptions' => [
            'allowClear' => true,
          ],
        ]);
        ?>
      </div>
      <div class="col-md-2">
        <?php echo $form->field($model, 'havenpwp')->widget(Select2::classname(), [
          'data' => [1 => 'Yes', 2 => 'No'],
          'options' => ['placeholder' => '- select -', 'id' => 'havenpwp'],
          'pluginOptions' => [
            'allowClear' => true
          ],
        ]);
        ?>
      </div>
      <div class="col-md-2">
        <?php echo $form->field($model, 'religion')->widget(Select2::classname(), [
          'data' => ['islam' => 'Islam', 'christian' => 'Christian', 'catholic' => 'Catholic', 'protestant' => 'Protestant', 'hindu' => 'Hindu', 'buddha' => 'Buddha'],
          'options' => ['placeholder' => '- select -', 'id' => 'religion'],
          'pluginOptions' => [
            'allowClear' => true
          ],
        ]);
        ?>
      </div>
      <div class="col-md-2">
        <?php echo $form->field($model, 'maritalstatus')->widget(Select2::classname(), [
          'data' => ['married' => 'Married', 'single' => 'Single'],
          'options' => ['placeholder' => '- select -', 'id' => 'maritalstatus'],
          'pluginOptions' => [
            'allowClear' => true
          ],
        ])->label('Marital Status');
        ?>
      </div>
    </div>
    <div class="col-md-12">
      <div class="col-md-12">
        <div class="form-group pull-right">
          <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
          <?= Html::a('Reset', ['/report/reportapplicant'], ['class' => 'btn btn-default', 'id' => 'resethiringreport']) ?>
        </div>
      </div>
    </div>

    <?php ActiveForm::end(); ?>
  </div>
</div>