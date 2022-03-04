<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use app\models\Saparea;
use app\models\Masterareaish;
use app\models\Masterregion;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Mappingregionareasearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mapping Area';
$this->params['breadcrumbs'][] = $this->title;

Modal::begin([
    'header'=>'<h4 class="modal-title">View Area ISH</h4>',
    'id'=>'viewmappingregionarea-modal',
    'size'=>'modal-md'
]);

echo "<div id='mappingregionareaview'></div>";


Modal::end();
Modal::begin([
    'header'=>'<h4 class="modal-title">Update Mapping Area ISH</h4>',
    'id'=>'updatemappingregionarea-modal',
    'size'=>'modal-md'
]);

echo "<div id='updatemappingregionarea'></div>";


Modal::end();
Modal::begin([
    'header'=>'<h4 class="modal-title">Create New Area ISH</h4>',
    'id'=>'createmappingregionarea-modal',
    'size'=>'modal-md'
]);

echo "<div id='createmappingregionarea'></div>";


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
<div class="mappingregionarea-index box box-default">
  <div class="box-header with-border">
    <?php echo Html::button('Create',[
        'value'=>Yii::$app->urlManager->createUrl('mappingregionarea/create'), //<---- here is where you define the action that handles the ajax request
        'class'=>'btn btn-md btn-success createmappingregionarea-modal-click',
        'data-toggle'=>'tooltip',
        'data-placement'=>'bottom',
        'title'=>'Create New Mapping Area'
    ]); ?>
  </div>
    <div class="box-body table-responsive">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn',
                'contentOptions'=>['style'=>'width: 50px;'],
                ],

                // 'id',
                [
                  'attribute' => 'areaishid',
                  'format' => 'html',
                  'filter' => \kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'areaishid',
                    'data' => ArrayHelper::map(Masterareaish::find()->asArray()->all(), 'id', 'area'),
                    'options' => ['placeholder' => '--'],
                    'pluginOptions' => [
                       'allowClear' => true,
                       // 'width' => '120px',
                       ],
                  ]),
                  'value'=>function ($data) {
                    return ($data->masterareaish)?$data->masterareaish->area:'';
                  }

                ],
                [
                  'attribute' => 'regionid',
                  'format' => 'html',
                  'filter' => \kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'regionid',
                    'data' => ArrayHelper::map(Masterregion::find()->asArray()->all(), 'id', 'regionname'),
                    'options' => ['placeholder' => '--'],
                    'pluginOptions' => [
                       'allowClear' => true,
                       // 'width' => '120px',
                       ],
                  ]),
                  'value'=>function ($data) {
                    return ($data->masterregion)?$data->masterregion->regionname:'';
                  }

                ],
                [
                  'attribute' => 'area',
                  'format' => 'html',
                  // 'contentOptions'=>['style'=>'width: 200px;'],
                  
                  'value'=>function ($data) {
                    return ($data->masterarea)?$data->masterarea->value2:'';
                  }

                ],
                // 'createtime',
                // 'updatetime',
                // 'createdby',
                // 'updatedby',

                ['class' => 'yii\grid\ActionColumn',
                'contentOptions'=>['style'=>'max-width: 50px;'],
                'template'=>'<div class="btn-group pull-right">'.$action.'</div>',
                'buttons'=>[
                  'view' => function($url,$model,$key){
                      $btn = Html::button('<i class="fa fa-eye" style="font-size:12pt;"></i>',[
                          'value'=>Yii::$app->urlManager->createUrl('mappingregionarea/view?id='.$model->id), //<---- here is where you define the action that handles the ajax request
                          'class'=>'btn btn-sm btn-info viewmappingregionarea-modal-click',
                          'data-toggle'=>'tooltip',
                          'data-placement'=>'bottom',
                          'title'=>'Views Detail'
                      ]);
                      return $btn;
                  },
                  'update' => function($url,$model,$key){
                      $btn = Html::button('<i class="fa fa-pencil" style="font-size:12pt;"></i>',[
                          'value'=>Yii::$app->urlManager->createUrl('mappingregionarea/update?id='.$model->id), //<---- here is where you define the action that handles the ajax request
                          'class'=>'btn btn-sm btn-default updatemappingregionarea-modal-click',
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
