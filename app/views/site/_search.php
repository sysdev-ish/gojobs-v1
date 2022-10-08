<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\MappingCity;

/* @var $this yii\web\View */
/* @var $model app\models\Transrinciansearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transrincian-search">

  <?php $form = ActiveForm::begin([
    'action' => ['searchjob'],
    'method' => 'get',
    'options' => [
      'class' => 'careerfy-banner-search',
    ],

  ]); ?>
  <ul>
    <li>
      <?= $form->field($model, 'jobfunclike')->textInput(['placeholder' => "Job Title .."])->label(false) ?>
    </li>

    <li>

      <?php
      $city = ArrayHelper::map(MappingCity::find()->asArray()->all(), 'city_id', 'city_name');
      echo   $form->field($model, 'lokasi')->widget(Select2::classname(), [
        'data' => $city,
        'options' => ['placeholder' => '- All Location -', 'id'=>'lokasi'],
        'pluginOptions' => [
          'allowClear' => true,
          'width'=>'resolve',
        ],
        ])->label(false);
        ?>
      </li>
      <li>
        <?php
        echo   $form->field($model, 'gender')->widget(Select2::classname(), [
          'data' => ['pria'=>'Male','wanita'=>'Female'],
          'options' => ['placeholder' => '- All Gender -', 'id'=>'gender'],
          'pluginOptions' => [
            'allowClear' => true
          ],
          ])->label(false);
          ?>
        </li>
        <li class="careerfy-banner-submit">
          <?php //echo Html::submitButton('<i class="careerfy-icon careerfy-search"></i>', ['class' => 'btn btn-block btn-primary']) ?>
          <?php  //echo Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
          <input type="submit" value=""> <i class="careerfy-icon careerfy-search"></i>
        </li>
      </ul>

      <?php ActiveForm::end(); ?>

    </div>
