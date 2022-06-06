<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ChangjoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Changejos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="changejo-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Create Changejo', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
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
                'recruitreqid',
                'createtime',
                'updatetime',
                'approvedtime',
                // 'approvedtime2',
                // 'createdby',
                // 'updatedby',
                // 'approvedby',
                // 'approvedby2',
                // 'status',
                // 'remarks',
                // 'oldjumlah',
                // 'jumlahstop',
                // 'jumlah',
                // 'documentevidence',
                // 'reason',
                // 'typeapproval',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
