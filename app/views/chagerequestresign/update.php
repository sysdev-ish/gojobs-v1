<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Chagerequestresign */

$this->title = 'Update Chagerequestresign: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Chagerequestresigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="chagerequestresign-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
