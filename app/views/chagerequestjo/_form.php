<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use linslin\yii2\curl;
use kartik\file\FileInput;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Chagerequestjo */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
<div class="col-md-5">
  <?= DetailView::widget([
      'model' => $modelrecreq,
      'template' =>'<tr><th width="30%" style="text-align:right;">{label}</th><td>{value}</td></tr>',
      'options' => ['class' => 'table table-striped detail-view'],
      'attributes' => [
          'id',
          'nojo',
          // 'jobfunc.jobcat.name_job_function_category',
          [
            'label' => 'Job Function',
            'attribute' => 'jobfunc',
            // 'contentOptions'=>['style'=>'width: 150px;'],
            'format' => 'html',
            'value'=>function ($data) {

              return (is_numeric($data->jabatan)) ? $data->jobfunc->name_job_function : $data->jabatan;
          }

          ],
          [
            'label' => 'Type Project',
            // 'contentOptions'=>['style'=>'width: 150px;'],
            'format' => 'html',
            'value'=>function ($data) {

              // return ($data->transjo->n_project == '' || $data->transjo->n_project == 'Pilih')?$data->transjo->project : $data->transjo->n_project;
              return ($data->typejo == 3)?'Temporary Request':(($data->typejo == 1)?"New Project":"Replacement");
          }

          ],
          [
            'label' => 'Project',
            // 'contentOptions'=>['style'=>'width: 150px;'],
            'format' => 'html',
            'value'=>function ($data) {

              // return ($data->transjo->n_project == '' || $data->transjo->n_project == 'Pilih')?$data->transjo->project : $data->transjo->n_project;
              return $data->n_project;
          }

          ],
          [
            'label' => 'Lama Project',
            // 'contentOptions'=>['style'=>'width: 150px;'],
            'format' => 'html',
            'value'=>function ($data) {

              return ($data->transjo->lama)?$data->transjo->lama." Bulan" : "";
          }

          ],
          [
            'label' => 'Perner replaced',
            // 'contentOptions'=>['style'=>'width: 150px;'],
            'format' => 'html',
            'value'=>function ($data) {

              return ($data->typejo == 2)?(($data->perner)?$data->perner->perner:""): "";
          }

          ],
          'gender',
          'pendidikan',
          'city.city_name',
          // 'atasan',
          'kontrak',
          'waktu',
          'jumlah',
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

          // 'status_rekrut',
          [
            'label' => 'Status',
            // 'contentOptions'=>['style'=>'width: 150px;'],
            'format' => 'html',
            'value'=>function ($data) {

              return ($data->status_rekrut == 1)?"On Progress" : "Done";
          }

          ],
          [
            'label' => 'Personal Area (SAP)',
            'format' => 'html',
            'value'=>function ($data) {

              return (Yii::$app->utils->getpersonalarea($data->persa_sap))?Yii::$app->utils->getpersonalarea($data->persa_sap) : "";

          }

          ],
          [
            'label' => 'Area (SAP)',
            'format' => 'html',
            'value'=>function ($data) {

              return (Yii::$app->utils->getarea($data->area_sap))?Yii::$app->utils->getarea($data->area_sap) : "";
          }

          ],
          [
            'label' => 'Skilllayanan (SAP)',
            'format' => 'html',
            'value'=>function ($data) {

              return (Yii::$app->utils->getskilllayanan($data->skill_sap))?Yii::$app->utils->getskilllayanan($data->skill_sap) : "";
          }

          ],
          [
            'label' => 'Payroll Area (SAP)',
            'format' => 'html',
            'value'=>function ($data) {

              return (Yii::$app->utils->getpayrollarea($data->abkrs_sap))?Yii::$app->utils->getpayrollarea($data->abkrs_sap) : "";
          }

          ],
          [
            'label' => 'Jabatan (SAP)',
            'format' => 'html',
            'value'=>function ($data) {

              return (Yii::$app->utils->getjabatan($data->hire_jabatan_sap))?Yii::$app->utils->getjabatan($data->hire_jabatan_sap) : "";
          }

          ],

          // 'ket_rekrut:ntext',
          // 'upd_rekrut',
          // 'pic_hi',
          // 'n_pic_hi',
          // 'pic_manar',
          // 'n_pic_manar',
          // 'pic_rekrut',
          // 'n_pic_rekrut',
          [
            'label' => 'Level (SAP)',
            'format' => 'html',
            'value'=>function ($data) {
              $curl = new curl\Curl();
              $getlevels = $curl->setPostParams([
                'level' => $data->level_sap,
                'token' => 'ish**2019',
              ])
              ->post('http://192.168.88.5/service/index.php/sap_profile/getlevel');
              $level  = json_decode($getlevels);
              return ($level)?$level : "";
          }

          ],
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
      ],
  ]) ?>
</div>
<div class="col-md-7">
  <div class="chagerequestjo-form">
      <?php $form = ActiveForm::begin([
        'options'=>[
          'enctype'=>'multipart/form-data',
          'id'=>'stopjo-form'
        ]
      ]); ?>
      <div class="box-body table-responsive">

          <?= $form->field($model, 'oldjumlah')->hiddenInput()->label('Jumlah Kebutuhan')->label(false) ?>
          <?= $form->field($model, 'counthiredtype1')->hiddenInput()->label(false) ?>
          <?php

          echo   $form->field($model, 'reason')->widget(Select2::classname(), [
            'data' => [1 => 'Permintaan User/Client',2 => 'Project Batal'],
            'options' => ['placeholder' => '- select -'],
            'pluginOptions' => [
                'allowClear' => false,
                'initialize' => true,
            ],
          ]);
          ?>

          <?= $form->field($model, 'jumlahstop')->textInput() ?>

          <?php if (!$model->isNewRecord): ?>
            <?php

            $type = '';
            $file = '';
            $asdata = false;
            $assetUrl = Yii::$app->request->baseUrl;
            if (!empty($model->$documentevidence)){
              $type = substr($model->$documentevidence, strrpos($model->$documentevidence, '.') + 1);
              if($type == 'pdf'){
                $asdata = true;
                $file = $assetUrl.'/app/assets/upload/documentevidence/'.$model->$documentevidence;
              }else{
                $asdata = false;
                $file = Html::img($assetUrl.'/app/assets/upload/documentevidence/'.$model->$documentevidence,['width'=>'150']);
              }
            }
            ?>

            <?= $form->field($model, 'documentevidence')->widget(FileInput::className(),[
              'options' => ['accept' => ''],
              'pluginOptions' => [
                'showRemove'=> false,
                // 'theme' => 'explorer-fa',
                'showUpload' => false,
                'showCancel' => false,
                'showPreview' => true,
                'overwriteInitial' => true,
                'previewFileType' => 'any',
                'initialPreviewAsData'=>$asdata,
                'initialPreview' => $file,
                'initialPreviewConfig' => [
                  ['type' => $type ,'caption' => $model->$documentevidence, 'deleteUrl' => false],
                ],
                'uploadAsync'=> true,
                // 'maxFileSize' => 10*1024*1024,
                'allowedExtensions' => ['jpg','png','jpeg', 'pdf'],
              ]
              ])?>
            <?php else : ?>
              <?= $form->field($model, 'documentevidence')->widget(FileInput::classname(), [
                'options' => ['accept' => ''],
                'pluginOptions' => [
                  'showUpload' => false,
                  'showCaption' => true,
                  'showRemove' => true,
                ]
              ]); ?>
            <?php endif; ?>

            <?= $form->field($model, 'remarks')->textInput(['maxlength' => true])->label('Keterangan') ?>
      </div>
      <br>
      <div class="box-footer">
          <?= Html::submitButton('Submit', ['class' => 'btn btn-success btn-flat']) ?>
      </div>
      <?php ActiveForm::end(); ?>
  </div>
</div>
</div>
