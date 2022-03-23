<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tpasif */

$this->title = 'Update Tpasif: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tpasifs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tpasif-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
