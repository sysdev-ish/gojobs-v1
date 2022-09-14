<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Changecanceljoin */

$this->title = 'Create Cancel Join';
$this->params['breadcrumbs'][] = ['label' => 'Cancel Joins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="changecanceljoin-create">

    <?= $this->render('_form', [
    'model' => $model,
    // 'approvalname' => $approvalname,
    'reason' => $reason,
    ]) ?>

</div>
