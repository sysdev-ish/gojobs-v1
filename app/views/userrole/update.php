<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Userrole */

$this->title = 'Update Userrole: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Userroles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="userrole-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
