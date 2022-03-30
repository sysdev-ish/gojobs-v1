<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use app\models\Sapjob;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Mappingjobposition */
/* @var $form yii\widgets\ActiveForm */

if ($model->isNewRecord) {
    $dropdownparent = new yii\web\JsExpression('$("#createmappingjobposition-modal")');
} else {
    $dropdownparent = new yii\web\JsExpression('$("#updatemappingjobposition-modal")');
}
?>

<div class="mappingjobposition-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->errorSummary($model) ?>
    <div class="box-body table-responsive">
        <?php echo $form->field($model, 'status')
        ->dropdownList([1 => 'Publish', 0 => 'Unpublish'], ['prompt' => 'Select']); ?>
        <?php
        echo   $form->field($model, 'subjobfamilyid')->widget(Select2::classname(), [
            'data' => $subjobfamilyid,
            // 'initValueText' => $recruitreqs, // set the initial display text
            'options' => ['placeholder' => '- Select Sub Jobfamily -'],
            'pluginOptions' => [
                'dropdownParent' => $dropdownparent,
                'allowClear' => true,
            ],
        ]);
        ?>
        <?php
        $kodejabatan = ArrayHelper::map(Sapjob::find()->all(), 'value1', 'value1');
        echo   $form->field($model, 'kodejabatan')->widget(Select2::classname(), [
            'data' => $kodejabatan,
            // 'initValueText' => $recruitreqs, // set the initial display text
            // 'options' => ['placeholder' => '- Select -'],
            'options' => ['placeholder' => Yii::t('app', '- Select -')],
            'pluginOptions' => [
                'dropdownParent' => $dropdownparent,
                'allowClear' => true,
                // 'minimumInputLength' => 5,
            ],
        ]);
        ?>
        <?=
        $form->field($model, 'jabatansap')->widget(DepDrop::classname(), [
            'type' => DepDrop::TYPE_SELECT2,
            'options' => ['value1' => 'mappingjobposition-jabatansap'],
            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
            'pluginOptions' => [
                'depends' => ['mappingjobposition-kodejabatan'],
                'url' => Url::to(['/mappingjobposition/jabatans']),
                'placeholder' => Yii::t('app', '- Select -'),
            ]
        ]);
        ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>