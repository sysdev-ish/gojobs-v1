<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Transrinciansearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transrincian-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nojo') ?>

    <?= $form->field($model, 'jabatan') ?>

    <?= $form->field($model, 'gender') ?>

    <?= $form->field($model, 'pendidikan') ?>

    <?php // echo $form->field($model, 'lokasi') ?>

    <?php // echo $form->field($model, 'atasan') ?>

    <?php // echo $form->field($model, 'kontrak') ?>

    <?php // echo $form->field($model, 'waktu') ?>

    <?php // echo $form->field($model, 'jumlah') ?>

    <?php // echo $form->field($model, 'komentar') ?>

    <?php // echo $form->field($model, 'skema') ?>

    <?php // echo $form->field($model, 'ket_done') ?>

    <?php // echo $form->field($model, 'upd') ?>

    <?php // echo $form->field($model, 'lup') ?>

    <?php // echo $form->field($model, 'flag_jobs') ?>

    <?php // echo $form->field($model, 'upd_jobs') ?>

    <?php // echo $form->field($model, 'lup_jobs') ?>

    <?php // echo $form->field($model, 'flag_app') ?>

    <?php // echo $form->field($model, 'upd_app') ?>

    <?php // echo $form->field($model, 'ket_rej') ?>

    <?php // echo $form->field($model, 'status_rekrut') ?>

    <?php // echo $form->field($model, 'ket_rekrut') ?>

    <?php // echo $form->field($model, 'upd_rekrut') ?>

    <?php // echo $form->field($model, 'pic_hi') ?>

    <?php // echo $form->field($model, 'n_pic_hi') ?>

    <?php // echo $form->field($model, 'pic_manar') ?>

    <?php // echo $form->field($model, 'n_pic_manar') ?>

    <?php // echo $form->field($model, 'pic_rekrut') ?>

    <?php // echo $form->field($model, 'n_pic_rekrut') ?>

    <?php // echo $form->field($model, 'level') ?>

    <?php // echo $form->field($model, 'level_txt') ?>

    <?php // echo $form->field($model, 'skilllayanan') ?>

    <?php // echo $form->field($model, 'skilllayanan_txt') ?>

    <?php // echo $form->field($model, 'level_sap') ?>

    <?php // echo $form->field($model, 'persa_sap') ?>

    <?php // echo $form->field($model, 'skill_sap') ?>

    <?php // echo $form->field($model, 'area_sap') ?>

    <?php // echo $form->field($model, 'jabatan_sap') ?>

    <?php // echo $form->field($model, 'jabatan_sap_nm') ?>

    <?php // echo $form->field($model, 'jenis_pro_sap') ?>

    <?php // echo $form->field($model, 'skema_sap') ?>

    <?php // echo $form->field($model, 'abkrs_sap') ?>

    <?php // echo $form->field($model, 'hire_jabatan_sap') ?>

    <?php // echo $form->field($model, 'zparam') ?>

    <?php // echo $form->field($model, 'lup_skema') ?>

    <?php // echo $form->field($model, 'upd_skema') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
