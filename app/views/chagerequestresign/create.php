<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Chagerequestresign */

$this->title = 'Create Chage request resign';
$this->params['breadcrumbs'][] = ['label' => 'Chage request resigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chagerequestresign-create">

    <?= $this->render('_form', [
    'model' => $model,
    'approvalname' => $approvalname,
    'reason' => $reason,
    ]) ?>

</div>
