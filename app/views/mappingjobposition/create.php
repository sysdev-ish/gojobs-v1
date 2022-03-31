<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MappingJobPosition */

$this->title = 'Create Job Position';
$this->params['breadcrumbs'][] = ['label' => 'Mapping Job Positions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mappingjobposition-create">

    <?= $this->render('_form', [
    'model' => $model,
    'subjobfamilyid' => $subjobfamilyid,
    'kodejabatan' => $kodejabatan,
    // 'jabatansap' => $jabatansap,
    ]) ?>

</div>
