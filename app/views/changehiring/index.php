<?php

use app\models\Hiring;
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Masterstatuscr;
use app\models\Transrincian;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Changehiringsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Change Hiring';
$this->params['breadcrumbs'][] = $this->title;
Modal::begin([
    'header'=>'<h4 class="modal-title">View Change Hiring</h4>',
    'id'=>'viewchiring-modal',
    'size'=>'modal-lg'
]);
echo "<div id='viewchiring-view'></div>";
Modal::end();

Modal::begin([
    'header'=>'<h4 class="modal-title">Approve Change Hiring</h4>',
    'id'=>'approvecrhiring-modal',
    'size'=>'modal-lg'
]);
echo "<div id='approvecrhiring-view'></div>";
Modal::end();

Modal::begin([
    'header'=>'<h4 class="modal-title">Confirmation Change Hiring</h4>',
    'id'=>'confirmcrhiring-modal',
    'size'=>'modal-lg'
]);
echo "<div id='confirmcrhiring-view'></div>";
Modal::end();

if(Yii::$app->user->isGuest){
  $role = null;
}else{
  // $userid = Yii::$app->user->identity->id;
  $role = Yii::$app->user->identity->role;
}
$actionview = '';
$actionupdate = '';
$actiondelete = '';
$actionapprove = '';
$actionconfirmation = '';
if(Yii::$app->utils->permission($role,'m88')){
  $actionview = '{view}';
}
if(Yii::$app->utils->permission($role,'m90')){
  $actionupdate = '{update}';
}
if(Yii::$app->utils->permission($role,'m91')){
  $actiondelete = '{delete}';
}
if(Yii::$app->utils->permission($role,'m92')){
  $actionapprove = '{approve}';
}
if (Yii::$app->user->identity->username == '9802618' || Yii::$app->user->identity->username == '9103005' || Yii::$app->user->identity->username == "seysi.lupi1@ish.co.id") {
  $actionconfirmation = '{confirmation}';
}
$action = $actionview.$actionupdate.$actiondelete.$actionapprove.$actionconfirmation;
?>
<div class="changehiring-index box box-default">
  <?php if(Yii::$app->utils->permission($role,'m68')): ?>
  <div class="box-header with-border">
    <?= Html::a('Create', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
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

            [
              'label' => 'Name',
              'attribute' => 'fullname',
              'format' => 'html',
              'value'=>function ($data) {
                return $data->fullname;
              }
            ],

            [
              'label' => 'No Jo',
              'format' => 'html',
              'value' => function ($data) {
                if ($data->userid) {
                  $cekhiring = Hiring::find()->where('userid =' . $data->userid . ' and (statushiring = 4 OR statushiring = 6)')->orderBy(["id" => SORT_DESC])->one();
                  if ($cekhiring) {
                    $getjo = Transrincian::find()->where(['id' => $cekhiring->recruitreqid])->one();
                  }
                  return ($getjo) ? $getjo->nojo : '-';
                }
              }
            ],

            [
              'label' => 'Replacement',
              'format' => 'html',
              'value' => function ($data) {
                return "Date Hiring: " . ($data->newhiringdate) . "<br>" .
                "Contract Periode: " . ($data->newcontractperiode) . "<br>" .
                "No JO: " . ($data->newrecruitreqid) ;
              } 
            ],

            [
              'label' => 'Cancel Hiring',
              'attribute' => 'cancelhiring',
              'contentOptions'=>['style'=>'min-width: 100px;'],
              'format' => 'html',
              'value'=>function ($data) {
                return $data->cancelhiring;
              }
            ],

            [
              'label' => 'Created By',
              'attribute' => 'createduser',
              'format' => 'html',
              'value'=>function ($data) {

                return ($data->createduser)?$data->createduser->name:"";
              }
            ],

            [
              'label' => 'Approver',
              'attribute' => 'approveduser',
              'format' => 'html',
              'value'=>function ($data) {
                return ($data->approveduser)?$data->approveduser->name: "PM";
              }
            ],

            [
              'attribute' => 'status',
              'contentOptions'=>['style'=>'min-width: 200px;'],
              'format' => 'html',
              'filter' => \kartik\select2\Select2::widget([
                'model' => $searchModel,
                'attribute' => 'status',
                'data' => ArrayHelper::map(Masterstatuscr::find()->where('id in (1, 2, 4, 5, 7, 8, 9)')->asArray()->all(), 'id', 'statusname'),
                'options' => ['placeholder' => '--'],
                'pluginOptions' => [
                    'allowClear' => true,
                    // 'width' => '150px',
                    ],
              ]),
              'value'=>function ($data) {
                if($data->status == 1){$label='label-danger';}elseif($data->status == 2 OR $data->status == 3 OR $data->status == 6){$label='label-warning';}elseif($data->status == 4 OR $data->status == 9){$label='label-success';}elseif($data->status == 8){$label='label-info';}else{$label='label-danger';}
                return '<span class="label '.$label.'">'.$data->statusprocess->statusname.'</span>';
              }
            ],

            // [
            //   'label' => 'Remarks',
            //   'attribute' => 'remarks',
            //   'format' => 'html',
            //   'value'=>function ($data) {
            //     if ($data->status == 9) {
            //       if ($data->perner == null) {
            //         return "<b><i>".$data->remarks."</i></b><br>";
            //       } else {
            //         return "<b><i>".$data->remarks."</i></b><br>";
            //       }
            //     } else {
            //       return "<b><i>".$data->remarks."</i></b><br>";
            //     }
            //   }
            // ],

            ['class' => 'yii\grid\ActionColumn',
            'contentOptions'=>['style'=>'min-width: 210px;'],
            'template'=>'<div class="btn-group pull-right">'.$action.'</div>',
            'buttons'=>[
              'view' => function($url,$model,$key){
                  $btn = Html::button('<i class="fa fa-eye" style="font-size:12pt;"></i>',[
                    'value'=>Yii::$app->urlManager->createUrl('changehiring/view?id='.$model->id),
                    'class'=>'btn btn-sm btn-default viewchiring-modal-click',
                    'data-toggle'=>'tooltip',
                    'data-placement'=>'bottom',
                    'title'=>'Views Detail'
                  ]);
                  return $btn;
              },
              'approve' => function($url,$model,$key){
                if($model->status == 2){
                  $disabled = false;
                }else{
                  $disabled = true;
                }
                  $btn = Html::button('<i class="fa fa-gavel" style="font-size:12pt;"></i>',[
                      'value'=>Yii::$app->urlManager->createUrl('changehiring/approve?id='.$model->id), //<---- here is where you define the action that handles the ajax request
                      'class'=>'btn btn-sm btn-info approvecrhiring-modal-click',
                      'disabled' => $disabled,
                      'data-toggle'=>'tooltip',
                      'data-placement'=>'bottom',
                      'title'=>'Approve'
                  ]);
                  return $btn;
              },
              'confirmation' => function($url,$model,$key){
                if($model->status == 8){
                  $disabled = false;
                }else{
                  $disabled = true;
                }
                  $btn = Html::button('<i class="fa fa-check-square-o" style="font-size:12pt;"></i>',[
                      'value'=>Yii::$app->urlManager->createUrl('changehiring/confirmcancel?id='.$model->id), //<---- here is where you define the action that handles the ajax request
                      'class'=> 'btn btn-sm btn-success confirmcrhiring-modal-click',
                      'disabled' => $disabled,
                      'data-toggle'=>'tooltip',
                      'data-placement'=>'bottom',
                      'title'=>'Confirm'
                  ]);
                  return $btn;
              },
              'update' => function ($url, $model) {
                if($model->status < 2 OR $model->status == 5 OR $model->status == 6){
                  $disabled = false; $link='update';
                }else{
                  $disabled = true; $link='#';
                }
                return Html::a('<i class="fa fa-pencil" style="font-size:12pt;"></i>', [$link, 'id'=>$model->id], [
                  'class' => 'btn btn-sm btn-default',
                  'disabled' => $disabled,
                  'data-toggle' => 'tooltip',
                  'title'=> 'Update' ]);
              },
              'delete' => function ($url, $model) {
                ($model->status < 2 )?$disabled = false : $disabled = true;
                if($model->status < 2 ){
                  return Html::a('<i class="fa fa-trash" style="font-size:12pt;"></i>', ['delete', 'id' => $model->id], [
                              'class' => 'btn btn-sm btn-danger','data-toggle' => 'tooltip', 'title'=> 'delete', 'disabled' => $disabled,
                              'data' => [
                                  'confirm' => 'Are you sure you want to delete this item?',
                                  'method' => 'post',
                              ],
                          ]);
                }else{
                  return Html::a('<i class="fa fa-trash" style="font-size:12pt;"></i>', ['#', 'id' => $model->id], [
                    'class' => 'btn btn-sm btn-danger','data-toggle' => 'tooltip', 'title'=> 'delete', 'disabled' => $disabled,
                          ]);
                }
              }
            ]
            ],
        ],
      ]); ?>
  </div>
</div>