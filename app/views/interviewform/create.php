<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Interviewform */

$this->title = 'Create Interviewform';
$this->params['breadcrumbs'][] = ['label' => 'Interviewforms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="interviewform-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
