<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Interview */

$this->title = 'Create Interview';
$this->params['breadcrumbs'][] = ['label' => 'Interviews', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="interview-create">

    <?= $this->render('_forminvite', [
    'model' => $model,
    'modelreccan' => $modelreccan,
    'modelrecreq' => $modelrecreq,
    'office' => $office,
    'invitefor' => $invitefor,
    ]) ?>

</div>
