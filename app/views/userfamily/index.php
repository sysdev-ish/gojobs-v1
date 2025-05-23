<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Userfamilysearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Userfamilies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userfamily-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Create Userfamily', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
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
                'fullname',
                // 'gender',
                // 'birthdate',
                // 'birthplace',
                // 'lasteducation',
                // 'jobtitle',
                // 'companyname',
                // 'description:ntext',
                // 'relationship',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
