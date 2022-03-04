<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Mastercitysearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mastercities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mastercity-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Create Mastercity', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'kotaid',
                'provinsiid',
                'kota',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
