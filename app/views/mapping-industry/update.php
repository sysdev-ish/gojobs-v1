<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MappingindustryPosition */

$this->title = 'Update Mapping Industrie: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mapping Industries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mappingindustry-update">

    <?= $this->render('_update', [
        'model' => $model,
        'industry' => $industry,
    ]) ?>

</div>
