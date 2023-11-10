<?php

use yii\helpers\Html;
use kartik\editors\Summernote;

/* @var $this yii\web\View */
/* @var $model app\models\Transrincian */

$this->title = 'Update Transrincian: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Transrincians', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="transrincian-update">

    <?= $this->render('_formupdate', [
        'model' => $model,
        'modeljo' => $modeljo,
    ]) ?>

</div>
