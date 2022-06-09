<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Userrolesearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User roles';
$this->params['breadcrumbs'][] = $this->title;

if(Yii::$app->user->isGuest){
  $role = null;
}else{
  // $userid = Yii::$app->user->identity->id;
  $role = Yii::$app->user->identity->role;
}
if(Yii::$app->utils->permission($role,'m21') && Yii::$app->utils->permission($role,'m22')){
  $action = '{view}{update}{delete}';
}elseif(Yii::$app->utils->permission($role,'m21')){
  $action = '{view}{update}';
}elseif(Yii::$app->utils->permission($role,'m22')){
  $action = '{view}{delete}';
}else{
  $action = '{view}';
}
?>
<div class="userrole-index box box-default">
  <?php if(Yii::$app->utils->permission($role,'m20')): ?>
    <div class="box-header with-border">
        <?= Html::a('Create', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </div>
  <?php endif; ?>
    <div class="box-body table-responsive ">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'role',
                'createtime',
                'updatetime',

                ['class' => 'yii\grid\ActionColumn',
                'contentOptions'=>['style'=>'min-width: 100px;'],
                'template'=>'<div class="btn-group pull-right">'.$action.'</div>',
                'buttons'=>[
                  'view' => function($url,$model,$key){
                      $btn = Html::button('<i class="fa fa-eye" style="font-size:12pt;"></i>',[
                          'value'=>Yii::$app->urlManager->createUrl('userrole/view?id='.$model->id), //<---- here is where you define the action that handles the ajax request
                          'class'=>'btn btn-sm btn-info viewuserrole-modal-click',
                          'data-toggle'=>'tooltip',
                          'data-placement'=>'bottom',
                          'title'=>'Views Detail'
                      ]);
                      return $btn;
                  },
                  'update' => function ($url, $model) {
                    return Html::a('<i class="fa fa-pencil" style="font-size:12pt;"></i>', ['update', 'id'=>$model->id], ['class' => 'btn btn-sm btn-default','data-toggle' => 'tooltip', 'title'=> 'Update' ]);
                  },
                  // 'delete' => function ($url, $model) {
                  //   return Html::a('<i class="fa fa-trash" style="font-size:12pt;"></i>', ['#', 'id'=>$model->id], ['class' => 'btn btn-sm btn-danger','data-toggle' => 'tooltip', 'title'=> 'delete' ]);
                  // }
                  'delete' => function ($url, $model) {
                    return Html::a('<i class="fa fa-trash" style="font-size:12pt;"></i>', ['delete', 'id' => $model->id], [
                      'class' => 'btn btn-sm btn-danger',
                      'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                      ],
                      'data-toggle' => 'tooltip',
                      'title' => 'delete'
                    ]);
                  }


                ]
              ],
            ],
        ]); ?>
    </div>
</div>
