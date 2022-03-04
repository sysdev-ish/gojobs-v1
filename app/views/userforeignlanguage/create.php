<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Userforeignlanguage */

$this->title = 'Create Userforeignlanguage';
$this->params['breadcrumbs'][] = ['label' => 'Userforeignlanguages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userforeignlanguage-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
