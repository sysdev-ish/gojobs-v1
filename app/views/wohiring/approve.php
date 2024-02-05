<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Hiring */

$this->title = 'Approve Hiring: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Hirings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="hiring-approve">

    <?= $this->render('_form', [
        'model' => $model,
        'modelrecreq' => $modelrecreq,
    ]) ?>

</div>
