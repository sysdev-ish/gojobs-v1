<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Mastersubgrouppenilaian;
use app\models\Interviewform;

/* @var $this yii\web\View */
/* @var $model app\models\Interview */
$assetUrl = Yii::$app->request->baseUrl . '/assets';
?>
<img src="<?php echo $assetUrl; ?>/img/ishlogo.png" align="center" alt="User Image"/>
<div class="header">
    EVALUASI HASIL INTERVIEW CALON KARYAWAN
</div>
<div class="sub-header">
    <i class="fa fa-check"></i>
    INTERVIEW USER
</div>
<table class ="table no-border" style="page-break-inside:avoid" style="margin-top:10px;">
  <tr>
    <td>Nama</td>
    <td>:</td>
    <td><?php echo $profile->fullname; ?></td>
    <td>Rencana Posisi</td>
    <td>:</td>
    <td>
      <?php 
      //echo (is_numeric($model->reccandidate->recrequest->jabatan)) ? $model->reccandidate->recrequest->jobfunc->name_job_function : $model->reccandidate->recrequest->jabatan; 

      $planPosition = null;

      if(isset($model->reccandidate->recrequest->jobfunc->name_job_function)) $planPosition = $model->reccandidate->recrequest->jobfunc->name_job_function;

      if(isset($model->reccandidate->recrequest->jabatan)) $planPosition = $model->reccandidate->recrequest->jabatan;

      echo $planPosition;
      ?>
        
      </td>
  </tr>
  <tr>
    <td>Pendidikan Terakhir</td>
    <td>:</td>
    <td><?php //echo $lasteducation->educationallevel; ?></td>
    <td>Pengalaman Kerja</td>
    <td>:</td>
    <td>-</td>
  </tr>
</table>
<table class="table table-striped">
  <tbody><tr>
    <th style="width: 10px">#</th>
    <th>Aspek - Aspek Penilaian</th>
    <th style="width: 150px">Nilai</th>
    <th>Deskripsi</th>
  </tr>
  <?php
  $subgroupprev = null;
  $i=1;
  foreach ($masterpenilaian as $key => $value) {
    $subgroup = Mastersubgrouppenilaian::find()->where(['id'=>$value->subgrouppenilaian])->one();
    $interviewform = Interviewform::find()->where(['interviewid'=>$model->id,'aspekpenilaianid'=>$value->id])->one();

    if($value->subgrouppenilaian != $subgroupprev){
      echo '<tr><th colspan="4">'.$subgroup->subgroup.'</th></tr>';
      $subgroupprev = $subgroup->id;
      $i=1;
    }

    $interviewformNilai = 0;
    if(isset($interviewform->nilai)) $interviewformNilai = $interviewform->nilai;

    $interviewformDesc = null;
    if(isset($interviewform->desc)) $interviewformDesc = $interviewform->desc;

    echo '<tr>';
    echo '<td>'.$i++.'</td>';
    echo '<td>'.$value->aspekpenilaian.'</td>';
    //echo '<td>'.$interviewform->nilai.'</td>';
    echo '<td>'.$interviewformNilai.'</td>';
    //echo '<td>'.$interviewform->desc.'</td>';
    echo '<td>'.$interviewformDesc.'</td>';
    echo '</tr>';
  }
   ?>

</tbody></table>

<br>
<p> <b> SKALA RATING :   </b>       K (Kurang);    C (Cukup);     B (Baik);    T (Tinggi) </p>
<br>
<p>DESKRIPSI :</p>
<p><?php echo $model->desc; ?></p>
<p>Keterangan / Tambahan informasi hasil interview :</p>
<p><?php echo $model->addinfo; ?></p>
<br><br>
<p>Berdasarkan hasil wawancara maka disimpulkan bahwa Calon Agent dapat :</p>
<p><strong><?php echo ($model->statusprocess->statusname ==  'Pass')?'Diterima':'Ditolak'; ?></strong></p>
<br>
<p>
  <!--Posisi yang disarankan : <?php //echo (is_numeric($model->reccandidate->recrequest->jabatan)) ? $model->reccandidate->recrequest->jobfunc->name_job_function : $model->reccandidate->recrequest->jabatan; ?>-->

  <?php
  $jabatan = null;

  if(isset($model->reccandidate->recrequest->jobfunc->name_job_function)) $jabatan = $model->reccandidate->recrequest->jobfunc->name_job_function;

  if(isset($model->reccandidate->recrequest->jobfunc->jabatan)) $jabatan = $model->reccandidate->recrequest->jobfunc->jabatan;
  ?>

  Posisi yang disarankan : <?php echo $jabatan; ?>
</p><br>
<p>Tandatangan Pewawancara</p>
<p style="margin-bottom:100px;">
  <?php //echo $model->reccandidate->recrequest->city->city_name.', '.Yii::$app->utils->indodate($model->date);?>
  <?php
  $city = null;
  if(isset($model->reccandidate->recrequest->city)) $city = $model->reccandidate->recrequest->city->city_name;
  echo $city . ', ' . Yii::$app->utils->indodate($model->date);
  ?>
</p>
<p> <?php echo ($model->penandatangan)?$model->penandatangan:'-'; ?> </p>







