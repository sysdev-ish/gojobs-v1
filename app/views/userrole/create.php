<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Userrole */

$this->title = 'Create Userrole';
$this->params['breadcrumbs'][] = ['label' => 'Userroles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userrole-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
