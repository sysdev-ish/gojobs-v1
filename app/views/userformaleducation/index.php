<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Userformaleducationsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Userformaleducations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userformaleducation-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Create Userformaleducation', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'userid',
                'createtime',
                'updatetime',
                'educationallevel',
                // 'institutions',
                // 'city',
                // 'majoring',
                // 'startdate',
                // 'enddate',
                // 'status',
                // 'gpa',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
