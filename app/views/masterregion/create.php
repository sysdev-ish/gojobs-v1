<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Masterregion */

$this->title = 'Create Masterregion';
$this->params['breadcrumbs'][] = ['label' => 'Masterregions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="masterregion-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
