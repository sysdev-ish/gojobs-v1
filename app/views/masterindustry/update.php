<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Masterindustry */

$this->title = 'Update Masterindustry: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Masterindustries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="masterindustry-update">

    <?= $this->render('_formupdate', [
        'model' => $model,
    ]) ?>

</div>
