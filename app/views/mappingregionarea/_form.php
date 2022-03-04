<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Mappingregionarea */
/* @var $form yii\widgets\ActiveForm */
if ($model->isNewRecord) {
      $dropdownparent = new yii\web\JsExpression('$("#createmappingregionarea-modal")');
    }else{
      $dropdownparent = new yii\web\JsExpression('$("#updatemappingregionarea-modal")');
    }
?>

<div class="mappingregionarea-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">
        <?php
        echo   $form->field($model, 'areaishid')->widget(Select2::classname(), [
          'data' => $areaish,
          // 'initValueText' => $recruitreqs, // set the initial display text
          'options' => ['placeholder' => '- select -'],
          'pluginOptions' => [
              'dropdownParent' => $dropdownparent,
              'allowClear' => true,
          ],
        ]);
        ?>
        <?php
        echo   $form->field($model, 'regionid')->widget(Select2::classname(), [
          'data' => $region,
          // 'initValueText' => $recruitreqs, // set the initial display text
          'options' => ['placeholder' => '- select -'],
          'pluginOptions' => [
              'dropdownParent' => $dropdownparent,
              'allowClear' => true,
          ],
        ]);
        ?>
        <?php
        echo   $form->field($model, 'areaid')->widget(Select2::classname(), [
          'data' => $area,
          // 'initValueText' => $recruitreqs, // set the initial display text
          'options' => ['placeholder' => '- select -'],
          'pluginOptions' => [
              'dropdownParent' => $dropdownparent,
              'allowClear' => true,
          ],
        ]);
        ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
