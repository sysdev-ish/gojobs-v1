<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Grouprolepermission */

$this->title = 'Update: ' . $model->grouprolepermission;
$this->params['breadcrumbs'][] = ['label' => 'Group role permissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="grouprolepermission-update">

    <?= $this->render('_form', [
        'model' => $model,
        'mappinggrps' => $mappinggrps,
        'userrole' => $userrole,
    ]) ?>

</div>
