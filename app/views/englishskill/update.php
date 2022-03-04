<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Englishskill */

$this->title = 'Update Englishskill: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Englishskills', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="englishskill-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
