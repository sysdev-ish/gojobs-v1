<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MappingindustryPosition */

$this->title = 'Create Industrie';
$this->params['breadcrumbs'][] = ['label' => 'Mapping Industries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mappingindustry-create">

    <?= $this->render('_form', [
    'model' => $model,
    'industry' => $industry,
    ]) ?>

</div>
