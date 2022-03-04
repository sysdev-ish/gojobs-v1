<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Crdtransaction */

$this->title = 'Create Crdtransaction';
$this->params['breadcrumbs'][] = ['label' => 'Crdtransactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="crdtransaction-create">

    <?= $this->render('_form', [
    'model' => $model,
    'param' => $param,
    'bank' => $bank,
    'bankreason' => $bankreason,
    ]) ?>

</div>
