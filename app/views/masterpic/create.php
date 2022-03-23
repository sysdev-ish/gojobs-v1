<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Masterpic */

$this->title = 'Create Master pic';
$this->params['breadcrumbs'][] = ['label' => 'Masterpics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="masterpic-create">

    <?= $this->render('_form', [
    'model' => $model,
    'office' => $office,
    'userlogin' => $userlogin,
    ]) ?>

</div>
