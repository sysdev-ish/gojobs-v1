<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Interviewformsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Interviewforms';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="interviewform-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Create Interviewform', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
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
                'interviewid',
                // 'aspekpenilaianid',
                // 'nilai',
                // 'desc',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
