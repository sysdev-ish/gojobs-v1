<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Userlogin */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Userlogins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userlogin-view box box-solid">
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'created_at',
                'updated_at',
                'username',
                'name',
                'email:email',
                'mobile',
                // 'password_hash',
                // 'status',
                // 'verify_code',
                // 'auth_key',
                'rolename.role',
                'grouprolename.grouprolepermission',
                // 'verify_status',
            ],
        ]) ?>
    </div>
</div>
