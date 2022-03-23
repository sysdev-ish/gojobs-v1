<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Userlogin */

$this->title = 'Update Userlogin: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'User login', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="userlogin-update">

    <?= $this->render('_form', [
        'model' => $model,
        'userrole' => $userrole,
        'grouprolepermission' => $grouprolepermission,
    ]) ?>

</div>
