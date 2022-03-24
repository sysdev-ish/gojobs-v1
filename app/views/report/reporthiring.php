<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use app\models\Masterstatushiring;
use app\models\Transrincian;
use app\models\Userfamily;
use app\models\Userformaleducation;
use app\models\Mastereducation;
use app\models\Userworkexperience;
use app\models\Userabout;
use app\models\Recruitmentcandidate;
use app\models\Masterinfoofrecruitment;
use app\models\Interview;
use app\models\Psikotest;
use app\models\Userinterview;
use app\models\Tsoftskill;
use app\models\Thardskill;
use app\models\Tpasif;
use app\models\Taktif;
use app\models\User;
use app\models\Sappayrollarea;
use app\models\Sappersonalarea;
use app\models\Saparea;
use app\models\Sapskilllayanan;
use app\models\Transperner;
use app\models\Transrincianori;
use app\models\Hiring;
use app\models\Uservaksin;
use app\models\Masterjobfamily;
use app\models\Mastersubjobfamily;
use yii\helpers\ArrayHelper;
use kartik\export\ExportMenu;
use linslin\yii2\curl;


/* @var $this yii\web\View */
/* @var $searchModel app\models\Hiringsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hiring Report';
$this->params['breadcrumbs'][] = $this->title;

if(Yii::$app->user->isGuest){
  $role = null;
}else{
  // $userid = Yii::$app->user->identity->id;
  $role = Yii::$app->user->identity->role;
}
app\assets\ReportAsset::register($this);
?>
<div class="hiring-index box box-default">
    <div class="box-body">
        <?php echo $this->render('_search', [
          'model' => $searchModel,
          'area' => $area,
          'parea' => $parea,
          'jabatan' => $jabatan,
          'areaish' => $areaish,
          'region' => $region,
          'jobfamily' => $jobfamily,
          'subjobfamily' => $subjobfamily,
        ]); ?>
    </div>
</div>
<div class="row">
        <div class="col-md-5 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Hired</span>
              <span class="info-box-number"><?php echo $dataProvider['dataProvider']->getTotalCount(); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-institution (alias)"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Hired By Personal Area</span>
              <span class="info-box-number"><?php echo $dataProvider['bypersonalarea']->getTotalCount(); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Hired By Education</h3>

              <!-- <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="chart-responsive">
                    <canvas id="pieChart" height="160" width="206" style="width: 206px; height: 160px;"></canvas>
                  </div>
                  <!-- ./chart-responsive -->
                </div>
                <!-- /.col -->
                <div class="col-md-6">
                  <ul class="chart-legend clearfix">
                    <li><i class="fa fa-circle-o text-red"></i> Elementary school <span class="pull-right badge bg-red"><?php echo ($dataProvider['byedusd'])?round(($dataProvider['byedusd']->getTotalCount()/$dataProvider['dataProvider']->getTotalCount()  * 100),1).' %':'0 %'; ?></span></li>
                    <li><i class="fa fa-circle-o text-green"></i> Junior high school <span class="pull-right badge bg-green"><?php echo ($dataProvider['byedusmp'])?round(($dataProvider['byedusmp']->getTotalCount()/$dataProvider['dataProvider']->getTotalCount()  * 100),1).' %':'0 %'; ?></span></li>
                    <li><i class="fa fa-circle-o text-yellow"></i> Senior high school <span class="pull-right badge bg-yellow"><?php echo ($dataProvider['byedusma'])?round(($dataProvider['byedusma']->getTotalCount()/$dataProvider['dataProvider']->getTotalCount()  * 100),1).' %':'0 %'; ?></span></li>
                    <li><i class="fa fa-circle-o text-aqua"></i> Associate degree <span class="pull-right badge bg-aqua"><?php echo ($dataProvider['byedud3'])?round(($dataProvider['byedud3']->getTotalCount()/$dataProvider['dataProvider']->getTotalCount()  * 100),1).' %':'0 %'; ?></span></li>
                    <li><i class="fa fa-circle-o text-light-blue"></i> Bachelor degree <span class="pull-right badge bg-blue"><?php echo ($dataProvider['byedus1'])?round(($dataProvider['byedus1']->getTotalCount()/$dataProvider['dataProvider']->getTotalCount()  * 100),1).' %':'0 %'; ?></span></li>
                    <li><i class="fa fa-circle-o text-gray"></i> Master degree <span class="pull-right badge bg-gray"><?php echo ($dataProvider['byedus2'])?round(($dataProvider['byedus2']->getTotalCount()/$dataProvider['dataProvider']->getTotalCount()  * 100),1).' %':'0 %'; ?></span></li>
                    <li><i class="fa fa-circle-o text-black"></i> Doctoral degree <span class="pull-right badge bg-black"><?php echo ($dataProvider['byedus3'])?round(($dataProvider['byedus3']->getTotalCount()/$dataProvider['dataProvider']->getTotalCount()  * 100),1).' %':'0 %'; ?></span></li>
                  </ul>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-body -->

          </div>




        </div>
        <!-- /.col -->
        <div class="col-md-7 col-sm-6 col-xs-12">
        <div class="box">
        <div class="box-header">
              <h3 class="box-title">Data Hiring</h3>
              <div class="box-tools pull-right">
                <?php
                $gridColumns = [
                    ['class' => 'kartik\grid\SerialColumn'],
                    'userprofile.fullname',
                    'perner',
                    [
                      'label' => 'Jabatan (SAP)',
                      // 'show' => false,
                      // 'attribute' => 'jabatansap',
                      // 'contentOptions'=>['style'=>'width: 150px;'],
                      'format' => 'raw',
                      'value'=>function ($data) {

                        return ($data->recrequest->hire_jabatan_sap)? ((is_numeric($data->recrequest->hire_jabatan_sap))?$data->recrequest->jabatansap->value2:'-'):'-';
                    }

                    ],
                    'recrequest.id',
                    'recrequest.nojo',
                    [
                      'label' => 'Tipe SAP',
                      'format' => 'raw',
                      'value'=>function ($data) {

                        return ($data->typejo == 1)?"ISH" : "PERALIHAN";
                    }

                    ],
                    [
                      'label' => 'Tipe Job Order',
                      'format' => 'raw',
                      'value'=>function ($data) {
                        return ($data->recrequest->typejo == 1)? "New Project" : "Replacement";
                    }

                    ],
                    [
                      'label' => 'Tanggal Create Jo',
                      'format' => ['date', 'php:Y-m-d'],
                      'value'=>function ($data) {

                        return ($data->recrequest->transjo)?$data->recrequest->transjo->tanggal : "";
                    }

                    ],
                    [
                      'label' => 'Tanggal Approved JO',
                      'format' => ['date', 'php:Y-m-d'],
                      'value'=>function ($data) {

                        if($data->recrequest->typejo == 1){
                          $getapprovejo = Transrincianori::find()->where(['id' => $data->recrequest->idpktable])->one();
                        }else{
                          $getapprovejo = Transperner::find()->where(['id' => $data->recrequest->idpktable])->one();

                        }


                        return ($getapprovejo)?(($getapprovejo->lup_skema AND $getapprovejo->lup_skema <> '0000-00-00')?$getapprovejo->lup_skema : ""):"";
                    }

                    ],
                    [
                      'label' => 'Tipe Job Order',
                      'format' => 'raw',
                      'value'=>function ($data) {
                        return ($data->recrequest->typejo == 1)? "New Project" : "Replacement";
                    }

                    ],
                    [
                      'label' => 'Personal Area (SAP)',
                      'format' => 'raw',
                      'value'=>function ($data) {
                        $personalarea = Sappersonalarea::find()->where(['value1' => $data->recrequest->persa_sap])->one();
                        return ($personalarea)?$personalarea->value2 : "";
                    }

                    ],
                    [
                      'label' => 'Kode Personal Area',
                      'format' => 'raw',
                      'value'=>function ($data) {

                        return ($data->recrequest->persa_sap)?$data->recrequest->persa_sap : "";

                    }

                    ],
                    [
                      'label' => 'Area (SAP)',
                      'format' => 'raw',
                      'value'=>function ($data) {
                            $area = Saparea::find()->where(['value1' => $data->recrequest->area_sap])->one();
                            return ($area)?$area->value2 : "";
                        }

                    ],
                    [
                      'label' => 'Skilllayanan (SAP)',
                      'format' => 'raw',
                      'value'=>function ($data) {
                        $skill = Sapskilllayanan::find()->where(['value1' => $data->recrequest->skill_sap])->one();
                        return ($skill)?$skill->value2 : "";
                    }

                    ],
                    [
                      'label' => 'Payroll Area (SAP)',
                      'format' => 'raw',
                      'value'=>function ($data) {
                        $payarea = Sappayrollarea::find()->where(['value1' => $data->recrequest->abkrs_sap])->one();
                        return ($payarea)?$payarea->value2 : "";
                    }

                    ],
                    [
                      'label' => 'Kode Payroll Area (SAP)',
                      'format' => 'raw',
                      'value'=>function ($data) {

                        return ($data->recrequest->abkrs_sap)?$data->recrequest->abkrs_sap : "";
                    }

                    ],
                  [
                    'label' => 'Job Family',
                    'format' => 'raw',
                    'value' => function ($data) {
                      $jobfamily = Masterjobfamily::find()->where(['id' => $data->recrequest->jobfamily])->one();
                      return ($jobfamily) ? $jobfamily->jobfamily : "";
                    }

                  ],
                  [
                    'label' => 'Sub Job Family',
                    'format' => 'raw',
                    'value' => function ($data) {
                      $subjobfamily = Mastersubjobfamily::find()->where(['id' => $data->recrequest->subjobfamily])->one();
                      return ($subjobfamily) ? $subjobfamily->subjobfamily : "";
                    }

                  ],
                    [
                      'label' => 'Jumlah Permintaan SDM',
                      'format' => 'raw',
                      'value'=>function ($data) {

                        return ($data->recrequest->jumlah)?$data->recrequest->jumlah : "";
                    }

                    ],
                    [
                      'label' => 'Status Pemenuhan (hiring)',
                      'format' => 'raw',
                      'value'=>function ($data) {
                        switch ($data->recrequest->status_rekrut) {
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
                      'label' => 'Jumlah Pemenuhan (Hiring)',
                      'format' => 'raw',
                      'value'=>function ($data) {
                        $hired = Hiring::find()->where(['recruitreqid'=>$data->recruitreqid,'statushiring'=>[4,7,8]])->count();
                        $hiredpending = Hiring::find()->where(['recruitreqid'=>$data->recruitreqid,'statushiring'=>3])->count();
                        return ($hired)?$hired:(($hiredpending)?"Fail On Hiring":"-");
                    }

                    ],
                    'awalkontrak',
                    'akhirkontrak',
                    [
                      'label' => 'Status Kontrak',
                      'format' => 'raw',
                      'value'=>function ($data) {

                        return ($data->recrequest->kontrak)?$data->recrequest->kontrak : "";
                    }

                    ],
                    [
                      'label' => 'Tanggal Register Gojobs',
                      'format' => ['date', 'php:Y-m-d'],
                      'value'=>function ($data) {

                        return ($data->userprofile->createtime)?$data->userprofile->createtime : "";
                    }

                    ],
                    [
                      'label' => 'No Telp',
                      'value'=>function ($data) {

                        return ($data->userprofile->phone)?$data->userprofile->phone : "";
                    }

                    ],
                    [
                      'label' => 'email',
                      'format' => 'raw',
                      'value'=>function ($data) {
                        $email = null;
                            $user = User::find()->where(['id' => $data->userid])->one();
                            if($user){
                              $email = $user->email;
                            }
                        return ($email)?$email : "";
                    }

                    ],
                    [
                      'label' => 'Jenis Kelamin',
                      'format' => 'raw',
                      'value'=>function ($data) {

                        return ($data->userprofile->gender)?$data->userprofile->gender : "";
                    }

                    ],
                    [
                      'label' => 'Tanggal Lahir',
                      'format' => ['date', 'php:Y-m-d'],
                      'value'=>function ($data) {

                        return ($data->userprofile->birthdate)?$data->userprofile->birthdate : "";
                    }

                    ],
                    [
                      'label' => 'Tempat Lahir',
                      'format' => 'raw',
                      'value'=>function ($data) {

                        return ($data->userprofile->birthplace)?$data->userprofile->birthplace : "";
                    }

                    ],
                    [
                      'label' => 'Alamat KTP',
                      'format' => 'raw',
                      'value'=>function ($data) {

                        return ($data->userprofile->addressktp)?$data->userprofile->addressktp : "";
                    }

                    ],
                    [
                      'label' => 'Kota KTP',
                      'format' => 'raw',
                      'value'=>function ($data) {

                        return ($data->userprofile->cityktp->kota)?$data->userprofile->cityktp->kota : "";
                    }

                    ],
                    [
                      'label' => 'Provinsi KTP',
                      'format' => 'raw',
                      'value'=>function ($data) {

                        return ($data->userprofile->provincektp->provinsi)?$data->userprofile->provincektp->provinsi : "";
                    }

                    ],
                    [
                      'label' => 'Alamat Domisili',
                      'format' => 'raw',
                      'value'=>function ($data) {

                        return ($data->userprofile->address)?$data->userprofile->address : "";
                    }

                    ],
                    [
                      'label' => 'Kota Domisili',
                      'format' => 'raw',
                      'value'=>function ($data) {

                        return ($data->userprofile->city->kota)?$data->userprofile->city->kota : "";
                    }

                    ],
                    [
                      'label' => 'Provinsi Domisili',
                      'format' => 'raw',
                      'value'=>function ($data) {

                        return ($data->userprofile->province->provinsi)?$data->userprofile->province->provinsi : "";
                    }

                    ],
                    [
                      'label' => 'Nama Ibu Kandung',
                      'format' => 'raw',
                      'value'=>function ($data) {
                        $ibukandung = Userfamily::find()->where(['userid' => $data->userid, 'relationship'=>'mother'])->one();
                        return ($ibukandung)?$ibukandung->fullname : "";
                    }

                    ],
                    [
                      'label' => 'Agama',
                      'format' => 'raw',
                      'value'=>function ($data) {

                        return ($data->userprofile->religion)?$data->userprofile->religion : "";
                    }

                    ],
                    [
                      'label' => 'Golongan Darah',
                      'format' => 'raw',
                      'value'=>function ($data) {

                        return ($data->userprofile->bloodtype)?$data->userprofile->bloodtype : "";
                    }

                    ],
                    [
                      'label' => 'Status Pernikahan',
                      'format' => 'raw',
                      'value'=>function ($data) {

                        return ($data->userprofile->maritalstatus)?$data->userprofile->maritalstatus : "";
                    }

                    ],
                    [
                      // 'class' => 'kartik\grid\EditableColumn',
                      'label' => 'No KTP',
                      'format'=>'text',
                      'value'=>function ($data) {
                        // var_dump($data->userprofile->identitynumber);die;
                        return ($data->userprofile->identitynumber)? number_format($data->userprofile->identitynumber,0,","," ") : "";
                    }

                    ],
                    [
                      'label' => 'No BPJS TK',
                      'format'=>'text',
                      'value'=>function ($data) {

                        return (is_string($data->userprofile->jamsosteknumber))?$data->userprofile->jamsosteknumber:(($data->userprofile->jamsosteknumber)?number_format($data->userprofile->jamsosteknumber,0,","," ") : "");
                    }

                    ],
                    [
                      'label' => 'No BPJS Kesehatan',
                      'format'=>'text',
                      'value'=>function ($data) {

                        return ($data->userprofile->bpjsnumber)?$data->userprofile->bpjsnumber : "";
                    }

                    ],
                    [
                      'label' => 'No NPWP',
                      'format'=>'text',
                      'value'=>function ($data) {

                        return ($data->userprofile->npwpnumber)?number_format($data->userprofile->npwpnumber,0,","," ") : "";
                    }

                    ],
                    [
                      'label' => 'No SIM A',
                      'format'=>'text',
                      'value'=>function ($data) {

                        return ($data->userprofile->drivinglicencecarnumber)?$data->userprofile->drivinglicencecarnumber : "";
                    }

                    ],
                    [
                      'label' => 'No SIM C',
                      'format'=>'text',
                      'value'=>function ($data) {

                        return ($data->userprofile->drivinglicencemotorcyclenumber)?$data->userprofile->drivinglicencemotorcyclenumber : "";
                    }

                    ],
                    [
                      'label' => 'Pendidikan terakhir',
                      'format' => 'raw',
                      'value'=>function ($data) {
                        $lasteducation = Userformaleducation::find()->where(['userid' => $data->userid])->orderBy([
                                      'educationallevel' => SORT_DESC //specify sort order ASC for ascending DESC for descending
                                      ])->one();
                        if($lasteducation){
                          $eduname = Mastereducation::find()->where(['idmastereducation' => $lasteducation->educationallevel])->one();
                          return ($eduname)?$eduname->education : "";
                        }else{
                          return "";
                        }
                    }

                    ],
                    [
                      'label' => 'Nama Sekolah / Universitas terakhir',
                      'format' => 'raw',
                      'value'=>function ($data) {
                        $lasteducation = Userformaleducation::find()->where(['userid' => $data->userid])->orderBy([
                                      'educationallevel' => SORT_DESC //specify sort order ASC for ascending DESC for descending
                                      ])->one();

                        return ($lasteducation)?$lasteducation->institutions : "";
                    }

                    ],
                    [
                      'label' => 'Jurusan',
                      'format' => 'raw',
                      'value'=>function ($data) {
                        $lasteducation = Userformaleducation::find()->where(['userid' => $data->userid])->orderBy([
                                      'educationallevel' => SORT_DESC //specify sort order ASC for ascending DESC for descending
                                      ])->one();
                        return ($lasteducation)?$lasteducation->majoring : "";
                    }

                    ],
                    [
                      'label' => 'IPK / Nilai Rata Rata',
                      'format' => 'raw',
                      'value'=>function ($data) {
                        $lasteducation = Userformaleducation::find()->where(['userid' => $data->userid])->orderBy([
                                      'educationallevel' => SORT_DESC //specify sort order ASC for ascending DESC for descending
                                      ])->one();
                        return ($lasteducation)?$lasteducation->gpa : "";
                    }

                    ],
                    [
                      'label' => 'Tahun Lulus Sekolah/ Universitas',
                      'format' => ['date', 'php:Y'],
                      'value'=>function ($data) {
                        $lasteducation = Userformaleducation::find()->where(['userid' => $data->userid])->orderBy([
                                      'educationallevel' => SORT_DESC //specify sort order ASC for ascending DESC for descending
                                      ])->one();
                        return ($lasteducation)?$lasteducation->enddate : "";
                    }

                    ],
                    [
                      'label' => 'Pengalaman Kerja Terakhir (Jabatan)',
                      'format' => 'raw',
                      'value'=>function ($data) {
                        $experience = Userworkexperience::find()->where(['userid' => $data->userid])->orderBy([
                                      'enddate' => SORT_DESC //specify sort order ASC for ascending DESC for descending
                                      ])->one();
                        return ($experience)?$experience->lastposition : "";
                    }

                    ],
                    [
                      'label' => 'Lama Bekerja',
                      'format' => 'raw',
                      'value'=>function ($data) {
                        $experience = Userworkexperience::find()->where(['userid' => $data->userid])->orderBy([
                                      'enddate' => SORT_DESC //specify sort order ASC for ascending DESC for descending
                                      ])->one();

                        return ($experience && $experience->startdate && $experience->enddate)?Yii::$app->utils->diffdate($experience->startdate, $experience->enddate).' Bulan' : "";
                    }

                    ],
                    [
                      'label' => 'Gaji Terakhir',
                      'format' => 'raw',
                      'value'=>function ($data) {
                        $experience = Userworkexperience::find()->where(['userid' => $data->userid])->orderBy([
                                      'enddate' => SORT_DESC //specify sort order ASC for ascending DESC for descending
                                      ])->one();
                        return ($experience)?$experience->salary : "";
                    }

                    ],
                    [
                      'label' => 'Gaji Yang Diharapkan',
                      'format' => 'raw',
                      'value'=>function ($data) {
                        $userabout = Userabout::find()->where(['userid' => $data->userid])->orderBy([
                                      'id' => SORT_DESC //specify sort order ASC for ascending DESC for descending
                                      ])->one();
                        return ($userabout)?$userabout->expectsalary : "";
                    }

                    ],
                    [
                      'label' => 'Waktu Apply',
                      'format' => ['date', 'php:Y-m-d'],
                      // 'format' => 'raw',
                      'value'=>function ($data) {
                        $candidate = Recruitmentcandidate::find()->where(['userid' => $data->userid, 'recruitreqid'=>$data->recruitreqid])->one();
                        return ($candidate)?$candidate->createtime : "";
                    }

                    ],
                    [
                      'label' => 'Info Lamaran Diketahui Dari',
                      'format' => 'raw',
                      'value'=>function ($data) {
                        $userabout = Userabout::find()->where(['userid' => $data->userid])->orderBy([
                                      'id' => SORT_DESC //specify sort order ASC for ascending DESC for descending
                                      ])->one();
                        $infoofrec = null;
                        if($userabout){
                          $infoofrec = Masterinfoofrecruitment::find()->where(['id' => $userabout->infoofrecruitmentid])->one();
                        }
                        return ($infoofrec)?$infoofrec->infoofrecruitment : "";
                    }

                    ],
                    [
                      'label' => 'Waktu Interview HR',
                      'format' => ['date', 'php:Y-m-d'],
                      'value'=>function ($data) {
                        $candidate = Recruitmentcandidate::find()->where(['userid' => $data->userid, 'recruitreqid'=>$data->recruitreqid])->one();
                        $process = null;
                        if($candidate){
                          $process = Interview::find()->where(['recruitmentcandidateid' => $candidate->id])->one();
                        }
                        return ($process)?$process->createtime : "";
                    }

                    ],
                    [
                      'label' => 'PIC Interview HR',
                      'format' => 'raw',
                      'value'=>function ($data) {
                        $candidate = Recruitmentcandidate::find()->where(['userid' => $data->userid, 'recruitreqid'=>$data->recruitreqid])->one();
                        $process = null;
                        $picprocess = null;
                        if($candidate){
                          $process = Interview::find()->where(['recruitmentcandidateid' => $candidate->id])->one();
                          if($process){
                            $user = User::find()->where(['id' => $process->pic])->one();
                            if($user){
                              $picprocess = $user->name;
                            }
                          }

                        }
                        return ($picprocess)?$picprocess : "";
                    }

                    ],
                    [
                      'label' => 'Waktu Psikotest',
                      'format' => ['date', 'php:Y-m-d'],
                      'value'=>function ($data) {
                        $candidate = Recruitmentcandidate::find()->where(['userid' => $data->userid, 'recruitreqid'=>$data->recruitreqid])->one();
                        $process = null;
                        if($candidate){
                          $process = Psikotest::find()->where(['recruitmentcandidateid' => $candidate->id])->one();
                        }
                        return ($process)?$process->createtime : "";
                    }

                    ],
                    [
                      'label' => 'PIC Psikotest',
                      'format' => 'raw',
                      'value'=>function ($data) {
                        $candidate = Recruitmentcandidate::find()->where(['userid' => $data->userid, 'recruitreqid'=>$data->recruitreqid])->one();
                        $process = null;
                        $picprocess = null;
                        if($candidate){
                          $process = Psikotest::find()->where(['recruitmentcandidateid' => $candidate->id])->one();
                          if($process){
                            $user = User::find()->where(['id' => $process->pic])->one();
                            if($user){
                              $picprocess = $user->name;
                            }
                          }

                        }
                        return ($picprocess)?$picprocess : "";
                    }

                    ],
                    [
                      'label' => 'Waktu User Interview',
                      'format' => ['date', 'php:Y-m-d'],
                      'value'=>function ($data) {
                        $candidate = Recruitmentcandidate::find()->where(['userid' => $data->userid, 'recruitreqid'=>$data->recruitreqid])->one();
                        $process = null;
                        if($candidate){
                          $process = Userinterview::find()->where(['recruitmentcandidateid' => $candidate->id])->one();
                        }
                        return ($process)?$process->createtime : "";
                    }

                    ],
                    [
                      'label' => 'PIC User Interview',
                      'format' => 'raw',
                      'value'=>function ($data) {
                        $candidate = Recruitmentcandidate::find()->where(['userid' => $data->userid, 'recruitreqid'=>$data->recruitreqid])->one();
                        $process = null;
                        $picprocess = null;
                        if($candidate){
                          $process = Userinterview::find()->where(['recruitmentcandidateid' => $candidate->id])->one();
                          if($process){
                            $user = User::find()->where(['id' => $process->pic])->one();
                            if($user){
                              $picprocess = $user->name;
                            }
                          }

                        }
                        return ($picprocess)?$picprocess : "";
                    }

                    ],
                    [
                      'label' => 'Waktu Training Soft Skill',
                      'format' => ['date', 'php:Y-m-d'],
                      'value'=>function ($data) {
                        $candidate = Recruitmentcandidate::find()->where(['userid' => $data->userid, 'recruitreqid'=>$data->recruitreqid])->one();
                        $process = null;
                        if($candidate){
                          $process = Tsoftskill::find()->where(['recruitmentcandidateid' => $candidate->id])->one();
                        }
                        return ($process)?$process->createtime : "";
                    }

                    ],
                    [
                      'label' => 'PIC Training Soft Skill',
                      'format' => 'raw',
                      'value'=>function ($data) {
                        $candidate = Recruitmentcandidate::find()->where(['userid' => $data->userid, 'recruitreqid'=>$data->recruitreqid])->one();
                        $process = null;
                        $picprocess = null;
                        if($candidate){
                          $process = Tsoftskill::find()->where(['recruitmentcandidateid' => $candidate->id])->one();
                          if($process){
                            $user = User::find()->where(['id' => $process->officepic])->one();
                            if($user){
                              $picprocess = $user->name;
                            }
                          }

                        }
                        return ($picprocess)?$picprocess : "";
                    }

                    ],
                    [
                      'label' => 'Waktu Training Hard Skill',
                      'format' => ['date', 'php:Y-m-d'],
                      'value'=>function ($data) {
                        $candidate = Recruitmentcandidate::find()->where(['userid' => $data->userid, 'recruitreqid'=>$data->recruitreqid])->one();
                        $process = null;
                        if($candidate){
                          $process = Thardskill::find()->where(['recruitmentcandidateid' => $candidate->id])->one();
                        }
                        return ($process)?$process->createtime : "";
                    }

                    ],
                    [
                      'label' => 'PIC Training Hard Skill',
                      'format' => 'raw',
                      'value'=>function ($data) {
                        $candidate = Recruitmentcandidate::find()->where(['userid' => $data->userid, 'recruitreqid'=>$data->recruitreqid])->one();
                        $process = null;
                        $picprocess = null;
                        if($candidate){
                          $process = Thardskill::find()->where(['recruitmentcandidateid' => $candidate->id])->one();
                          if($process){
                            $user = User::find()->where(['id' => $process->officepic])->one();
                            if($user){
                              $picprocess = $user->name;
                            }
                          }

                        }
                        return ($picprocess)?$picprocess : "";
                    }

                    ],
                    [
                      'label' => 'Waktu Tendem Pasif',
                      'format' => ['date', 'php:Y-m-d'],
                      'value'=>function ($data) {
                        $candidate = Recruitmentcandidate::find()->where(['userid' => $data->userid, 'recruitreqid'=>$data->recruitreqid])->one();
                        $process = null;
                        if($candidate){
                          $process = Tpasif::find()->where(['recruitmentcandidateid' => $candidate->id])->one();
                        }
                        return ($process)?$process->createtime : "";
                    }

                    ],
                    [
                      'label' => 'PIC Tendem Pasif',
                      'format' => 'raw',
                      'value'=>function ($data) {
                        $candidate = Recruitmentcandidate::find()->where(['userid' => $data->userid, 'recruitreqid'=>$data->recruitreqid])->one();
                        $process = null;
                        $picprocess = null;
                        if($candidate){
                          $process = Tpasif::find()->where(['recruitmentcandidateid' => $candidate->id])->one();
                          if($process){
                            $user = User::find()->where(['id' => $process->officepic])->one();
                            if($user){
                              $picprocess = $user->name;
                            }
                          }

                        }
                        return ($picprocess)?$picprocess : "";
                    }

                    ],
                    [
                      'label' => 'Waktu Tendem Aktif',
                      'format' => ['date', 'php:Y-m-d'],
                      'value'=>function ($data) {
                        $candidate = Recruitmentcandidate::find()->where(['userid' => $data->userid, 'recruitreqid'=>$data->recruitreqid])->one();
                        $process = null;
                        if($candidate){
                          $process = Taktif::find()->where(['recruitmentcandidateid' => $candidate->id])->one();
                        }
                        return ($process)?$process->createtime : "";
                    }

                    ],
                    [
                      'label' => 'PIC Tendem Aktif',
                      'format' => 'raw',
                      'value'=>function ($data) {
                        $candidate = Recruitmentcandidate::find()->where(['userid' => $data->userid, 'recruitreqid'=>$data->recruitreqid])->one();
                        $process = null;
                        $picprocess = null;
                        if($candidate){
                          $process = Taktif::find()->where(['recruitmentcandidateid' => $candidate->id])->one();
                          if($process){
                            $user = User::find()->where(['id' => $process->officepic])->one();
                            if($user){
                              $picprocess = $user->name;
                            }
                          }

                        }
                        return ($picprocess)?$picprocess : "";
                    }

                  ],
                  [
                    'label' => 'Waktu create Hiring',
                    'format' => 'raw',
                    'value'=>function ($data) {

                      return ($data->createtime)?$data->createtime : "";
                  }

                  ],
                  [
                    'label' => 'PIC Hiring',
                    'format' => 'raw',
                    'value'=>function ($data) {

                      $picprocess = null;

                        if($data->createdby){
                          $user = User::find()->where(['id' => $data->createdby])->one();
                          if($user){
                            $picprocess = $user->name;
                          }
                        }
                      return ($picprocess)?$picprocess : "";
                  }

                ],
                [
                  'label' => 'Waktu Approve Hiring',
                  'format' => 'raw',
                  'value'=>function ($data) {

                    return ($data->updatetime)?$data->updatetime : "";
                }

              ],
                [
                  'label' => 'PIC Approve Hiring',
                  'format' => 'raw',
                  'value'=>function ($data) {

                    $picprocess = null;

                      if($data->approvedby){
                        $user = User::find()->where(['id' => $data->approvedby])->one();
                        if($user){
                          $picprocess = $user->name;
                        }
                      }
                    return ($picprocess)?$picprocess : "";
                }

              ],
              [
                'label' => 'Status',
                'format' => 'raw',
                'value'=>function ($data) {
                  $curl = new curl\Curl();
                  $getdatapekerjabyperner =  $curl->setPostParams([
                    'perner' => $data->perner,
                    'token' => 'ish**2019',
                  ])
                  ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerjabystatus');
                  $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
                  // var_dump($datapekerjabyperner[0]);die;
                  return ($datapekerjabyperner)?(($datapekerjabyperner[0]->MASSN == "Z8")?"Withdrawn":"Active"):'-';

              }

              ],
              [
                'label' => 'Reason',
                'format' => 'raw',
                'value'=>function ($data) {
                  $curl = new curl\Curl();
                  $getdatapekerjabyperner =  $curl->setPostParams([
                    'perner' => $data->perner,
                    'token' => 'ish**2019',
                  ])
                  ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerjabystatus');
                  $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
                  // var_dump($datapekerjabyperner[0]);die;
                  return ($datapekerjabyperner)?(($datapekerjabyperner[0]->MASSN == "Z8")?$datapekerjabyperner[0]->MSGTX:""):'';
              }

              ],
              [
                'label' => 'Resign Date',
                'format' => ['date', 'php:Y-m-d'],
                'value'=>function ($data) {
                  $curl = new curl\Curl();
                  $getdatapekerjabyperner =  $curl->setPostParams([
                    'perner' => $data->perner,
                    'token' => 'ish**2019',
                  ])
                  ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerjabystatus');
                  $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
                  if($datapekerjabyperner){
                    $date = strtotime($datapekerjabyperner[0]->BEGDA_00);
                    $newformatdate = date('Y-m-d',$date);
                    return ($datapekerjabyperner[0]->MASSN == "Z8")?$newformatdate:"";
                    // return $newformatdate;
                  }else{
                    return "";
                  }

                  // var_dump($newformat);die;

              }

              ],
              [
                'label' => 'Status Vaksin',
                'format' => 'html',
                'contentOptions'=>['style'=>'width: 100px;'],
                'value'=>function ($data) {
                  $vaksin = Uservaksin::find()->where(['userid' => $data->userid])->one();
                  if($vaksin){
                    switch ($vaksin->statusvaksin) {
                      case '1':
                      $value = "Belum Vaksin";

                        break;
                      case '2':
                      $value = "Vaksin 1";

                        break;
                      case '3':
                      $value = "Vaksin 2";

                        break;

                      default:
                        $value = "Belum Vaksin";
                        break;
                    }
                  }else{
                    $value = "Belum Vaksin";
                  }

                  return $value;
              }

              ],
              [
                'label'=>'Alasan',
                'format' => 'html',
                'value' => function($data){
                    $vaksin = Uservaksin::find()->where(['userid' => $data->userid])->one();

                    return ($vaksin)?(($vaksin->alasan)?(($vaksin->alasanvaksin)?$vaksin->alasanvaksin->alasan:''):''):'';

                }

              ],
              [
                'label' => 'Tanggal Vaksin 1',
                'format' => ['date', 'php:Y-m-d'],
                'value'=>function ($data) {
                  $vaksin = Uservaksin::find()->where(['userid' => $data->userid])->one();

                  return ($vaksin)?$vaksin->tanggalvaksin1 : "";
              }

              ],
              [
                'label' => 'Lokasi Vaksin 1',
                'format' => 'html',
                'value'=>function ($data) {
                  $vaksin = Uservaksin::find()->where(['userid' => $data->userid])->one();

                  return ($vaksin)?$vaksin->lokasivaksin1 : "";
              }

              ],
              [
                'label' => 'Sertifikat Vaksin 1',
                'format' => 'html',
                'contentOptions'=>['style'=>'width: 100px;'],
                'value'=>function ($data) {
                  $vaksin = Uservaksin::find()->where(['userid' => $data->userid])->one();

                  return ($vaksin)?(($vaksin->sertvaksin1)?"V":"X") : "X";
              }

              ],
              [
                'label' => 'Tanggal Vaksin 2',
                'format' => ['date', 'php:Y-m-d'],
                'value'=>function ($data) {
                  $vaksin = Uservaksin::find()->where(['userid' => $data->userid])->one();

                  return ($vaksin)?$vaksin->tanggalvaksin2 : "";
              }

              ],
              [
                'label' => 'Lokasi Vaksin 2',
                'format' => 'html',
                'value'=>function ($data) {
                  $vaksin = Uservaksin::find()->where(['userid' => $data->userid])->one();

                  return ($vaksin)?$vaksin->lokasivaksin2 : "";
              }

              ],
              [
                'label' => 'Sertifikat Vaksin 2',
                'format' => 'html',
                'contentOptions'=>['style'=>'width: 100px;'],
                'value'=>function ($data) {
                  $vaksin = Uservaksin::find()->where(['userid' => $data->userid])->one();

                  return ($vaksin)?(($vaksin->sertvaksin2)?"V":"X") : "X";
              }

              ],
                // ['class' => 'kartik\grid\ActionColumn', 'urlCreator'=>function(){return '#';}]
                ];
                echo ExportMenu::widget([
                    'dataProvider' => $dataProvider['dataProvider'],
                    'columns' => $gridColumns,
                    // 'target'=> ExportMenu::TARGET_BLANK,
                    'batchSize' => 10,
                    'selectedColumns'=> [0,1, 2, 3, 4, 5,6,7,8,9,10,11,12,13,14,15,16],
                    'columnSelectorOptions'=>[
                        'label' => 'Columns',
                    ],
                    // 'stream' => false, // this will automatically save file to a folder on web server
                    // 'afterSaveView' => '_view', // this view file can be overwritten with your own that displays the generated file link
                    // 'target' => '_blank',
                    // 'folder' => '@webroot/exportemp', // this is default save folder on server
                    // 'linkPath' => '/exportemp', // the web accessible location to the above folder
                    'exportConfig' => [
                        ExportMenu::FORMAT_HTML => false,
                        ExportMenu::FORMAT_TEXT => false,
                        ExportMenu::FORMAT_PDF => false,
                    ]
                ]);

                 ?>
              </div>
        </div>
        <div class="box-body">
        <?php echo GridView::widget([
            'dataProvider' => $dataProvider['dataProvider'],
            // 'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                  'label' => 'Full Name',
                  'attribute' => 'fullname',
                  // 'contentOptions'=>['style'=>'width: 100px;'],
                  'format' => 'raw',
                  'value'=>function ($data) {
                    return $data->userprofile->fullname;
                }

                ],
                [
                  'attribute' => 'perner',
                  'format' => 'raw',
                  'value'=>function ($data) {
                  return ($data->perner)?$data->perner:"";
                }

                ],
                [
                  'attribute' => 'statuspekerja',
                  'label' => 'Status',
                  'format' => 'raw',
                  'value'=>function ($data) {
                    $curl = new curl\Curl();
                    $getdatapekerjabyperner =  $curl->setPostParams([
                      'perner' => $data->perner,
                      'token' => 'ish**2019',
                    ])
                    ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerjabystatus');
                    $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
                    // var_dump($datapekerjabyperner[0]);die;

                  return ($datapekerjabyperner)?(($datapekerjabyperner[0]->MASSN == "Z8")?"Withdrawn":"Active"):'-';
                }

                ],
            ],
        ]); ?>
        </div>
        </div>
        </div>
      </div>
<script>
      //-------------
  //- PIE CHART -
  //-------------
  // Get context with jQuery - using jQuery's .get() method.
  var PieData        = [
    {
      value    : <?php echo ($dataProvider['byedusd'])?$dataProvider['byedusd']->getTotalCount():0; ?>,
      color    : '#f56954',
      highlight: '#f56954',
      label    : 'Elementary school'
    },
    {
      value    : <?php echo ($dataProvider['byedusmp'])?$dataProvider['byedusmp']->getTotalCount():0; ?>,
      color    : '#00a65a',
      highlight: '#00a65a',
      label    : 'Junior high school'
    },
    {
      value    : <?php echo ($dataProvider['byedusma'])?$dataProvider['byedusma']->getTotalCount():0; ?>,
      color    : '#f39c12',
      highlight: '#f39c12',
      label    : 'Senior high school'
    },
    {
      value    : <?php echo ($dataProvider['byedud3'])?$dataProvider['byedud3']->getTotalCount():0; ?>,
      color    : '#00c0ef',
      highlight: '#00c0ef',
      label    : 'Associate degree'
    },
    {
      value    : <?php echo ($dataProvider['byedus1'])?$dataProvider['byedus1']->getTotalCount():0; ?>,
      color    : '#3c8dbc',
      highlight: '#3c8dbc',
      label    : 'Bachelor degree'
    },
    {
      value    : <?php echo ($dataProvider['byedus2'])?$dataProvider['byedus2']->getTotalCount():0; ?>,
      color    : '#d2d6de',
      highlight: '#d2d6de',
      label    : 'Master degree'
    },
    {
      value    : <?php echo ($dataProvider['byedus3'])?$dataProvider['byedus3']->getTotalCount():0; ?>,
      color    : '#000',
      highlight: '#000',
      label    : 'Doctoral degree'
    }
  ]
  var pieOptions     = {
    //Boolean - Whether we should show a stroke on each segment
    segmentShowStroke    : true,
    //String - The colour of each segment stroke
    segmentStrokeColor   : '#fff',
    //Number - The width of each segment stroke
    segmentStrokeWidth   : 2,
    //Number - The percentage of the chart that we cut out of the middle
    percentageInnerCutout: 50, // This is 0 for Pie charts
    //Number - Amount of animation steps
    animationSteps       : 100,
    //String - Animation easing effect
    animationEasing      : 'easeOutBounce',
    //Boolean - Whether we animate the rotation of the Doughnut
    animateRotate        : true,
    //Boolean - Whether we animate scaling the Doughnut from the centre
    animateScale         : false,
    //Boolean - whether to make the chart responsive to window resizing
    responsive           : true,
    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio  : true,
    //String - A legend template
    // legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
  }
  //Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  window.onload = function(){
				var ctx = document.getElementById("pieChart").getContext("2d");
				window.myPie = new Chart(ctx).Pie(PieData, pieOptions);
			};

</script>
