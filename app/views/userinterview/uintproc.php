<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Interview */

$this->title = 'Update User Interview: ' . $model->id;
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="userinterview-update">

    <?= $this->render('_formuintproc', [
        'model' => $model,
        'modelreccan' => $modelreccan,
        'modelrecreq' => $modelrecreq,
        'office' => $office,
        'pic' => $pic,
    ]) ?>

</div>
