<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use app\models\Transrincian;
use app\models\Hiring;
use app\models\Mastercity;
use app\models\Masterstatuscandidate;
use app\models\Recruitmentcandidate;
use app\models\Sapjob;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Recruitmentcandidatesearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Recruitment Candidate';
$this->params['breadcrumbs'][] = $this->title;
$url = \yii\helpers\Url::to(['transrincian/recreqlist']);
$recruitreqs = empty($model->recruitreqid) ? '' : Transrincian::findOne($model->recruitreqid)->nojo;
Modal::begin([
  'header' => '<h4 class="modal-title">View Profile</h4>',
  'id' => 'profileviewshort-modal',
  'size' => 'modal-lg'
]);

echo "<div id='profileviewshortview'></div>";

Modal::end();
Modal::begin([
  'header' => '<h4 class="modal-title">View Recruitment Request</h4>',
  'id' => 'recreq-modal',
  'size' => 'modal-lg'
]);

echo "<div id='recreqview'></div>";

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
  // $userid = Yii::$app->user->identity->id;
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
<div class="recruitmentcandidate-index box box-default">
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
              'value' => Yii::$app->urlManager->createUrl('userprofile/viewshort?userid=' . $data->userid), //<---- here is where you define the action that handles the ajax request
              'class' => 'btn btn-link profileviewshort-modal-click',
              'style' => 'padding:0px;',
              'data-toggle' => 'tooltip',
              'data-placement' => 'bottom',
              'title' => 'View Profile detail'
            ]);
            return $btn;
          }

        ],
        // 'userdata.email',
        'userdata.mobile',

        // 'createtime',
        // 'updatetime',
        [

          'label' => 'Recruitment Request',
          'attribute' => 'nojo',
          'contentOptions' => ['style' => 'min-width: 180px;'],
          'format' => 'raw',
          // 'filter' => \kartik\select2\Select2::widget([
          //   'model' => $searchModel,
          //   'attribute' => 'nojo',
          //   'initValueText' => empty($searchModel->nojo) ? '' : Transrincian::findOne($searchModel->nojo)->nojo, // set the initial display text
          //   'options' => ['placeholder' => '--'],
          //   'pluginOptions' => [
          //     'allowClear' => true,
          //     'minimumInputLength' => 3,
          //     'language' => [
          //       'errorLoading' => new \yii\web\JsExpression("function () { return 'Waiting for results...'; }"),
          //     ],
          //     'ajax' => [
          //       'url' => $url,
          //       'dataType' => 'json',
          //       'data' => new \yii\web\JsExpression('function(params) { return {q:params.term}; }'),
          //     ],
          //     'escapeMarkup' => new \yii\web\JsExpression('function (markup) { return markup; }'),
          //     'templateResult' => new \yii\web\JsExpression('function(r) { return r.nojo; }'),
          //     // 'templateSelection' => new \yii\web\JsExpression('function (r) { return r.nojo; }'),
          //   ],
          // ]),
          'value' => function ($data) {
            if ($data->recrequest) {
              $btn = Html::button($data->recrequest->nojo, [
                'value' => Yii::$app->urlManager->createUrl('transrincian/viewshort?id=' . $data->recruitreqid), //<---- here is where you define the action that handles the ajax request
                'class' => 'btn btn-link recreq-modal-click',
                'style' => 'padding:0px;',
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'title' => 'View Recruitment Request Detail'
              ]);
            } else {
              $btn = '';
            }
            return $btn;
          }

        ],
        [
          'label' => 'Jabatan (SAP)',
          'attribute' => 'jabatans',
          'format' => 'html',
          // add by kaha 24/9/2023
          'filter' => \kartik\select2\Select2::widget([
            'model' => $searchModel,
            'attribute' => 'jabatans',
            'data' => ArrayHelper::map(Sapjob::find()->asArray()->all(), 'value2', 'value2'),
            'options' => ['placeholder' => '--'],
            'pluginOptions' => [
              'allowClear' => true,
              // 'width' => '120px',
            ],
          ]),
          // change value relational by kaha
          'value' => function ($data) {
            // return ($data->recrequest->hire_jabatan_sap)? ((is_numeric($data->recrequest->hire_jabatan_sap))?$data->recrequest->jabatansap->value2:'-'):'-';
            if ($data->recrequest) {
              if (is_numeric($data->recrequest->hire_jabatan_sap)) {
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
          'value' => 'recrequest.city.city_name'
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
          'attribute' => 'typeinterview',
          'contentOptions' => ['style' => 'width: 100px;'],
          'format' => 'html',
          'filter' => \kartik\select2\Select2::widget([
            'model' => $searchModel,
            'attribute' => 'typeinterview',
            'data' => ['1' => 'Invite', '2' => 'Walk In'],
            'options' => ['placeholder' => '--'],
            'pluginOptions' => [
              'allowClear' => true,
              'width' => '100px',
            ],
          ]),
          'value' => function ($data) {
            return ($data->typeinterview == 1) ? 'Invite' : 'Walk in';
          }
          
        ],
        
        [
          'attribute' => 'method',
          'contentOptions' => ['style' => 'width: 80px;'],
          'filter' => \kartik\select2\Select2::widget([
            'model' => $searchModel,
            'attribute' => 'typeinterview',
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
              $cekhiring = Hiring::find()->where(['userid' => $model->userid])->one();
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
              // (Yii::$app->chproc->interview($model->userid,$model->id) == 3 )?$disabled = false : $disabled = true;
              $cekcandidate = Recruitmentcandidate::find()->where(['status' => 4, 'userid' => $model->userid, 'recruitreqid' => $model->recruitreqid, 'id' => $model->id])->one();
              $cekhiring = Hiring::find()->where(
                "userid = " . $model->userid . " AND recruitreqid = " . $model->recruitreqid . " AND
                statushiring <> 5 AND
                statushiring <> 7"
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
                'value' => Yii::$app->urlManager->createUrl('recruitmentcandidate/changejo?userid=' . $model->userid . '&reccanid=' . $model->id), //<---- here is where you define the action that handles the ajax request
                'class' => 'btn btn-sm btn-info changejo-modal-click',
                'disabled' => $disabled,
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'title' => 'Change JO'
              ]);
              return $btn;
            },

            'invite' => function ($url, $model, $key) {
              // (Yii::$app->chproc->interview($model->userid,$model->id) == 3 )?$disabled = false : $disabled = true;
              $cekcandidate = Recruitmentcandidate::find()->where(['status' => 4, 'userid' => $model->userid])->one();
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
                'value' => Yii::$app->urlManager->createUrl('recruitmentcandidate/invite?userid=' . $model->userid . '&reccanid=' . $model->id), //<---- here is where you define the action that handles the ajax request
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