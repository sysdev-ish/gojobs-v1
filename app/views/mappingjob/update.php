<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MappingJobPosition */

$this->title = 'Update Mapping Job Position: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mapping Job Positions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mappingjob-update">

    <?= $this->render('_update', [
        'model' => $model,
        'subjobfamilyid' => $subjobfamilyid,
    ]) ?>

</div>
