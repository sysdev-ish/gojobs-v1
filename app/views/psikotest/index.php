<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use app\models\Masterstatusprocess;
use app\models\Psikotest;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Psikotestsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Psikotest';
$this->params['breadcrumbs'][] = $this->title;
Modal::begin([
    'header'=>'<h4 class="modal-title">View Profile</h4>',
    'id'=>'profileviewshort-modal',
    'size'=>'modal-lg'
]);

echo "<div id='profileviewshortview'></div>";

Modal::end();
Modal::begin([
    'header'=>'<h4 class="modal-title">View Recruitment Candidate detail</h4>',
    'id'=>'reccan-modal',
    'size'=>'modal-md'
]);

echo "<div id='reccanview'></div>";

Modal::end();
Modal::begin([
    'header'=>'<h4 class="modal-title">Psikotest Confirmation</h4>',
    'id'=>'confirmpskotest-modal',
    'size'=>'modal-md'
]);

echo "<div id='confirmpskotest'></div>";

Modal::end();
Modal::begin([
    'header'=>'<h4 class="modal-title">Psikotest Process</h4>',
    'id'=>'psikotestproc-modal',
    'size'=>'modal-md'
]);

echo "<div id='psikotestproc'></div>";

Modal::end();
Modal::begin([
    'header'=>'<h4 class="modal-title">Upload Psychogram</h4>',
    'id'=>'psikotestupload-modal',
    'size'=>'modal-md'
]);

echo "<div id='psikotestupload'></div>";

Modal::end();

if(Yii::$app->user->isGuest){
  $role = null;
}else{
  // $userid = Yii::$app->user->identity->id;
  $role = Yii::$app->user->identity->role;
}
if(Yii::$app->utils->permission($role,'m8') && Yii::$app->utils->permission($role,'m9')){
  $action = '{download}{confirmpskotest}{psikotestproc}{uploadpsychogram}';
}elseif(Yii::$app->utils->permission($role,'m8')){
  $action = '{confirmpskotest}';
}elseif(Yii::$app->utils->permission($role,'m9')){
  $action = '{psikotestproc}';
}else{
  $action = ' ';
}
?>
<div class="psikotest-index box box-default">
    <div class="box-body table-responsive">
      <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
      <?= GridView::widget([
          'dataProvider' => $dataProvider,
          'filterModel' => $searchModel,
          'layout' => "{items}\n{summary}\n{pager}",
          'columns' => [
              ['class' => 'yii\grid\SerialColumn'],

              'id',
              [
                'label' => 'Invitation Number',
                'contentOptions'=>['style'=>'width: 100px;'],
                'format' => 'raw',
                'value'=>function ($data) {
                  $btn = Html::button($data->reccandidate->invitationnumber,[
                      'value'=>Yii::$app->urlManager->createUrl('recruitmentcandidate/view?id='.$data->recruitmentcandidateid), //<---- here is where you define the action that handles the ajax request
                      'class'=>'btn btn-link reccan-modal-click',
                      'style'=>'padding:0px;',
                      'data-toggle'=>'tooltip',
                      'data-placement'=>'bottom',
                      'title'=>'View Candidate Detail'
                  ]);
                  return $btn;
              }

              ],
              [
                'label' => 'Full Name',
                'attribute' => 'fullname',
                'contentOptions'=>['style'=>'width: 100px;'],
                'format' => 'raw',
                'value'=>function ($data) {
                  $btn = Html::button($data->userprofile->fullname,[
                      'value'=>Yii::$app->urlManager->createUrl('userprofile/viewshort?userid='.$data->userid), //<---- here is where you define the action that handles the ajax request
                      'class'=>'btn btn-link profileviewshort-modal-click',
                      'style'=>'padding:0px;',
                      'data-toggle'=>'tooltip',
                      'data-placement'=>'bottom',
                      'title'=>'View Profile detail'
                  ]);
                  return $btn;
              }

              ],
              // 'reccandidate.recrequest.jobfunc.jobcat.name_job_function_category',
              // 'reccandidate.recrequest.jobfunc.name_job_function',
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
                'format' => 'html',
                'value'=>function ($data) {
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
                'contentOptions'=>['style'=>'width: 100px;'],
                'format' => 'html',
                'value'=>function ($data) {

                  return ($data->reccandidate->recrequest->city)?$data->reccandidate->recrequest->city->city_name:"";
              }

              ],
              [
                'attribute' => 'scheduledate',
                // 'contentOptions'=>['style'=>'width: 150px;'],
                'format' => 'html',
                'value'=>function ($data) {

                  return Yii::$app->utils->indodate($data->scheduledate).' '.date("H:i", strtotime($data->scheduledate));
              }

              ],
              [
                'attribute' => 'date',
                // 'contentOptions'=>['style'=>'width: 150px;'],
                'format' => 'html',
                'value'=>function ($data) {

                  return ($data->date)?Yii::$app->utils->indodate($data->date):'-';
              }

              ],
              'masteroffice.officename',
              [
                'label' => 'Room',
                'contentOptions'=>['style'=>'width: 150px;'],
                'format' => 'html',
                'value'=>function ($data) {

                  return ($data->roomid != null)?Yii::$app->utils->ordinal($data->masterroom->floor).' Floor, '. $data->masterroom->room. ' Room': ' ';
              }

              ],
              [
                'label' => 'PIC Psikotest',
                'contentOptions'=>['style'=>'width: 100px;'],
                'format' => 'html',
                'value'=>function ($data) {

                  return ($data->pic)?$data->userpic->name:'';
              }

              ],

              [
                'attribute' => 'status',
                'contentOptions'=>['style'=>'width: 100px;'],
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
                'value'=>function ($data) {
                  if($data->status == 0){$label='label-warning';}elseif($data->status == 2){$label='label-success';}elseif($data->status == 3){$label='label-danger';}else{$label='label-primary';}
                  return '<span class="label '.$label.'">'.$data->statusprocess->statusname.'</span>';
              }

              ],


              // 'recruitmentcandidateid',


              ['class' => 'yii\grid\ActionColumn',
              'contentOptions'=>['style'=>'min-width: 170px;'],
              'template'=>'<div class="btn-group pull-right">'.$action.'</div>',
              'buttons'=>[
                'download' => function ($url, $model) {

                  if($model->documentpsikotest){
                    $disabled = false;
                  }else{
                    $disabled = true;
                  }
                  return Html::a('<i class="fa fa-download" style="font-size:12pt;"></i>', ['/app/assets/upload/documentpsikotest/'.$model->documentpsikotest], ['class' => 'btn btn-sm btn-primary','disabled' => $disabled,'data-toggle' => 'tooltip', 'title'=> 'Download','target'=>'_blank' ]);
                },
                'confirmpskotest' => function($url,$model,$key){
                  $cekinterview = Psikotest::find()->where(['status'=>1, 'date'=> date('Y-m-d'),'userid'=>$model->userid])->one();
                  if($model->status >1){
                    $disabled = true;
                  }else{
                    ($cekinterview == null)?$disabled = false : $disabled = true;
                  }
                      $btn = Html::button('<i class="fa fa-child" style="font-size:12pt;"></i>',[
                          'value'=>Yii::$app->urlManager->createUrl('psikotest/update?id='.$model->id), //<---- here is where you define the action that handles the ajax request
                          'class'=>'btn btn-sm btn-default confirmpskotest-modal-click',
                          'disabled' => $disabled,
                          'data-toggle'=>'tooltip',
                          'data-placement'=>'bottom',
                          'title'=>'Confirmation'
                      ]);
                      return $btn;
                },
                'psikotestproc' => function($url,$model,$key){
                  // (Yii::$app->chproc->interview($model->userid,$model->id) == 3 )?$disabled = false : $disabled = true;
                  ($model->status == 1 )?$disabled = false : $disabled = true;
                      $btn = Html::button('<i class="fa fa-tags" style="font-size:12pt;"></i>',[
                          'value'=>Yii::$app->urlManager->createUrl('psikotest/psiproc?id='.$model->id), //<---- here is where you define the action that handles the ajax request
                          'class'=>'btn btn-sm btn-primary psikotestproc-modal-click',
                          'disabled' => $disabled,
                          'data-toggle'=>'tooltip',
                          'data-placement'=>'bottom',
                          'title'=>'Process'
                      ]);
                      return $btn;
                },
                'uploadpsychogram' => function($url,$model,$key){

                  if($model->status == 2){
                    if($model->documentpsikotest){
                      $disabled = true;
                    }else{
                      $disabled = false;
                    }
                  }else{
                    $disabled = true;
                  }
                      $btn = Html::button('<i class="fa fa-upload" style="font-size:12pt;"></i>',[
                          'value'=>Yii::$app->urlManager->createUrl('psikotest/psiupload?id='.$model->id), //<---- here is where you define the action that handles the ajax request
                          'class'=>'btn btn-sm btn-danger psikotestupload-modal-click',
                          'disabled' => $disabled,
                          'data-toggle'=>'tooltip',
                          'data-placement'=>'bottom',
                          'title'=>'Upload Psychogram'
                      ]);
                      return $btn;
                },


              ]
            ],
          ],
      ]); ?>
    </div>
</div>
