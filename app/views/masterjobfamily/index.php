<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MasterJobFamilySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Job Families';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-job-family-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Create Master Job Family', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                // 'id',
                'jobfamily',
                // 'createtime',
                // 'updatetime',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
