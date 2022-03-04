<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Uploadocument */
/* @var $form yii\widgets\ActiveForm */
?>
<?php if(Yii::$app->utils->getlayout() == 'main'): ?>
<div class="box box-header with-border">

<h3 class="box-title">Upload Document</h3>
</div>
<?php endif; ?>

<!-- validation rule -->
  <?php if(Yii::$app->user->isGuest){
    $role = null;
  }else{
    $role = Yii::$app->user->identity->role;
  } ?>
<!-- end validation rule -->

<!-- show no data if user was hiring -->
  <?php if($model) :?>
    <?php if (Yii::$app->utils->aplhired($userid)) :?>
      <div class="box box-header with-border">
        <center><h3 class="box-title">No Data</h3></center>
      </div>
<!-- end of show no data if user was hiring -->

      <!-- show edit menu if user as superadmin -->
        <?php if (Yii::$app->utils->permission($role,'m49')):?>
          <div class="box box-solid">
            <div class="box-body">

              <?php $form = ActiveForm::begin([
                'options'=>[
                  'enctype'=>'multipart/form-data'
                ]
              ]); ?>
              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-6">
                  <?php if (!$model->isNewRecord): ?>
                    <?php
                    $type = substr($model->ijazah, strrpos($model->ijazah, '.') + 1);
                    $file = '';
                    $assetUrl = Yii::$app->request->baseUrl;
                    if (!empty($model->ijazah)){
                      if($type == 'pdf'){
                        $asdata = true;
                        $file = $assetUrl.'/app/assets/upload/ijazah/'.$model->ijazah;
                      }else{
                        $asdata = false;
                        $file = Html::img($assetUrl.'/app/assets/upload/ijazah/'.$model->ijazah,['width'=>'150']);
                      }
                    }
                    ?>

                    <?= $form->field($model, 'ijazah')->widget(FileInput::className(),[
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
                          ['type' => $type ,'caption' => $model->ijazah, 'deleteUrl' => false],
                        ],
                        'uploadAsync'=> true,
                        // 'maxFileSize' => 10*1024*1024,
                        'allowedExtensions' => ['jpg','png','jpeg', 'pdf'],
                      ]
                      ])?>
                    <?php else : ?>
                      <?= $form->field($model, 'ijazah')->widget(FileInput::classname(), [
                        'options' => ['accept' => ''],
                        'pluginOptions' => [
                          'showUpload' => false,
                          'showCaption' => true,
                          'showRemove' => true,
                        ]
                      ]); ?>
                    <?php endif; ?>
                  </div>
                  <div class="col-md-6">
                  <?php if (!$model->isNewRecord): ?>
                    <?php
                    $type = substr($model->transkipnilai, strrpos($model->transkipnilai, '.') + 1);
                    $file = '';
                    $assetUrl = Yii::$app->request->baseUrl;
                    if (!empty($model->transkipnilai)){
                      if($type == 'pdf'){
                        $asdata = true;
                        $file = $assetUrl.'/app/assets/upload/transkipnilai/'.$model->transkipnilai;
                      }else{
                        $asdata = false;
                        $file = Html::img($assetUrl.'/app/assets/upload/transkipnilai/'.$model->transkipnilai,['width'=>'150']);
                      }
                    }
                    ?>

                    <?= $form->field($model, 'transkipnilai')->widget(FileInput::className(),[
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
                          ['type' => $type ,'caption' => $model->transkipnilai, 'deleteUrl' => false],
                        ],
                        'uploadAsync'=> true,
                        'maxFileSize' => 3*1024*1024,
                        'allowedExtensions' => ['jpg','png','jpeg', 'pdf'],
                      ]
                      ])?>
                    <?php else : ?>
                      <?= $form->field($model, 'transkipnilai')->widget(FileInput::classname(), [
                        'options' => ['accept' => ''],
                        'pluginOptions' => [
                          'showUpload' => false,
                          'showCaption' => true,
                          'showRemove' => true,
                        ]
                      ]); ?>
                    <?php endif; ?>
                  </div>
                  </div>
                  <div class="col-md-12">
                    <div class="col-md-6">
                      <?php if (!$model->isNewRecord): ?>
                        <?php
                        $type = substr($model->suratketerangansehat, strrpos($model->suratketerangansehat, '.') + 1);
                        $file = '';
                        $assetUrl = Yii::$app->request->baseUrl;
                        if (!empty($model->suratketerangansehat)){
                          if($type == 'pdf'){
                            $asdata = true;
                            $file = $assetUrl.'/app/assets/upload/suratketerangansehat/'.$model->suratketerangansehat;
                          }else{
                            $asdata = false;
                            $file = Html::img($assetUrl.'/app/assets/upload/suratketerangansehat/'.$model->suratketerangansehat,['width'=>'150']);
                          }
                        }
                        ?>

                        <?= $form->field($model, 'suratketerangansehat')->widget(FileInput::className(),[
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
                              ['type' => $type ,'caption' => $model->suratketerangansehat, 'deleteUrl' => false],
                            ],
                            'uploadAsync'=> true,
                            'maxFileSize' => 3*1024*1024,
                            'allowedExtensions' => ['jpg','png','jpeg', 'pdf'],
                          ]
                          ])?>
                        <?php else : ?>
                          <?= $form->field($model, 'suratketerangansehat')->widget(FileInput::classname(), [
                            'options' => ['accept' => ''],
                            'pluginOptions' => [
                              'showUpload' => false,
                              'showCaption' => true,
                              'showRemove' => true,
                            ]
                          ]); ?>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                      <?php if (!$model->isNewRecord): ?>
                        <?php
                        $type = substr($model->kartukeluarga, strrpos($model->kartukeluarga, '.') + 1);
                        $file = '';
                        $assetUrl = Yii::$app->request->baseUrl;
                        if (!empty($model->kartukeluarga)){
                          if($type == 'pdf'){
                            $asdata = true;
                            $file = $assetUrl.'/app/assets/upload/kartukeluarga/'.$model->kartukeluarga;
                          }else{
                            $asdata = false;
                            $file = Html::img($assetUrl.'/app/assets/upload/kartukeluarga/'.$model->kartukeluarga,['width'=>'150']);
                          }
                        }
                        ?>

                        <?= $form->field($model, 'kartukeluarga')->widget(FileInput::className(),[
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
                              ['type' => $type ,'caption' => $model->kartukeluarga, 'deleteUrl' => false],
                            ],
                            'uploadAsync'=> true,
                            'maxFileSize' => 3*1024*1024,
                            'allowedExtensions' => ['jpg','png','jpeg', 'pdf'],
                          ]
                          ])?>
                        <?php else : ?>
                          <?= $form->field($model, 'kartukeluarga')->widget(FileInput::classname(), [
                            'options' => ['accept' => ''],
                            'pluginOptions' => [
                              'showUpload' => false,
                              'showCaption' => true,
                              'showRemove' => true,
                            ]
                          ]); ?>
                        <?php endif; ?>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="col-md-6">
                      <?php if (!$model->isNewRecord): ?>
                        <?php
                        $type = substr($model->ktp, strrpos($model->ktp, '.') + 1);
                        $file = '';
                        $assetUrl = Yii::$app->request->baseUrl;
                        if (!empty($model->ktp)){
                          if($type == 'pdf'){
                            $asdata = true;
                            $file = $assetUrl.'/app/assets/upload/ktp/'.$model->ktp;
                          }else{
                            $asdata = false;
                            $file = Html::img($assetUrl.'/app/assets/upload/ktp/'.$model->ktp,['width'=>'150']);
                          }
                        }
                        ?>

                        <?= $form->field($model, 'ktp')->widget(FileInput::className(),[
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
                              ['type' => $type ,'caption' => $model->ktp, 'deleteUrl' => false],
                            ],
                            'uploadAsync'=> true,
                            'maxFileSize' => 3*1024*1024,
                            'allowedExtensions' => ['jpg','png','jpeg', 'pdf'],
                          ]
                          ])?>
                        <?php else : ?>
                          <?= $form->field($model, 'ktp')->widget(FileInput::classname(), [
                            'options' => ['accept' => ''],
                            'pluginOptions' => [
                              'showUpload' => false,
                              'showCaption' => true,
                              'showRemove' => true,
                            ]
                          ]); ?>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                      <?php if (!$model->isNewRecord): ?>
                        <?php
                        $type = substr($model->jamsostek, strrpos($model->jamsostek, '.') + 1);
                        $file = '';
                        $assetUrl = Yii::$app->request->baseUrl;
                        if (!empty($model->jamsostek)){
                          if($type == 'pdf'){
                            $asdata = true;
                            $file = $assetUrl.'/app/assets/upload/jamsostek/'.$model->jamsostek;
                          }else{
                            $asdata = false;
                            $file = Html::img($assetUrl.'/app/assets/upload/jamsostek/'.$model->jamsostek,['width'=>'150']);
                          }
                        }
                        ?>

                        <?= $form->field($model, 'jamsostek')->widget(FileInput::className(),[
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
                              ['type' => $type ,'caption' => $model->jamsostek, 'deleteUrl' => false],
                            ],
                            'uploadAsync'=> true,
                            'maxFileSize' => 3*1024*1024,
                            'allowedExtensions' => ['jpg','png','jpeg', 'pdf'],
                          ]
                          ])?>
                        <?php else : ?>
                          <?= $form->field($model, 'jamsostek')->widget(FileInput::classname(), [
                            'options' => ['accept' => ''],
                            'pluginOptions' => [
                              'showUpload' => false,
                              'showCaption' => true,
                              'showRemove' => true,
                            ]
                          ]); ?>
                        <?php endif; ?>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="col-md-6">
                      <?php if (!$model->isNewRecord): ?>
                        <?php
                        $type = substr($model->bpjskesehatan, strrpos($model->bpjskesehatan, '.') + 1);
                        $file = '';
                        $assetUrl = Yii::$app->request->baseUrl;
                        if (!empty($model->bpjskesehatan)){
                          if($type == 'pdf'){
                            $asdata = true;
                            $file = $assetUrl.'/app/assets/upload/bpjskesehatan/'.$model->bpjskesehatan;
                          }else{
                            $asdata = false;
                            $file = Html::img($assetUrl.'/app/assets/upload/bpjskesehatan/'.$model->bpjskesehatan,['width'=>'150']);
                          }
                        }
                        ?>

                        <?= $form->field($model, 'bpjskesehatan')->widget(FileInput::className(),[
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
                              ['type' => $type ,'caption' => $model->bpjskesehatan, 'deleteUrl' => false],
                            ],
                            'uploadAsync'=> true,
                            'maxFileSize' => 3*1024*1024,
                            'allowedExtensions' => ['jpg','png','jpeg', 'pdf'],
                          ]
                          ])?>
                        <?php else : ?>
                          <?= $form->field($model, 'bpjskesehatan')->widget(FileInput::classname(), [
                            'options' => ['accept' => ''],
                            'pluginOptions' => [
                              'showUpload' => false,
                              'showCaption' => true,
                              'showRemove' => true,
                            ]
                          ]); ?>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                      <?php if (!$model->isNewRecord): ?>
                        <?php
                        $type = substr($model->npwp, strrpos($model->npwp, '.') + 1);
                        $file = '';
                        $assetUrl = Yii::$app->request->baseUrl;
                        if (!empty($model->npwp)){
                          if($type == 'pdf'){
                            $asdata = true;
                            $file = $assetUrl.'/app/assets/upload/npwp/'.$model->npwp;
                          }else{
                            $asdata = false;
                            $file = Html::img($assetUrl.'/app/assets/upload/npwp/'.$model->npwp,['width'=>'150']);
                          }
                        }
                        ?>

                        <?= $form->field($model, 'npwp')->widget(FileInput::className(),[
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
                              ['type' => $type ,'caption' => $model->npwp, 'deleteUrl' => false],
                            ],
                            'uploadAsync'=> true,
                            'maxFileSize' => 3*1024*1024,
                            'allowedExtensions' => ['jpg','png','jpeg', 'pdf'],
                          ]
                          ])?>
                        <?php else : ?>
                          <?= $form->field($model, 'npwp')->widget(FileInput::classname(), [
                            'options' => ['accept' => ''],
                            'pluginOptions' => [
                              'showUpload' => false,
                              'showCaption' => true,
                              'showRemove' => true,
                            ]
                          ]); ?>
                        <?php endif; ?>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="col-md-12">
                      <?php if (!$model->isNewRecord): ?>
                        <?php
                        $type = substr($model->suratlamarankerja, strrpos($model->suratlamarankerja, '.') + 1);
                        $file = '';
                        $assetUrl = Yii::$app->request->baseUrl;
                        if (!empty($model->suratlamarankerja)){
                          if($type == 'pdf'){
                            $asdata = true;
                            $file = $assetUrl.'/app/assets/upload/suratlamarankerja/'.$model->npwp;
                          }else{
                            $asdata = false;
                            $file = Html::img($assetUrl.'/app/assets/upload/suratlamarankerja/'.$model->npwp,['width'=>'150']);
                          }
                        }
                        ?>

                        <?= $form->field($model, 'suratlamarankerja')->widget(FileInput::className(),[
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
                              ['type' => $type ,'caption' => $model->suratlamarankerja, 'deleteUrl' => false],
                            ],
                            'uploadAsync'=> true,
                            'maxFileSize' => 3*1024*1024,
                            'allowedExtensions' => ['jpg','png','jpeg', 'pdf'],
                          ]
                          ])?>
                        <?php else : ?>
                          <?= $form->field($model, 'suratlamarankerja')->widget(FileInput::classname(), [
                            'options' => ['accept' => ''],
                            'pluginOptions' => [
                              'showUpload' => false,
                              'showCaption' => true,
                              'showRemove' => true,
                            ]
                          ]); ?>
                        <?php endif; ?>
                    </div>
                  </div>
              </div>
              </div>
              <div class="box-footer">
                <div class="pull-right">
                  <?= Html::submitButton((Yii::$app->controller->action->id == 'cwizard' or Yii::$app->controller->action->id == 'uwizard') ? 'Save & Next':'Save', ['class' => 'btn btn-success btn']) ?>
                  </div>
              </div>

              <?php ActiveForm::end(); ?>
            </div>
          </div>
        <?php endif; ?>
      <!-- end of show edit menu if user as superadmin -->

<!-- show edit menu if user not hiring yet -->
  <?php else :?>      
    <div class="box box-solid">
            <div class="box-body">

              <?php $form = ActiveForm::begin([
                'options'=>[
                  'enctype'=>'multipart/form-data'
                ]
              ]); ?>
              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-6">
                  <?php if (!$model->isNewRecord): ?>
                    <?php
                    $type = substr($model->ijazah, strrpos($model->ijazah, '.') + 1);
                    $file = '';
                    $assetUrl = Yii::$app->request->baseUrl;
                    if (!empty($model->ijazah)){
                      if($type == 'pdf'){
                        $asdata = true;
                        $file = $assetUrl.'/app/assets/upload/ijazah/'.$model->ijazah;
                      }else{
                        $asdata = false;
                        $file = Html::img($assetUrl.'/app/assets/upload/ijazah/'.$model->ijazah,['width'=>'150']);
                      }
                    }
                    ?>

                    <?= $form->field($model, 'ijazah')->widget(FileInput::className(),[
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
                          ['type' => $type ,'caption' => $model->ijazah, 'deleteUrl' => false],
                        ],
                        'uploadAsync'=> true,
                        // 'maxFileSize' => 10*1024*1024,
                        'allowedExtensions' => ['jpg','png','jpeg', 'pdf'],
                      ]
                      ])?>
                    <?php else : ?>
                      <?= $form->field($model, 'ijazah')->widget(FileInput::classname(), [
                        'options' => ['accept' => ''],
                        'pluginOptions' => [
                          'showUpload' => false,
                          'showCaption' => true,
                          'showRemove' => true,
                        ]
                      ]); ?>
                    <?php endif; ?>
                  </div>
                  <div class="col-md-6">
                  <?php if (!$model->isNewRecord): ?>
                    <?php
                    $type = substr($model->transkipnilai, strrpos($model->transkipnilai, '.') + 1);
                    $file = '';
                    $assetUrl = Yii::$app->request->baseUrl;
                    if (!empty($model->transkipnilai)){
                      if($type == 'pdf'){
                        $asdata = true;
                        $file = $assetUrl.'/app/assets/upload/transkipnilai/'.$model->transkipnilai;
                      }else{
                        $asdata = false;
                        $file = Html::img($assetUrl.'/app/assets/upload/transkipnilai/'.$model->transkipnilai,['width'=>'150']);
                      }
                    }
                    ?>

                    <?= $form->field($model, 'transkipnilai')->widget(FileInput::className(),[
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
                          ['type' => $type ,'caption' => $model->transkipnilai, 'deleteUrl' => false],
                        ],
                        'uploadAsync'=> true,
                        'maxFileSize' => 3*1024*1024,
                        'allowedExtensions' => ['jpg','png','jpeg', 'pdf'],
                      ]
                      ])?>
                    <?php else : ?>
                      <?= $form->field($model, 'transkipnilai')->widget(FileInput::classname(), [
                        'options' => ['accept' => ''],
                        'pluginOptions' => [
                          'showUpload' => false,
                          'showCaption' => true,
                          'showRemove' => true,
                        ]
                      ]); ?>
                    <?php endif; ?>
                  </div>
                  </div>
                  <div class="col-md-12">
                    <div class="col-md-6">
                      <?php if (!$model->isNewRecord): ?>
                        <?php
                        $type = substr($model->suratketerangansehat, strrpos($model->suratketerangansehat, '.') + 1);
                        $file = '';
                        $assetUrl = Yii::$app->request->baseUrl;
                        if (!empty($model->suratketerangansehat)){
                          if($type == 'pdf'){
                            $asdata = true;
                            $file = $assetUrl.'/app/assets/upload/suratketerangansehat/'.$model->suratketerangansehat;
                          }else{
                            $asdata = false;
                            $file = Html::img($assetUrl.'/app/assets/upload/suratketerangansehat/'.$model->suratketerangansehat,['width'=>'150']);
                          }
                        }
                        ?>

                        <?= $form->field($model, 'suratketerangansehat')->widget(FileInput::className(),[
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
                              ['type' => $type ,'caption' => $model->suratketerangansehat, 'deleteUrl' => false],
                            ],
                            'uploadAsync'=> true,
                            'maxFileSize' => 3*1024*1024,
                            'allowedExtensions' => ['jpg','png','jpeg', 'pdf'],
                          ]
                          ])?>
                        <?php else : ?>
                          <?= $form->field($model, 'suratketerangansehat')->widget(FileInput::classname(), [
                            'options' => ['accept' => ''],
                            'pluginOptions' => [
                              'showUpload' => false,
                              'showCaption' => true,
                              'showRemove' => true,
                            ]
                          ]); ?>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                      <?php if (!$model->isNewRecord): ?>
                        <?php
                        $type = substr($model->kartukeluarga, strrpos($model->kartukeluarga, '.') + 1);
                        $file = '';
                        $assetUrl = Yii::$app->request->baseUrl;
                        if (!empty($model->kartukeluarga)){
                          if($type == 'pdf'){
                            $asdata = true;
                            $file = $assetUrl.'/app/assets/upload/kartukeluarga/'.$model->kartukeluarga;
                          }else{
                            $asdata = false;
                            $file = Html::img($assetUrl.'/app/assets/upload/kartukeluarga/'.$model->kartukeluarga,['width'=>'150']);
                          }
                        }
                        ?>

                        <?= $form->field($model, 'kartukeluarga')->widget(FileInput::className(),[
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
                              ['type' => $type ,'caption' => $model->kartukeluarga, 'deleteUrl' => false],
                            ],
                            'uploadAsync'=> true,
                            'maxFileSize' => 3*1024*1024,
                            'allowedExtensions' => ['jpg','png','jpeg', 'pdf'],
                          ]
                          ])?>
                        <?php else : ?>
                          <?= $form->field($model, 'kartukeluarga')->widget(FileInput::classname(), [
                            'options' => ['accept' => ''],
                            'pluginOptions' => [
                              'showUpload' => false,
                              'showCaption' => true,
                              'showRemove' => true,
                            ]
                          ]); ?>
                        <?php endif; ?>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="col-md-6">
                      <?php if (!$model->isNewRecord): ?>
                        <?php
                        $type = substr($model->ktp, strrpos($model->ktp, '.') + 1);
                        $file = '';
                        $assetUrl = Yii::$app->request->baseUrl;
                        if (!empty($model->ktp)){
                          if($type == 'pdf'){
                            $asdata = true;
                            $file = $assetUrl.'/app/assets/upload/ktp/'.$model->ktp;
                          }else{
                            $asdata = false;
                            $file = Html::img($assetUrl.'/app/assets/upload/ktp/'.$model->ktp,['width'=>'150']);
                          }
                        }
                        ?>

                        <?= $form->field($model, 'ktp')->widget(FileInput::className(),[
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
                              ['type' => $type ,'caption' => $model->ktp, 'deleteUrl' => false],
                            ],
                            'uploadAsync'=> true,
                            'maxFileSize' => 3*1024*1024,
                            'allowedExtensions' => ['jpg','png','jpeg', 'pdf'],
                          ]
                          ])?>
                        <?php else : ?>
                          <?= $form->field($model, 'ktp')->widget(FileInput::classname(), [
                            'options' => ['accept' => ''],
                            'pluginOptions' => [
                              'showUpload' => false,
                              'showCaption' => true,
                              'showRemove' => true,
                            ]
                          ]); ?>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                      <?php if (!$model->isNewRecord): ?>
                        <?php
                        $type = substr($model->jamsostek, strrpos($model->jamsostek, '.') + 1);
                        $file = '';
                        $assetUrl = Yii::$app->request->baseUrl;
                        if (!empty($model->jamsostek)){
                          if($type == 'pdf'){
                            $asdata = true;
                            $file = $assetUrl.'/app/assets/upload/jamsostek/'.$model->jamsostek;
                          }else{
                            $asdata = false;
                            $file = Html::img($assetUrl.'/app/assets/upload/jamsostek/'.$model->jamsostek,['width'=>'150']);
                          }
                        }
                        ?>

                        <?= $form->field($model, 'jamsostek')->widget(FileInput::className(),[
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
                              ['type' => $type ,'caption' => $model->jamsostek, 'deleteUrl' => false],
                            ],
                            'uploadAsync'=> true,
                            'maxFileSize' => 3*1024*1024,
                            'allowedExtensions' => ['jpg','png','jpeg', 'pdf'],
                          ]
                          ])?>
                        <?php else : ?>
                          <?= $form->field($model, 'jamsostek')->widget(FileInput::classname(), [
                            'options' => ['accept' => ''],
                            'pluginOptions' => [
                              'showUpload' => false,
                              'showCaption' => true,
                              'showRemove' => true,
                            ]
                          ]); ?>
                        <?php endif; ?>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="col-md-6">
                      <?php if (!$model->isNewRecord): ?>
                        <?php
                        $type = substr($model->bpjskesehatan, strrpos($model->bpjskesehatan, '.') + 1);
                        $file = '';
                        $assetUrl = Yii::$app->request->baseUrl;
                        if (!empty($model->bpjskesehatan)){
                          if($type == 'pdf'){
                            $asdata = true;
                            $file = $assetUrl.'/app/assets/upload/bpjskesehatan/'.$model->bpjskesehatan;
                          }else{
                            $asdata = false;
                            $file = Html::img($assetUrl.'/app/assets/upload/bpjskesehatan/'.$model->bpjskesehatan,['width'=>'150']);
                          }
                        }
                        ?>

                        <?= $form->field($model, 'bpjskesehatan')->widget(FileInput::className(),[
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
                              ['type' => $type ,'caption' => $model->bpjskesehatan, 'deleteUrl' => false],
                            ],
                            'uploadAsync'=> true,
                            'maxFileSize' => 3*1024*1024,
                            'allowedExtensions' => ['jpg','png','jpeg', 'pdf'],
                          ]
                          ])?>
                        <?php else : ?>
                          <?= $form->field($model, 'bpjskesehatan')->widget(FileInput::classname(), [
                            'options' => ['accept' => ''],
                            'pluginOptions' => [
                              'showUpload' => false,
                              'showCaption' => true,
                              'showRemove' => true,
                            ]
                          ]); ?>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                      <?php if (!$model->isNewRecord): ?>
                        <?php
                        $type = substr($model->npwp, strrpos($model->npwp, '.') + 1);
                        $file = '';
                        $assetUrl = Yii::$app->request->baseUrl;
                        if (!empty($model->npwp)){
                          if($type == 'pdf'){
                            $asdata = true;
                            $file = $assetUrl.'/app/assets/upload/npwp/'.$model->npwp;
                          }else{
                            $asdata = false;
                            $file = Html::img($assetUrl.'/app/assets/upload/npwp/'.$model->npwp,['width'=>'150']);
                          }
                        }
                        ?>

                        <?= $form->field($model, 'npwp')->widget(FileInput::className(),[
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
                              ['type' => $type ,'caption' => $model->npwp, 'deleteUrl' => false],
                            ],
                            'uploadAsync'=> true,
                            'maxFileSize' => 3*1024*1024,
                            'allowedExtensions' => ['jpg','png','jpeg', 'pdf'],
                          ]
                          ])?>
                        <?php else : ?>
                          <?= $form->field($model, 'npwp')->widget(FileInput::classname(), [
                            'options' => ['accept' => ''],
                            'pluginOptions' => [
                              'showUpload' => false,
                              'showCaption' => true,
                              'showRemove' => true,
                            ]
                          ]); ?>
                        <?php endif; ?>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="col-md-12">
                      <?php if (!$model->isNewRecord): ?>
                        <?php
                        $type = substr($model->suratlamarankerja, strrpos($model->suratlamarankerja, '.') + 1);
                        $file = '';
                        $assetUrl = Yii::$app->request->baseUrl;
                        if (!empty($model->suratlamarankerja)){
                          if($type == 'pdf'){
                            $asdata = true;
                            $file = $assetUrl.'/app/assets/upload/suratlamarankerja/'.$model->npwp;
                          }else{
                            $asdata = false;
                            $file = Html::img($assetUrl.'/app/assets/upload/suratlamarankerja/'.$model->npwp,['width'=>'150']);
                          }
                        }
                        ?>

                        <?= $form->field($model, 'suratlamarankerja')->widget(FileInput::className(),[
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
                              ['type' => $type ,'caption' => $model->suratlamarankerja, 'deleteUrl' => false],
                            ],
                            'uploadAsync'=> true,
                            'maxFileSize' => 3*1024*1024,
                            'allowedExtensions' => ['jpg','png','jpeg', 'pdf'],
                          ]
                          ])?>
                        <?php else : ?>
                          <?= $form->field($model, 'suratlamarankerja')->widget(FileInput::classname(), [
                            'options' => ['accept' => ''],
                            'pluginOptions' => [
                              'showUpload' => false,
                              'showCaption' => true,
                              'showRemove' => true,
                            ]
                          ]); ?>
                        <?php endif; ?>
                    </div>
                  </div>
              </div>
              </div>
              <div class="box-footer">
                <div class="pull-right">
                  <?= Html::submitButton((Yii::$app->controller->action->id == 'cwizard' or Yii::$app->controller->action->id == 'uwizard') ? 'Save & Next':'Save', ['class' => 'btn btn-success btn']) ?>
                  </div>
              </div>

              <?php ActiveForm::end(); ?>
            </div>
      </div>
<!-- end of show edit menu if user not hiring yet -->

    <?php endif; ?>
  <?php endif; ?>