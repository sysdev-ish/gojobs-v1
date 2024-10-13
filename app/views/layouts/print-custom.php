<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */



      app\assets\PrintAsset::register($this);


    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    $assetUrl = Yii::$app->request->baseUrl . '/assets';
    $uploadUrl = Yii::$app->request->baseUrl . '/app/assets/upload';
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <!-- <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes" name="viewport"> -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body onload="window.print();">
    <!-- <body> -->
    <?php $this->beginBody() ?>
    <div class="wrapper">



        <?= $this->render(
            'contentprint.php',
            ['content' => $content,
            'directoryAsset' => $directoryAsset,
            'assetUrl' => $assetUrl,
            'uploadUrl' => $uploadUrl,
          ]
        ) ?>

    </div>

    <?php $this->endBody() ?>
    </body>

    </html>
    <?php $this->endPage() ?>
