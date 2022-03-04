<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Chagerequestdata */

$this->title = 'Create Chage request data';
$this->params['breadcrumbs'][] = ['label' => 'Chage request data', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chagerequestdata-create">

    <?= $this->render('_form', [
    'model' => $model,
    'name' => $name,
    'approvalname' => $approvalname,
    ]) ?>

</div>
