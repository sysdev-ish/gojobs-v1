<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Changejo */

$this->title = 'Create Changejo';
$this->params['breadcrumbs'][] = ['label' => 'Changejos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="changejo-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
