<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Userworkexperienceposition */

$this->title = 'Update Userworkexperienceposition: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Userworkexperiencepositions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="userworkexperienceposition-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
