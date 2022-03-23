<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Transrincianrekrut */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transrincianrekrut-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'nojo')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'detail_komp')->textInput() ?>

        <?= $form->field($model, 'jabatan')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'gender')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'pendidikan')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'lokasi')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'atasan')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'kontrak')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'waktu')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'jumlah')->textInput() ?>

        <?= $form->field($model, 'komentar')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'skema')->textInput() ?>

        <?= $form->field($model, 'ket_done')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'upd')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'lup')->textInput() ?>

        <?= $form->field($model, 'flag_jobs')->textInput() ?>

        <?= $form->field($model, 'upd_jobs')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'lup_jobs')->textInput() ?>

        <?= $form->field($model, 'flag_app')->textInput() ?>

        <?= $form->field($model, 'upd_app')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'ket_rej')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'status_rekrut')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'ket_rekrut')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'upd_rekrut')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'pic_hi')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'n_pic_hi')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'pic_manar')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'n_pic_manar')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'pic_rekrut')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'n_pic_rekrut')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'level')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'level_txt')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'skilllayanan')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'skilllayanan_txt')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'level_sap')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'persa_sap')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'skill_sap')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'area_sap')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'jabatan_sap')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'jabatan_sap_nm')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'jenis_pro_sap')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'skema_sap')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'abkrs_sap')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'hire_jabatan_sap')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'zparam')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'lup_skema')->textInput() ?>

        <?= $form->field($model, 'upd_skema')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'finish_view_manar')->textInput() ?>

        <?= $form->field($model, 'idtr')->textInput() ?>

        <?= $form->field($model, 'idtp')->textInput() ?>

        <?= $form->field($model, 'typejo')->textInput() ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
