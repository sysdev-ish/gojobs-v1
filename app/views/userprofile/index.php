<?php

use app\models\Mappingjob;
use app\models\Masterjobfamily;
use app\models\Mastersubjobfamily;
use app\models\Userworkexperience;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Userprofilesearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Applicant Master Data';
$this->params['breadcrumbs'][] = $this->title;

Modal::begin([
    'header'=>'<h4 class="modal-title">Add to Candidate</h4>',
    'id'=>'addcandidate-modal',
    'size'=>'modal-md'
]);

echo "<div id='addcandidateform'></div>";

Modal::end();
if(Yii::$app->user->isGuest){
  $role = null;
}else{
  // $userid = Yii::$app->user->identity->id;
  $role = Yii::$app->user->identity->role;
}
if(Yii::$app->utils->permission($role,'m14')){
  $action = '{view}{addcandidate}';
}else{
  $action = '{view}';
}
?>
<div class="userprofile-index box box-default">

    <div class="box-body table-responsive">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                // 'id',
                // 'userid',
                // 'createtime',
                // 'updatetime',
                'fullname',
                // 'nickname',
                // 'gender',
                [
                  'attribute' => 'gender',
                  'filter' => \kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'gender',
                    'data' => ['male'=>'male','female'=>'female'],
                    'options' => ['placeholder' => '--'],
                    'pluginOptions' => [
                       'allowClear' => true,
                       'width' => '80px',
                       ],
                  ]),
                  'contentOptions'=>['style'=>'width: 80px;']

                ],

                'birthdate',
                // 'birthplace',
                'address:ntext',
                [
                  'attribute' => 'cityname',
                  'value' => 'city.kota',
                  'contentOptions'=>['style'=>'width: 150px;']

                ],
                // 'postalcode',
                [
                  'attribute' => 'phone',
                  'contentOptions'=>['style'=>'width: 120px;']

                ],
                // [
                //   'attribute' => 'industry',
                //   'contentOptions'=>['style'=>'width: 120px;'],
                //   'format' => 'raw',
                //   'value' => 'userworkexperience.industry'
                // ],
                [
                  'attribute' => 'lastposition',
                  'contentOptions' => ['style' => 'min-width: 150px;'],
                  'value' => 'userworkexperience.lastposition'
                ],
                [
                  'attribute' => 'jobfamily',
                  'contentOptions'=>['style'=>'width: 120px;'],
                  'format' => 'raw',
                  'filter' => \kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'jobfamily',
                    'data' => ArrayHelper::map(Masterjobfamily::find()->asArray()->all(), 'id', 'jobfamily'),
                    'options' => ['placeholder' => 'Job Family'],
                    'pluginOptions' => [
                      'allowClear' => true,
                      // 'minimumInputLength' => 1,
                      'min-width' => '100px',
                    ],
                  ]),
                  'value' => function ($data) {
                    $userid = Userworkexperience::find()->where(['userid'=>$data->userid])->one();
                    $subjob = Userworkexperience::find()->where(['lastposition'=>$userid])->one();
                    $subjobfamily = Mastersubjobfamily::find()->where(['subjobfamily'=>$subjob])->one();
                    $subjobfamilyid = Mastersubjobfamily::find()->where(['jobfamily_id'=>$subjobfamily])->one();
                    $jobfam = Masterjobfamily::find()->where(['id'=>$subjobfamilyid])->one();
                    // return ($subjobfamilyid) ? $subjobfamilyid->jobfamily_id : '';
                    return ($jobfam) ? $jobfam->jobfamily : '';
                  }
                ],
                // 'domicilestatus',
                // 'domicilestatusdescription:ntext',
                // 'addressktp:ntext',
                // 'nationality',
                // 'religion',
                // 'maritalstatus',
                // 'weddingdate',
                // 'bloodtype',
                // 'identitynumber',
                // 'jamsosteknumber',
                // 'npwpnumber',
                // 'drivinglicencecarnumber',
                // 'drivinglicencemotorcyclenumber',


                ['class' => 'yii\grid\ActionColumn',
                'contentOptions'=>['style'=>'min-width: 100px;'],
                'template'=>'<div class="btn-group pull-right">'.$action.'</div>',
                'buttons'=>[

                  'view' => function ($url, $model) {
                    return Html::a('<i class="fa fa-eye" style="font-size:12pt;"></i>', ['views', 'userid'=>$model->userid], ['class' => 'btn btn-sm btn-info','data-toggle' => 'tooltip', 'title'=> 'Detail View' ]);
                  },
                  'addcandidate' => function($url,$model,$key){
                      $btn = Html::button('<i class="fa fa-user-plus" style="font-size:12pt;"></i>',[
                          'value'=>Yii::$app->urlManager->createUrl('recruitmentcandidate/addcandidate?userid='.$model->userid), //<---- here is where you define the action that handles the ajax request
                          'class'=>'btn btn-sm btn-default addcandidate-modal-click',
                          'data-toggle'=>'tooltip',
                          'data-placement'=>'bottom',
                          'title'=>'Add to candidate',
                      ]);
                      return $btn;
                  }

                ]
              ],
            ],
        ]); ?>
    </div>
</div>
