<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use app\models\Recruitmentcandidate;
use app\models\Hiring;
use app\models\Transrincian;
use app\models\Transkomponen;
use app\models\Masterstatuscandidate;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $model app\models\Hiring */

$this->title = 'Create Hiring';
$this->params['breadcrumbs'][] = ['label' => 'Hirings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$url = \yii\helpers\Url::to(['transrincian/recreqlist']);
?>
<div class="hiring-create">

  <?php Pjax::begin([
    'id' => 'addhiringpjax',
    'timeout' => false,
    'enablePushState' => false,
    ])?>
    <div id ="cobaajax"></div>
  <div class="hiring-form">

      <div class="box-body table-responsive">
          <?= GridView::widget([
              'dataProvider' => $dataProviderprofile,
              'filterModel' => $searchModelprofile,
              // 'filterModel' => true,
              // 'pjax' => true,
              'layout' => "{items}\n{summary}\n{pager}",
              'columns' => [
                  ['class' => 'yii\grid\SerialColumn'],


                  [
                    'label' => 'Full Name',
                    'attribute' => 'fullname',
                    'contentOptions'=>['style'=>'width: 150px;'],
                    'format' => 'raw',
                    'value'=>function ($data) {
                      return $data->userprofile->fullname;
                  }

                  ],
                  [

                    'label' => 'Recruitment Request',
                    'attribute' => 'nojo',
                    'contentOptions'=>['style'=>'min-width: 180px;'],
                    'format' => 'raw',
                    'filter' => \kartik\select2\Select2::widget([
                      'model' => $searchModelprofile,
                      'attribute' => 'nojo',
                      'initValueText' => empty($searchModel->nojo) ? '' : Transrincian::findOne($searchModel->nojo)->nojo, // set the initial display text
                      'options' => ['placeholder' => '--', 'id'=>'recruitreqid'],
                      'pluginOptions' => [
                          'dropdownParent' => new yii\web\JsExpression('$("#hiring-modal")'),
                          'allowClear' => true,
                          'minimumInputLength' => 3,
                          'language' => [
                              'errorLoading' => new \yii\web\JsExpression("function () { return 'Waiting for results...'; }"),
                          ],
                          'ajax' => [
                              'url' => $url,
                              'dataType' => 'json',
                              'data' => new \yii\web\JsExpression('function(params) { return {q:params.term}; }')
                          ],
                          'escapeMarkup' => new \yii\web\JsExpression('function (markup) { return markup; }'),
                          'templateResult' => new \yii\web\JsExpression('function(a) { if(a.nojo == null){return "No Data";}else{return a.nojo+" <br> "+ a.name_job_function + " - " + a.city_name;}; }'),

                      ],
                    ]),
                    'value'=>function ($data) {
                      return $data->recrequest->nojo;
                  }

                  ],
                  [
                    'label' => 'Jabatan (SAP)',
                    // 'attribute' => 'jabatansap',
                    // 'contentOptions'=>['style'=>'width: 150px;'],
                    'format' => 'html',
                    'value'=>function ($data) {

                      return ($data->recrequest->hire_jabatan_sap)? ((is_numeric($data->recrequest->hire_jabatan_sap))?$data->recrequest->jabatansap->value2:'-'):'-';
                  }

                  ],
                  [
                    'label' => 'City',
                    'attribute' => 'city',
                    'contentOptions'=>['style'=>'width: 150px;'],
                    'format' => 'html',
                    'value'=>function ($data) {

                      return ($data->recrequest)?(($data->recrequest->city)?$data->recrequest->city->city_name:'-'):'-';
                  }

                  ],
                  [
                    'label' => 'Project',
                    'attribute' => 'project',
                    // 'contentOptions'=>['style'=>'width: 150px;'],
                    'format' => 'html',
                    'value'=>function ($data) {

                      return ($data->recrequest->n_project)?$data->recrequest->n_project:(($data->recrequest->transjo->n_project == '' || $data->recrequest->transjo->n_project == 'Pilih')?$data->recrequest->transjo->project : $data->recrequest->transjo->n_project);
                  }

                  ],
                  [
                    'label' => 'SAP',
                    // 'attribute' => 'project',
                    // 'contentOptions'=>['style'=>'width: 150px;'],
                    'format' => 'html',
                    'value'=>function ($data) {

                      return ($data->recrequest->transjo->flag_peralihan==1)?"Peralihan":"ISH";
                  }

                  ],

                  [
                    'label' => 'Basic Salary',
                    // 'contentOptions'=>['style'=>'width: 150px;'],
                    'format' => 'html',

                    'value'=>function ($data) {
                      $transkomponen = Transkomponen::find()->where(['nojo'=>$data->recrequest->nojo,'area'=>$data->recrequest->lokasi,'jabatan'=>$data->recrequest->jabatan,'level'=>$data->recrequest->level, 'skill'=>$data->recrequest->skilllayanan,'komponen_txt'=>'GAJI POKOK'])->one();

                      return ($transkomponen)?((is_numeric($transkomponen->value))?number_format($transkomponen->value):$transkomponen->value):'-';
                  }

                  ],


                  ['class' => 'yii\grid\ActionColumn',
                  'contentOptions'=>['style'=>'min-width: 50px;'],
                  'template'=>'<div id = "actionpjax" class="btn-group pull-right">{addtohiring}</div>',
                  'buttons'=>[
                    'addtohiring' => function ($url, $model) {

                      $cekcandidate = Hiring::find()->where('userid = '.$model->userid.' AND statushiring <> 5 AND statushiring <> 6 AND statushiring <> 7')->one();
                      // $cekjoreject = Hiring::find()->where('userid = '.$model->userid.' AND recruitreqid = '.$model->recruitreqid)->one();
                          // if($cekcandidate OR $cekjoreject){
                          if($cekcandidate){
                            $icon = '<i class="fa fa-check  text-green" style="font-size:12pt;"></i>';
                            $disabled = true;
                            $display = 'display:none';
                            $displaycheck = '';
                          }else{
                            $icon = '<i class="fa fa-user-plus" style="font-size:12pt;"></i>';
                            $display = '';
                            $displaycheck = 'display:none';
                          }

                          return  '<a id="btncheck'.$model->id.'" class=" btn btn-sm btn-default" disabled style ="'.$displaycheck.'"><i class="fa fa-check text-green" style="font-size:12pt;"></i></a>'.' '
                          .Html::a($icon, '#', [
                              'id' => 'btnaddhiring'.$model->id,
                             'class' => 'btn btn-sm btn-default btnaddhiringid',
                             'title' => 'Add to Hiring',
                             'style' => $display,
                             'onclick' => "
                                 if (confirm('Are you sure you want to Hiring this candidate?') == true) {
                                   var loading = new Loading({
                                     direction: 'hor',
                                     discription: 'Loading...',
                                       defaultApply: 	true,
                                   });

                                   event.preventDefault();
                                   this.blur();

                                     $.ajax({
                                         type: 'POST',
                                         cache: false,
                                         data : {
                                           recruitreqid : '".$model->recruitreqid."',
                                         },
                                         url: '" .Yii::$app->urlManager->createUrl(['hiring/create', 'userid'=>$model->userid]). "',
                                         success: function (data, textStatus, jqXHR) {
                                           loading.out()
                                           if(data == 2){
                                             alert('Hiring berhasil');
                                             $('#hiring-modal').find('#btnaddhiring".$model->id."').hide();
                                             $('#hiring-modal').find('#btncheck".$model->id."').show();
                                           }else if(data == 0){
                                             alert('JO belum di approve, silahkan hubungi PM untuk approval');
                                           }else if(data == 3){
                                             alert('Data Applicant Belum Lengkap, Silahkan lengkapi data terlebih dahulu');
                                           }else if(data == 4){
                                             alert('Hiring Fail, Jumlah kebutuhan Jo tersebut sudah terpenuhi');
                                           }else if(data == 5){
                                             alert('Hiring Fail, Candidate masih menggunakan JO Temporary silahkan ubah JO pada menu recruitment candidate');
                                           }else if(data == 6){
                                             alert('Hiring Fail, JO sedang dalam proses stop jo dan jumlah pekerja dalam pengajuan pada proses hiring sudah terpenuhi');
                                           }else{
                                             alert('Hiring Fail');
                                           }

                                         },
                                     });

                                 }

                                 return false;
                             "
                         ]);
                       }



                  ]
                ],
              ],
          ]); ?>





      </div>
  </div>
  <?php Pjax::end()?>

</div>
