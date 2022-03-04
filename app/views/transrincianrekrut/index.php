<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Transrincianrekrutsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transrincianrekruts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transrincianrekrut-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Create Transrincianrekrut', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'nojo',
                'detail_komp',
                'jabatan',
                'gender',
                // 'pendidikan',
                // 'lokasi',
                // 'atasan',
                // 'kontrak',
                // 'waktu',
                // 'jumlah',
                // 'komentar',
                // 'skema',
                // 'ket_done:ntext',
                // 'upd',
                // 'lup',
                // 'flag_jobs',
                // 'upd_jobs',
                // 'lup_jobs',
                // 'flag_app',
                // 'upd_app',
                // 'ket_rej:ntext',
                // 'status_rekrut',
                // 'ket_rekrut:ntext',
                // 'upd_rekrut',
                // 'pic_hi',
                // 'n_pic_hi',
                // 'pic_manar',
                // 'n_pic_manar',
                // 'pic_rekrut',
                // 'n_pic_rekrut',
                // 'level',
                // 'level_txt',
                // 'skilllayanan',
                // 'skilllayanan_txt',
                // 'level_sap',
                // 'persa_sap',
                // 'skill_sap',
                // 'area_sap',
                // 'jabatan_sap',
                // 'jabatan_sap_nm',
                // 'jenis_pro_sap',
                // 'skema_sap',
                // 'abkrs_sap',
                // 'hire_jabatan_sap',
                // 'zparam',
                // 'lup_skema',
                // 'upd_skema',
                // 'finish_view_manar',
                // 'idtr',
                // 'idtp',
                // 'typejo',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
