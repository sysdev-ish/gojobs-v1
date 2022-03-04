<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Userloginsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Login';
$this->params['breadcrumbs'][] = $this->title;
Modal::begin([
    'header'=>'<h4 class="modal-title">View User Login</h4>',
    'id'=>'viewuserlogin-modal',
    'size'=>'modal-md'
]);

echo "<div id='userloginview'></div>";


Modal::end();

if(Yii::$app->user->isGuest){
  $role = null;
}else{
  // $userid = Yii::$app->user->identity->id;
  $role = Yii::$app->user->identity->role;
}
if(Yii::$app->utils->permission($role,'m17') && Yii::$app->utils->permission($role,'m18')){
  $action = '{view}{update}{delete}';
}elseif(Yii::$app->utils->permission($role,'m17')){
  $action = '{view}{update}';
}elseif(Yii::$app->utils->permission($role,'m18')){
  $action = '{view}{delete}';
}else{
  $action = '{view}';
}
?>
<div class="userlogin-index box box-default">
  <?php if(Yii::$app->utils->permission($role,'m16')): ?>
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

                // 'id',
                // 'created_at',
                // 'updated_at',
                'username',
                'name',
                'email:email',
                // 'mobile',
                // 'password_hash',

                // 'status',
                // 'verify_code',
                // 'auth_key',
                'rolename.role',
                [
                  'label' => 'Status',
                  'attribute' => 'requestforchangepassword',
                  'filter' => \kartik\select2\Select2::widget([
                      'model' => $searchModel,
                      'attribute' => 'requestforchangepassword',
                      'data' => [1 => "Waiting for change password", 2 => "active", 3 =>'not active'],
                      'options' => ['placeholder' => '--'],
                      'pluginOptions' => [
                         'allowClear' => true,
                         'width' => '100px',
                         ],
                    ]),
                  'format' => 'html',
                  'value'=>function ($data) {
                    return ($data->requestforchangepassword == 1)?(($data->status <> 10)?'not active':'Waiting for change password'):'active';
                }
              ],
                // 'verify_status',


                ['class' => 'yii\grid\ActionColumn',
                'contentOptions'=>['style'=>'min-width: 150px;'],
                'template'=>'<div class="btn-group pull-right">'.$action.'</div>',
                'buttons'=>[
                  'view' => function($url,$model,$key){
                      $btn = Html::button('<i class="fa fa-eye" style="font-size:12pt;"></i>',[
                          'value'=>Yii::$app->urlManager->createUrl('userlogin/view?id='.$model->id), //<---- here is where you define the action that handles the ajax request
                          'class'=>'btn btn-sm btn-info viewuserlogin-modal-click',
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
                    return Html::a('<i class="fa fa-retweet" style="font-size:12pt;"></i>', ['rchangepass', 'id' => $model->id], [
                    'class' => 'btn btn-sm btn-danger',
                    'data-toggle' => 'tooltip',
                    'title'=> 'Request for Change Password',
                    'data' => [
                    'confirm' => 'Are you sure you want to request this user for change password?',
                    'method' => 'post',
                    ],
                  ]);
                  }
                ]
              ],
            ],
        ]); ?>
    </div>
</div>
