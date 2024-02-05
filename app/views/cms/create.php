<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Cms */

$this->title = 'Create Content';
$this->params['breadcrumbs'][] = ['label' => 'CMS', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
