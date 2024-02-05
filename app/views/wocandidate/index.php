<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use app\models\Transrincian;
use app\models\WoHiring;
use app\models\Mastercity;
use app\models\Masterstatuscandidate;
use app\models\WoRecruitmentCandidate;
use app\models\Sapjob;
use app\models\WorkOrder;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\WoRecruitmentCandidatesearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Recruitment Candidate';
$this->params['breadcrumbs'][] = $this->title;
$url = \yii\helpers\Url::to(['transrincian/recreqlist']);
$recruitreqs = empty($model->wo_id) ? '' : WorkOrder::findOne($model->wo_id)->nojo;
Modal::begin([
  'header' => '<h4 class="modal-title">View Profile</h4>',
  'id' => 'profileviewshort-modal',
  'size' => 'modal-lg'
]);
echo "<div id='profileviewshortview'></div>";
Modal::end();

Modal::begin([
    'header' => '<h4 class="modal-title">View Work Order</h4>',
    'id' => 'viewworkorder-modal',
    'size' => 'modal-xl'
]);
echo "<div id='viewworkorder'></div>";
Modal::end();

Modal::begin([
  'header' => '<h4 class="modal-title">Change Recruitment Request</h4>',
  'id' => 'changejo-modal',
  'size' => 'modal-lg'
]);
echo "<div id='changejoview'></div>";
Modal::end();

Modal::begin([
  'header' => '<h4 class="modal-title">Invite For Recruitment Process</h4>',
  'id' => 'invite-modal',
  'size' => 'modal-lg',
  // 'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
]);

echo "<div id='inviteview'></div>";

Modal::end();
if (Yii::$app->user->isGuest) {
  $role = null;
} else {
  // $user_id = Yii::$app->user->identity->id;
  $role = Yii::$app->user->identity->role;
}
if (Yii::$app->utils->permission($role, 'm3') && Yii::$app->utils->permission($role, 'm46') && Yii::$app->utils->permission($role, 'm47')) {
  $action = '{invite}{cancel}{changejo}';
} elseif (Yii::$app->utils->permission($role, 'm3')) {
  $action = '{invite}';
} elseif (Yii::$app->utils->permission($role, 'm46')) {
  $action = '{cancel}';
} elseif (Yii::$app->utils->permission($role, 'm47')) {
  $action = '{changejo}';
} else {
  $action = ' ';
}

?>
<div class="wocandidate-index box box-default">
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
          'label' => 'Full Name',
          'attribute' => 'fullname',
          // 'contentOptions'=>['style'=>'width: 50px;'],
          'format' => 'raw',
          'value' => function ($data) {
            $btn = Html::button(($data->userprofile) ? $data->userprofile->fullname : '-', [
              'value' => Yii::$app->urlManager->createUrl('userprofile/viewshort?userid=' . $data->user_id), //<---- here is where you define the action that handles the ajax request
              'class' => 'btn btn-link profileviewshort-modal-click',
              'style' => 'padding:0px;',
              'data-toggle' => 'tooltip',
              'data-placement' => 'bottom',
              'title' => 'View Profile detail'
            ]);
            return $btn;
          }

        ],
        'userdata.mobile',
        [

          'label' => 'Recruitment Request',
          'attribute' => 'wo_number',
          'contentOptions' => ['style' => 'min-width: 180px;'],
          'format' => 'raw',
          'value' => function ($data) {
            if ($data->wo_id) {
              $btn = Html::button($data->workorder->wo_number, [
                'value' => Yii::$app->urlManager->createUrl('workorder/view?id=' . $data->wo_id), //<---- here is where you define the action that handles the ajax request
                'class' => 'btn btn-link viewworkorder-modal-click',
                'style' => 'padding:0px;',
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'title' => 'View Workorder Detail'
              ]);
            } else {
              $btn = '';
            }
            return $btn;
          }

        ],
        [
          'label' => 'Jabatan (SAP)',
          'attribute' => 'job',
          'format' => 'html',
          // add by kaha 24/9/2023
          'filter' => \kartik\select2\Select2::widget([
            'model' => $searchModel,
            'attribute' => 'job',
            'data' => ArrayHelper::map(Sapjob::find()->asArray()->all(), 'value2', 'value2'),
            'options' => ['placeholder' => '--'],
            'pluginOptions' => [
              'allowClear' => true,
              // 'width' => '120px',
            ],
          ]),
          // change value relational by kaha
          'value' => function ($data) {
            if ($data->workorder) {
              if (is_numeric($data->workorder->job_code)) {
                if ($data->workorder->jobsap) {
                  return $data->workorder->jobsap->jabatansap;
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
          'label' => 'City',
          'attribute' => 'city',
          'contentOptions' => ['style' => 'width: 150px;'],
          'format' => 'html',
          'filter' => \kartik\select2\Select2::widget([
            'model' => $searchModel,
            'attribute' => 'city',
            'data' => ArrayHelper::map(Mastercity::find()->asArray()->all(), 'kota', 'kota'),
            'options' => ['placeholder' => '--'],
            'pluginOptions' => [
              'allowClear' => true,
              // 'width' => '120px',
            ],
          ]),
          'value' => 'workorder.city.city_name'
        ],

        [
          'attribute' => 'status',
          'contentOptions' => ['style' => 'width: 100px;'],
          'format' => 'html',
          'filter' => \kartik\select2\Select2::widget([
            'model' => $searchModel,
            'attribute' => 'status',
            'data' => ArrayHelper::map(Masterstatuscandidate::find()->asArray()->all(), 'id', 'statusname'),
            'options' => ['placeholder' => '--'],
            'pluginOptions' => [
              'allowClear' => true,
              'width' => '100px',
            ],
          ]),
          'value' => function ($data) {
            if ($data->status == 0) {
              $label = 'label-warning';
            } elseif ($data->status == 4 or $data->status == 5 or $data->status == 6 or $data->status == 7 or $data->status == 12 or $data->status == 13 or $data->status == 14 or $data->status == 15) {
              $label = 'label-success';
            } elseif ($data->status == 8 or $data->status == 9 or $data->status == 10 or $data->status == 16 or $data->status == 17 or $data->status == 18 or $data->status == 19 or $data->status == 24) {
              $label = 'label-danger';
            } else {
              $label = 'label-primary';
            }
            return '<span class="label ' . $label . '">' . $data->statuscandidate->statusname . '</span>';
          }

        ],
        // 'invitationnumber',
        [
          'attribute' => 'type_interview',
          'contentOptions' => ['style' => 'width: 100px;'],
          'format' => 'html',
          'filter' => \kartik\select2\Select2::widget([
            'model' => $searchModel,
            'attribute' => 'type_interview',
            'data' => ['1' => 'Invite', '2' => 'Walk In'],
            'options' => ['placeholder' => '--'],
            'pluginOptions' => [
              'allowClear' => true,
              'width' => '100px',
            ],
          ]),
          'value' => function ($data) {
            return ($data->type_interview == 1) ? 'Invite' : 'Walk in';
          }
          
        ],
        
        [
          'attribute' => 'method',
          'contentOptions' => ['style' => 'width: 80px;'],
          'filter' => \kartik\select2\Select2::widget([
            'model' => $searchModel,
            'attribute' => 'type_interview',
            'data' => ['1' => 'Offline', '2' => 'Online'],
            'options' => ['placeholder' => '--'],
            'pluginOptions' => [
              'allowClear' => true,
              'width' => '100px',
            ],
          ]),
          'value' => function ($data) {
            return ($data->method == 1) ? 'Offline' : 'Online';
          }
        ],

        [
          'class' => 'yii\grid\ActionColumn',
          'contentOptions' => ['style' => 'min-width: 150px;'],
          'template' => '<div class="btn-group pull-right">' . $action . '</div>',
          'buttons' => [

            'update' => function ($url, $model) {
              return Html::a('<i class="fa fa-pencil" style="font-size:12pt;"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-sm btn-default', 'data-toggle' => 'tooltip', 'title' => 'Update']);
            },

            'cancel' => function ($url, $model) {
              $cekhiring = WoHiring::find()->where(['user_id' => $model->user_id])->one();
              if ($model->status == 4) {
                if ($cekhiring) {
                  $disabled = true;
                } else {
                  $disabled = false;
                  return Html::a(
                    '<i class="fa fa-user-times" style="font-size:12pt;"></i>',
                    ['cancel', 'id' => $model->id],
                    [
                      'class' => 'btn btn-sm btn-danger',
                      // 'disabled' => $disabled,
                      'data-toggle' => 'tooltip',
                      'data-placement' => 'bottom',
                      'title' => 'Cancel',
                      'data' => [
                        'confirm' => 'Are you sure you want to cacel this Candidate?',
                        'method' => 'post',
                      ]
                    ]
                  );
                }
              } else {
                $disabled = true;
              }
            },
            'changejo' => function ($url, $model, $key) {
              // (Yii::$app->chproc->interview($model->user_id,$model->id) == 3 )?$disabled = false : $disabled = true;
              $cekcandidate = WoRecruitmentCandidate::find()->where(['status' => 4, 'user_id' => $model->user_id, 'wo_id' => $model->wo_id, 'id' => $model->id])->one();
              $cekhiring = WoHiring::find()->where(
                "user_id = " . $model->user_id . " AND wo_id = " . $model->wo_id . " AND
                hiring_status <> 5 AND
                hiring_status <> 7"
              )->one();
              // if ($model->status == 4) {
              //   if ($cekhiring) {
              //     $disabled = true;
              //   } else {
              //     $disabled = false;
              //   }
              // } else {
              //   $disabled = true;
              // }
              if ($model->status == 4 || $cekcandidate) {
                if ($cekhiring) {
                  $disabled = true;
                } else {
                  $disabled = false;
                }
              } else {
                $disabled = true;
              }

              $btn = Html::button('<i class="fa fa-retweet" style="font-size:12pt;"></i>', [
                'value' => Yii::$app->urlManager->createUrl('wocandidate/changejo?user_id=' . $model->user_id . '&reccanid=' . $model->id), //<---- here is where you define the action that handles the ajax request
                'class' => 'btn btn-sm btn-info changejo-modal-click',
                'disabled' => $disabled,
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'title' => 'Change JO'
              ]);
              return $btn;
            },

            'invite' => function ($url, $model, $key) {
              $cekcandidate = WoRecruitmentCandidate::find()->where(['status' => 4, 'user_id' => $model->user_id])->one();
              if ($cekcandidate) {
                $disabled = true;
              } else {
                switch ($model->status) {
                  case 0:
                    $disabled = false;
                    break;
                  case 5:
                    $disabled = false;
                    break;
                  case 6:
                    $disabled = false;
                    break;
                  case 7:
                    $disabled = false;
                    break;
                  case 12:
                    $disabled = false;
                    break;
                  case 13:
                    $disabled = false;
                    break;
                  case 14:
                    $disabled = false;
                    break;
                  case 15:
                    $disabled = false;
                    break;
                  default:
                    $disabled = true;
                }
              }

              $btn = Html::button('<i class="fa fa-send (alias)" style="font-size:12pt;"></i>', [
                'value' => Yii::$app->urlManager->createUrl('wocandidate/invite?user_id=' . $model->user_id . '&reccanid=' . $model->id), //<---- here is where you define the action that handles the ajax request
                'class' => 'btn btn-sm btn-primary invite-modal-click',
                'disabled' => $disabled,
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'title' => 'Invite'
              ]);
              return $btn;
            }
          ]
        ],
      ],
    ]); ?>
  </div>
</div>