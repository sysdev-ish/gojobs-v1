<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Mastersubjobfamily */

$this->title = 'Create Master Sub Job Family';
$this->params['breadcrumbs'][] = ['label' => 'Master Sub Job Families', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mastersubjobfamily-create">

    <?= $this->render('_form', [
        'model' => $model,
        'jobfamily' => $jobfamily,
    ]) ?>

</div>
