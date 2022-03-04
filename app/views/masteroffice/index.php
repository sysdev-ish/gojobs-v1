<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Masterofficesearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master office';
$this->params['breadcrumbs'][] = $this->title;

Modal::begin([
    'header'=>'<h4 class="modal-title">View Office</h4>',
    'id'=>'viewmasteroffice-modal',
    'size'=>'modal-md'
]);

echo "<div id='masterofficeview'></div>";


Modal::end();
Modal::begin([
    'header'=>'<h4 class="modal-title">Update Office</h4>',
    'id'=>'updatemasteroffice-modal',
    'size'=>'modal-md'
]);

echo "<div id='updatemasteroffice'></div>";


Modal::end();
Modal::begin([
    'header'=>'<h4 class="modal-title">Create New Office</h4>',
    'id'=>'createmasteroffice-modal',
    'size'=>'modal-md'
]);

echo "<div id='createmasteroffice'></div>";


Modal::end();


if(Yii::$app->user->isGuest){
  $role = null;
}else{
  // $userid = Yii::$app->user->identity->id;
  $role = Yii::$app->user->identity->role;
}
if(Yii::$app->utils->permission($role,'m25') && Yii::$app->utils->permission($role,'m26')){
  $action = '{view}{update}{delete}';
}elseif(Yii::$app->utils->permission($role,'m25')){
  $action = '{view}{update}';
}elseif(Yii::$app->utils->permission($role,'m26')){
  $action = '{view}{delete}';
}else{
  $action = '{view}';
}
?>
<div class="masteroffice-index box box-default">
  <?php if(Yii::$app->utils->permission($role,'m24')): ?>
    <div class="box-header with-border">
      <?php echo Html::button('Create',[
          'value'=>Yii::$app->urlManager->createUrl('masteroffice/create'), //<---- here is where you define the action that handles the ajax request
          'class'=>'btn btn-md btn-success createmasteroffice-modal-click',
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
                // 'createtime',
                // 'updatetime',
                'officename',
                'address',
                [
                  'label' => 'Map Location',
                  'contentOptions'=>['style'=>'width: 100px;'],
                  'format' => 'raw',
                  'value'=>function ($data) {

                    return Html::a('Link location', 'https://maps.google.com/?q='.$data->lat.','.$data->long, ['target' => '_blank']);
                }

                ],


                ['class' => 'yii\grid\ActionColumn',
                'contentOptions'=>['style'=>'min-width: 150px;'],
                'template'=>'<div class="btn-group pull-right">'.$action.'</div>',
                'buttons'=>[
                  'view' => function($url,$model,$key){
                      $btn = Html::button('<i class="fa fa-eye" style="font-size:12pt;"></i>',[
                          'value'=>Yii::$app->urlManager->createUrl('masteroffice/view?id='.$model->id), //<---- here is where you define the action that handles the ajax request
                          'class'=>'btn btn-sm btn-info viewmasteroffice-modal-click',
                          'data-toggle'=>'tooltip',
                          'data-placement'=>'bottom',
                          'title'=>'Views Detail'
                      ]);
                      return $btn;
                  },
                  'update' => function($url,$model,$key){
                      $btn = Html::button('<i class="fa fa-pencil" style="font-size:12pt;"></i>',[
                          'value'=>Yii::$app->urlManager->createUrl('masteroffice/update?id='.$model->id), //<---- here is where you define the action that handles the ajax request
                          'class'=>'btn btn-sm btn-default updatemasteroffice-modal-click',
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
