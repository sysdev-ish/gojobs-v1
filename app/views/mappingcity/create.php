<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MappingCity */

$this->title = 'Create Mapping City';
$this->params['breadcrumbs'][] = ['label' => 'Mapping Cities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mapping-city-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
