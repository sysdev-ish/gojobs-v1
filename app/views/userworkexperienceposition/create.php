<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Userworkexperienceposition */

$this->title = 'Create Userworkexperienceposition';
$this->params['breadcrumbs'][] = ['label' => 'Userworkexperiencepositions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userworkexperienceposition-create">

    <?= $this->render('_form', [
    'model' => $model,
    'userid' => $userid,
    ]) ?>

</div>
