<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Userforeignlanguagesearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Userforeignlanguages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userforeignlanguage-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Create Userforeignlanguage', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
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
                'language',
                // 'speaking',
                // 'writing',
                // 'reading',
                // 'understanding',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
