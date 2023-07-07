<?php

use app\models\Hiring;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use app\models\Masterstatuscr;
use app\models\Transrincian;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use linslin\yii2\curl;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Changecanceljoinsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cancel Join';
$this->params['breadcrumbs'][] = $this->title;
Modal::begin([
  'header' => '<h4 class="modal-title">View Change Cancel Join</h4>',
  'id' => 'viewccanceljoin-modal',
  'size' => 'modal-lg'
]);
echo "<div id='viewccanceljoin-view'></div>";
Modal::end();

Modal::begin([
  'header' => '<h4 class="modal-title">Approve Change Cancel Join</h4>',
  'id' => 'approvecrcanceljoin-modal',
  'size' => 'modal-lg'
]);
echo "<div id='approvecrcanceljoin-view'></div>";
Modal::end();

Modal::begin([
  'header' => '<h4 class="modal-title">Confirmation Cancel Join</h4>',
  'id' => 'confirmcrcanceljoin-modal',
  'size' => 'modal-lg'
]);
echo "<div id='confirmcrcanceljoin-view'></div>";
Modal::end();

if (Yii::$app->user->isGuest) {
  $role = null;
} else {
  // $userid = Yii::$app->user->identity->id;
  $role = Yii::$app->user->identity->role;
}
$actionview = '';
$actionupdate = '';
$actiondelete = '';
$actionapprove = '';
$actionconfirmation = '';
if (Yii::$app->utils->permission($role, 'm88')) {
  $actionview = '{view}';
}
if (Yii::$app->utils->permission($role, 'm90')) {
  $actionupdate = '{update}';
}
if (Yii::$app->utils->permission($role, 'm91')) {
  $actiondelete = '{delete}';
}
if (Yii::$app->utils->permission($role, 'm92')) {
  $actionapprove = '{approve}';
}
if (Yii::$app->user->identity->username == '9802618' || Yii::$app->user->identity->username == '9103005' || Yii::$app->user->identity->username == "seysi" || Yii::$app->user->identity->username == '9610439' || Yii::$app->user->identity->username == '9411677' || Yii::$app->user->identity->username == '8412075') {
  $actionconfirmation = '{confirmation}';
}
$action = $actionview . $actionupdate . $actiondelete . $actionapprove . $actionconfirmation;
?>
<div class="changecanceljoin-index box box-default">
  <?php if (Yii::$app->utils->permission($role, 'm89')) : ?>
    <div class="box-header with-border">
      <?= Html::a('Create', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </div>
  <?php endif; ?>
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
        [
          'label' => 'Name',
          'attribute' => 'fullname',
          'format' => 'html',
          'value' => function ($data) {
            return $data->fullname;
          }
        ],

        [
          'label' => 'Perner',
          'attribute' => 'perner',
          'format' => 'html',
          'value' => function ($data) {
            return $data->perner;
          }
        ],

        [
          'label' => 'No JO',
          'format' => 'html',
          'value' => function ($data) {
            if ($data->userid) {
              $cekhiring = Hiring::find()->where('userid =' . $data->userid . ' and (statushiring = 4 OR statushiring = 6)')->orderBy(["id" => SORT_DESC])->one();
              if ($cekhiring) {
                $getjo = Transrincian::find()->where(['id' => $cekhiring->recruitreqid])->one();
                return ($getjo) ? $getjo->nojo : '-';
              } else {
                return "-";
              }
            }
          }
        ],

        [
          'label' => 'Cancel Date',
          'attribute' => 'canceldate',
          'contentOptions' => ['style' => 'min-width: 100px;'],
          'format' => 'html',
          'value' => function ($data) {
            return $data->canceldate;
          }
        ],

        [
          'label' => 'Created By',
          'attribute' => 'createduser',
          'format' => 'html',
          'value' => function ($data) {

            return ($data->createduser) ? $data->createduser->name : "";
          }
        ],

        [
          'label' => 'Approver',
          'attribute' => 'approveduser',
          'format' => 'html',
          'value' => function ($data) {
            return ($data->approveduser) ? $data->approveduser->name : "-";
            // return "PM";
          }
        ],

        [
          'attribute' => 'status',
          'contentOptions' => ['style' => 'min-width: 200px;'],
          'format' => 'html',
          'filter' => \kartik\select2\Select2::widget([
            'model' => $searchModel,
            'attribute' => 'status',
            'data' => ArrayHelper::map(Masterstatuscr::find()->where('id in (1, 2, 4, 5, 7, 8, 9)')->asArray()->all(), 'id', 'statusname'),
            'options' => ['placeholder' => '--'],
            'pluginOptions' => [
              'allowClear' => true,
            ],
          ]),
          'value' => function ($data) {
            // return $data->status;
            if ($data->status == 1) {
              $label = 'label-danger';
            } elseif ($data->status == 2 or $data->status == 3 or $data->status == 6) {
              $label = 'label-warning';
            } elseif ($data->status == 4 or $data->status == 9) {
              $label = 'label-success';
            } elseif ($data->status == 8) {
              $label = 'label-info';
            } else {
              $label = 'label-danger';
            }
            return '<span class="label ' . $label . '">' . $data->statusprocess->statusname . '</span>';
          }
        ],

        [
          'label' => 'Remarks',
          'attribute' => 'remarks',
          'format' => 'html',
          'value' => function ($data) {
            if ($data->status == 9) {
              $curl = new curl\Curl();
              $getdatapekerjabyperner =  $curl->setPostParams([
                'perner' => $data->perner,
                'token' => 'ish**2019',
              ])
                ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerja');
              $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
              // var_dump($datapekerjabyperner);die;
              if ($datapekerjabyperner == null) {
                return "<b><i>" . $data->remarks . "</i></b><br>" . $data->userremarks . "<br>Proses Selesai";
              } else {
                return "<b><i>" . $data->remarks . "</i></b><br>" . $data->userremarks . "<br>Proses Selesai, Perner belum Dihapus";
              }
            } else {
              return "<b><i>" . $data->remarks . "</i></b><br>" . $data->userremarks . "<br>";
            }
          }
        ],

        [
          'class' => 'yii\grid\ActionColumn',
          'contentOptions' => ['style' => 'min-width: 210px;'],
          'template' => '<div class="btn-group pull-right">' . $action . '</div>',
          'buttons' => [
            'view' => function ($url, $model, $key) {
              if ($model->status == 1 && $model->perner == null) {
                $disabled = true;
              } else {
                $disabled = false;
              }
              $btn = Html::button('<i class="fa fa-eye" style="font-size:12pt;"></i>', [
                'value' => Yii::$app->urlManager->createUrl('changecanceljoin/view?id=' . $model->id),
                'class' => 'btn btn-sm btn-default viewccanceljoin-modal-click',
                'disabled' => $disabled,
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'title' => 'Views Detail'
              ]);
              return $btn;
            },
            'approve' => function ($url, $model, $key) {
              if ($model->status == 2) {
                $disabled = false;
              } else {
                $disabled = true;
              }
              $btn = Html::button('<i class="fa fa-gavel" style="font-size:12pt;"></i>', [
                'value' => Yii::$app->urlManager->createUrl('changecanceljoin/approve?id=' . $model->id), //<---- here is where you define the action that handles the ajax request
                'class' => 'btn btn-sm btn-info approvecrcanceljoin-modal-click',
                'disabled' => $disabled,
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'title' => 'Approve'
              ]);
              return $btn;
            },
            'confirmation' => function ($url, $model, $key) {
              if ($model->status == 8) {
                $disabled = false;
              } else {
                $disabled = true;
              }
              $btn = Html::button('<i class="fa fa-check-square-o" style="font-size:12pt;"></i>', [
                'value' => Yii::$app->urlManager->createUrl('changecanceljoin/confirmcancel?id=' . $model->id), //<---- here is where you define the action that handles the ajax request
                'class' => 'btn btn-sm btn-success confirmcrcanceljoin-modal-click',
                'disabled' => $disabled,
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'title' => 'Confirm'
              ]);
              return $btn;
            },
            'update' => function ($url, $model) {
              if ($model->status < 2 or $model->status == 5 or $model->status == 6) {
                $disabled = false;
                $link = 'update';
              } else {
                $disabled = true;
                $link = '#';
              }
              return Html::a('<i class="fa fa-pencil" style="font-size:12pt;"></i>', [$link, 'id' => $model->id], [
                'class' => 'btn btn-sm btn-default',
                'disabled' => $disabled,
                'data-toggle' => 'tooltip',
                'title' => 'Update'
              ]);
            },
            'delete' => function ($url, $model) {
              ($model->status < 2) ? $disabled = false : $disabled = true;
              if ($model->status < 2) {
                return Html::a('<i class="fa fa-trash" style="font-size:12pt;"></i>', ['delete', 'id' => $model->id], [
                  'class' => 'btn btn-sm btn-danger', 'data-toggle' => 'tooltip', 'title' => 'delete', 'disabled' => $disabled,
                  'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                  ],
                ]);
              } else {
                return Html::a('<i class="fa fa-trash" style="font-size:12pt;"></i>', ['#', 'id' => $model->id], [
                  'class' => 'btn btn-sm btn-danger', 'data-toggle' => 'tooltip', 'title' => 'delete', 'disabled' => $disabled,
                ]);
              }
            }
          ]
        ],
      ],
    ]); ?>
  </div>
</div>