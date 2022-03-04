<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Masterregionsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Region';
$this->params['breadcrumbs'][] = $this->title;
Modal::begin([
    'header'=>'<h4 class="modal-title">View Region</h4>',
    'id'=>'viewmasterregion-modal',
    'size'=>'modal-md'
]);

echo "<div id='masterregionview'></div>";


Modal::end();
Modal::begin([
    'header'=>'<h4 class="modal-title">Update Region</h4>',
    'id'=>'updatemasterregion-modal',
    'size'=>'modal-md'
]);

echo "<div id='updatemasterregion'></div>";


Modal::end();
Modal::begin([
    'header'=>'<h4 class="modal-title">Create New Region</h4>',
    'id'=>'createmasterregion-modal',
    'size'=>'modal-md'
]);

echo "<div id='createmasterregion'></div>";


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
<div class="masterregion-index  box box-default">
  <div class="box-header with-border">
    <?php echo Html::button('Create',[
        'value'=>Yii::$app->urlManager->createUrl('masterregion/create'), //<---- here is where you define the action that handles the ajax request
        'class'=>'btn btn-md btn-success createmasterregion-modal-click',
        'data-toggle'=>'tooltip',
        'data-placement'=>'bottom',
        'title'=>'Create New Region'
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
                'regionname',
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
                          'value'=>Yii::$app->urlManager->createUrl('masterregion/view?id='.$model->id), //<---- here is where you define the action that handles the ajax request
                          'class'=>'btn btn-sm btn-info viewmasterregion-modal-click',
                          'data-toggle'=>'tooltip',
                          'data-placement'=>'bottom',
                          'title'=>'Views Detail'
                      ]);
                      return $btn;
                  },
                  'update' => function($url,$model,$key){
                      $btn = Html::button('<i class="fa fa-pencil" style="font-size:12pt;"></i>',[
                          'value'=>Yii::$app->urlManager->createUrl('masterregion/update?id='.$model->id), //<---- here is where you define the action that handles the ajax request
                          'class'=>'btn btn-sm btn-default updatemasterregion-modal-click',
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
