<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use kartik\file\FileInput;
use floor12\summernote\Summernote;

/* @var $this yii\web\View */
/* @var $model app\models\Cms */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cms-form box box-primary">
    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data'
        ]
    ]); ?>
    <div class="box-body table-responsive">
        <?php echo $form->field($model, 'type_content')->widget(Select2::classname(), [
            'data' => [
                1 => 'Banner',
                2 => 'Privacy & Policy',
                3 => 'Terms & Condition',
                4 => 'About & Contact',
                5 => 'Benefit',
                6 => 'Process Recruitment',
                7 => 'Testimonial',
                8 => 'FAQ',
            ],
            'options' => ['placeholder' => '- Select Type -'],
        ])
        ?>
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'content')->widget(Summernote::class)->label('Content') ?>
        <?php if (!$model->isNewRecord) : ?>
            <?php
            $img = '';
            $json = [];
            $assetUrl = Yii::$app->request->baseUrl;
            if (!empty($model->assets_path)) {

                $img = Html::img($assetUrl . '/app/assets/upload/cms/' . $model->assets_path, ['width' => '150']);

                $json[] = [
                    'caption' => $model->assets_path, Url::to(['/cms/deletefile']),
                    'key' => $model->id,
                ];
            }
            ?>

            <?= $form->field($model, 'assets_path')->widget(FileInput::className(), [
                'options' => ['accept' => ''],
                'pluginOptions' => [
                    'showRemove' => false,
                    'showUpload' => false,
                    'showCancel' => false,
                    'overwriteInitial' => true,
                    'initialPreviewConfig' => $json,
                    'previewFileType' => 'any',
                    'initialPreview' => $img,
                    'uploadAsync' => true,
                    'maxFileSize' => 3 * 1024 * 1024,
                    'deleteUrl' => false,
                    'allowedExtensions' => ['jpg', 'png', 'jpeg'],
                ]
            ]) ?>
        <?php else : ?>
            <?= $form->field($model, 'assets_path')->widget(FileInput::classname(), [
                'options' => ['accept' => ''],
                'pluginOptions' => [
                    'showUpload' => false,
                ]
            ]); ?>
        <?php endif; ?>
        <?php echo $form->field($model, 'status')->widget(Select2::classname(), [
            'data' => [1 => 'Publish', 0 => 'Unpublish'],
            'options' => ['placeholder' => '- Select Status -'],
        ])
        ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>