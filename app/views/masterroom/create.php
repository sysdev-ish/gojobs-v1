<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Masterroom */

$this->title = 'Create Masterroom';
$this->params['breadcrumbs'][] = ['label' => 'Masterrooms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="masterroom-create">

    <?= $this->render('_form', [
    'model' => $model,
    'office' => $office,
    ]) ?>

</div>
