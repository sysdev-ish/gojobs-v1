<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Thardskill */

$this->title = 'Create Thardskill';
$this->params['breadcrumbs'][] = ['label' => 'Thardskills', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thardskill-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
