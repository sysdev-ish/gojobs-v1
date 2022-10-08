<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */



if (Yii::$app->controller->action->id === 'login' or Yii::$app->controller->action->id == 'error') {
  /**
   * Do not use this code in your template. Remove it.
   * Instead, use the code  $this->layout = '//main-login'; in your controller.
   */
  app\assets\AppAsset::register($this);
  echo $this->render(
    'main-login',
    ['content' => $content]
  );
} else {

  app\assets\AppAsset::register($this);

  // dmstr\web\AdminLteAsset::register($this);

  $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
  $baseUrl = Yii::$app->request->baseUrl;
  $assetUrl = Yii::$app->request->baseUrl . '/assets';
  $uploadUrl = Yii::$app->request->baseUrl . '/app/assets/upload';
?>
  <?php $this->beginPage() ?>
  <!DOCTYPE html>
  <html lang="<?= Yii::$app->language ?>">

  <head>
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="icon" type="image/x-icon" href="<?php echo $baseUrl; ?>/images/icon.ico" />
    <?php $this->head() ?>
  </head>

  <body class="skin-blue sidebar-mini">


    <?php $this->beginBody() ?>
    <div class="wrapper" style="height: auto; min-height: 100%;">

      <?= $this->render(
        'header.php',
        [
          'directoryAsset' => $directoryAsset,
          'baseUrl' => $baseUrl,
          'assetUrl' => $assetUrl,
          'uploadUrl' => $uploadUrl,
        ]
      ) ?>


      <?= $this->render(
        'left.php',
        [
          'directoryAsset' => $directoryAsset,
          'baseUrl' => $baseUrl,
          'assetUrl' => $assetUrl,
          'uploadUrl' => $uploadUrl,
        ]
      )
      ?>


      <?= $this->render(
        'content.php',
        [
          'content' => $content,
          'directoryAsset' => $directoryAsset,
          'baseUrl' => $baseUrl,
          'assetUrl' => $assetUrl,
          'uploadUrl' => $uploadUrl,
        ]
      ) ?>

    </div>

    <?php $this->endBody() ?>
  </body>

  </html>
  <?php $this->endPage() ?>
<?php } ?>