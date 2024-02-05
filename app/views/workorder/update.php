<?php

use app\models\MappingCity;
use app\models\Mappingjob;
use app\models\Mastercontract;
use app\models\Masterjobfamily;
use app\models\Masterlevel;
use app\models\WoClient;
use floor12\summernote\Summernote;
use kartik\date\DatePicker;
use kartik\file\FileInput;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Workorder */

$this->title = 'Update Workorder: ' . $model->wo_number;
$this->params['breadcrumbs'][] = ['label' => 'Workorders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

$dropdownparent = new yii\web\JsExpression('$("#updateworkorder-modal")');

?>
<div class="workorder-update">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data',
            // 'class' => 'form-control kv-editor-container'
        ]
    ]); ?>
    <div class="box-body">
        <!-- <? //= $form->field($model, 'project_name')->textInput(['maxlength' => true])->label('Title') 
                ?> -->
        <div class="row">
            <div class="col-lg-4">
                <?php echo $form->field($model, 'client_id')->widget(Select2::className(), [
                    'data' => ArrayHelper::map(WoClient::find()->asArray()->all(), 'id', 'client_name'),
                    'options' => ['placeholder' => '- Select Client -'],
                    'pluginOptions' => [
                        'dropdownParent' => $dropdownparent,
                        'allowClear' => true,
                    ],
                ])->label('Client'); ?>
            </div>
            <div class="col-lg-4">
                <?= $form->field($model, 'project_name')->textInput(['maxlength' => true])->label('Job Title') ?>
            </div>
            <div class="col-lg-4">
                <?php echo $form->field($model, 'job_code')->widget(Select2::className(), [
                    'data' => ArrayHelper::map(Mappingjob::find()->asArray()->all(), 'kodejabatan', 'jabatansap'),
                    'options' => ['placeholder' => '- Select Client -'],
                    'pluginOptions' => [
                        'dropdownParent' => $dropdownparent,
                        'allowClear' => true,
                    ],
                ])->label('Job SAP'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <?php echo $form->field($model, 'location')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(MappingCity::find()->asArray()->all(), 'city_id', 'city_name'),
                    'options' => ['placeholder' => '- select -'],
                    'pluginOptions' => [
                        'dropdownParent' => $dropdownparent,
                        'allowClear' => true,
                    ],
                ])->label('Location');
                ?>
            </div>
            <div class="col-lg-4">
                <?php echo $form->field($model, 'type_contract')->widget(Select2::className(), [
                    'data' => ArrayHelper::map(Mastercontract::find()->asArray()->all(), 'id', 'contract_name'),
                    'options' => ['placeholder' => '- Select Contract -'],
                    'pluginOptions' => [
                        'dropdownParent' => $dropdownparent,
                        'allowClear' => true,
                    ],
                ])->label('Type Contract'); ?>
            </div>
            <div class="col-lg-4">
                <?php echo $form->field($model, 'level')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Masterlevel::find()->asArray()->all(), 'id', 'level_name'),
                    'options' => ['placeholder' => '- select -'],
                    'pluginOptions' => [
                        'dropdownParent' => $dropdownparent,
                        'allowClear' => true,
                    ],
                ])->label('Job Level');
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <?= $form->field($model, 'project_end')->widget(
                    DatePicker::className(),
                    [
                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                        'options' => ['placeholder' => 'Project Date (Duration)', 'autocomplete' => 'off'],
                        'readonly' => true,
                        'removeButton' => false,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'startDate' => '-100y',
                            'endDate' => '+100y',
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,
                            'width' => '200px',
                        ]
                    ]
                );
                ?>
            </div>
            <div class="col-lg-3">
                <?= $form->field($model, 'total_job')->textInput(['maxlength' => true])->label('Total Job') ?>
            </div>
            <div class="col-lg-3">
                <?= $form->field($model, 'start_benefit')->textInput(['maxlength' => true])->label('Start salary') ?>
            </div>
            <div class="col-lg-3">
                <?= $form->field($model, 'end_benefit')->textInput(['maxlength' => true])->label('Until') ?>
            </div>
        </div>
        <!-- job description & requirement -->
        <div class="row">
            <div class="col-lg-4">
                <?= $form->field($model, 'job_description')->widget(Summernote::class)->label('Job Description') ?>
            </div>
            <div class="col-lg-4">
                <?= $form->field($model, 'job_requirement')->widget(Summernote::class)->label('Job Requirement') ?>
            </div>
            <div class="col-lg-4">
                <?= $form->field($model, 'file_path')->widget(FileInput::classname(), [
                    'options' => ['accept' => ''],
                    'pluginOptions' => [
                        'showUpload' => false,
                        'showCaption' => true,
                        'showRemove' => true,
                        'allowedExtensions' => ['jpg', 'png', 'jpeg', 'pdf'],
                    ]
                ])->label('Evidence Request'); ?>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>


</div>