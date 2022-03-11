<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MappingJobPositionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mapping-job-position-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'jabatan_sap') ?>

    <?= $form->field($model, 'kode_jabatan') ?>

    <?= $form->field($model, 'kode_posisi') ?>

    <?= $form->field($model, 'subjobfamily_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
