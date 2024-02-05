<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Modal;

/* @var $this \yii\web\View */
/* @var $content string */

$assetUrl = Yii::$app->request->baseUrl . '/assets';
$baseUrl = Yii::$app->request->baseUrl;
if (!Yii::$app->user->isGuest) :
  $userid = Yii::$app->user->identity->id;
else :
  $userid = null;
endif;
(Yii::$app->user->isGuest) ? $id = null : $id = Yii::$app->user->identity->id;
(Yii::$app->user->isGuest) ? $vstatus = null : $vstatus = Yii::$app->user->identity->verify_status;

Modal::begin([
  'header' => '<h4 class="modal-title">Login to your account</h4>',
  'id' => 'login-modal',
  'size' => 'modal-md'
]);

echo "<div id='loginview'></div>";

Modal::end();
Modal::begin([
  'header' => '<h4 class="modal-title">Signup to your account</h4>',
  'id' => 'signup-modal',
  'size' => 'modal-md'
]);
echo "<div id='signupview'></div>";
Modal::end();

?>

<style type="text/css">
  @media (max-width: 767px) {
    .careerfy-navigation {
      float: right;
    }
  }
</style>

<header id="careerfy-header" class="careerfy-header-one">
  <div class="container">
    <div class="row">
      <aside class="col-md-2"> <a href="<?php echo $baseUrl; ?>" class="careerfy-logo"><img width="250" height="100" src="<?php echo $baseUrl; ?>/images/logo-gojobs.webp" alt=""></a>
      </aside>
      <!--<aside class="col-md-6">-->
      <aside class="col-md-10">
        <nav class="careerfy-navigation">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#careerfy-navbar-collapse-1" aria-expanded="false">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
          <?php if (Yii::$app->controller->action->id <> 'changepassword') : ?>
            <div class="collapse navbar-collapse" id="careerfy-navbar-collapse-1">
              <ul class="navbar-nav">
                <?php if ($vstatus == 1 or Yii::$app->user->isGuest) : ?>
                  <li class="<?php echo (Yii::$app->controller->action->id == 'index') ? 'active ' : ' '; ?> ">
                    <?= Html::a(Yii::t('app', 'Home'), ['/site/index']) ?></li>
                  <li class="<?php echo (Yii::$app->controller->action->id == 'searchjob') ? 'active ' : ' '; ?>">
                    <?= Html::a(Yii::t('app', 'Search Job'), ['/site/searchjob']) ?></li>
                  <?php if (Yii::$app->check->datacompleted($userid) == 1) : ?>
                    <li class="<?php echo (Yii::$app->controller->id == 'userprofile') ? 'active ' : ' '; ?>">
                      <?= Html::a('Profile', ['/userprofile/views', 'userid' => $userid]) ?></li>
                  <?php endif; ?>
                  <li class="<?php echo (Yii::$app->controller->action->id == 'contact') ? 'active ' : ' '; ?>">
                    <?= Html::a(Yii::t('app', 'Contact'), ['/site/contact']) ?></li>
                  <?php if (Yii::$app->check->datacompleted($userid) == 1) : ?>
                    <?php $link = 'https://rencanamu.id/gojobs';
                    $target = "_blank";
                    ?>
                  <?php else : ?>
                    <?php $link = ['/site/login'];
                    $target = "_self";
                    ?>
                  <?php endif; ?>
                  <li><?= Html::a(Yii::t('app', 'Assessment'), $link, ["target" => $target]) ?></li>
                <?php endif; ?>
                <!-- <li> -->
                <ul class="careerfy-user-section">
                  <?php
                  $language = isset($_SESSION['language']) ? $_SESSION['language'] : null;
                  $setLang = 'btn btn-sm btn-primary-flip language';
                  if ($language == 'en') {
                    $setLangid = 'btn btn-sm btn-primary language';
                    $setLangen = 'btn btn-sm btn-primary-flip language';
                  } else {
                    $setLangid = 'btn btn-sm btn-primary-flip language';
                    $setLangen = 'btn btn-sm btn-primary language';
                  }
                  ?>
                  <li><a href="<?php echo Yii::$app->request->baseUrl; ?>/site/setlang?lang=id"><?= Html::button('ID', ['id' => 'id', 'class' => $setLangid]) ?></a>
                  </li>
                  <li><a href="<?php echo Yii::$app->request->baseUrl; ?>/site/setlang?lang=en"><?= Html::button('EN', ['id' => 'en', 'class' => $setLangen]) ?></a>
                  </li>
                </ul>

                <ul class="careerfy-user-section">
                  <?php (Yii::$app->check->datacompleted($userid) == 1) ?>
                  <?php if (Yii::$app->user->isGuest) : ?>
                    <li>
                      <?= Html::button('Login', ['id' => 'loginButton', 'value' => \yii\helpers\Url::to(['site/login']), 'class' => 'btn btn-sm btn-primary']) ?>
                    </li>
                    <li>
                      <?= Html::button('Register', ['id' => 'signupButton', 'value' => \yii\helpers\Url::to(['site/signup']), 'class' => 'btn btn-sm btn-primary-flip']) ?>
                    </li>
                  <?php else : ?>
                    <li><?= Html::a(
                          '<i class="careerfy-icon careerfy-logout"></i> Logout (' . (Yii::$app->user->isGuest ? 'Guest' : Yii::$app->user->identity->username) . ')',
                          // '<i class="careerfy-icon careerfy-logout"></i> Logout',
                          ['/site/logout'],
                          ['data-method' => 'post', 'class' => 'btn btn-sm btn-primary']
                        ) ?></li>
                  <?php endif; ?>
                </ul>
              </ul>
            </div>
          <?php endif; ?>
        </nav>
        <ul class="careerfy-user-section hidden-lg hidden-md hidden-desktop">
          <?php if (Yii::$app->check->datacompleted($userid) == 1) : ?>
            <li><?= Html::a(
                  '<class="careerfy"> Profile ',
                  ['/userprofile/views', 'userid' => $userid],
                  ['class' => 'btn btn-sm btn-primary']
                )
                ?></li>
            <li><?= Html::a(
                  '<i class="careerfy-icon careerfy-logout"></i> (' . (Yii::$app->user->isGuest ? 'Guest' : Yii::$app->user->identity->username) . ')',
                  ['/site/logout'],
                  ['data-method' => 'post', 'class' => 'btn btn-sm btn-primary']
                )
                ?></li>

          <?php endif; ?>
        </ul>
      </aside>
    </div>
</header>
