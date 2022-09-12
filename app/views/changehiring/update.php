<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Changecanceljoin */

$this->title = 'Update Changecanceljoin: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Changecanceljoin', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="changecanceljoin-update">

    <?= $this->render('_form', [
        'model' => $model,
        'approvalname' => $approvalname,
        'reason' => $reason
    ]) ?>

</div>
