<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Taktif */

$this->title = 'Create Taktif';
$this->params['breadcrumbs'][] = ['label' => 'Taktifs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="taktif-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
