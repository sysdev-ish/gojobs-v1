<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Request Hold Job */

$this->title = 'Create Request Hold Job';
$this->params['breadcrumbs'][] = ['label' => 'Request Hold Jobs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-hold-job-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modelrecreq' => $modelrecreq,
    ]) ?>

</div>