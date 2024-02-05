<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cms */

$this->title = 'Update Content: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'CMS', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cms-update">

    <?= $this->render('_update', [
        'model' => $model,
    ]) ?>

</div>
