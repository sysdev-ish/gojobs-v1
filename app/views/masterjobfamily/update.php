<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MasterJobFamily */

$this->title = 'Update Master Job Family: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Master Job Families', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="master-job-family-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
