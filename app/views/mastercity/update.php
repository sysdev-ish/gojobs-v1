<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Mastercity */

$this->title = 'Update Mastercity: ' . $model->kotaid;
$this->params['breadcrumbs'][] = ['label' => 'Mastercities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->kotaid, 'url' => ['view', 'id' => $model->kotaid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mastercity-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
