<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Userloginsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Applicant Login';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="userlogin-index box box-default">

    <div class="box-body table-responsive">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                // 'id',
                // 'created_at',
                // 'updated_at',
                'username',
                'name',
                'email:email',
                // 'mobile',
                // 'password_hash',

                // 'status',
                'verify_code',
                // 'auth_key',

                // 'verify_status',



            ],
        ]); ?>
    </div>
</div>
