<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Hiring */

$this->title = 'Update Hiring: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Hirings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="hiring-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
