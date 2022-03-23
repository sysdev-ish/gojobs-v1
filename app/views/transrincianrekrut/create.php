<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Transrincianrekrut */

$this->title = 'Create Transrincianrekrut';
$this->params['breadcrumbs'][] = ['label' => 'Transrincianrekruts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transrincianrekrut-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
