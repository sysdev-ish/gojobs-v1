<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Chagerequestdata */

$this->title = 'Update Chagerequestdata: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Chagerequestdatas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="chagerequestdata-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
