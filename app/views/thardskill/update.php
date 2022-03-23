<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Thardskill */

$this->title = 'Update Thardskill: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Thardskills', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="thardskill-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
