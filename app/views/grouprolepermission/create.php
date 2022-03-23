<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Grouprolepermission */

$this->title = 'Create';
$this->params['breadcrumbs'][] = ['label' => 'Group user roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grouprolepermission-create">

    <?= $this->render('_form', [
    'model' => $model,
    'mappinggrps' => $mappinggrps,
    'userrole' => $userrole,
    ]) ?>

</div>
