<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Masterroom */

$this->title = 'Update Masterroom: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Masterrooms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="masterroom-update">

    <?= $this->render('_form', [
        'model' => $model,
        'office' => $office,
    ]) ?>

</div>
