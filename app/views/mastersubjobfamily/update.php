<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MasterSubJobFamily */

$this->title = 'Update Master Sub Job Family: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Master Sub Job Families', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="master-sub-job-family-update">

    <?= $this->render('_form', [
        'model' => $model,
        'jobfamily' => $jobfamily,
    ]) ?>

</div>
