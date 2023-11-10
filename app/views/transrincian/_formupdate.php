<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
// use kartik\editors\Summernote;
// use kartik\editors\Summernote;
// use floor12\summernote\Summernote;
use floor12\summernote\Summernote;
use kartik\file\FileInput;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\Crdtransaction */
/* @var $form yii\widgets\ActiveForm */
?>

<!-- <div class="crdtransaction-form box box-primary"> -->
<?php $form = ActiveForm::begin([
    'options' => [
        'enctype' => 'multipart/form-data',
        // 'class' => 'form-control kv-editor-container'
    ]
]); ?>
<blockquote>
    <p>Edit description & requirement for Recruitment request No Jo: <?php echo $model->nojo; ?></p>
</blockquote>
<div class="box-body">

    <?php
    echo   $form->field($model, 'status_rekrut')->widget(Select2::classname(), [
        'data' => ['2' => 'Done', '1' => 'On Progress'],
        'options' => ['placeholder' => '- select -'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])->label('Status Recruitment Job Order');
    ?>
    <!-- <? //= $form->field($modeljo, 'syarat')->textArea(['rows' => 4, 'id' => 'textarea_requirement'])->label('Requirement') 
            ?> -->
    <?= $form->field($modeljo, 'syarat')->widget(Summernote::class)->label('Syarat') ?>
    <span style="margin-bottom: 10px;">Sangat disarankan menggunakan Unordered List</span>

    <!-- <? //= $form->field($modeljo, 'deskripsi')->textArea(['rows' => 4, 'id' => 'textarea_description'])->label('Description') 
            ?> -->
    <?= $form->field($modeljo, 'deskripsi')->widget(Summernote::class)->label('Description') ?>
    <span>Sangat disarankan menggunakan Unordered List</span>

</div>
<div class="box-footer">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat pull-right']) ?>
</div>
<?php ActiveForm::end(); ?>

<!-- <script>
    $(document).ready(function() {
        $('#textarea_requirement').summernote({
            height: 300, // Set the height as needed.
        });
        $('#textarea_description').summernote({
            height: 300, // Set the height as needed.
        });
    });
</script> -->