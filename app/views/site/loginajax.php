<style>
  .login-form>textarea,
  input[type="text"],
  input[type="password"],
  input[type="datetime"],
  input[type="datetime-local"],
  input[type="date"],
  input[type="month"],
  input[type="time"],
  input[type="week"],
  input[type="number"],
  input[type="email"],
  input[type="url"],
  input[type="search"],
  input[type="tel"],
  input[type="color"],
  .uneditable-input {
    padding: 6px 13px;
    color: #999999;
    font-size: 12px;
    height: 42px;
    border: 1px solid #efefef;
    border-radius: 3px;
    background-color: #ffffff;
  }

  .form-control-feedback {
    line-height: 60px;
  }
</style>
<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Sign In';

$fieldOptions1 = [
  'options' => ['class' => 'form-group has-feedback'],
  'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
  'options' => ['class' => 'form-group has-feedback'],
  'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
$assetUrl = Yii::$app->request->baseUrl . '/assets';
$baseUrl = Yii::$app->request->baseUrl;

?>


<div class="login-ajax" style="padding-top:10px">

  <?php if (Yii::$app->session->hasFlash('error')) : ?>
    <div class="alert alert-error alert-dismissable">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
      <!-- <h4><i class="icon fa fa-check"></i>Saved!</h4> -->
      <?= Yii::$app->session->getFlash('error') ?>
    </div>
  <?php endif; ?>
  <?php $form = ActiveForm::begin(
    [
      'id' => 'login-form', 'enableClientValidation' => true,
      'action' => ['site/ajax-login'],
      'enableAjaxValidation' => true,
    ]
  ); ?>

  <?= $form
    ->field($model, 'username', $fieldOptions1)
    // ->label(false)
    ->textInput(['placeholder' => 'Username / email']) ?>

  <?= $form
    ->field($model, 'password', $fieldOptions2)
    // ->label(false)
    ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

  <div class="row">
    <div class="col-xs-8">
      <?= $form->field($model, 'rememberMe')->checkbox() ?>
    </div>
    <!-- /.col -->
    <div class="col-xs-4">
      <?= Html::a('I forgot my password', ['site/forgotpassword'], ['class' =>  '']) ?>
    </div>
    <div class="col-xs-12">
      <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
    </div>
  </div>
  <div class="row" style="margin-top:10px;">
    <div class="col-xs-12">
      <div class="careerfy-box-title careerfy-box-title-sub"><span> Or Sign in With </span></div>
    </div>
    <div class="col-xs-12">
      <?php echo Html::a('Sign in with HRIS', 'https://passport.ish.co.id/core/sso/default/login?response_type=code&client_id=GojobsDev&redirect_uri=http://localhost/rekrut/site/oauthhris&scope=user&action=login', ['class' =>  'btn btn-danger btn-block']) ?>
    </div>
  </div>

  <?php ActiveForm::end(); ?>

</div>

<!-- /.login-box-body -->
</div><!-- /.login-box -->