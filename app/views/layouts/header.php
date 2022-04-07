<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $this \yii\web\View */
/* @var $content string */

$assetUrl = Yii::$app->request->baseUrl . '/assets';

?>
<header class="main-header">
    <!-- <?= Html::a('<span class="logo-mini"></span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?> -->
    <span class="logo-mini logo-lg logo">
        <img src="../images/logo-gojobs-colour.png" class="img-responsive logo" />
    </span>
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">



                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo $assetUrl; ?>/img/user-avatar.png" class="user-image" alt="User Image" />
                        <span class="hidden-xs"><?php echo Yii::$app->user->isGuest ? 'Guest' : Yii::$app->user->identity->username; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?php echo $assetUrl; ?>/img/user-avatar.png" class="img-circle" alt="User Image" />

                            <p>
                                <?php echo Yii::$app->user->isGuest ? 'Guest' : Yii::$app->user->identity->name; ?>
                                <!-- <small>Member since Nov. 2012</small> -->
                            </p>
                        </li>

                        <!-- Menu Footer-->
                        <li class="user-footer">

                            <div class="pull-right">
                                <?= Html::a(
                                    'Sign out',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->

            </ul>
        </div>


    </nav>
</header>