<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Masterroomsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master rooms';
$this->params['breadcrumbs'][] = $this->title;
Modal::begin([
    'header'=>'<h4 class="modal-title">View Room</h4>',
    'id'=>'viewmasterroom-modal',
    'size'=>'modal-md'
]);

echo "<div id='masterroomview'></div>";


Modal::end();
Modal::begin([
    'header'=>'<h4 class="modal-title">Update Room</h4>',
    'id'=>'updatemasterroom-modal',
    'size'=>'modal-md'
]);

echo "<div id='updatemasterroom'></div>";


Modal::end();
Modal::begin([
    'header'=>'<h4 class="modal-title">Create New Room</h4>',
    'id'=>'createmasterroom-modal',
    'size'=>'modal-md'
]);

echo "<div id='createmasterroom'></div>";


Modal::end();


if(Yii::$app->user->isGuest){
  $role = null;
}else{
  // $userid = Yii::$app->user->identity->id;
  $role = Yii::$app->user->identity->role;
}
if(Yii::$app->utils->permission($role,'m29') && Yii::$app->utils->permission($role,'m30')){
  $action = '{view}{update}{delete}';
}elseif(Yii::$app->utils->permission($role,'m29')){
  $action = '{view}{update}';
}elseif(Yii::$app->utils->permission($role,'m30')){
  $action = '{view}{delete}';
}else{
  $action = '{view}';
}
?>
<div class="masterroom-index box box-default">
  <?php if(Yii::$app->utils->permission($role,'m28')): ?>
  <div class="box-header with-border">
    <?php echo Html::button('Create',[
        'value'=>Yii::$app->urlManager->createUrl('masterroom/create'), //<---- here is where you define the action that handles the ajax request
        'class'=>'btn btn-md btn-success createmasterroom-modal-click',
        'data-toggle'=>'tooltip',
        'data-placement'=>'bottom',
        'title'=>'Create New Office'
    ]); ?>
  </div>

  <?php endif; ?>
    <div class="box-body table-responsive">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                // 'id',
                [
                  'label' => 'Office',
                  'attribute' => 'office',
                  'format' => 'html',
                  'value'=>function ($data) {
                    return $data->masteroffice->officename;
                }

                ],
                // 'createtime',
                // 'updatetime',
                'room',
                'floor',

                ['class' => 'yii\grid\ActionColumn',
                'contentOptions'=>['style'=>'min-width: 100px;'],
                'template'=>'<div class="btn-group pull-right">'.$action.'</div>',
                'buttons'=>[
                  'view' => function($url,$model,$key){
                      $btn = Html::button('<i class="fa fa-eye" style="font-size:12pt;"></i>',[
                          'value'=>Yii::$app->urlManager->createUrl('masterroom/view?id='.$model->id), //<---- here is where you define the action that handles the ajax request
                          'class'=>'btn btn-sm btn-info viewmasterroom-modal-click',
                          'data-toggle'=>'tooltip',
                          'data-placement'=>'bottom',
                          'title'=>'Views Detail'
                      ]);
                      return $btn;
                  },
                  'update' => function($url,$model,$key){
                      $btn = Html::button('<i class="fa fa-pencil" style="font-size:12pt;"></i>',[
                          'value'=>Yii::$app->urlManager->createUrl('masterroom/update?id='.$model->id), //<---- here is where you define the action that handles the ajax request
                          'class'=>'btn btn-sm btn-default updatemasterroom-modal-click',
                          'data-toggle'=>'tooltip',
                          'data-placement'=>'bottom',
                          'title'=>'Update'
                      ]);
                      return $btn;
                  },
                  'delete' => function ($url, $model) {
                    return Html::a('<i class="fa fa-trash" style="font-size:12pt;"></i>', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-sm btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                        'data-toggle' => 'tooltip',
                        'title'=> 'delete'
                        ]) ;
                  }


                ]
              ],
            ],
        ]); ?>
    </div>
</div>
