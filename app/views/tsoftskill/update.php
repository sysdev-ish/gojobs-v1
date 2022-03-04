<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tsoftskill */

$this->title = 'Update Tsoftskill: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tsoftskills', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tsoftskill-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
