<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MasterJobFamily */

$this->title = 'Create Master Job Family';
$this->params['breadcrumbs'][] = ['label' => 'Master Job Families', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-job-family-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
