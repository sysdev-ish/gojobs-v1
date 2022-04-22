<?php
use yii\helpers\Html;
use app\models\Recruitmentcandidate;
use app\models\Interview;

// var_dump($model->jabatan);die;
// if($model->jabatan){
if ( strval($model->jabatan) !== strval(intval($model->jabatan)) ) {
  $jobcategory = $model->jabatan;
  $jobfunction = $model->jabatan;
}else{
  $jobcategory = $model->jobfunc->jobcat->name_job_function_category;
  $jobfunction = $model->jobfunc->name_job_function;
}
?>
<div class="careerfy-job careerfy-joblisting-classic">
  <ul class="careerfy-row">
    <li class="careerfy-column-12">
      <div class="careerfy-joblisting-classic-wrap">
        <!-- <figure><a href="#"><img src="extra-images/job-listing-logo-1.png" alt=""></a></figure> -->
        <div class="careerfy-joblisting-text">
          <div class="careerfy-list-option">
            <h2><a href="#"><?php  echo Html::a($jobfunction, ['#', 'id'=>$model->id], ['class' => 'btn-link','data-toggle' => 'tooltip', 'title'=> 'View detail' ]);?></a> <span><?php $date = date_create($model->lup); echo date_format($date,"d-M-Y");?></span></h2>
            <ul>
              <li><i class="careerfy-icon careerfy-user"></i><?php echo $model->gender; ?></li>
              <li><i class="careerfy-icon careerfy-maps-and-flags"></i> <?php echo ($model->city)?$model->city->city_name:''; ?></li>
              <li><i class="careerfy-icon careerfy-filter-tool-black-shape"></i> <?php echo $jobcategory; ?></li>
              <li><i class="careerfy-icon careerfy-mortarboard"></i> <?php echo $model->pendidikan; ?></li>
            </ul>
          </div>
          <div class="careerfy-job-userlist">

            <?php
            (Yii::$app->user->isGuest)?$userid = null : $userid = Yii::$app->user->identity->id;
            $checkapply = Recruitmentcandidate::find()->where(['userid'=>$userid,'recruitreqid'=>$model->id])->one();
            if($checkapply){
              echo Html::a(($checkapply->typeinterview == 2)?'Walk in Applied':'Applied', ['#'], [
                'class' => 'careerfy-jobdetail-btn active',
                'disabled' => true,

              ]);
            }else {
              $disabled = false;
              if($model->status_rekrut == 2){
                echo '<i>Expired</i>';
              }else{
                echo Html::a('Apply', ['recruitmentcandidate/applyjob', 'userid' => $userid,'jobsid'=> $model->id], [
                  'class' => 'careerfy-jobdetail-btn active',
                  'id' => 'applyjob',
                  'data' => [
                    'confirm' => 'Are you sure you want to apply this job?',
                    'method' => 'post',
                  ],
                ]);
              }

            }
            $interviewcheck = Interview::find()
            ->where(['DATE(scheduledate)'=>date('Y-m-d')])
            ->orWhere(['DATE(date)'=>date('Y-m-d')])
            ->andWhere(['userid'=>$userid])
            ->one();

            if(!$interviewcheck){
              // echo Html::a('Walk Interview', ['recruitmentcandidate/walkin', 'userid' => $userid,'jobsid'=> $model->id], [
              //   'class' => 'careerfy-jobdetail-btn active',
              //   'disabled' => false,
              //   'id' => 'walkin',
              //   'data' => [
              //     'confirm' => 'Are you sure you want to Walk Interview for this job?',
              //     'method' => 'post',
              //   ],
              // ]);
            }

            ?>

          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </li>
  </ul>
</div>
