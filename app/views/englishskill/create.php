<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Englishskill */

$this->title = 'Create Englishskill';
$this->params['breadcrumbs'][] = ['label' => 'Englishskills', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="englishskill-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
