<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Interview */

$this->title = 'Update Pskikotest: ' . $model->id;
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pskikotest-update">

    <?= $this->render('_formpsiproc', [
        'model' => $model,
        'modelreccan' => $modelreccan,
        'modelrecreq' => $modelrecreq,
        'office' => $office,
        'pic' => $pic,
    ]) ?>

</div>
