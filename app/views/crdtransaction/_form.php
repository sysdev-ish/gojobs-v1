<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\Crdtransaction */
/* @var $form yii\widgets\ActiveForm */

switch ($param) {
    case 1:
        $label = 'No NPWP';
        $path = 'npwp';
        break;
    case 2:
        $label = 'No BPJS Kesehatan';
        $path = 'bpjskesehatan';
        break;
    case 3:
        $label = 'No BPJS Tenaga Kerja';
        $path = 'jamsostek';
        break;
    case 4:
        $label = 'Bank';
        $path = 'bankaccount';
        break;
    default:
        $label = '';
        $path = '';
}
?>

<!-- <div class="crdtransaction-form box box-primary"> -->
    <?php $form = ActiveForm::begin([
      'options'=>[
        'enctype'=>'multipart/form-data'
      ]
    ]); ?>
    <div class="box-body table-responsive">

      <?php
      if($param == 4) :
      echo   $form->field($model, 'newvalue')->widget(Select2::classname(), [
        'data' => $bank,
        'options' => ['placeholder' => '- select -'
        ],
        'pluginOptions' => [
            'dropdownParent' => new yii\web\JsExpression('$("#crformupdatebank-modal")'),
            'allowClear' => false,
            'initialize' => true,
        ],
      ])->label($label);
      ?>

        <?= $form->field($model, 'newvalue2')->textInput(['maxlength' => false])->label('Bank Account Number') ?>
        <?php echo   $form->field($model, 'bankreasonid')->widget(Select2::classname(), [
          'data' => $bankreason,
          'options' => ['placeholder' => '- select -'
          ],
          'pluginOptions' => [
              'dropdownParent' => new yii\web\JsExpression('$("#crformupdatebank-modal")'),
              'allowClear' => false,
              'initialize' => true,
          ],
        ]); ?>
      <?php else : ?>
        <?= $form->field($model, 'newvalue')->textInput(['maxlength' => true])->label($label) ?>
      <?php endif; ?>

        <?php if (!$model->isNewRecord && $model->newdoc): ?>
          <?php
          $type = substr($model->newdoc, strrpos($model->newdoc, '.') + 1);
          $file = '';
          $assetUrl = Yii::$app->request->baseUrl;
          if (!empty($model->newdoc)){
            if($type == 'pdf'){
              $asdata = true;
              $file = $assetUrl.'/app/assets/upload/'.$path.'/'.$model->newdoc;
            }else{
              $asdata = false;
              $file = Html::img($assetUrl.'/app/assets/upload/'.$path.'/'.$model->newdoc,['width'=>'150']);
            }
          }
          ?>

          <?= $form->field($model, 'newdoc')->widget(FileInput::className(),[
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
                ['type' => $type ,'caption' => $model->newdoc, 'deleteUrl' => false],
              ],
              'uploadAsync'=> true,
              'maxFileSize' => 3*1024*1024,
              'allowedExtensions' => ['jpg','png','jpeg', 'pdf'],
            ]
            ])->label('File') ?>
          <?php else : ?>
            <?= $form->field($model, 'newdoc')->widget(FileInput::classname(), [
              'options' => ['accept' => ''],
              'pluginOptions' => [
                'showUpload' => false,
                'showCaption' => true,
                'showRemove' => true,
              ]
            ])->label('File'); ?>
          <?php endif; ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>
<!-- </div> -->
