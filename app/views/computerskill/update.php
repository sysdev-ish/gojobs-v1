<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Computerskill */

$this->title = 'Update Computerskill: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Computerskills', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="computerskill-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
