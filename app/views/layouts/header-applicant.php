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
      <aside class="col-md-2"> <a href="#" class="careerfy-logo"><img style="max-width: 100%;"
            src="<?php echo $baseUrl; ?>/images/logo-gojobs-colour.png" alt=""></a> </aside>
      <!--<aside class="col-md-6">-->
      <aside class="col-md-9 col-md-push-3">
        <nav class="careerfy-navigation">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
              data-target="#careerfy-navbar-collapse-1" aria-expanded="false">
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
              <li>
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
                  <li><a
                      href="<?php echo Yii::$app->request->baseUrl; ?>/site/setlang?lang=id"><?= Html::button('ID', ['id' => 'id', 'class' => $setLangid]) ?></a>
                  </li>
                  <li><a
                      href="<?php echo Yii::$app->request->baseUrl; ?>/site/setlang?lang=en"><?= Html::button('EN', ['id' => 'en', 'class' => $setLangen]) ?></a>
                  </li>
                </ul>
              </li>
              <!--<li role="presentation" class="dropdown"> 
              <?php
              // $language = isset($_SESSION['language']) ? $_SESSION['language'] : null;
              // $setLang = 'Language EN';
              // if($language == 'id') $setLang = 'Bahasa ID';
              ?>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> 
                <?php //echo Html::encode($setLang); 
                ?> <span class="caret"></span> 
              </a> 
              <ul class="dropdown-menu"> 
                <li><a href="<?php //echo Yii::$app->request->baseUrl; 
                              ?>/site/setlang?lang=en">English</a></li> 
                <li><a href="<?php //echo Yii::$app->request->baseUrl; 
                              ?>/site/setlang?lang=id">Indonesia</a></li>
              </ul> 
            </li>-->
            </ul>
            <div class="careerfy-left">
              <ul class="careerfy-user-section visible-lg--block">
                <?php (Yii::$app->check->datacompleted($userid) == 1)?>
                <?php if (Yii::$app->user->isGuest) : ?>
                <li>
                  <?= Html::button('Login', ['id' => 'loginButton', 'value' => \yii\helpers\Url::to(['site/login']), 'class' => 'btn btn-sm btn-primary']) ?>
                </li>
                <li>
                  <?= Html::button('Register', ['id' => 'signupButton', 'value' => \yii\helpers\Url::to(['site/signup']), 'class' => 'btn btn-sm btn-primary-flip']) ?>
                </li>

                <?php else : ?>
                <li><?= Html::a(
                          // '<i class="careerfy-icon careerfy-logout"></i> Logout (' . (Yii::$app->user->isGuest ? 'Guest' : Yii::$app->user->identity->username) . ')',
                          '<i class="careerfy-icon careerfy-logout"></i> Logout',
                          ['/site/logout'],
                          ['data-method' => 'post', 'class' => 'btn btn-sm btn-primary']
                        ) ?></li>
                <?php endif; ?>
              </ul>
            </div>
          </div>
          <?php endif; ?>
        </nav>


        <!--<div class="hidden-lg hidden-md">-->
        <!--<nav class="careerfy-navigation navbar-default hidden-lg hidden-md">
            <div class="container-fluid">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
              </div>

              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                  <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
                  <li><a href="#">Link</a></li>
                </ul>
              </div>
            </div>
          </nav>-->
        <!--</div>-->


      </aside>
      <!--<aside class="col-md-4">-->
      <aside class="col-md-3 col-md-pull-9 visible-xs-block">
        <div class="careerfy-right">
          <ul class="careerfy-user-section">
            <?php (Yii::$app->check->datacompleted($userid) == 1)?>
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
                    ['/site/logout'],
                    ['data-method' => 'post', 'class' => 'btn btn-sm btn-primary']
                  ) ?></li>
            <?php endif; ?>
          </ul>
          <!-- <a href="#" class="careerfy-simple-btn careerfy-bgcolor"><span> <i class="careerfy-icon careerfy-arrows-2"></i> Post Job</span></a> -->
        </div>
      </aside>
    </div>
  </div>
</header>



<!-- ModalLogin Box -->
<div class="careerfy-modal fade careerfy-typo-wrap" id="JobSearchModalSignup">
  <div class="modal-inner-area">&nbsp;</div>
  <div class="modal-content-area">
    <div class="modal-box-area">

      <div class="careerfy-modal-title-box">
        <h2>Login to your account</h2>
        <span class="modal-close"><i class="fa fa-times"></i></span>
      </div>
      <form>
        <div class="careerfy-box-title">
          <span>Choose your Account Type</span>
        </div>
        <div class="careerfy-user-options">
          <ul>
            <li class="active">
              <a href="#">
                <i class="careerfy-icon careerfy-user"></i>
                <span>Candidate</span>
                <small>I want to discover awesome companies.</small>
              </a>
            </li>
            <li>
              <a href="#">
                <i class="careerfy-icon careerfy-building"></i>
                <span>Employer</span>
                <small>I want to attract the best talent.</small>
              </a>
            </li>
          </ul>
        </div>
        <div class="careerfy-user-form">
          <ul>
            <li>
              <label>Email Address:</label>
              <input value="Enter Your Email Address"
                onblur="if(this.value == '') { this.value ='Enter Your Email Address'; }"
                onfocus="if(this.value =='Enter Your Email Address') { this.value = ''; }" type="text">
              <i class="careerfy-icon careerfy-mail"></i>
            </li>
            <li>
              <label>Password:</label>
              <input value="Enter Password" onblur="if(this.value == '') { this.value ='Enter Password'; }"
                onfocus="if(this.value =='Enter Password') { this.value = ''; }" type="text">
              <i class="careerfy-icon careerfy-multimedia"></i>
            </li>
            <li>
              <input type="submit" value="Sign In">
            </li>
          </ul>
          <div class="clearfix"></div>
          <div class="careerfy-user-form-info">
            <p>Forgot Password? | <a href="#">Sign Up</a></p>
            <div class="careerfy-checkbox">
              <input type="checkbox" id="r10" name="rr" />
              <label for="r10"><span></span> Remember Password</label>
            </div>
          </div>
        </div>
        <div class="careerfy-box-title careerfy-box-title-sub">
          <span>Or Sign In With</span>
        </div>
        <div class="clearfix"></div>
        <ul class="careerfy-login-media">
          <li><a href="#"><i class="fa fa-facebook"></i> Sign In with Facebook</a></li>
          <li><a href="#" data-original-title="google"><i class="fa fa-google"></i> Sign In with Google</a></li>
          <li><a href="#" data-original-title="twitter"><i class="fa fa-twitter"></i> Sign In with Twitter</a></li>
          <li><a href="#" data-original-title="linkedin"><i class="fa fa-linkedin"></i> Sign In with LinkedIn</a></li>
        </ul>
      </form>

    </div>
  </div>
</div>
<!-- Modal Signup Box -->