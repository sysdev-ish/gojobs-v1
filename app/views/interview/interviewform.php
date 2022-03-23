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
    INTERVIEW HR
</div>
<table class ="table no-border" style="page-break-inside:avoid" style="margin-top:10px;">
  <tr>
    <td>Nama</td>
    <td>:</td>
    <td><?php echo $profile->fullname; ?></td>
    <td>Rencana Posisi</td>
    <td>:</td>
    <td><?php echo (is_numeric($model->reccandidate->recrequest->jabatan)) ? $model->reccandidate->recrequest->jobfunc->name_job_function : $model->reccandidate->recrequest->jabatan; ?></td>
  </tr>
  <tr>
    <td>Pendidikan Terakhir</td>
    <td>:</td>
    <td><?php echo ($lasteducation)?$lasteducation->education:'-'; ?></td>
    <td>Pengalaman Kerja</td>
    <td>:</td>
    <td><?php echo ($lastexperience)?$lastexperience->companyname." - ".$lastexperience->lastposition:"-"; ?></td>
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
    echo '<tr>';
    echo '<td>'.$i++.'</td>';
    echo '<td>'.$value->aspekpenilaian.'</td>';
    echo '<td>'.$interviewform->nilai.'</td>';
    echo '<td>'.$interviewform->desc.'</td>';
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
<p>Posisi yang disarankan : <?php echo (is_numeric($model->reccandidate->recrequest->jabatan)) ? $model->reccandidate->recrequest->jobfunc->name_job_function : $model->reccandidate->recrequest->jabatan; ?></p><br>
<p>Tandatangan Pewawancara</p>
<p style="margin-bottom:100px;"><?php echo $model->reccandidate->recrequest->city->city_name.', '.Yii::$app->utils->indodate($model->date);?></p>
<p> <?php echo ($model->pic)?$model->userpic->name:'-'; ?> </p>
