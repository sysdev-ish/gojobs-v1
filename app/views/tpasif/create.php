<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Tpasif */

$this->title = 'Create Tpasif';
$this->params['breadcrumbs'][] = ['label' => 'Tpasifs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tpasif-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
