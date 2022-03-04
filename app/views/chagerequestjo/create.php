<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Chagerequestjo */

$this->title = 'Create Chagerequestjo';
$this->params['breadcrumbs'][] = ['label' => 'Chagerequestjos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chagerequestjo-create">

    <?= $this->render('_form', [
    'model' => $model,
    'modelrecreq' => $modelrecreq,
    ]) ?>

</div>
