<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use app\models\Masterstatushiring;
use app\models\Transrincian;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Hiringsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hiring';
$this->params['breadcrumbs'][] = $this->title;
$url = \yii\helpers\Url::to(['transrincian/recreqlist']);
$masterstatushiring = ArrayHelper::map(Masterstatushiring::find()->asArray()->all(), 'id', 'statusname');
Modal::begin([
    'header'=>'<h4 class="modal-title">View Profile</h4>',
    'id'=>'profileviewshort-modal',
    'size'=>'modal-lg'
]);

echo "<div id='profileviewshortview'></div>";

Modal::end();
Modal::begin([
    'header'=>'<h4 class="modal-title">Hiring</h4>',
    'id'=>'hiring-modal',
    'size'=>'modal-xl',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    // 'pjaxContainer' => '#addcandidate',
]);

echo "<div id='hiring'></div>";
Modal::end();

Modal::begin([
    'header'=>'<h4 class="modal-title">Approve Hiring</h4>',
    'id'=>'hiringapprove-modal',
    'size'=>'modal-lg',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    // 'pjaxContainer' => '#addcandidate',
]);

echo "<div id='hiringapprove'></div>";

Modal::end();
Modal::begin([
    'header'=>'<h4 class="modal-title">View Recruitment Request</h4>',
    'id'=>'recreq-modal',
    'size'=>'modal-lg'
]);

echo "<div id='recreqview'></div>";

Modal::end();
if(Yii::$app->user->isGuest){
  $role = null;
}else{
  // $userid = Yii::$app->user->identity->id;
  $role = Yii::$app->user->identity->role;
}
if(Yii::$app->utils->permission($role,'m37')){
  $action = "{approve}";
}else{
  $action = '';
}
?>
<div class="hiring-index box box-default">
  <?php if(Yii::$app->utils->permission($role,'m36')): ?>
  <div class="box-header with-border">
    <?php echo Html::button('Create',[
        'value'=>Yii::$app->urlManager->createUrl('hiring/addhiring'), //<---- here is where you define the action that handles the ajax request
        'class'=>'btn btn-md btn-success createhiring-modal-click',
        'data-toggle'=>'tooltip',
        'data-placement'=>'bottom',
        'title'=>'Create Hiring'
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
                'id',
                'updatetime',
                'userid',
                [
                  'label' => 'Full Name',
                  'attribute' => 'fullname',
                  'contentOptions'=>['style'=>'width: 100px;'],
                  'format' => 'raw',
                  'value'=>function ($data) {
                    $btn = Html::button($data->userprofile->fullname,[
                        'value'=>Yii::$app->urlManager->createUrl('userprofile/viewshortwd?userid='.$data->userid.'&recid='.$data->recruitreqid), //<---- here is where you define the action that handles the ajax request
                        'class'=>'btn btn-link profileviewshort-modal-click',
                        'style'=>'padding:0px;',
                        'data-toggle'=>'tooltip',
                        'data-placement'=>'bottom',
                        'title'=>'View Profile detail'
                    ]);
                    return $btn;
                  }
                ],

                // 'createtime',
                // 'updatetime',
                [
                  'attribute' => 'perner',
                  'format' => 'raw',
                  'value'=>function ($data) {
                  return ($data->perner)?$data->perner:"";
                  }
                ],


                [

                  'label' => 'Recruitment Request',
                  'attribute' => 'nojo',
                  'contentOptions'=>['style'=>'min-width: 180px;'],
                  'format' => 'raw',
                  'value'=>function ($data) {
                    $btn = Html::button((($data->recrequest)?$data->recrequest->nojo:"-"),[
                        'value'=>Yii::$app->urlManager->createUrl('transrincian/viewshort?id='.$data->recruitreqid), //<---- here is where you define the action that handles the ajax request
                        'class'=>'btn btn-link recreq-modal-click',
                        'style'=>'padding:0px;',
                        'data-toggle'=>'tooltip',
                        'data-placement'=>'bottom',
                        'title'=>'View Recruitment Request Detail'
                    ]);
                    return $btn;
                  }
                ],

                [
                  'label' => 'type jo',
                  'attribute' => 'typejorincian',
                  'contentOptions'=>['style'=>'width: 100px;'],
                  'format' => 'html',
                  'filter' => \kartik\select2\Select2::widget([
                      'model' => $searchModel,
                      'attribute' => 'typejorincian',
                      'data' => [1 => "New Project", 2 => "replacement"],
                      'options' => ['placeholder' => '--'],
                      'pluginOptions' => [
                        'allowClear' => true,
                        'width' => '100px',
                        ],
                    ]),
                  'value'=>function ($data) {
                    return ($data->recrequest)?(($data->recrequest->typejo==1)?"New Project":"Replacement"):"-";
                  }
                ],

                [
                  'label' => 'Area (SAP)',
                  'attribute' => 'areasap',
                  'contentOptions'=>['style'=>'width: 100px;'],
                  'format' => 'html',

                  'value'=>function ($data) {
                    return ($data->recrequest)?((($data->recrequest->area_sap))?(($data->recrequest->areasap)?(($data->recrequest->areasap->value2)?$data->recrequest->areasap->value2 : ""):''):""):"-";
                  }
                ],

                [
                  'label' => 'Jabatan (SAP)',
                  'attribute' => 'jabatansap',
                  'contentOptions'=>['style'=>'width: 100px;'],
                  'format' => 'html',

                  'value'=>function ($data) {
                    if ($data->recrequest) {
                      if ($data->recrequest->hire_jabatan_sap) {
                        // return $data->recrequest->hire_jabatan_sap;
                        if ($data->recrequest->jabatansap) {
                          return $data->recrequest->jabatansap->value2;
                        } else {
                          return "-";
                        }
                      } else {
                        return "-";
                      }
                    } else {
                      return "-";
                    }
                  }
                ],

                [
                  'label' => 'SAP',
                  'attribute' => 'typejo',
                  'contentOptions'=>['style'=>'width: 100px;'],
                  'format' => 'html',
                  'filter' => \kartik\select2\Select2::widget([
                      'model' => $searchModel,
                      'attribute' => 'typejo',
                      'data' => [1 => "ISH", 2 => "Peralihan"],
                      'options' => ['placeholder' => '--'],
                      'pluginOptions' => [
                        'allowClear' => true,
                        'width' => '100px',
                        ],
                    ]),
                  'value'=>function ($data) {
                    return ($data->typejo==1)?"ISH":"Peralihan";
                  }
                ],

                [
                  'label' => 'Status',
                  'attribute' => 'status',
                  'contentOptions'=>['style'=>'min-width: 300px;'],
                  'format' => 'html',
                  'filter' => \kartik\select2\Select2::widget([
                      'model' => $searchModel,
                      'attribute' => 'status',
                      'data' => $masterstatushiring,
                      'options' => ['placeholder' => '--'],
                      'pluginOptions' => [
                        'allowClear' => true,
                        'width' => '300px',
                        ],
                    ]),
                  'value'=>function ($data) {
                    return "Status Hiring : ".(($data->statushiring0)?$data->statushiring0->statusname:'-')."<br>".
                      "Status Biodata : ".(($data->statusbiodata0)?$data->statusbiodata0->statusname:'-')."<br>".
                      "SAP Message : ".(($data->message)?$data->message:"-");
                  }
                ],

                [
                  'label' => 'PM',
                  'attribute' => 'userpm',
                  'contentOptions'=>['style'=>'min-width: 100px;'],
                  'format' => 'html',
                  'value'=>function ($data) {
                    return ($data->recrequest)?(($data->recrequest->userpm)?((Yii::$app->utils->getusername($data->recrequest->userpm))?Yii::$app->utils->getusername($data->recrequest->userpm):$data->recrequest->userpm):''):"-";
                  }
                ],

                // [
                //   'attribute' => 'statushiring',
                //   'contentOptions'=>['style'=>'width: 100px;'],
                //   'format' => 'html',
                //   'filter' => \kartik\select2\Select2::widget([
                //     'model' => $searchModel,
                //     'attribute' => 'statushiring',
                //     'data' => $masterstatushiring,
                //     'options' => ['placeholder' => '--'],
                //     'pluginOptions' => [
                //        'allowClear' => true,
                //        'width' => '100px',
                //        ],
                //   ]),
                //   'value'=>function ($data) {
                //     return ($data->statushiring0)?$data->statushiring0->statusname:'-';
                // }
                //
                // ],
                // [
                //   'attribute' => 'statusbiodata',
                //   'contentOptions'=>['style'=>'width: 100px;'],
                //   'format' => 'html',
                //   'filter' => \kartik\select2\Select2::widget([
                //     'model' => $searchModel,
                //     'attribute' => 'statusbiodata',
                //     'data' => $masterstatushiring,
                //     'options' => ['placeholder' => '--'],
                //     'pluginOptions' => [
                //        'allowClear' => true,
                //        'width' => '100px',
                //        ],
                //   ]),
                //   'value'=>function ($data) {
                //     return ($data->statusbiodata0)?$data->statusbiodata0->statusname:'-';
                // }
                //
                // ],
                'tglinput',
                // 'awalkontrak',
                // 'akhirkontrak',
                // 'message',
                // 'statusbiodata',

                // ['class' => 'yii\grid\ActionColumn'],
                ['class' => 'yii\grid\ActionColumn',
                'contentOptions'=>['style'=>'min-width: 50px;'],
                'template'=>'<div class="btn-group pull-right">'.$action.'</div>',
                'buttons'=>[
                  'approve' => function($url,$model,$key){
                    if($model->statushiring ==  1){
                      $disabled = false;
                    }else{
                      $disabled = true;
                    }
                      $btn = Html::button('<i class="fa fa-gavel" style="font-size:12pt;"></i>',[
                          'value'=>Yii::$app->urlManager->createUrl('hiring/approve?id='.$model->id), //<---- here is where you define the action that handles the ajax request
                          'class'=>'btn btn-sm btn-info approvehiring-modal-click',
                          'disabled' => $disabled,
                          'data-toggle'=>'tooltip',
                          'data-placement'=>'bottom',
                          'title'=>'Approve'
                      ]);
                      return $btn;
                  },
                ]
              ],

            ],
        ]); ?>
    </div>
</div>
