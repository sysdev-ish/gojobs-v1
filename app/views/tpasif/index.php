<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Masterstatusprocess;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Thardskillsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tandem Pasif';
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
    'header'=>'<h4 class="modal-title">Training Hard Skill Process</h4>',
    'id'=>'tproc-modal',
    'size'=>'modal-lg',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false]
]);

echo "<div id='tproc'></div>";

Modal::end();
if(Yii::$app->user->isGuest){
  $role = null;
}else{
  // $userid = Yii::$app->user->identity->id;
  $role = Yii::$app->user->identity->role;
}
if(Yii::$app->utils->permission($role,'m43')){
  $action = '{tproc}';
}else{
  $action = ' ';
}
?>
<div class="tpasif-index box box-solid">
    <div class="box-body table-responsive">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

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
                  // 'attribute' => 'jabatansap',
                  'format' => 'html',
                  'value'=>function ($data) {
                    return ( $data->reccandidate->recrequest->jabatan_sap_nm)? $data->reccandidate->recrequest->jabatan_sap_nm : Yii::$app->utils->getjabatan($data->reccandidate->recrequest->hire_jabatan_sap) ;
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
                // 'createtime',
                // 'updatetime',
                [
                  'label' => 'Date',
                  'attribute' => 'scheduledate',
                  'format' => 'html',
                  'value'=>function ($data) {

                    return Yii::$app->utils->indodate($data->scheduledate).' '.date("H:i", strtotime($data->scheduledate));
                }

                ],
                // 'date',
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

                ['class' => 'yii\grid\ActionColumn',
                'contentOptions'=>['style'=>'min-width: 50px;'],
                'template'=>'<div class="btn-group pull-right">'.$action.'</div>',
                'buttons'=>[
                  'tproc' => function($url,$model,$key){
                    ($model->status == 1 )?$disabled = false : $disabled = true;
                        $btn = Html::button('<i class="fa fa-tags" style="font-size:12pt;"></i>',[
                            'value'=>Yii::$app->urlManager->createUrl('tpasif/tproc?id='.$model->id), //<---- here is where you define the action that handles the ajax request
                            'class'=>'btn btn-sm btn-primary tproc-modal-click',
                            'disabled' => $disabled,
                            'data-toggle'=>'tooltip',
                            'data-placement'=>'bottom',
                            'title'=>'Process'
                        ]);
                        return $btn;
                  }


                ]
              ],
            ],
        ]); ?>
    </div>
</div>
