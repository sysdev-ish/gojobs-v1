<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Masterareaishsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master area ISH';
$this->params['breadcrumbs'][] = $this->title;
Modal::begin([
    'header'=>'<h4 class="modal-title">View Region</h4>',
    'id'=>'viewmasterareaish-modal',
    'size'=>'modal-md'
]);

echo "<div id='masterareaishview'></div>";


Modal::end();
Modal::begin([
    'header'=>'<h4 class="modal-title">Update Region</h4>',
    'id'=>'updatemasterareaish-modal',
    'size'=>'modal-md'
]);

echo "<div id='updatemasterareaish'></div>";


Modal::end();
Modal::begin([
    'header'=>'<h4 class="modal-title">Create New Region</h4>',
    'id'=>'createmasterareaish-modal',
    'size'=>'modal-md'
]);

echo "<div id='createmasterareaish'></div>";


Modal::end();
if(Yii::$app->user->isGuest){
  $role = null;
}else{
  // $userid = Yii::$app->user->identity->id;
  $role = Yii::$app->user->identity->role;
}
if(Yii::$app->utils->permission($role,'m25') && Yii::$app->utils->permission($role,'m26')){
  $action = '{view}{update}';
}elseif(Yii::$app->utils->permission($role,'m25')){
  $action = '{update}';
}else{
  $action = '{view}';
}
?>
<div class="masterareaish-index box box-default">
  <div class="box-header with-border">
    <?php echo Html::button('Create',[
        'value'=>Yii::$app->urlManager->createUrl('masterareaish/create'), //<---- here is where you define the action that handles the ajax request
        'class'=>'btn btn-md btn-success createmasterareaish-modal-click',
        'data-toggle'=>'tooltip',
        'data-placement'=>'bottom',
        'title'=>'Create New Area ISH'
    ]); ?>
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
                'area',
                // 'createtime',
                // 'updatetime',
                // 'createdby',
                // 'updatedby',

                ['class' => 'yii\grid\ActionColumn',
                'contentOptions'=>['style'=>'min-width: 150px;'],
                'template'=>'<div class="btn-group pull-right">'.$action.'</div>',
                'buttons'=>[
                  'view' => function($url,$model,$key){
                      $btn = Html::button('<i class="fa fa-eye" style="font-size:12pt;"></i>',[
                          'value'=>Yii::$app->urlManager->createUrl('masterareaish/view?id='.$model->id), //<---- here is where you define the action that handles the ajax request
                          'class'=>'btn btn-sm btn-info viewmasterareaish-modal-click',
                          'data-toggle'=>'tooltip',
                          'data-placement'=>'bottom',
                          'title'=>'Views Detail'
                      ]);
                      return $btn;
                  },
                  'update' => function($url,$model,$key){
                      $btn = Html::button('<i class="fa fa-pencil" style="font-size:12pt;"></i>',[
                          'value'=>Yii::$app->urlManager->createUrl('masterareaish/update?id='.$model->id), //<---- here is where you define the action that handles the ajax request
                          'class'=>'btn btn-sm btn-default updatemasterareaish-modal-click',
                          'data-toggle'=>'tooltip',
                          'data-placement'=>'bottom',
                          'title'=>'Update'
                      ]);
                      return $btn;
                  },
                  // 'delete' => function ($url, $model) {
                  //   return Html::a('<i class="fa fa-trash" style="font-size:12pt;"></i>', ['delete', 'id' => $model->id], [
                  //       'class' => 'btn btn-sm btn-danger',
                  //       'data' => [
                  //           'confirm' => 'Are you sure you want to delete this item?',
                  //           'method' => 'post',
                  //       ],
                  //       'data-toggle' => 'tooltip',
                  //       'title'=> 'delete'
                  //       ]) ;
                  // }


                ]
              ],
            ],
        ]); ?>
    </div>
</div>
