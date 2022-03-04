<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Computerskill */

$this->title = 'Create Computerskill';
$this->params['breadcrumbs'][] = ['label' => 'Computerskills', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="computerskill-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
