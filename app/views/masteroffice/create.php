<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Masteroffice */

$this->title = 'Create Masteroffice';
$this->params['breadcrumbs'][] = ['label' => 'Masteroffices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="masteroffice-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
