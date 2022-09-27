<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use linslin\yii2\curl;

/* @var $this yii\web\View */
/* @var $model app\models\Transrincian */

$this->title = $model->nojo;
$this->params['breadcrumbs'][] = ['label' => 'Recruitment Request', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
<div class="col-md-6">
<div class="transrincian-view box box-solid">

    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'template' =>'<tr><th width="30%" style="text-align:right;">{label}</th><td>{value}</td></tr>',
            'options' => ['class' => 'table table-striped detail-view'],
            'attributes' => [
                'id',
                'nojo',
                // 'jobfunc.jobcat.name_job_function_category',
                [
                  'label' => 'Job Function',
                  'attribute' => 'jobfunc',
                  'format' => 'html',
                  'value'=>function ($data) {

                    return (is_numeric($data->jabatan)) ? $data->jobfunc->name_job_function : $data->jabatan;
                }

                ],
                [
                  'label' => 'Type Project',
                  'format' => 'html',
                  'value'=>function ($data) {
                    return ($data->typejo == 3)?'Temporary Request':(($data->typejo == 1)?"New Project":"Replacement");
                }

                ],
                [
                  'label' => 'Project',
                  'format' => 'html',
                  'value'=>function ($data) {
                    return $data->n_project;
                }

                ],
                [
                  'label' => 'Lama Project',
                  'format' => 'html',
                  'value'=>function ($data) {

                    return ($data->transjo->lama)?$data->transjo->lama." Bulan" : "";
                }

                ],
                [
                  'label' => 'Perner replaced',
                  'format' => 'html',
                  'value'=>function ($data) {

                    return ($data->typejo == 2)?(($data->perner)?$data->perner->perner:""): "";
                }

                ],
                [
                  'label' => 'Due Date JO',
                  'contentOptions'=>['style'=>'min-width: 100px;'],
                  'format' => 'html',
                  'value'=>function ($data) {
                    $datenow = date("Y-m-d");
                    if ($data->typejo == 1) {
                      $datenew = $data->transrincian->lup_skema;
                      $datenewplus = date('Y-m-d', strtotime($datenew . ' + 14 days'));
                      $now = new DateTime($datenow);
                      $date2 = new DateTime($datenew);
                      $duedate = $now->diff($date2);
                      return ($data->transrincian) ? 
                      (($duedate->d >= 1 && $data->status_rekrut == 1) ? '<span class="text-red">' . $datenewplus . "</span>" : $datenewplus)
                      : '-';
                    } else {
                      $daterep = $data->transperner->lup_skema;
                      $datereplace = date('Y-m-d', strtotime($daterep . ' + 6 days'));
                      $now = new DateTime($datenow);
                      $date2 = new DateTime($daterep);
                      $duedate = $now->diff($date2);
                      return ($data->transperner) ? (($duedate->d >= 1 && $data->status_rekrut == 1) ? '<span class="text-red">' . $datereplace . "</span>" : $datereplace) : '-';
                    }
                  }
                ],

                [
                  'label' => 'Approved JO',
                  'format' => 'html',
                  'value'=>function ($data) {

                    if($data->typejo == 1){
                      return ($data->transrincian)? (($data->transrincian->lup_skema AND $data->transrincian->lup_skema <> '0000-00-00')?$data->transrincian->lup_skema : ""):'';
                    }else{
                      return ($data->transperner)? (($data->transperner->lup_skema AND $data->transperner->lup_skema <> '0000-00-00')?$data->transperner->lup_skema : ""):'';

                    }
                }

                ],
                [
                  'label' => 'Over Due JO',
                  'contentOptions'=>['style'=>'min-width: 100px;'],
                  'format' => 'html',
                  'value'=>function ($data) {

                    if($data->typejo == 1){
                      $datejo =  ($data->transrincian)? $data->transrincian->lup_skema:null;
                    }else{
                      $datejo =  ($data->transperner)? $data->transperner->lup_skema : null;
                    }
                    $datenow = date("Y-m-d");
                    $duedate = '';
                    if($datejo){
                      $now = new DateTime($datenow);
                      $date2 = new DateTime($datejo);
                      $duedate = $now->diff($date2);
                      if($datejo < $datenow){
                        return $duedate->m.' Bulan '.$duedate->d.' Hari';
                      }else{
                        return '-';
                      }
                    }else{
                      return '-';
                    }
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
                [
                  'label' => 'Status',
                  'format' => 'html',
                  'value'=>function ($data) {

                    switch ($data->status_rekrut) {
                      case 1:
                        $status = "On Progress";
                        break;
                      case 2:
                        $status = "Done";
                        break;
                      case 3:
                        $status = "On Progress (Revised JO)";
                        break;
                      case 4:
                        $status = "Done (Revised JO)";
                        break;

                      default:
                        $status = '';
                        break;
                    }


                  return $status;
                }

                ],
                [
                  'label' => 'Personal Area (SAP)',
                  'format' => 'html',
                  'value'=>function ($data) {

                    return (Yii::$app->utils->getpersonalarea($data->persa_sap))?Yii::$app->utils->getpersonalarea($data->persa_sap).'-'.$data->persa_sap : "";

                }

                ],
                [
                  'label' => 'Area (SAP)',
                  'format' => 'html',
                  'value'=>function ($data) {

                    return (Yii::$app->utils->getarea($data->area_sap))?Yii::$app->utils->getarea($data->area_sap).'-'.$data->area_sap : "";
                }

                ],
                [
                  'label' => 'Skilllayanan (SAP)',
                  'format' => 'html',
                  'value'=>function ($data) {

                    return (Yii::$app->utils->getskilllayanan($data->skill_sap))?Yii::$app->utils->getskilllayanan($data->skill_sap).'-'.$data->skill_sap : "";
                }

                ],
                [
                  'label' => 'Payroll Area (SAP)',
                  'format' => 'html',
                  'value'=>function ($data) {

                    return (Yii::$app->utils->getpayrollarea($data->abkrs_sap))?Yii::$app->utils->getpayrollarea($data->abkrs_sap).'-'.$data->abkrs_sap : "";
                }

                ],
                [
                  'label' => 'Jabatan (SAP)',
                  'format' => 'html',
                  'value'=>function ($data) {
                    // return (Yii::$app->utils->getjabatan($data->abkrs_sap)) ? Yii::$app->utils->getjabatan($data->abkrs_sap) . '-' . $data->abkrs_sap : "";
                    return ($data->jabatansap)?$data->jabatansap->value2.'-'.$data->hire_jabatan_sap : "";
                }

                ],

                // 'ket_rekrut:ntext',
                // 'upd_rekrut',
                // 'pic_hi',
                // 'n_pic_hi',
                // 'pic_manar',
                // 'n_pic_manar',
                // 'pic_rekrut',
                // 'n_pic_rekrut',
                [
                  'label' => 'Level (SAP)',
                  'format' => 'html',
                  'value'=>function ($data) {
                    $curl = new curl\Curl();
                    $getlevels = $curl->setPostParams([
                      'level' => $data->level_sap,
                      'token' => 'ish**2019',
                    ])
                    ->post('http://192.168.88.5/service/index.php/sap_profile/getlevel');
                    $level  = json_decode($getlevels);
                    return ($level)?$level.'-'.$data->level_sap : "";
                }

                ],
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
    <div class="box-footer">
          <div class="row">
            <div class="col-sm-12 col-xs-12">
              <div class="description-block border-right">
                <h5 class="description-header"><?php echo $candidatecount; ?></h5>
                <span class="description-text">TOTAL Candidate</span>
              </div>
              <!-- /.description-block -->
            </div>

        </div>
        </div>
    <div class="box-footer">
          <div class="row">

            <div class="col-sm-4 col-xs-12">
              <div class="description-block border-right">
                <h5 class="description-header"><?php echo $onintcount; ?></h5>
                <span class="description-text">On Interview</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4 col-xs-12">
              <div class="description-block border-right">
                <h5 class="description-header"><?php echo $onpsicount; ?></h5>
                <span class="description-text">On Psikotest</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4 col-xs-12">
              <div class="description-block">
                <h5 class="description-header"><?php echo $onuintcount; ?></h5>
                <span class="description-text">On User Interview</span>
              </div>
              <!-- /.description-block -->
            </div>
          </div>
          <!-- /.row -->
          <div class="row">

            <div class="col-sm-4 col-xs-12">
              <div class="description-block border-right">
                <h5 class="description-header"><?php echo $intcount; ?></h5>
                <span class="description-text">Interview</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4 col-xs-12">
              <div class="description-block border-right">
                <h5 class="description-header"><?php echo $psicount; ?></h5>
                <span class="description-text">Psikotest</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4 col-xs-12">
              <div class="description-block">
                <h5 class="description-header"><?php echo $uintcount; ?></h5>
                <span class="description-text">User Interview</span>
              </div>
              <!-- /.description-block -->
            </div>
          </div>
          <!-- /.row -->

        </div>
</div>
<div class="box">
        <div class="box-header">
          <h3 class="box-title">Candidate</h3>


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
              <td><?php echo $value->userprofile->fullname; ?></td>
              <td>
                <?php
                if($value->status == 0){$label='label-warning';}elseif($value->status == 4 OR $value->status == 5 OR $value->status == 6 OR $value->status == 7){$label='label-success';}elseif($value->status == 8 OR $value->status == 9 OR $value->status == 10){$label='label-danger';}else{$label='label-primary';}
                echo '<span class="label '.$label.'">'.$value->statuscandidate->statusname.'</span>';
                ?>
                </td>
            </tr>
          <?php  }}else{
            echo '<tr><td colspan = "3">No data..</td></tr>';
          } ?>

          </tbody></table>
        </div>
        <!-- /.box-body -->

      </div>

</div>
<div class="col-md-6">
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
                  <td align="right"><?php echo (is_numeric($value->value))?number_format($value->value):$value->value; ?></td>
                </tr>
              <?php  }}else{
                echo '<tr><td colspan = "3">Use existing schema</td></tr>';
              } ?>

              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>
          <div class="box">
                    <div class="box-header">
                      <h3 class="box-title">Change Request / Stop Request</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                      <table class="table table-hover">
                        <tbody><tr>
                          <th>Request Date</th>
                          <th>Request By</th>
                          <th>Approved Date</th>
                          <th>Approve By</th>
                          <th>Status</th>
                          <th>Reason</th>
                        </tr>
                        <?php
                        if($crjo){
                        foreach ($crjo as $key => $value) {
                          switch ($value->status) {
                            case '1':
                              $status = '<span class="label label-warning">Waiting Approval I</span>';
                              break;
                            case '2':
                              $status = '<span class="label label-warning">Waiting Approval II</span>';
                              break;
                            case '3':
                              $status = '<span class="label label-success">Approved</span>';
                              break;
                            case '4':
                              $status = '<span class="label label-danger">Rejected</span>';
                              break;

                            default:
                              $status = '';
                              break;
                          }
                          ?>
                          <tr>
                            <td><?php echo $value->createtime; ?></td>
                            <td><?php echo $value->createdbyu->name; ?></td>
                            <td><?php echo $value->approvedtime; ?></td>
                            <td><?php echo ($value->approvedby)?$value->approvedbyu->name:''; ?></td>
                            <td><?php echo $status; ?></td>
                            <td><?php echo $value->remarks; ?></td>
                          </tr>
                        <?php }}else{ ?>
                          <tr>
                            <td colspan="6">No data...</td>
                          </tr>
                        <?php } ?>

                      </tbody></table>
                    </div>
                    <!-- /.box-body -->
                  </div>

</div>

</div>
