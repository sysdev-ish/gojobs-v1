<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Userworkexperiencepositionsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Userworkexperiencepositions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userworkexperienceposition-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Create Userworkexperienceposition', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
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
                'idworkexperience',
                'createtime',
                'updatetime',
                'position',
                // 'salary',
                // 'jobdesc',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
