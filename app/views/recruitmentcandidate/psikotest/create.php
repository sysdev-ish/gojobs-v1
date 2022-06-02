<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Psikotest */

$this->title = 'Create Psikotest';
$this->params['breadcrumbs'][] = ['label' => 'Psikotests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="psikotest-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
