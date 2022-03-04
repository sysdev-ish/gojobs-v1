<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Masterareaish */

$this->title = 'Update Masterareaish: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Masterareaishes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="masterareaish-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
