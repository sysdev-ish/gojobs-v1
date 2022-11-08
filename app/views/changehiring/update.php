<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Changehiring */

$this->title = 'Update Change Hiring: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Changehiring', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="changehiring-update">
    <?= $this->render('_form', [
        'model' => $model,
        'data' => $data,
        // 'datanew' => $datanew,
        'reason' => $reason
    ]) ?>
</div>
