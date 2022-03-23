<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Mappingregionarea */

$this->title = 'Update Mappingregionarea: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mappingregionareas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mappingregionarea-update">

    <?= $this->render('_form', [
        'model' => $model,
        'areaish' => $areaish,
        'region' => $region,
        'area' => $area,
    ]) ?>

</div>
