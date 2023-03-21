<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use app\models\Masterstatusprocess;
use app\models\Userinterview;
use app\models\Interviewform;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Userinterviewsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User interview';
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
  'header' => '<h4 class="modal-title">User Interview Confirmation</h4>',
  'id' => 'confirmuint-modal',
  'size' => 'modal-md'
]);

echo "<div id='confirmuint'></div>";

Modal::end();
Modal::begin([
  'header' => '<h4 class="modal-title">User Interview Process</h4>',
  'id' => 'uintproc-modal',
  'size' => 'modal-lg',
  'clientOptions' => ['backdrop' => 'static', 'keyboard' => false]
]);

echo "<div id='uintproc'></div>";

Modal::end();


if (Yii::$app->user->isGuest) {
  $role = null;
} else {
  // $userid = Yii::$app->user->identity->id;
  $role = Yii::$app->user->identity->role;
}
if (Yii::$app->utils->permission($role, 'm11') && Yii::$app->utils->permission($role, 'm12')) {
  $action = '{download}{confirmuint}{uintproc}';
} elseif (Yii::$app->utils->permission($role, 'm11')) {
  $action = '{confirmuint}';
} elseif (Yii::$app->utils->permission($role, 'm12')) {
  $action = '{uintproc}';
} else {
  $action = ' ';
}
?>
<div class="userinterview-index box box-default">

  <div class="box-body table-responsive">
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <?= GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'layout' => "{items}\n{summary}\n{pager}",
      'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        [
          'label' => 'Invitation Number',
          'contentOptions' => ['style' => 'width: 100px;'],
          'format' => 'raw',
          'value' => function ($data) {
            $btn = Html::button($data->reccandidate->invitationnumber, [
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
            $btn = Html::button($data->userprofile->fullname, [
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
        // [
        //   'label' => 'Job Function',
        //   // 'attribute' => 'jobfunc',
        //   // 'contentOptions'=>['style'=>'width: 150px;'],
        //   'format' => 'html',
        //   'value'=>function ($data) {
        //
        //     return (is_numeric($data->reccandidate->recrequest->jabatan)) ? $data->reccandidate->recrequest->jobfunc->name_job_function : $data->reccandidate->recrequest->jabatan;
        // }
        //
        // ],
        [
          'label' => 'Jabatan (SAP)',
          // 'attribute' => 'jabatansap',
          'format' => 'html',
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
          'contentOptions' => ['style' => 'width: 100px;'],
          'format' => 'html',
          'value' => function ($data) {

            $ret = null;

            if (isset($data->reccandidate->recrequest->city))
              $ret = ($data->reccandidate->recrequest->city) ? $data->reccandidate->recrequest->city->city_name : "";

            return $ret;
          }

        ],
        [
          'attribute' => 'scheduledate',
          'format' => 'html',
          'value' => function ($data) {

            return Yii::$app->utils->indodate($data->scheduledate) . ' ' . date("H:i", strtotime($data->scheduledate));
          }

        ],
        [
          'attribute' => 'date',
          'format' => 'html',
          'value' => function ($data) {

            return ($data->date) ? Yii::$app->utils->indodate($data->date) : '-';
          }

        ],
        'masteroffice.officename',
        [
          'label' => 'Room',
          'contentOptions' => ['style' => 'width: 150px;'],
          'format' => 'html',
          'value' => function ($data) {

            return ($data->roomid != null) ? Yii::$app->utils->ordinal($data->masterroom->floor) . ' Floor, ' . $data->masterroom->room . ' Room' : ' ';
          }

        ],
        [
          'label' => 'PIC User Interview',
          'contentOptions' => ['style' => 'width: 100px;'],
          'format' => 'html',
          'value' => function ($data) {

            return ($data->pic) ? $data->userpic->name : '';
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
          'contentOptions' => ['style' => 'min-width: 150px;'],
          'template' => '<div class="btn-group pull-right">' . $action . '</div>',
          'buttons' => [
            'download' => function ($url, $model) {
              $cekforminterview = Interviewform::find()->where(['interviewid' => $model->id])->one();
              if ($cekforminterview) {
                $disabled = false;
              } else {
                if ($model->documentinterview) {
                  $disabled = false;
                } else {
                  $disabled = true;
                }
              }
              $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
              $randChar = '';

              for ($p = 0; $p < 7; $p++) {
                $randChar .= $characters[mt_rand(0, strlen($characters) - 1)];
              }
              if ($model->documentinterview) {
                return Html::a('<i class="fa fa-download" style="font-size:12pt;"></i>', ['/app/assets/upload/documentinterview/' . $model->documentinterview . '?' . $randChar], ['class' => 'btn btn-sm btn-primary', 'disabled' => $disabled, 'data-toggle' => 'tooltip', 'title' => 'Download', 'target' => '_blank']);
              } else {
                return Html::a('<i class="fa fa-download" style="font-size:12pt;"></i>', ['downloadinterviewform', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary', 'disabled' => $disabled, 'data-toggle' => 'tooltip', 'title' => 'Download', 'target' => '_blank']);
              }
            },
            'confirmuint' => function ($url, $model, $key) {
              $cekinterview = Userinterview::find()->where(['status' => 1, 'date' => date('Y-m-d'), 'userid' => $model->userid])->one();
              if ($model->status > 1) {
                $disabled = true;
              } else {
                ($cekinterview == null) ? $disabled = false : $disabled = true;
              }
              $btn = Html::button('<i class="fa fa-child" style="font-size:12pt;"></i>', [
                'value' => Yii::$app->urlManager->createUrl('userinterview/update?id=' . $model->id), //<---- here is where you define the action that handles the ajax request
                'class' => 'btn btn-sm btn-default confirmuint-modal-click',
                'disabled' => $disabled,
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'title' => 'Confirmation'
              ]);
              return $btn;
            },
            'uintproc' => function ($url, $model, $key) {
              // (Yii::$app->chproc->interview($model->userid,$model->id) == 3 )?$disabled = false : $disabled = true;
              ($model->status == 1) ? $disabled = false : $disabled = true;

              if (Yii::$app->user->identity->username == '9103005') $disabled = false;

              $btn = Html::button('<i class="fa fa-tags" style="font-size:12pt;"></i>', [
                'value' => Yii::$app->urlManager->createUrl('userinterview/uintproc?id=' . $model->id), //<---- here is where you define the action that handles the ajax request
                'class' => 'btn btn-sm btn-primary uintproc-modal-click',
                'disabled' => $disabled,
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'title' => 'Process'
              ]);
              return $btn;
            }


          ]
        ],
      ],
    ]); ?>
  </div>
</div>