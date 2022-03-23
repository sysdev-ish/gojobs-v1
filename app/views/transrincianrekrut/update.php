<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Transrincianrekrut */

$this->title = 'Update Transrincianrekrut: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Transrincianrekruts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="transrincianrekrut-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
