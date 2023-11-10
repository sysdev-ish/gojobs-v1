<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;


?>
<div class="careerfy-row careerfy-employer-profile-form" style="padding-top:10%;">
  <div class="careerfy-row">
    <?php $form = ActiveForm::begin(['id' => 'form-changepassword', 'class' => 'careerfy-employer-dasboard']); ?>
    <div class="careerfy-employer-box-section" style="width:30%;float:none;margin:auto; margin-bottom:10%;">
      <div class="careerfy-profile-title">
        <h3 class="box-title">Change Password</h3>
      </div>
      <div class="careerfy-row careerfy-employer-profile-form">

        <li class="careerfy-column-12">
          <?php if (Yii::$app->session->hasFlash('success')) : ?>
            <div class="alert alert-success alert-dismissable">
              <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
              <!-- <h4><i class="icon fa fa-check"></i>Saved!</h4> -->
              <?= Yii::$app->session->getFlash('success') ?>
            </div>
          <?php endif; ?>

          <?php if (Yii::$app->session->hasFlash('error')) : ?>
            <div class="alert alert-error alert-dismissable" style="text-align: center;border: 1px solid #f507074d;padding: 15px;">
              <button aria-hidden="true" data-dismiss="alert" class="close" type="button" style="top: -15px;right: -10px;">×</button>
              <!-- <h4><i class="icon fa fa-check"></i>Saved!</h4> -->
              <?= Yii::$app->session->getFlash('error') ?>
            </div>
          <?php endif; ?>


          <!-- <div class="col-lg-12"> -->
          <?= $form->field($model, 'username')->hiddenInput(['maxlength' => true])->label(false) ?>

          <p class="text-red">Sebagai starndard keamanan sistem, silahkan ubah password anda pada form dibawah</p>
        <li class="careerfy-column-12">
          <?= $form->field($model, 'password')->passwordInput()->label('New Password') ?>
        </li>
        <li class="careerfy-column-12">
          <?= $form->field($model, 'retype_password')->passwordInput() ?>
        </li>
        <!-- </div> -->
        </li>
        <li class="careerfy-column-12">
          <?= Html::submitButton('Change Password', ['class' => 'btn btn-sm btn-primary pull-right', 'name' => 'verify-button']) ?>
        </li>
        </ul>
      </div>
      <?php ActiveForm::end(); ?>
    </div>
  </div>