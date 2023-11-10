<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Userfamily */

$this->title = "User Family";
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
      <div class="userprofile-view box box-solid" style="padding: 10px;">
        <div class="box-header with-border">
          <h3 class="box-title">User Family</h3>
          <span class="pull-right">
            <!-- validation rule -->
            <?php if (Yii::$app->user->isGuest) {
              $role = null;
            } else {
              $role = Yii::$app->user->identity->role;
            }
            if ($model) {
              if (!Yii::$app->utils->aplhired($model->userid)) {
                echo  Html::a('<i class="fa fa-pencil-square-o"></i>', ['update', 'id' => $model->userid], [
                  'class' => 'btn btn-sm btn-default text-muted',
                  'data-toggle' => 'tooltip',
                  'data-placement' => 'bottom',
                  'title' => 'Update',
                ]);
              } elseif (Yii::$app->utils->permission($role, 'm49')) {
                echo  Html::a('<i class="fa fa-pencil-square-o"></i>', ['update', 'id' => $model->userid], [
                  'class' => 'btn btn-sm btn-default text-muted',
                  'data-toggle' => 'tooltip',
                  'data-placement' => 'bottom',
                  'title' => 'Update',
                ]);
              }
            }
            ?>
            <!-- end validation rule -->
          </span>
        </div>

        <div class="box-body">
          <?php foreach ($modelall as $key => $model) { ?>
            <div class="box-title" style="margin-bottom: 0px;">
              <h5> Family Information <?php echo $key + 1; ?></h5>
            </div>
            <div class="row" style="margin-bottom: 8px;">
              <div class="col-xs-8 col-md-6"><strong><?= Yii::t('app', 'Relationship') ?></strong></div>
              <div class="col-xs-4 col-md-6"><?php echo $model->relationship; ?></div>
            </div>
            <div class="row" style="margin-bottom: 8px;">
              <div class="col-xs-8 col-md-6"><strong><?= Yii::t('app', 'Full Name') ?></strong></div>
              <div class="col-xs-4 col-md-6"><?php echo $model->fullname; ?></div>
            </div>
            <div class="row" style="margin-bottom: 8px;">
              <div class="col-xs-8 col-md-6"><strong><?= Yii::t('app', 'Gender') ?></strong></div>
              <div class="col-xs-4 col-md-6"><?php echo $model->gender; ?></div>
            </div>
            <div class="row" style="margin-bottom: 8px;">
              <div class="col-xs-8 col-md-6"><strong><?= Yii::t('app', 'Last Education') ?></strong></div>
              <div class="col-xs-4 col-md-6"><?php echo $model->lasteducation0->education; ?></div>
            </div>
            <div class="row" style="margin-bottom: 8px;">
              <div class="col-xs-8 col-md-6"><strong><?= Yii::t('app', 'Birth date') ?></strong></div>
              <div class="col-xs-4 col-md-6"><?php echo $model->birthdate; ?></div>
            </div>
            <div class="row" style="margin-bottom: 8px;">
              <div class="col-xs-8 col-md-6"><strong><?= Yii::t('app', 'Birth place') ?></strong></div>
              <div class="col-xs-4 col-md-6"><?php echo $model->birthplace; ?></div>
            </div>
            <div class="row" style="margin-bottom: 8px;">
              <div class="col-xs-8 col-md-6"><strong><?= Yii::t('app', 'Job Title') ?></strong></div>
              <div class="col-xs-4 col-md-6"><?php echo $model->jobtitle; ?></div>
            </div>
            <div class="row" style="margin-bottom: 8px;">
              <div class="col-xs-8 col-md-6"><strong><?= Yii::t('app', 'Company Name') ?></strong></div>
              <div class="col-xs-4 col-md-6"><?php echo $model->companyname; ?></div>
            </div>
            <div class="row" style="margin-bottom: 15px;">
              <div class="col-xs-8 col-md-6"><strong><?= Yii::t('app', 'Remarks') ?></strong></div>
              <div class="col-xs-4 col-md-6"><?php echo $model->description; ?></div>
            </div>
          <?php } ?>
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
            <h1>Companies</h1>
            <p>Thousands of prestigious employers for you, search for a recruiter right now.</p>
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
                <h2><?= Yii::t('app', 'My Family') ?></h2>
                <!-- validation rule -->
                <?php if ($model) {
                  if (!Yii::$app->utils->aplhired($model->userid)) {
                    echo  Html::a('<i class="fa fa-pencil-square-o"></i>', ['update', 'id' => $model->userid], [
                      'class' => 'pull-right btn btn-sm btn-default text-muted',
                      'data-toggle' => 'tooltip',
                      'data-placement' => 'bottom',
                      'title' => 'Update',
                    ]);
                  }
                }
                ?>
                <!-- end validation rule -->
              </div>
              <div class="careerfy-description">
                <div class="box-body" style="margin: 20px;">
                  <div class="careerfy-row">
                    <?php foreach ($modelall as $key => $model) { ?>
                      <div class="careerfy-candidate-title" style="margin-bottom: 0px;">
                        <h6><i class="careerfy-icon careerfy-user"></i> Family Information <?php echo $key + 1; ?></h6>
                      </div>
                      <div class="row">
                        <div class="col-xs-8 col-md-6"><strong><?= Yii::t('app', 'Relationship') ?></strong></div>
                        <div class="col-xs-4 col-md-6"><?php echo $model->relationship; ?></div>
                      </div>
                      <div class="row">
                        <div class="col-xs-8 col-md-6"><strong><?= Yii::t('app', 'Full Name') ?></strong></div>
                        <div class="col-xs-4 col-md-6"><?php echo $model->fullname; ?></div>
                      </div>
                      <div class="row">
                        <div class="col-xs-8 col-md-6"><strong><?= Yii::t('app', 'Gender') ?></strong></div>
                        <div class="col-xs-4 col-md-6"><?php echo $model->gender; ?></div>
                      </div>
                      <div class="row">
                        <div class="col-xs-8 col-md-6"><strong><?= Yii::t('app', 'Last Education') ?></strong></div>
                        <div class="col-xs-4 col-md-6"><?php echo $model->lasteducation0->education; ?></div>
                      </div>
                      <div class="row">
                        <div class="col-xs-8 col-md-6"><strong><?= Yii::t('app', 'Birth date') ?></strong></div>
                        <div class="col-xs-4 col-md-6"><?php echo $model->birthdate; ?></div>
                      </div>
                      <div class="row">
                        <div class="col-xs-8 col-md-6"><strong><?= Yii::t('app', 'Birth place') ?></strong></div>
                        <div class="col-xs-4 col-md-6"><?php echo $model->birthplace; ?></div>
                      </div>
                      <div class="row">
                        <div class="col-xs-8 col-md-6"><strong><?= Yii::t('app', 'Job Title') ?></strong></div>
                        <div class="col-xs-4 col-md-6"><?php echo $model->jobtitle; ?></div>
                      </div>
                      <div class="row">
                        <div class="col-xs-8 col-md-6"><strong><?= Yii::t('app', 'Company Name') ?></strong></div>
                        <div class="col-xs-4 col-md-6"><?php echo $model->companyname; ?></div>
                      </div>
                      <div class="row" style="margin-bottom: 15px;">
                        <div class="col-xs-8 col-md-6"><strong><?= Yii::t('app', 'Remarks') ?></strong></div>
                        <div class="col-xs-4 col-md-6"><?php echo $model->description; ?></div>
                      </div>
                    <?php } ?>
                  </div>
                </div>
                <?php if ($model) {
                  echo  Html::a('Previous', ['/userprofile/views', 'userid' => $userid], [
                    'class' => 'btn btn-sm btn-default text-muted',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'bottom',
                    'title' => 'Previous',
                  ]);
                  echo  Html::a('Next', ['/userformaleducation/views', 'userid' => $userid], [
                    'class' => 'pull-right btn btn-sm btn-info text-muted',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'bottom',
                    'title' => 'Next',
                  ]);
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Main Section -->

  </div>
<?php endif; ?>