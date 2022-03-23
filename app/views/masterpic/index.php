<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Masterpicsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master PIC';
$this->params['breadcrumbs'][] = $this->title;
Modal::begin([
    'header'=>'<h4 class="modal-title">View PIC</h4>',
    'id'=>'viewmasterpic-modal',
    'size'=>'modal-md'
]);

echo "<div id='masterpicview'></div>";


Modal::end();
Modal::begin([
    'header'=>'<h4 class="modal-title">Update PIC</h4>',
    'id'=>'updatemasterpic-modal',
    'size'=>'modal-md'
]);

echo "<div id='updatemasterpic'></div>";


Modal::end();
Modal::begin([
    'header'=>'<h4 class="modal-title">Create New PIC</h4>',
    'id'=>'createmasterpic-modal',
    'size'=>'modal-md'
]);

echo "<div id='createmasterpic'></div>";


Modal::end();
if(Yii::$app->user->isGuest){
  $role = null;
}else{
  // $userid = Yii::$app->user->identity->id;
  $role = Yii::$app->user->identity->role;
}
if(Yii::$app->utils->permission($role,'m33') && Yii::$app->utils->permission($role,'m34')){
  $action = '{view}{update}{delete}';
}elseif(Yii::$app->utils->permission($role,'m33')){
  $action = '{view}{update}';
}elseif(Yii::$app->utils->permission($role,'m34')){
  $action = '{view}{delete}';
}else{
  $action = '{view}';
}
?>
<div class="masterpic-index box box-default">
  <?php if(Yii::$app->utils->permission($role,'m32')): ?>
  <div class="box-header with-border">
    <?php echo Html::button('Create',[
        'value'=>Yii::$app->urlManager->createUrl('masterpic/create'), //<---- here is where you define the action that handles the ajax request
        'class'=>'btn btn-md btn-success createmasterpic-modal-click',
        'data-toggle'=>'tooltip',
        'data-placement'=>'bottom',
        'title'=>'Create New PIC'
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
                [
                  'label' => 'PIC',
                  'attribute' => 'userid',
                  'format' => 'html',
                  'value'=>function ($data) {
                    return ($data->userlogin)?$data->userlogin->name:'-';
                }

                ],
                [
                  'label' => 'Mobile Phone PIC',
                  // 'attribute' => 'userid',
                  'format' => 'html',
                  'value'=>function ($data) {
                    return ($data->userlogin)?$data->userlogin->mobile:'-';
                }

                ],
                // 'createtime',
                // 'updatetime',
                // 'userid',

                ['class' => 'yii\grid\ActionColumn',
                'contentOptions'=>['style'=>'min-width: 100px;'],
                'template'=>'<div class="btn-group pull-right">'.$action.'</div>',
                'buttons'=>[
                  'view' => function($url,$model,$key){
                      $btn = Html::button('<i class="fa fa-eye" style="font-size:12pt;"></i>',[
                          'value'=>Yii::$app->urlManager->createUrl('masterpic/view?id='.$model->id), //<---- here is where you define the action that handles the ajax request
                          'class'=>'btn btn-sm btn-info viewmasterpic-modal-click',
                          'data-toggle'=>'tooltip',
                          'data-placement'=>'bottom',
                          'title'=>'Views Detail'
                      ]);
                      return $btn;
                  },
                  'update' => function($url,$model,$key){
                      $btn = Html::button('<i class="fa fa-pencil" style="font-size:12pt;"></i>',[
                          'value'=>Yii::$app->urlManager->createUrl('masterpic/update?id='.$model->id), //<---- here is where you define the action that handles the ajax request
                          'class'=>'btn btn-sm btn-default updatemasterpic-modal-click',
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
