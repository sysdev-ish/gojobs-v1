<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Mastercity */

$this->title = 'Create Mastercity';
$this->params['breadcrumbs'][] = ['label' => 'Mastercities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mastercity-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
