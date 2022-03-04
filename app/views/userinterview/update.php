<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Userinterview */

$this->title = 'Update Userinter view: ' . $model->id;
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="userinterview-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modelreccan' => $modelreccan,
        'modelrecreq' => $modelrecreq,
        'office' => $office,
        'pic' => $pic,
    ]) ?>

</div>
