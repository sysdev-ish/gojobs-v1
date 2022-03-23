<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Masterpic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="masterpic-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

      <?php
      if (!$model->isNewRecord){$dropdownparent = new yii\web\JsExpression('$("#updatemasterpic-modal")');
      }else{$dropdownparent = new yii\web\JsExpression('$("#createmasterpic-modal")');};
      echo   $form->field($model, 'masterofficeid')->widget(Select2::classname(), [
        'data' => $office,
        'options' => ['placeholder' => '- select -'],
        'pluginOptions' => [
            'dropdownParent' => $dropdownparent,
            'allowClear' => true,
        ],
      ]);
      ?>
      <?php
      if (!$model->isNewRecord){$dropdownparent = new yii\web\JsExpression('$("#updatemasterpic-modal")');
      }else{$dropdownparent = new yii\web\JsExpression('$("#createmasterpic-modal")');};
      echo   $form->field($model, 'userid')->widget(Select2::classname(), [
        'data' => $userlogin,
        'options' => ['placeholder' => '- select -'],
        'pluginOptions' => [
            'dropdownParent' => $dropdownparent,
            'allowClear' => true,
        ],
      ]);
      ?>



    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
