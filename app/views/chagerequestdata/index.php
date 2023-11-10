<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\select2\Select2;
use app\models\Masterstatuscr;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Chagerequestdatasearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Change Request Data';
$this->params['breadcrumbs'][] = $this->title;
Modal::begin([
  'header' => '<h4 class="modal-title">View Change Request Data</h4>',
  'id' => 'crdata-modal',
  'size' => 'modal-lg'
]);

echo "<div id='crdatatview'></div>";

Modal::end();
Modal::begin([
  'header' => '<h4 class="modal-title">Approve Change Request Data</h4>',
  'id' => 'approvecrdata-modal',
  'size' => 'modal-lg'
]);

echo "<div id='approvecrdatatview'></div>";

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
if (Yii::$app->utils->permission($role, 'm52')) {
  $actionview = '{view}';
}
if (Yii::$app->utils->permission($role, 'm54')) {
  $actionupdate = '{update}';
}
if (Yii::$app->utils->permission($role, 'm55')) {
  $actiondelete = '{delete}';
}
if (Yii::$app->utils->permission($role, 'm56')) {
  $actionapprove = '{approve}';
}
$action = $actionview . $actionupdate . $actiondelete . $actionapprove;

// var_dump($action);die;
?>
<div class="chagerequestdata-index box box-default">
  <?php if (Yii::$app->utils->permission($role, 'm53')) : ?>
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

        [
          'label' => 'Name',
          'attribute' => 'fullname',
          'format' => 'html',
          'value' => function ($data) {
            // return $data->fullname;
            return ($data->userprofile) ? $data->userprofile->fullname : "<i class='text-red'>not set</i>";
          }

        ],
        
        'perner',
        // 'createtime',
        // 'updatetime',
        // 'approvedtime',
        [
          'label' => 'Created By',
          'attribute' => 'createduser',
          'format' => 'html',
          'value' => function ($data) {

            return ($data->createduser) ? $data->createduser->name : "";
          }

        ],
        // 'updatedby',
        // 'approvedby',
        [
          'label' => 'Approver',
          // 'attribute' => 'approveduser',
          'format' => 'html',
          'value' => function ($data) {

            return ($data->approveduser) ? $data->approveduser->name : "";
          }

        ],

        [
          'attribute' => 'status',
          'contentOptions' => ['style' => 'width: 100px;'],
          'format' => 'html',
          'filter' => \kartik\select2\Select2::widget([
            'model' => $searchModel,
            'attribute' => 'status',
            'data' => ArrayHelper::map(Masterstatuscr::find()->asArray()->all(), 'id', 'statusname'),
            'options' => ['placeholder' => '--'],
            'pluginOptions' => [
              'allowClear' => true,
              'width' => '120px',
            ],
          ]),
          'value' => function ($data) {
            // return $data->status;
            if ($data->status == 1) {
              $label = 'label-danger';
            } elseif ($data->status == 2 or $data->status == 3) {
              $label = 'label-warning';
            } elseif ($data->status == 4) {
              $label = 'label-success';
            } else {
              $label = 'label-danger';
            }
            return '<span class="label ' . $label . '">' . $data->statusprocess->statusname . '</span>';
          }

        ],

        'remarks',
        [
          'class' => 'yii\grid\ActionColumn',
          'contentOptions' => ['style' => 'min-width: 200px;'],
          'template' => '<div class="btn-group pull-right">' . $action . '</div>',
          'buttons' => [
            'view' => function ($url, $model, $key) {
              if ($model->status == 1 && $model->perner == null) {
                $disabled = true;
              } else {
                $disabled = false;
              }
              $btn = Html::button('<i class="fa fa-eye" style="font-size:12pt;"></i>', [
                'value' => Yii::$app->urlManager->createUrl('chagerequestdata/view?id=' . $model->id),
                'class' => 'btn btn-sm btn-default viewcrdata-modal-click',
                'disabled' => $disabled,
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'title' => 'Views Detail'
              ]);
              return $btn;
            },
            'approve' => function ($url, $model, $key) {
              if ($model->status ==  2) {
                $disabled = false;
              } else {
                $disabled = true;
              }
              $btn = Html::button('<i class="fa fa-gavel" style="font-size:12pt;"></i>', [
                'value' => Yii::$app->urlManager->createUrl('chagerequestdata/approve?id=' . $model->id . '&userid=' . $model->userid), //<---- here is where you define the action that handles the ajax request
                'class' => 'btn btn-sm btn-info approvecr-modal-click',
                'disabled' => $disabled,
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'title' => 'Approve'
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