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
<div class="login-box">
  <br>
  <br>
  <div class="box box-header with-border">
            <h3 class="box-title">Forgot Password</h3>
          </div>
  <div class="login-box-body">
    <!-- <p class="login-box-msg">Register New Account</p> -->

    <div class="row">
        <div class="col-lg-12">
          <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success alert-dismissable">
              <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
              <!-- <h4><i class="icon fa fa-check"></i>Saved!</h4> -->
              <?= Yii::$app->session->getFlash('success') ?>
            </div>
          <?php endif; ?>

          <?php if (Yii::$app->session->hasFlash('error')): ?>
            <div class="alert alert-error alert-dismissable">
              <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
              <!-- <h4><i class="icon fa fa-check"></i>Saved!</h4> -->
              <?= Yii::$app->session->getFlash('error') ?>
            </div>
          <?php endif; ?>
            <?php $form = ActiveForm::begin(['id' => 'form-forgotpassword']); ?>

                <?= $form->field($model, 'username')->label('Username') ?>

                <div class="form-group">

                  </div>
                <div class="box-footer">
                  <?= Html::submitButton('Submit', ['class' => 'btn btn-primary pull-right', 'name' => 'forgotpassword-button']) ?>



                </div>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
</div>
