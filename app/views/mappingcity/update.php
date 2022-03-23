<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MappingCity */

$this->title = 'Update Mapping City: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mapping Cities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mapping-city-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
