<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Masterindustry */

$this->title = 'Create Masterindustry';
$this->params['breadcrumbs'][] = ['label' => 'Masterindustries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="masterindustry-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
