<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;


?>
<div class="careerfy-main-content">
  <div class="careerfy-main-section careerfy-dashboard-full">
    <div class="container">

      <div class="careerfy-main-section">
        <div class="container">
          <div class="careerfy-employer-box-section" style="width:560px;margin:auto;float:none;">
            <div class="careerfy-profile-title">
              <h3 class="box-title">Email Verification Code</h3>
            </div>
            <div class="login-box-body">
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
                  <?php $form = ActiveForm::begin(['id' => 'form-verifycode']); ?>
                  <!-- <div class="col-lg-12"> -->
                  <?= $form->field($model, 'verify_code') ?>
                  <!-- </div> -->

                  <div class="box-footer">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'verify-button']) ?>
                    <?php
                    echo Html::a(
                      'Resend Verify Code',
                      ['/site/resendvcode'],
                      [
                        'class' => 'btn btn-default btn-flat pull-right',
                        'data' => [
                            'confirm' => 'Are you sure you want to resend verify code?',
                            'method' => 'post',
                        ],
                      ]
                    );
                      ?>



                    </div>
                  </div>

                  <?php ActiveForm::end(); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
