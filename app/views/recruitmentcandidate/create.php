<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Recruitmentcandidate */

$this->title = 'Create Recruitmentcandidate';
$this->params['breadcrumbs'][] = ['label' => 'Recruitmentcandidates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recruitmentcandidate-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
