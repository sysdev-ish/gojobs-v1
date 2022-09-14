<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Changehiring */

$this->title = 'Create Change Hiring';
$this->params['breadcrumbs'][] = ['label' => 'Change Hirings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="changehiring-create">

    <?= $this->render('_form', [
    'model' => $model,
    'approvalname' => $approvalname,
    'reason' => $reason,
    ]) ?>

</div>
