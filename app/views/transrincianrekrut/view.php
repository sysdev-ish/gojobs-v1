<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Transrincianrekrut */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Transrincianrekruts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transrincianrekrut-view box box-primary">
    <div class="box-header">
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'nojo',
                'detail_komp',
                'jabatan',
                'gender',
                'pendidikan',
                'lokasi',
                'atasan',
                'kontrak',
                'waktu',
                'jumlah',
                'komentar',
                'skema',
                'ket_done:ntext',
                'upd',
                'lup',
                'flag_jobs',
                'upd_jobs',
                'lup_jobs',
                'flag_app',
                'upd_app',
                'ket_rej:ntext',
                'status_rekrut',
                'ket_rekrut:ntext',
                'upd_rekrut',
                'pic_hi',
                'n_pic_hi',
                'pic_manar',
                'n_pic_manar',
                'pic_rekrut',
                'n_pic_rekrut',
                'level',
                'level_txt',
                'skilllayanan',
                'skilllayanan_txt',
                'level_sap',
                'persa_sap',
                'skill_sap',
                'area_sap',
                'jabatan_sap',
                'jabatan_sap_nm',
                'jenis_pro_sap',
                'skema_sap',
                'abkrs_sap',
                'hire_jabatan_sap',
                'zparam',
                'lup_skema',
                'upd_skema',
                'finish_view_manar',
                'idtr',
                'idtp',
                'typejo',
            ],
        ]) ?>
    </div>
</div>
