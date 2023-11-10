<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use app\models\Masterstatusprocess;
use app\models\Interview;
use app\models\Interviewform;
use app\models\Mastercity;
use app\models\Masteroffice;
use app\models\Sapjob;
use app\models\User;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Interviewsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Interviews';
$this->params['breadcrumbs'][] = $this->title;
Modal::begin([
  'header' => '<h4 class="modal-title">View Profile</h4>',
  'id' => 'profileviewshort-modal',
  'size' => 'modal-lg'
]);

echo "<div id='profileviewshortview'></div>";
Modal::end();

Modal::begin([
  'header' => '<h4 class="modal-title">View Recruitment Candidate detail</h4>',
  'id' => 'reccan-modal',
  'size' => 'modal-md'
]);

echo "<div id='reccanview'></div>";
Modal::end();

Modal::begin([
  'header' => '<h4 class="modal-title">Interview Confirmation</h4>',
  'id' => 'confirm-modal',
  'size' => 'modal-md'
]);

echo "<div id='confirminterview'></div>";
Modal::end();

Modal::begin([
  'header' => '<h4 class="modal-title">Interview Process</h4>',
  'id' => 'intproc-modal',
  'size' => 'modal-lg',
  'clientOptions' => ['backdrop' => 'static', 'keyboard' => false]
]);
echo "<div id='intproc'></div>";
Modal::end();

Modal::begin([
  'header' => '<h4 class="modal-title">Interview Upload</h4>',
  'id' => 'intupload-modal',
  'size' => 'modal-lg',
  'clientOptions' => ['backdrop' => 'static', 'keyboard' => false]
]);
echo "<div id='intupload'></div>";
Modal::end();

if (Yii::$app->user->isGuest) {
  $role = null;
} else {
  // $userid = Yii::$app->user->identity->id;
  $role = Yii::$app->user->identity->role;
}
if (Yii::$app->utils->permission($role, 'm5') && Yii::$app->utils->permission($role, 'm6')) {
  $action = '{download}{confirm}{intproc}{uploadinterview}';
} elseif (Yii::$app->utils->permission($role, 'm5')) {
  $action = '{confirm}';
} elseif (Yii::$app->utils->permission($role, 'm6')) {
  $action = '{intproc}';
} else {
  $action = ' ';
}
?>
<div class="interview-index box box-default">
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
          'label' => 'Invitation Number',
          'contentOptions' => ['style' => 'width: 100px;'],
          'format' => 'raw',
          'value' => function ($data) {
            $btn = Html::button((($data->reccandidate) ? $data->reccandidate->invitationnumber : "n/a"), [
              'value' => Yii::$app->urlManager->createUrl('recruitmentcandidate/view?id=' . $data->recruitmentcandidateid), //<---- here is where you define the action that handles the ajax request
              'class' => 'btn btn-link reccan-modal-click',
              'style' => 'padding:0px;',
              'data-toggle' => 'tooltip',
              'data-placement' => 'bottom',
              'title' => 'View Candidate Detail'
            ]);
            return $btn;
          }
        ],

        [
          'label' => 'Full Name',
          'attribute' => 'fullname',
          'contentOptions' => ['style' => 'width: 100px;'],
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

        [
          'label' => 'Jabatan (SAP)',
          // 'attribute' => 'jabatansap',
          'format' => 'html',
          'filter' => \kartik\select2\Select2::widget([
            'model' => $searchModel,
            'attribute' => 'jabatansap',
            'data' => ArrayHelper::map(Sapjob::find()->asArray()->all(), 'value2', 'value2'),
            'options' => ['placeholder' => '--'],
            'pluginOptions' => [
              'allowClear' => true,
              // 'width' => '120px',
            ],
          ]),
          'value' => function ($data) {

            if ($data->reccandidate->recrequest->hire_jabatan_sap) {
              if (is_numeric($data->reccandidate->recrequest->hire_jabatan_sap)) {
                if ($data->reccandidate->recrequest->jabatansap) {
                  return $data->reccandidate->recrequest->jabatansap->value2;
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
          // 'attribute' => 'city',
          'contentOptions' => ['style' => 'width: 100px;'],
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
          'format' => 'html',
          'value' => function ($data) {

            return ($data->reccandidate) ? (($data->reccandidate->recrequest->city) ? $data->reccandidate->recrequest->city->city_name : "") : '-';
          }
        ],

        [
          'attribute' => 'scheduledate',
          'filter' => DatePicker::widget([
            'model' => $searchModel,
            'attribute' => 'scheduledate',
            'options' => ['placeholder' => 'Date', 'autocomplete' => 'off'],
            'readonly' => false,
            'removeButton' => false,
            'pluginOptions' => [
              'startDate' => '2000-01-01',
              'format' => 'yyyy-mm-dd',
              'todayHighlight' => true
            ]
          ]),
          'format' => 'html',
          'value' => function ($data) {
            return Yii::$app->utils->indodate($data->scheduledate) . ' ' . date("H:i", strtotime($data->scheduledate));
          }
        ],

        [
          'attribute' => 'date',
          'filter' => DatePicker::widget([
            'model' => $searchModel,
            'attribute' => 'date',
            'options' => ['placeholder' => 'Date', 'autocomplete' => 'off'],
            'readonly' => false,
            'removeButton' => false,
            'pluginOptions' => [
              'startDate' => '2000-01-01',
              'format' => 'yyyy-mm-dd',
              'todayHighlight' => true
            ]
          ]),
          'format' => 'html',
          'value' => function ($data) {
            return ($data->date) ? Yii::$app->utils->indodate($data->date) : '-';
          }
        ],

        [
          'label' => 'Office Name',
          // 'attribute' => 'city',
          'contentOptions' => ['style' => 'width: 100px;'],
          'format' => 'html',
          'filter' => \kartik\select2\Select2::widget([
            'model' => $searchModel,
            'attribute' => 'officeid',
            'data' => ArrayHelper::map(Masteroffice::find()->asArray()->all(), 'id', 'officename'),
            'options' => ['placeholder' => '--'],
            'pluginOptions' => [
              'allowClear' => true,
              // 'width' => '120px',
            ],
          ]),
          'value' => function ($data) {
            return ($data->officeid) ? $data->masteroffice->officename : "";
          }
        ],

        [
          'label' => 'Room',
          'contentOptions' => ['style' => 'width: 150px;'],
          'format' => 'html',
          'value' => function ($data) {

            return ($data->roomid != null) ? Yii::$app->utils->ordinal($data->masterroom->floor) . ' Floor, ' . $data->masterroom->room . ' Room' : ' ';
          }
        ],

        [
          'label' => 'PIC Interview',
          'contentOptions' => ['style' => 'width: 150px;'],
          'format' => 'html',
          'filter' => \kartik\select2\Select2::widget([
            'model' => $searchModel,
            'attribute' => 'pic',
            'data' => ArrayHelper::map(User::find()->where('role = 22 OR role = 3 AND status = 10')->asArray()->all(), 'id', 'name'),
            'options' => ['placeholder' => '--'],
            'pluginOptions' => [
              'allowClear' => true,
              // 'width' => '120px',
            ],
          ]),
          'value' => function ($data) {
            return ($data->pic != null) ? $data->userpic->name : '';
          }
        ],

        [
          'attribute' => 'status',
          'contentOptions' => ['style' => 'width: 100px;'],
          'format' => 'html',
          'filter' => \kartik\select2\Select2::widget([
            'model' => $searchModel,
            'attribute' => 'status',
            'data' => ArrayHelper::map(Masterstatusprocess::find()->asArray()->all(), 'id', 'statusname'),
            'options' => ['placeholder' => '--'],
            'pluginOptions' => [
              'allowClear' => true,
              'width' => '120px',
            ],
          ]),
          'value' => function ($data) {
            if ($data->status == 0) {
              $label = 'label-warning';
            } elseif ($data->status == 2) {
              $label = 'label-success';
            } elseif ($data->status == 3) {
              $label = 'label-danger';
            } else {
              $label = 'label-primary';
            }
            return '<span class="label ' . $label . '">' . $data->statusprocess->statusname . '</span>';
          }
        ],


        // 'recruitmentcandidateid',


        [
          'class' => 'yii\grid\ActionColumn',
          'contentOptions' => ['style' => 'min-width: 170px;'],
          'template' => '<div class="btn-group pull-right">' . $action . '</div>',
          'buttons' => [
            'download' => function ($url, $model) {
              // $cekforminterview = Interviewform::find()->where(['interviewid' => $model->id])->one();
              // if ($cekforminterview) {
              //   $disabled = false;
              // } else {
              //   $disabled = true;
              // }
              ($model->status == 2) ? $disabled = false : $disabled = true;
              if ($model->documentinterview) {
                $btn = Html::a('<i class="fa fa-download" style="font-size:12pt;"></i>', ['/app/assets/upload/documentinterview/' . $model->documentinterview], ['class' => 'btn btn-sm btn-primary', 'disabled' => $disabled, 'data-toggle' => 'tooltip', 'title' => 'Download', 'target' => '_blank']); 
              } else {
                $btn = Html::a('<i class="fa fa-download" style="font-size:12pt;"></i>', ['downloadinterviewform', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary', 'disabled' => $disabled, 'data-toggle' => 'tooltip', 'title' => 'Download', 'target' => '_blank']); 
              }
              return $btn;
            },
            'confirm' => function ($url, $model, $key) {
              $cekinterview = Interview::find()->where(['status' => 1, 'date' => date('Y-m-d'), 'userid' => $model->userid])->one();
              if ($model->status > 1) {
                $disabled = true;
              } else {
                ($cekinterview == null) ? $disabled = false : $disabled = true;
              }
              $btn = Html::button('<i class="fa fa-child" style="font-size:12pt;"></i>', [
                'value' => Yii::$app->urlManager->createUrl('interview/update?id=' . $model->id), //<---- here is where you define the action that handles the ajax request
                'class' => 'btn btn-sm btn-default confirm-modal-click',
                'disabled' => $disabled,
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'title' => 'Confirmation'
              ]);
              return $btn;
            },
            'intproc' => function ($url, $model, $key) {
              // (Yii::$app->chproc->interview($model->userid,$model->id) == 3 )?$disabled = false : $disabled = true;
              ($model->status == 1) ? $disabled = false : $disabled = true;
              $btn = Html::button('<i class="fa fa-tags" style="font-size:12pt;"></i>', [
                'value' => Yii::$app->urlManager->createUrl('interview/intproc?id=' . $model->id), //<---- here is where you define the action that handles the ajax request
                'class' => 'btn btn-sm btn-primary intproc-modal-click',
                'disabled' => $disabled,
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'title' => 'Process'
              ]);
              return $btn;
            },
            'uploadinterview' => function ($url, $model, $key) {
              if ($model->status == 1) {
                if ($model->documentinterview) {
                  $disabled = true;
                } else {
                  $disabled = false;
                }
              } else {
                $disabled = true;
              }
              $btn = Html::button('<i class="fa fa-upload" style="font-size:12pt;"></i>', [
                'value' => Yii::$app->urlManager->createUrl('interview/intupload?id=' . $model->id), //<---- here is where you define the action that handles the ajax request
                'class' => 'btn btn-sm btn-danger intupload-modal-click',
                'disabled' => $disabled,
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'title' => 'Upload Interview Manual'
              ]);
              return $btn;
            },


          ]
        ],
      ],
    ]); ?>
  </div>
</div>