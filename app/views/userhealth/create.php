<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Userhealth */

$this->title = 'Create Userhealth';
$this->params['breadcrumbs'][] = ['label' => 'Userhealths', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userhealth-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
