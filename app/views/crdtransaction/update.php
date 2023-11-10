<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Crdtransaction */

$this->title = 'Update Crdtransaction: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Crdtransactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="crdtransaction-update">

    <?= $this->render('_form', [
        'model' => $model,
        'param' => $param,
        'bank' => $bank,
        'bankreason' => $bankreason,
    ]) ?>

</div>
