<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Userfamily */

$this->title = "My Application";
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if(Yii::$app->utils->getlayout() == 'main'): ?>
<div class="row">
  <div class="col-md-3">
    <?= $this->render(
        '/layouts/leftprofile.php',
        [
          'userid' => $userid,
        ]
    ) ?>
  </div>
  <div class="col-md-9">
    <div class="userprofile-view box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">My Applications</h3>
      </div>

        <div class="box-body table-responsive">
          <table class="table table-striped">
                <tbody><tr>
                  <th>No</th>
                  <!-- <th>Job Function Category</th> -->
                  <th>Job Function</th>
                  <th>Location</th>
                  <th>Status</th>

                </tr>
                <?php foreach ($modelall as $key => $model) { ?>
                <tr>
                  <td><?php echo $key+1; ?></td>
                  <!-- <td><?php //echo $model->recrequest->jobfunc->jobcat->name_job_function_category; ?></td> -->
                  <td><?php echo ($model->recrequest->hire_jabatan_sap)? ((is_numeric($model->recrequest->hire_jabatan_sap))?$model->recrequest->jabatansap->value2:'-'):'-'; ?></td>
                  <td><?php echo ($model->recrequest->city)?$model->recrequest->city->city_name:'-'; ?></td>
                  <td><?php echo ($model->status == 0)?'Candidate':'On Recruitment Process';?></td>

                </tr>
              <?php } ?>

              </tbody></table>
        </div>
    </div>
  </div>
</div>
<?php else: ?>
  <div class="careerfy-subheader careerfy-subheader-without-bg">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="careerfy-page-title">
            <h1><?= Yii::t('app', 'Companies') ?></h1>
            <p><?= Yii::t('app', 'Thousands of prestigious employers for you, search for a recruiter right now') ?>.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="careerfy-breadcrumb">
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">Pages</a></li>
        <li>Candidates</li>
      </ul>
    </div>
  </div>
  <div class="careerfy-main-content">

    <!-- Main Section -->
    <div class="careerfy-main-section careerfy-dashboard-fulltwo">
      <div class="container">
        <div class="row">

          <aside class="careerfy-column-4">
            <?= $this->render(
              '/layouts/leftprofile-applicant.php',
              [
                'userid' => $userid,
              ]
              ) ?>

            </aside>
            <div class="careerfy-column-8">
              <div class="careerfy-employer-box-section">
                <div class="careerfy-profile-title">
                  <h2><?= Yii::t('app', 'My Applied Job') ?></h2>

                </div>
                <div class="careerfy-description">
                  <div class="box-body table-responsive">
                    <table class="table table-striped">
                          <tbody><tr>
                            <th>No</th>
                            <!-- <th>Job Function Category</th> -->
                            <th>Job Function</th>
                            <th>Location</th>
                            <th>Status</th>

                          </tr>
                          <?php foreach ($modelall as $key => $model) { ?>
                          <tr>
                            <td><?php echo $key+1; ?></td>
                            <!-- <td><?php //echo $model->recrequest->jobfunc->jobcat->name_job_function_category; ?></td> -->
                            <td><?php echo (is_numeric($model->recrequest->jabatan)) ? $model->recrequest->jobfunc->name_job_function : $model->recrequest->jabatan; ?></td>
                            <td><?php echo ($model->recrequest->city)?$model->recrequest->city->city_name:'-'; ?></td>
                            <td><?php echo ($model->status == 0)?'Candidate':'On Recruitment Process';?></td>

                          </tr>
                        <?php } ?>

                        </tbody></table>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
      <!-- Main Section -->

    </div>
<?php endif; ?>
