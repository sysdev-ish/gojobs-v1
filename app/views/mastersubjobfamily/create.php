<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MasterSubJobFamily */

$this->title = 'Create Master Sub Job Family';
$this->params['breadcrumbs'][] = ['label' => 'Master Sub Job Families', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-sub-job-family-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
