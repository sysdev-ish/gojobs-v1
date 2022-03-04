<style>
.login-form > textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input {
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
?>

<div class="row">
<div class="login-box">

    <br>
        <p class="login-box-msg">Sign in to start your session</p>

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
                <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>

            </div>
            <!-- /.col -->
        </div>


        <?php ActiveForm::end(); ?>





    </div>

    <!-- /.login-box-body -->
</div><!-- /.login-box -->
