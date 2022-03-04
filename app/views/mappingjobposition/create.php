<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MappingJobPosition */

$this->title = 'Create Mapping Job Position';
$this->params['breadcrumbs'][] = ['label' => 'Mapping Job Positions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mapping-job-position-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
