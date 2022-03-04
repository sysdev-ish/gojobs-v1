<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use app\models\Jobfunction;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Transrinciansearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Recruitment Request';
$this->params['breadcrumbs'][] = $this->title;

Modal::begin([
    'header'=>'<h4 class="modal-title">Add Candidate</h4>',
    'id'=>'addcandidate2-modal',
    'size'=>'modal-xl',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    // 'pjaxContainer' => '#addcandidate',
]);

echo "<div id='addcandidateform2'></div>";

Modal::end();
Modal::begin([
    'header'=>'<h4 class="modal-title">Stop Job Order</h4>',
    'id'=>'stopjo-modal',
    'size'=>'modal-xl',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    // 'pjaxContainer' => '#addcandidate',
]);

echo "<div id='stopjoview'></div>";

Modal::end();
if(Yii::$app->user->isGuest){
  $role = null;
}else{
  // $userid = Yii::$app->user->identity->id;
  $role = Yii::$app->user->identity->role;
}
$actionstop = '';
$actionview = '';
$actionaddcandidate = '';
if(Yii::$app->utils->permission($role,'m62')){
  $actionstop = '{stop}';
}
if(Yii::$app->utils->permission($role,'m1')){
  $actionview = '{view}';
}
if(Yii::$app->utils->permission($role,'m63')){
  $actionaddcandidate = '{addcandidate2}';
}
$action = $actionstop.$actionview.$actionaddcandidate;

?>
<div class="transrincian-index box box-default">

    <div class="box-body table-responsive">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'nojo',

                [
                  'label' => 'typejo',
                  'attribute' => 'typejo',
                  // 'contentOptions'=>['style'=>'width: 150px;'],
                  'format' => 'html',
                  'filter' => \kartik\select2\Select2::widget([
                      'model' => $searchModel,
                      'attribute' => 'typejo',
                      'data' => [1 => "New Project", 2 => "replacement"],
                      'options' => ['placeholder' => '--'],
                      'pluginOptions' => [
                         'allowClear' => true,
                         'width' => '100px',
                         ],
                    ]),
                  'value'=>function ($data) {

                    return ($data->typejo == 1)?"New Project":"Replacement";
                  }

                ],
                [
                  'label' => 'Due Date JO',
                  'contentOptions'=>['style'=>'min-width: 100px;'],
                  'format' => 'html',
                  'value'=>function ($data) {
                    $datenow = date("Y-m-d");
                    if($data->typejo == 1){
                      return ($data->transjo)? (($data->transjo->bekerja < $datenow && $data->status_rekrut == 1)?'<span class="text-red">'.$data->transjo->bekerja."</span>":$data->transjo->bekerja):'-';

                    }else{
                      return ($data->transperner)? (($data->transperner->tgl_resign < $datenow && $data->status_rekrut == 1)?'<span class="text-red">'.$data->transperner->tglbekerja."</span>":$data->transperner->tglbekerja):'-';

                    }
                  }

                ],
                [
                  'label' => 'Jabatan (SAP)',
                  'attribute' => 'jabatansap',
                  // 'contentOptions'=>['style'=>'width: 150px;'],
                  'format' => 'html',
                  'value'=>function ($data) {

                    return ($data->hire_jabatan_sap)? ((is_numeric($data->hire_jabatan_sap))?$data->jabatansap->value2:'-'):'-';
                }

                ],
                [
                  'label' => 'Area',
                  'attribute' => 'city',
                  // 'contentOptions'=>['style'=>'width: 150px;'],
                  'format' => 'html',
                  'value'=>function ($data) {

                    return ($data->city)?$data->city->city_name:'';
                }

                ],

                [
                  'label' => 'Project',
                  'attribute' => 'n_project',
                  // 'contentOptions'=>['style'=>'width: 150px;'],
                  'format' => 'html',
                  'value'=>function ($data) {

                    return $data->n_project;
                }

                ],
                'gender',
                'pendidikan',

                'jumlah',

                [
                  'label' => 'Status',
                  'attribute' => 'status_rekrut',
                  'contentOptions'=>['style'=>'width: 100px;'],
                  'format' => 'html',
                  'filter' => \kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'status_rekrut',
                    'data' => ['1'=>'On Progress', '2' => 'Done', '3' => 'On Progress (Revised JO)','4' => 'Done (Revised JO)'],
                    'options' => ['placeholder' => '--'],
                    'pluginOptions' => [
                       'allowClear' => true,
                       'width' => '100px',
                       ],
                  ]),
                  'value'=>function ($data) {
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
                  // 'contentOptions'=>['style'=>'width: 150px;'],
                  'format' => 'html',
                  'value'=>function ($data) {

                    return Yii::$app->check->checkapplied($data->id);
                }

                ],
                [
                  'label' => 'Jumlah Kandidat lolos',
                  // 'contentOptions'=>['style'=>'width: 150px;'],
                  'format' => 'html',
                  'value'=>function ($data) {

                    return Yii::$app->check->checkcandidate($data->id);
                }

                ],
                [
                  'label' => 'Hired',
                  // 'contentOptions'=>['style'=>'width: 150px;'],
                  'format' => 'html',
                  'value'=>function ($data) {

                    return Yii::$app->check->checkJohired($data->id,1);
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

                ['class' => 'yii\grid\ActionColumn',
                'contentOptions'=>['style'=>'min-width: 150px;'],
                'template'=>'<div class="btn-group pull-right">'.$action.'</div>',
                'buttons'=>[

                  'view' => function ($url, $model) {
                    return Html::a('<i class="fa fa-eye" style="font-size:12pt;"></i>', ['view', 'id'=>$model->id], ['class' => 'btn btn-sm btn-info','data-toggle' => 'tooltip', 'title'=> 'View detail' ]);
                  },
                  'addcandidate2' => function($url,$model,$key){
                    ($model->status_rekrut == 2 || $model->status_rekrut == 4)?$disabled = true : $disabled = false;
                      $btn = Html::button('<i class="fa fa-user-plus" style="font-size:12pt;"></i>',[
                          'value'=>Yii::$app->urlManager->createUrl('recruitmentcandidate/addcandidate2?id='.$model->id), //<---- here is where you define the action that handles the ajax request
                          'class'=>'btn btn-sm btn-default addcandidate2-modal-click',
                          'disabled' => $disabled,
                          'data-toggle'=>'tooltip',
                          'data-placement'=>'bottom',
                          'title'=>'Add Candidate',
                      ]);
                      return $btn;
                  },
                  'stop' => function($url,$model,$key){
                    if($model->status_rekrut == 2 OR Yii::$app->check->checkstatuscr($model->id)){
                      $disabled = true;
                    }else{
                      $totalhired = Yii::$app->check->checkJohired($model->id,2);
                      if($totalhired < $model->jumlah){
                        $disabled = false;
                      }else{
                        $disabled = true;
                      }
                    }
                      $btn = Html::button('<i class="fa fa-recycle" style="font-size:12pt;"></i>',[
                          'value'=>Yii::$app->urlManager->createUrl('chagerequestjo/create?recruitreqid='.$model->id), // 'value'=>, //<---- here is where you define the action that handles the ajax request
                          'class'=>'btn btn-sm btn-danger stopjo-modal-click',
                          'disabled' => $disabled,
                          'data-toggle'=>'tooltip',
                          'data-placement'=>'bottom',
                          'title'=>'Stop Job Order',
                      ]);
                      return $btn;
                  }


                ]
              ],
            ],
        ]); ?>
    </div>
</div>
