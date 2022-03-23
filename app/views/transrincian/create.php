<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Transrincian */

$this->title = 'Create Transrincian';
$this->params['breadcrumbs'][] = ['label' => 'Transrincians', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transrincian-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
