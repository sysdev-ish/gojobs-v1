<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Userinterview */

$this->title = 'Create Userinterview';
$this->params['breadcrumbs'][] = ['label' => 'Userinterviews', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userinterview-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
