<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Changejo */

$this->title = 'Update Changejo: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Changejos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="changejo-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
