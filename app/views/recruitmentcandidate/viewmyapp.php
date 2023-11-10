<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Userfamily */

$this->title = "My Application";
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if (Yii::$app->utils->getlayout() == 'main') : ?>
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
            <tbody>
              <tr>
                <th>No</th>
                <!-- <th>Job Function Category</th> -->
                <th>Job Function</th>
                <th>Location</th>
                <th>Status</th>

              </tr>
              <?php foreach ($modelall as $key => $model) { ?>
                <tr>
                  <td><?php echo $key + 1; ?></td>
                  <!-- <td><?php //echo $model->recrequest->jobfunc->jobcat->name_job_function_category; 
                            ?></td> -->
                  <td><?php echo ($model->recrequest->hire_jabatan_sap) ? ((is_numeric($model->recrequest->hire_jabatan_sap)) ? $model->recrequest->jabatansap->value2 : '-') : '-'; ?></td>
                  <td><?php echo ($model->recrequest->city) ? $model->recrequest->city->city_name : '-'; ?></td>
                  <td><?php echo ($model->status == 0) ? 'Candidate' : 'On Recruitment Process'; ?></td>

                </tr>
              <?php } ?>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
<?php else : ?>
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
              <div class="careerfy-applied-jobs">
                <ul class="careerfy-row">
                  <?php foreach ($modelall as $key => $model) { ?>
                    <li class="careerfy-column-12">
                      <div class="careerfy-applied-jobs-wrap">
                        <div class="careerfy-table-layer">
                          <div class="careerfy-table-row">
                            <div class="careerfy-featured-listing-text">
                              <h1>
                                <?php echo (is_numeric($model->recrequest->jabatan)) ? $model->recrequest->jobfunc->name_job_function : $model->recrequest->jabatan; ?>
                              </h1>
                              <time><i class="fa fa-calendar"></i> Date Applied: <?php echo ($model->createtime) ? date('d-m-Y', strtotime($model->createtime)) : '-'; ?></time>
                              <div class="careerfy-featured-listing-options">
                                <ul>
                                  <li>
                                    <i class="careerfy-icon careerfy-maps-and-flags"></i><?php echo ($model->recrequest->city) ? $model->recrequest->city->city_name : '-'; ?>
                                  </li>
                                  <li><i class="careerfy-icon careerfy-filter-tool-black-shape"></i>
                                    Accounting / Finance
                                  </li>
                                  <li class="careerfy-right">
                                    Status:
                                    <?php
                                    if ($model->status == 0) {
                                      $label = 'label-warning';
                                    } elseif ($model->status == 4 or $model->status == 5 or $model->status == 6 or $model->status == 7 or $model->status == 12 or $model->status == 13 or $model->status == 14 or $model->status == 15) {
                                      $label = 'label-success';
                                    } elseif ($model->status == 8 or $model->status == 9 or $model->status == 10 or $model->status == 16 or $model->status == 17 or $model->status == 18 or $model->status == 19 or $model->status == 24) {
                                      $label = 'label-danger';
                                    } else {
                                      $label = 'label-primary';
                                    }
                                    echo ' <span class="label ' . $label . '">' . $model->statuscandidate->statusname . '</span>';
                                    ?>

                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                  <?php } ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Main Section -->

  </div>
<?php endif; ?>