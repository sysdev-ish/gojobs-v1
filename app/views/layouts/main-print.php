<?php

use backend\assets\AppAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

app\assets\AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
  <meta charset="<?= Yii::$app->charset ?>" />
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?= Html::csrfMetaTags() ?>
  <link rel="icon" type="image/x-icon" href="../images/icon.png" />
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
</head>

<body onload="window.print();">

  <?php $this->beginBody() ?>
  <div class="wrapper">
    <?= $content ?>
  </div>
  <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>