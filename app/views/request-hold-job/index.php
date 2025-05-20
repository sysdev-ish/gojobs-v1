<?php

use app\models\User;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\request-hold-jobsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hold Job Order';
$this->params['breadcrumbs'][] = $this->title;
Modal::begin([
  'header' => '<h4 class="modal-title">View Recruitment Request</h4>',
  'id' => 'recreq-modal',
  'size' => 'modal-lg'
]);
echo "<div id='recreqview'></div>";
Modal::end();

Modal::begin([
  'header' => '<h4 class="modal-title">View Request Hold JO</h4>',
  'id' => 'view-hold-job-modal',
  'size' => 'modal-lg'
]);
echo "<div id='view-hold-job-view'></div>";
Modal::end();

Modal::begin([
  'header' => '<h4 class="modal-title">Approve Request Hold JO</h4>',
  'id' => 'approve-hold-job-modal',
  'size' => 'modal-md'
]);
echo "<div id='approve-hold-job-view'></div>";
Modal::end();

Modal::begin([
  'header' => '<h4 class="modal-title">Hold Job Order</h4>',
  'id' => 'hold-job-modal',
  'size' => 'modal-xl',
  'clientOptions' => ['backdrop' => 'static', 'keyboard' => false]
]);
echo "<div id='hold-job-view'></div>";
Modal::end();


if (Yii::$app->user->isGuest) {
  $role = null;
} else {
  // $userid = Yii::$app->user->identity->id;
  $role = Yii::$app->user->identity->role;
}

$actionview = '';
$actionupdate = '';
$actionapprove = '';
if (Yii::$app->utils->permission($role, 'm93')) {
  $actionview = '{view}';
}
if (Yii::$app->utils->permission($role, 'm95')) {
  $actionview = '{update}';
}
if (Yii::$app->utils->permission($role, 'm97') || $role = 1) {
  $actionapprove = '{approve}';
}
$action = $actionview . $actionupdate . $actionapprove;
?>
<div class="request-hold-job-index box box-default">

  <div class="box-body table-responsive">
    <?= GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'layout' => "{items}\n{summary}\n{pager}",
      'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
          'attribute' => 'nojo',
          'label' => 'Nomor JO',
          'format' => 'raw',
          'value' => function ($data) {
            // here is where you define the action that handles the ajax request
            if ($data->jo) {
              $btn = Html::button($data->jo->nojo, [
                'value' => Yii::$app->urlManager->createUrl('transrincian/viewshort?id=' . $data->recruitreqid),
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
        'scheme_date_start',
        'scheme_date_end',
        [
          'attribute' => 'created_by',
          'format' => 'html',
          'value' => function ($data) {

            return ($data->creator) ? $data->creator->name : '';
          }

        ],
        'created_at',
        [
          'label' => 'Approval',
          'attribute' => 'approved_by',
          'contentOptions' => ['style' => 'width: 140px;'],
          'format' => 'html',
          'filter' => \kartik\select2\Select2::widget([
            'model' => $searchModel,
            'attribute' => 'approved_by',
            'data' => ArrayHelper::map(User::find()->where('role = 10 AND status = 10')->asArray()->all(), 'id', 'name'),
            'options' => ['placeholder' => '--'],
            'pluginOptions' => [
              'allowClear' => true,
              // 'width' => '120px',
            ],
          ]),
          'value' => function ($data) {
            // var_dump($data->approver->name);die();
            return ($data->approved_by) ? (($data->approver->role == 10) ? $data->approver->name : "PM") : "PM";
            // return "PM";
          }
        ],

        [
          'attribute' => 'status',
          'format' => 'html',
          'filter' => \kartik\select2\Select2::widget([
            'model' => $searchModel,
            'attribute' => 'status',
            'data' => [
              1 => 'Waiting Approval',
              2 => 'Rejected',
              3 => 'Approved',
              4 => 'Re Opened',
            ],
            'options' => ['placeholder' => '--'],
            'pluginOptions' => [
              'allowClear' => true,
              'width' => '100px',
            ],
          ]),
          'value' => function ($data) {
            switch ($data->status) {
              case '1':
                $status = '<span class="label label-warning">Waiting Approval</span>';
                break;
              case '2':
                $status = '<span class="label label-danger">Rejected</span>';
                break;
              case '3':
                $status = '<span class="label label-success">Approved</span>';
                break;
              case '4':
                $status = '<span class="label label-info">Re Opened</span>';
                break;

              default:
                $status = '';
                break;
            }
            return $status;
          }

        ],
        [
          'label' => 'Evidence',
          'format' => 'raw',
          'value' => function ($data) {
            return ($data->evidence) ? Html::a('<i class="fa fa-download"></i> Download', ['/app/assets/upload/holdjob/' . $data->evidence], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted']) : '-';
          }

        ],
        'remarks',

        [
          'class' => 'yii\grid\ActionColumn',
          'contentOptions' => ['style' => 'min-width: 100px;'],
          'template' => '<div class="btn-group pull-right">' . $action . '</div>',
          'buttons' => [
            'view' => function ($url, $model, $key) {
              $btn = Html::button('<i class="fa fa-eye" style="font-size:12pt;"></i>', [
                'value' => Yii::$app->urlManager->createUrl('request-hold-job/view?id=' . $model->id),
                'class' => 'btn btn-sm btn-default view-hold-job-modal-click',
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'title' => 'Views Detail'
              ]);
              return $btn;
            },
            'update' => function ($url, $model, $key) {
              if ($model->jo->status_rekrut == 2 or Yii::$app->check->checkstatuscr($model->recruitreqid) || $model->jo->is_hold_jobs != 2) {
                $disabled = true;
              } else {
                $totalhired = Yii::$app->check->checkJohired($model->recruitreqid, 2);
                if ($totalhired < $model->jo->jumlah) {
                  $disabled = false;
                } else {
                  $disabled = true;
                }
              }
              $button = Html::button('<i class="fa fa-gear" style="font-size:12pt;"></i>', [
                'value' => Yii::$app->urlManager->createUrl('request-hold-job/update?id=' . $model->id),
                'class' => 'btn btn-sm btn-warning hold-job-modal-click',
                'disabled' => $disabled,
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'title' => 'Request Hold Job Order',
              ]);
              return $button;
            },
            'approve' => function ($url, $model, $key) {
              if ($model->status == 1 or $model->status ==  2) {
                $disabled = true;
                if ($model->status == 1 and (Yii::$app->user->identity->role == 10 or Yii::$app->user->identity->role == 16 || Yii::$app->user->identity->role == 1)) {
                  $disabled = false;
                }
              } else {
                $disabled = true;
              }
              $btn = Html::button('<i class="fa fa-gavel" style="font-size:12pt;"></i>', [
                'value' => Yii::$app->urlManager->createUrl('request-hold-job/approve?id=' . $model->id), //<---- here is where you define the action that handles the ajax request
                'class' => 'btn btn-sm btn-info approve-hold-job-modal-click',
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