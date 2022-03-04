<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Hiring */

$this->title = 'Create Hiring';
$this->params['breadcrumbs'][] = ['label' => 'Hirings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hiring-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
