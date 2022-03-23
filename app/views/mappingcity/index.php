<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MappingCitysearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mapping Cities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mapping-city-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Create Mapping City', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
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
                'city_id',
                'city_name',
                'province_id',
                'manar',
                // 'manar2',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
