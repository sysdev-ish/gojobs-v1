<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Masterareaish */

$this->title = 'Create Masterareaish';
$this->params['breadcrumbs'][] = ['label' => 'Masterareaishes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="masterareaish-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
