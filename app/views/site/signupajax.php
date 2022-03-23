<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;


?>


    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin([
              'id' => 'form-signup',
              // 'enableClientValidation' => true,
              // 'enableAjaxValidation' => true,
            ]); ?>

                <?= $form->field($model, 'name') ?>

                <?= $form->field($model, 'mobile') ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'retype_password')->passwordInput() ?>

                <div class="form-group">

                  <?= $form->field($model, 'agree')->label('Dengan ini saya menyetujui aturan penggunaan dan kebijakan privasi dari PT Infomedia Solusi Humanika')->checkbox(['checked' => false, 'required' => true]) ?>
                </div>
                <div class="box-footer">
                  <?= Html::submitButton('Register', ['class' => 'btn btn-primary pull-right', 'name' => 'signup-button']) ?>



                </div>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
