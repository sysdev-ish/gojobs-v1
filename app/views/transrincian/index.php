<?php

use app\models\Mastercity;
use app\models\Saparea;
use app\models\Sapjob;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Transrinciansearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Recruitment Request';
$this->params['breadcrumbs'][] = $this->title;

Modal::begin([
  'header' => '<h4 class="modal-title">Add Candidate</h4>',
  'id' => 'addcandidate2-modal',
  'size' => 'modal-xl',
  'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
  // 'pjaxContainer' => '#addcandidate',
]);

echo "<div id='addcandidateform2'></div>";

Modal::end();
Modal::begin([
  'header' => '<h4 class="modal-title">Stop Job Order</h4>',
  'id' => 'stopjo-modal',
  'size' => 'modal-xl',
  'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
  // 'pjaxContainer' => '#addcandidate',
]);

echo "<div id='stopjoview'></div>";

Modal::end();
if (Yii::$app->user->isGuest) {
  $role = null;
} else {
  // $userid = Yii::$app->user->identity->id;
  $role = Yii::$app->user->identity->role;
}
$actionstop = '';
$actionview = '';
$actionaddcandidate = '';
if (Yii::$app->utils->permission($role, 'm62')) {
  $actionstop = '{stop}';
}
if (Yii::$app->utils->permission($role, 'm1')) {
  $actionview = '{view}';
}
if (Yii::$app->utils->permission($role, 'm63')) {
  $actionaddcandidate = '{addcandidate2}';
}
$action = $actionstop . $actionview . $actionaddcandidate;

?>
<div class="transrincian-index box box-default">
  <div class="box-header with-heaader">
    <?php echo Html::a('<i class="fa fa-tasks" style="font-size:12pt;"></i>', ['manage'], [
      'class' => 'btn btn-sm btn-default pull-right',
      'data-toggle' => 'tooltip',
      'title' => 'Change Layout'
    ]); ?>
  </div>

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
          'attribute' => 'id',
          'contentOptions' => ['style' => 'width: 50px;']
        ],
        [
          'attribute' => 'nojo',
          'contentOptions' => ['style' => 'width: 250px;']
        ],

        [
          'label' => 'Type JO',
          'attribute' => 'typejo',
          'format' => 'html',
          'filter' => \kartik\select2\Select2::widget([
            'model' => $searchModel,
            'attribute' => 'typejo',
            'data' => [1 => "New Project", 2 => "Replacement"],
            'options' => ['placeholder' => '--'],
            'pluginOptions' => [
              'allowClear' => true,
              'width' => '100px',
            ],
          ]),
          'value' => function ($data) {

            return ($data->typejo == 1) ? "New Project" : "Replacement";
          }
        ],

        [
          'label' => 'Due Date JO',
          'contentOptions' => ['style' => 'min-width: 100px;'],
          'format' => 'html',
          'value' => function ($data) {
            $datenow = date('Y-m-d');
            if ($data->typejo == 1) {
              if ($data->transrincian) {
                $datenew = $data->transrincian->lup_skema;
                $datenewplus = date('Y-m-d', strtotime($datenew . ' + 14 days'));
                $datediff = (strtotime($datenewplus) - strtotime($datenow)) / (60 * 60 * 24);
                return ($data->transrincian) ?
                  (($datediff < 0 && $data->status_rekrut == 1) ? '<span class="text-red">' . $datenewplus . "</span>" : $datenewplus)
                  : '-';
              } else {
                return "-";
              }
            } else {
              if ($data->transperner) {
                $daterep = $data->transperner->lup_skema;
                $datereplace = date('Y-m-d', strtotime($daterep . ' + 6 days'));
                $datediff = (strtotime($datereplace) - strtotime($datenow)) / (60 * 60 * 24);
                return ($data->transperner) ? (($datediff < 0 && $data->status_rekrut == 1) ? '<span class="text-red">' . $datereplace . "</span>" : $datereplace) : '-';
              } else {
                return "-";
              }
            }
          }
        ],

        [
          'label' => 'Jabatan (SAP)',
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
            if ($data->hire_jabatan_sap) {
              if (is_numeric($data->hire_jabatan_sap)) {
                if ($data->jabatansap) {
                  return $data->jabatansap->value2;
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
          'label' => 'Area (SAP)',
          'format' => 'html',
          'filter' => \kartik\select2\Select2::widget([
            'model' => $searchModel,
            'attribute' => 'areasap',
            'data' => ArrayHelper::map(Saparea::find()->asArray()->all(), 'value1', 'value2'),
            'options' => ['placeholder' => '--'],
            'pluginOptions' => [
              'allowClear' => true,
              // 'width' => '120px',
            ],
          ]),
          'value' => function ($data) {
            if ($data->area_sap) {
              return $data->areasap->value2;
            } else {
              return "-";
            }
          }
        ],

        [
          'label' => 'City',
          // 'attribute' => 'city',
          'contentOptions' => ['style' => 'width: 100px;'],
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
          'value' => function ($data) {
            return ($data->city) ? $data->city->city_name : '';
          }
        ],

        [
          'label' => 'Project',
          'attribute' => 'n_project',
          'format' => 'html',
          'value' => function ($data) {
            return $data->n_project;
          }
        ],

        // [
        //   'label' => 'Gender',
        //   'attribute' => 'gender',
        //   'format' => 'html',
        //   'filter' => \kartik\select2\Select2::widget([
        //     'model' => $searchModel,
        //     'attribute' => 'gender',
        //     'data' => ['Pria-Wanita' => "Pria-Wanita", 'Pria' => "Pria", 'Wanita' => "Wanita"],
        //     'options' => ['placeholder' => '--'],
        //     'pluginOptions' => [
        //       'allowClear' => true,
        //       'width' => '100px',
        //     ],
        //   ]),
        //   'value' => function ($data) {
        //     return ($data->gender) ? $data->gender : "-";
        //   }
        // ],

        // [
        //   'label' => 'Pendidikan',
        //   'attribute' => 'pendidikan',
        //   'format' => 'html',
        //   'filter' => \kartik\select2\Select2::widget([
        //     'model' => $searchModel,
        //     'attribute' => 'pendidikan',
        //     'data' => ['SD' => "SD", 'SMP' => "SMP", 'SMA' => "SMA", 'D1' =>"D1", 'D2' => "D2", 'D3' =>"D3", 'S1' =>"S1", 'S2' => "S2"],
        //     'options' => ['placeholder' => '--'],
        //     'pluginOptions' => [
        //       'allowClear' => true,
        //       'width' => '100px',
        //     ],
        //   ]),
        //   'value' => function ($data) {
        //     return ($data->pendidikan) ? $data->pendidikan : "-";
        //   }
        // ],

        // [
        //   'label' => 'Kontrak',
        //   'attribute' => 'kontrak',
        //   'format' => 'html',
        //   'filter' => \kartik\select2\Select2::widget([
        //     'model' => $searchModel,
        //     'attribute' => 'kontrak',
        //     'data' => ['PKWT' => "PKWT", 'KEMITRAAN' => "KEMITRAAN", 'MAGANG' => "MAGANG", 'PART TIME' =>"PART TIME", 'THL' => "THL", 'PKWT-KEMITRAAN PB' =>"PKWT-KEMITRAAN PB"],
        //     'options' => ['placeholder' => '--'],
        //     'pluginOptions' => [
        //       'allowClear' => true,
        //       'width' => '120px',
        //     ],
        //   ]),
        //   'value' => function ($data) {
        //     return ($data->kontrak) ? $data->kontrak : "-";
        //   }
        // ],

        [
          'attribute' => 'jumlah',
          'contentOptions' => ['style' => 'width: 80px;']
        ],

        [
          'label' => 'Status',
          'attribute' => 'status_rekrut',
          'contentOptions' => ['style' => 'width: 100px;'],
          'format' => 'html',
          'filter' => \kartik\select2\Select2::widget([
            'model' => $searchModel,
            'attribute' => 'status_rekrut',
            'data' => ['1' => 'On Progress', '2' => 'Done', '3' => 'On Progress (Revised JO)', '4' => 'Done (Revised JO)'],
            'options' => ['placeholder' => '--'],
            'pluginOptions' => [
              'allowClear' => true,
              'width' => '100px',
            ],
          ]),
          'value' => function ($data) {
            switch ($data->status_rekrut) {
              case 1:
                $status = "On Progress";
                break;
              case 2:
                $status = "Done";
                break;
              case 3:
                $status = "On Progress (Revised JO)";
                break;
              case 4:
                $status = "Done (Revised JO)";
                break;

              default:
                $status = '';
                break;
            }


            return $status;
          }
        ],


        [
          'label' => 'Total Applied',
          'format' => 'html',
          'value' => function ($data) {

            return Yii::$app->check->checkapplied($data->id);
          }
        ],

        [
          'label' => 'Candidated',
          'format' => 'html',
          'value' => function ($data) {

            return Yii::$app->check->checkcandidate($data->id);
          }
        ],

        [
          'label' => 'Hired',
          'format' => 'html',
          'value' => function ($data) {

            return Yii::$app->check->checkJohired($data->id, 1);
          }
        ],



        // 'komentar',
        // 'skema',
        // 'ket_done:ntext',
        // 'upd',
        // 'lup',
        // 'flag_jobs',
        // 'upd_jobs',
        // 'lup_jobs',
        // 'flag_app',
        // 'upd_app',
        // 'ket_rej:ntext',

        // 'ket_rekrut:ntext',
        // 'upd_rekrut',
        // 'pic_hi',
        // 'n_pic_hi',
        // 'pic_manar',
        // 'n_pic_manar',
        // 'pic_rekrut',
        // 'n_pic_rekrut',
        // 'level',
        // 'level_txt',
        // 'skilllayanan',
        // 'skilllayanan_txt',
        // 'level_sap',
        // 'persa_sap',
        // 'skill_sap',
        // 'area_sap',
        // 'jabatan_sap',
        // 'jabatan_sap_nm',
        // 'jenis_pro_sap',
        // 'skema_sap',
        // 'abkrs_sap',
        // 'hire_jabatan_sap',
        // 'zparam',
        // 'lup_skema',
        // 'upd_skema',

        [
          'class' => 'yii\grid\ActionColumn',
          'contentOptions' => ['style' => 'min-width: 150px;'],
          'template' => '<div class="btn-group pull-right">' . $action . '</div>',
          'buttons' => [

            'view' => function ($url, $model) {
              return Html::a('<i class="fa fa-eye" style="font-size:12pt;"></i>', ['view', 'id' => $model->id], ['class' => 'btn btn-sm btn-info', 'data-toggle' => 'tooltip', 'title' => 'View detail']);
            },
            'addcandidate2' => function ($url, $model, $key) {
              ($model->status_rekrut == 2 || $model->status_rekrut == 4) ? $disabled = true : $disabled = false;
              $btn = Html::button('<i class="fa fa-user-plus" style="font-size:12pt;"></i>', [
                'value' => Yii::$app->urlManager->createUrl('recruitmentcandidate/addcandidate2?id=' . $model->id), //<---- here is where you define the action that handles the ajax request
                'class' => 'btn btn-sm btn-default addcandidate2-modal-click',
                'disabled' => $disabled,
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'title' => 'Add Candidate',
              ]);
              return $btn;
            },
            'stop' => function ($url, $model, $key) {
              if ($model->status_rekrut == 2 or Yii::$app->check->checkstatuscr($model->id)) {
                $disabled = true;
              } else {
                $totalhired = Yii::$app->check->checkJohired($model->id, 2);
                if ($totalhired < $model->jumlah) {
                  $disabled = false;
                } else {
                  $disabled = true;
                }
              }
              $btn = Html::button('<i class="fa fa-recycle" style="font-size:12pt;"></i>', [
                'value' => Yii::$app->urlManager->createUrl('chagerequestjo/create?recruitreqid=' . $model->id), // 'value'=>, //<---- here is where you define the action that handles the ajax request
                'class' => 'btn btn-sm btn-danger stopjo-modal-click',
                'disabled' => $disabled,
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'title' => 'Stop Job Order',
              ]);
              return $btn;
            }


          ]
        ],
      ],
    ]); ?>
  </div>
</div>