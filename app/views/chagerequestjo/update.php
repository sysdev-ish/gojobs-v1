<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Chagerequestjo */

$this->title = 'Update Chagerequestjo: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Chagerequestjos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="chagerequestjo-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
