<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Grouprolepermissionsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Group user roles';
$this->params['breadcrumbs'][] = $this->title;

Modal::begin([
    'header'=>'<h4 class="modal-title">View Group Role Permission</h4>',
    'id'=>'viewgrouprolepermission-modal',
    'size'=>'modal-md'
]);

echo "<div id='grouprolepermissionview'></div>";


Modal::end();
if(Yii::$app->user->isGuest){
  $role = null;
}else{
  // $userid = Yii::$app->user->identity->id;
  $role = Yii::$app->user->identity->role;
}
if(Yii::$app->utils->permission($role,'m21') && Yii::$app->utils->permission($role,'m22')){
  $action = '{view}{update}';
  // $action = '{view}{update}{delete}';
}elseif(Yii::$app->utils->permission($role,'m21')){
  $action = '{view}{update}';
}elseif(Yii::$app->utils->permission($role,'m22')){
  $action = '{view}{delete}';
}else{
  $action = '{view}';
}
?>
<div class="grouprolepermission-index box box-default">
    <div class="box-header with-border">
        <?= Html::a('Create', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <div class="box-body table-responsive">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                // 'id',
                'grouprolepermission',
                'createtime',
                'updatetime',


                ['class' => 'yii\grid\ActionColumn',
                'contentOptions'=>['style'=>'min-width: 100px;'],
                'template'=>'<div class="btn-group pull-right">'.$action.'</div>',
                'buttons'=>[
                  'view' => function($url,$model,$key){
                      $btn = Html::button('<i class="fa fa-eye" style="font-size:12pt;"></i>',[
                          'value'=>Yii::$app->urlManager->createUrl('grouprolepermission/view?id='.$model->id), //<---- here is where you define the action that handles the ajax request
                          'class'=>'btn btn-sm btn-info viewgrouprolepermission-modal-click',
                          'data-toggle'=>'tooltip',
                          'data-placement'=>'bottom',
                          'title'=>'Views Detail'
                      ]);
                      return $btn;
                  },
                  'update' => function ($url, $model) {
                    return Html::a('<i class="fa fa-pencil" style="font-size:12pt;"></i>', ['update', 'id'=>$model->id], ['class' => 'btn btn-sm btn-default','data-toggle' => 'tooltip', 'title'=> 'Update' ]);
                  },
                  'delete' => function ($url, $model) {
                    return Html::a('<i class="fa fa-trash" style="font-size:12pt;"></i>', ['#', 'id'=>$model->id], ['class' => 'btn btn-sm btn-danger','data-toggle' => 'tooltip', 'title'=> 'delete' ]);
                  }


                ]
              ],
            ],
        ]); ?>
    </div>
</div>
