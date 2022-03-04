<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Userforeignlanguage */

$this->title = 'Update Userforeignlanguage: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Userforeignlanguages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="userforeignlanguage-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
