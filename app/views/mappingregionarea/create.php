<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Mappingregionarea */

$this->title = 'Create Mappingregionarea';
$this->params['breadcrumbs'][] = ['label' => 'Mappingregionareas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mappingregionarea-create">

    <?= $this->render('_form', [
    'model' => $model,
    'areaish' => $areaish,
    'region' => $region,
    'area' => $area,
    ]) ?>

</div>
