<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

app\assets\AppfrontAsset::register($this);

// dmstr\web\AdminLteAsset::register($this);

$assetUrl = Yii::$app->request->baseUrl . '/assets';
$uploadUrl = Yii::$app->request->baseUrl . '/app/assets/upload';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="../images/icon.png" />

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&amp;subset=cyrillic-ext,vietnamese" rel="stylesheet">
    <?php $this->head() ?>

</head>

<body>

    <?php $this->beginBody() ?>

    <div class="careerfy-wrapper">

        <?php
        echo  $this->render(
            'header-applicant.php'
        );

        echo $this->render(
            'content-applicant.php',
            [
                'content' => $content,
                'assetUrl' => $assetUrl,
                'uploadUrl' => $uploadUrl,
            ]
        );
        ?>

    </div>
    <script src="<?php echo Yii::$app->request->baseUrl;  ?>/js/frontend/script/jquery.js"></script>
    <!-- <script src="<?php //echo Yii::$app->request->baseUrl;  
                        ?>/js/frontend/script/bootstrap.js"></script> -->

    <script src="<?php echo Yii::$app->request->baseUrl;  ?>/js/frontend/script/slick-slider.js"></script>
    <script src="<?php echo Yii::$app->request->baseUrl;  ?>/js/frontend/plugin-script/counter.js"></script>
    <script src="<?php echo Yii::$app->request->baseUrl;  ?>/js/frontend/plugin-script/fancybox.pack.js"></script>
    <script src="<?php echo Yii::$app->request->baseUrl;  ?>/js/frontend/plugin-script/isotope.min.js"></script>
    <script src="<?php echo Yii::$app->request->baseUrl;  ?>/js/frontend/plugin-script/progressbar.js"></script>
    <script src="<?php echo Yii::$app->request->baseUrl;  ?>/js/frontend/build/mediaelement-and-player.js"></script>
    <script src="<?php echo Yii::$app->request->baseUrl;  ?>/js/frontend/plugin-script/functions.js"></script>
    <script src="<?php echo Yii::$app->request->baseUrl;  ?>/js/frontend/script/functions.js"></script>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>