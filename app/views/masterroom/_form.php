<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Masterroom */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="masterroom-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?php
        if (!$model->isNewRecord){$dropdownparent = new yii\web\JsExpression('$("#updatemasterroom-modal")');
        }else{$dropdownparent = new yii\web\JsExpression('$("#createmasterroom-modal")');};
        echo   $form->field($model, 'masterofficeid')->widget(Select2::classname(), [
          'data' => $office,
          'options' => ['placeholder' => '- select -'],
          'pluginOptions' => [
              'dropdownParent' => $dropdownparent,
              'allowClear' => true,
          ],
        ]);
        ?>

        <?= $form->field($model, 'room')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'floor')->textInput(['maxlength' => true]) ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
