<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Masterpic */

$this->title = 'Update Masterpic: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Masterpics', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="masterpic-update">

    <?= $this->render('_form', [
        'model' => $model,
        'office' => $office,
        'userlogin' => $userlogin,
    ]) ?>

</div>
