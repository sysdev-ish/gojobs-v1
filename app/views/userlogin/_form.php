<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Userlogin */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="userlogin-form box box-default">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">


        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'othersid')->textInput(['maxlength' => true])->label('Others ID') ?>


        <?php
         if (!$model->isNewRecord){$modelrole = $model->role;}else{$modelrole = null;}
        // var_dump($modelrole);die;
         if($model->role != 1){
           echo   $form->field($model, 'role')->widget(Select2::classname(), [
             'data' => $userrole,
             'options' => ['placeholder' => '- select -', 'id'=>'role'],
             'pluginOptions' => [
               'allowClear' => true
             ],
           ]);
         }

        ?>
        <?php
         if (!$model->isNewRecord){$modelrole = $model->role;}else{$modelrole = null;}
        // var_dump($modelrole);die;
         if($model->role != 1){
           echo   $form->field($model, 'grouprolepermissionid')->widget(Select2::classname(), [
             'data' => $grouprolepermission,
             'options' => ['placeholder' => '- select -', 'id'=>'grouprolepermissionid'],
             'pluginOptions' => [
               'allowClear' => true
             ],
           ]);
         }

        ?>
        <?php if ($model->isNewRecord) : ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'retype_password')->passwordInput() ?>
      <?php endif; ?>


    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
