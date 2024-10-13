<?php

use app\models\User;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Chagerequestjosearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stop Job Order';
$this->params['breadcrumbs'][] = $this->title;
Modal::begin([
  'header' => '<h4 class="modal-title">View Recruitment Request</h4>',
  'id' => 'recreq-modal',
  'size' => 'modal-lg'
]);

echo "<div id='recreqview'></div>";

Modal::end();
Modal::begin([
  'header' => '<h4 class="modal-title">View Change Request JO</h4>',
  'id' => 'crjo-modal',
  'size' => 'modal-lg'
]);

echo "<div id='crjoview'></div>";

Modal::end();
Modal::begin([
  'header' => '<h4 class="modal-title">Approve Change Request JO</h4>',
  'id' => 'approvecrjo-modal',
  'size' => 'modal-md'
]);

echo "<div id='approvecrjoview'></div>";

Modal::end();

if (Yii::$app->user->isGuest) {
  $role = null;
} else {
  // $userid = Yii::$app->user->identity->id;
  $role = Yii::$app->user->identity->role;
}
$actionview = '';
$actionapprove = '';
if (Yii::$app->utils->permission($role, 'm64')) {
  $actionview = '{view}';
}
if (Yii::$app->utils->permission($role, 'm65') || $role = 1) {
  $actionapprove = '{approve}';
}
$action = $actionview . $actionapprove;
?>
<div class="chagerequestjo-index box box-default">

  <div class="box-body table-responsive">
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <?= GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'layout' => "{items}\n{summary}\n{pager}",
      'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        // 'id',
        // 'recruitreqid',
        [
          'attribute' => 'nojo',
          'format' => 'raw',
          'value' => function ($data) {
            if ($data->jo) {
              $btn = Html::button($data->jo->nojo, [
                'value' => Yii::$app->urlManager->createUrl('transrincian/viewshort?id=' . $data->recruitreqid), //<---- here is where you define the action that handles the ajax request
                'class' => 'btn btn-link recreq-modal-click',
                'style' => 'padding:0px;',
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'title' => 'View Recruitment Request Detail'
              ]);
              return $btn;
            } else {
              return '';
            }
          }

        ],
        [
          'label' => 'Area',
          'format' => 'raw',
          'value' => function ($data) {

            return ($data->jo) ? $data->jo->areasap->value2 : '';
          }

        ],
        [
          'attribute' => 'createdby',
          'format' => 'html',
          'value' => function ($data) {

            return ($data->createdbyu) ? $data->createdbyu->name : '';
          }

        ],
        'createtime',
        // 'createtime',
        // 'updatetime',
        // 'approvedtime',
        // 'createdby',
        // 'updatedby',
        // 'approvedby',

        // 'oldjumlah',
        // 'jumlah',
        [
          'label' => 'Approval I',
          'attribute' => 'approvedby',
          'contentOptions' => ['style' => 'width: 140px;'],
          'format' => 'html',
          'filter' => \kartik\select2\Select2::widget([
            'model' => $searchModel,
            'attribute' => 'approvedby',
            'data' => ArrayHelper::map(User::find()->where('role = 10 AND status = 10')->asArray()->all(), 'id', 'name'),
            'options' => ['placeholder' => '--'],
            'pluginOptions' => [
              'allowClear' => true,
              // 'width' => '120px',
            ],
          ]),
          'value' => function ($data) {
            // var_dump($data->approvedbyu->name);die();
            return ($data->approvedby) ? (($data->approvedbyu->role == 10) ? $data->approvedbyu->name : "PM") : "PM";
            // return "PM";
          }
        ],

        // [
        //   'label' => 'Approval II',
        //   'contentOptions' => ['style' => 'min-width: 100px;'],
        //   'attribute' => 'approvedby2',
        //   'format' => 'html',
        //   'filter' => \kartik\select2\Select2::widget([
        //     'model' => $searchModel,
        //     'attribute' => 'approvedby2',
        //     'data' => ArrayHelper::map(User::find()->where('role = 22 OR role = 23 AND status = 10')->asArray()->all(), 'id', 'name'),
        //     'options' => ['placeholder' => '--'],
        //     'pluginOptions' => [
        //       'allowClear' => true,
        //     ],
        //   ]),
        //   'value' => function ($data) {
        //     return ($data->approveduser) ? $data->approveduser->name : "";
        //   }
        // ],

        [
          'label' => 'Approval II',
          // 'attribute' => 'approveduser',
          'format' => 'html',
          'value' => function ($data) {
            // return ($data->approvedby2) ? ((Yii::$app->utils->getnamebynik($data->approvedby2)) ? Yii::$app->utils->getnamebynik($data->approvedby2) : $data->approvedby2 . '<br>' . '<i class="text-red">(NIK Unregistered HRIS)</i>') : 'No Approval';
            $approvedBy2 = $data->approvedby2;

            if ($approvedBy2) {
              $name = Yii::$app->utils->getnamebynik($approvedBy2);
              if ($name) {
                return $name;
              } else {
                return $approvedBy2 . '<br><i class="text-red">(NIK Unregistered HRIS)</i>';
              }
            } else {
              return 'No Approval';
            }
          }
        ],
        
        [
          'attribute' => 'status',
          'format' => 'html',
          'filter' => \kartik\select2\Select2::widget([
            'model' => $searchModel,
            'attribute' => 'status',
            'data' => [1 => 'Waiting Approval I', 2 => 'Waiting Approval II', 3 => 'Approved', 4 => 'Rejected'],
            'options' => ['placeholder' => '--'],
            'pluginOptions' => [
              'allowClear' => true,
              'width' => '100px',
            ],
          ]),
          'value' => function ($data) {
            switch ($data->status) {
              case '1':
                $status = '<span class="label label-warning">Waiting Approval I</span>';
                break;
              case '2':
                $status = '<span class="label label-warning">Waiting Approval II</span>';
                break;
              case '3':
                $status = '<span class="label label-success">Approved</span>';
                break;
              case '4':
                $status = '<span class="label label-danger">Rejected</span>';
                break;

              default:
                $status = '';
                break;
            }
            return $status;
          }

        ],
        'remarks',

        // ['class' => 'yii\grid\ActionColumn'],
        [
          'class' => 'yii\grid\ActionColumn',
          'contentOptions' => ['style' => 'min-width: 100px;'],
          'template' => '<div class="btn-group pull-right">' . $action . '</div>',
          'buttons' => [
            'view' => function ($url, $model, $key) {
              $btn = Html::button('<i class="fa fa-eye" style="font-size:12pt;"></i>', [
                'value' => Yii::$app->urlManager->createUrl('chagerequestjo/view?id=' . $model->id),
                'class' => 'btn btn-sm btn-default viewcrjo-modal-click',
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'title' => 'Views Detail'
              ]);
              return $btn;
            },
            'approve' => function ($url, $model, $key) {
              if ($model->status ==  1 or $model->status ==  2) {
                $disabled = true;
                if ($model->status == 1 and (Yii::$app->user->identity->role == 10 or Yii::$app->user->identity->role == 16 || Yii::$app->user->identity->role == 1)) {
                  $disabled = false;
                }
                if ($model->status == 2 and $model->approvedby2 == Yii::$app->user->identity->username || Yii::$app->user->identity->role == 1) {
                  $disabled = false;
                }
              } else {
                $disabled = true;
              }
              $btn = Html::button('<i class="fa fa-gavel" style="font-size:12pt;"></i>', [
                'value' => Yii::$app->urlManager->createUrl('chagerequestjo/approve?id=' . $model->id), //<---- here is where you define the action that handles the ajax request
                'class' => 'btn btn-sm btn-info approvecrjo-modal-click',
                'disabled' => $disabled,
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'title' => 'Approve'
              ]);
              return $btn;
            },
          ]
        ],
      ],
    ]); ?>
  </div>
</div>