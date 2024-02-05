<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Recruitmentcandidate */

$this->title = 'Update Recruitmentcandidate: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Recruitmentcandidates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="recruitmentcandidate-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
