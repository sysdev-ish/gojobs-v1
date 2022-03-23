<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Userhealth */

$this->title = 'Update Userhealth: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Userhealths', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="userhealth-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
