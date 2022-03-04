<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Transrincian */

$this->title = $model->nojo;
$this->params['breadcrumbs'][] = ['label' => 'Recruitment Request', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
<div class="col-md-5">
<div class="transrincian-view box box-solid">

    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'template' =>'<tr><th width="30%" style="text-align:right;">{label}</th><td>{value}</td></tr>',
            'options' => ['class' => 'table table-striped detail-view'],
            'attributes' => [
                'nojo',
                'jobfunc.jobcat.name_job_function_category',
                'jobfunc.name_job_function',
                [
                  'label' => 'Project',
                  // 'contentOptions'=>['style'=>'width: 150px;'],
                  'format' => 'html',
                  'value'=>function ($data) {

                    return ($data->transjo->n_project == '' || $data->transjo->n_project == 'Pilih')?$data->transjo->project : $data->transjo->n_project;
                }

                ],
                'gender',
                'pendidikan',
                'city.city_name',
                // 'atasan',
                'kontrak',
                'waktu',
                'jumlah',
                // 'komentar',
                // 'skema',
                // 'ket_done:ntext',

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
            ],
        ]) ?>
    </div>

</div>
<div class="box">
        <div class="box-header">
          <h3 class="box-title">Candidate</h3>

          <div class="box-tools">
            <div class="input-group input-group-sm" style="width: 150px;">
              <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

              <div class="input-group-btn">
                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
              </div>
            </div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
          <table class="table table-hover">
            <tbody><tr>
              <th>No</th>
              <th>Applicant name</th>
              <th>Status</th>
            </tr>
            <?php
            if($candidate){
            foreach ($candidate as $key => $value) {?>
            <tr>
              <td><?php echo $key+1; ?></td>
              <td></td>
              <td><span class="label label-success">Approved</span></td>
            </tr>
          <?php  }}else{
            echo '<tr><td colspan = "3">No data..</td></tr>';
          } ?>

          </tbody></table>
        </div>
        <!-- /.box-body -->
      </div>
</div>
<div class="col-md-7">
  <div class="box">
            <div class="box-header">
              <h3 class="box-title">Detail Schema</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover table-striped ">
                <tbody><tr>
                  <th>No.</th>
                  <th>Komponen</th>
                  <th style="text-align:right;">Value</th>
                </tr>
                <?php
                if($transkomponen){
                foreach ($transkomponen as $key => $value) {?>
                <tr>
                  <td><?php echo $key+1; ?></td>
                  <td><?php echo $value->komponen_txt; ?></td>
                  <td align="right"><?php echo number_format($value->value); ?></td>
                </tr>
              <?php  }}else{
                echo '<tr><td colspan = "3">Use existing schema</td></tr>';
              } ?>

              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>
</div>
</div>
