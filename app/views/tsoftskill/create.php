<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Tsoftskill */

$this->title = 'Create Tsoftskill';
$this->params['breadcrumbs'][] = ['label' => 'Tsoftskills', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tsoftskill-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
