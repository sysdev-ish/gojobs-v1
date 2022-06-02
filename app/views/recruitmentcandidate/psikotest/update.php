<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Psikotest */

$this->title = 'Update Psikotest: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Psikotests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="psikotest-update">

    <?= $this->render('_form', [
      'model' => $model,
      'modelreccan' => $modelreccan,
      'modelrecreq' => $modelrecreq,
      'office' => $office,
      'pic' => $pic,
    ]) ?>

</div>
