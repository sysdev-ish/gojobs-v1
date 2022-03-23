<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Interview */

$this->title = 'Update Interview: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Interviews', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="interview-update">

    <?= $this->render('_formintproc', [
        'model' => $model,
        'modelreccan' => $modelreccan,
        'modelrecreq' => $modelrecreq,
        'office' => $office,
        'pic' => $pic,
        'interviewforms' => $interviewforms,
        'masterpenilaian' => $masterpenilaian,
        'formtype' => $formtype,
        
    ]) ?>

</div>
