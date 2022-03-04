<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Useremergencycontact */

$this->title = 'Emergency contact: ' ;
$this->params['breadcrumbs'][] = 'Update';
?>
<?php if(Yii::$app->utils->getlayout() == 'main'): ?>
<?php if (Yii::$app->controller->action->id == 'update' OR Yii::$app->controller->action->id == 'create') { ?>
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
  <?php } ?>
<div class="useremergencycontact-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modeluecontact' => $modeluecontact,
        'province' => $province,
        'kota' => $kota,
        'userid' => $userid,
    ]) ?>

</div>
<?php if (Yii::$app->controller->action->id == 'update' OR Yii::$app->controller->action->id == 'create') { ?>
</div>
</div>
<?php } ?>
<?php else: ?>
  <?php if (Yii::$app->controller->action->id == 'update' OR Yii::$app->controller->action->id == 'create') : ?>
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
<?php endif; ?>
  <div class="careerfy-main-content">

    <!-- Main Section -->
    <div class="careerfy-main-section careerfy-dashboard-fulltwo">
      <div class="container">
        <?php if (Yii::$app->controller->action->id == 'update' OR Yii::$app->controller->action->id == 'create') { ?>
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
              <?php } ?>
              <div class="careerfy-employer-box-section">
                <div class="careerfy-profile-title">
                  <h2><?= Yii::t('app', 'Update My Emergency Contact') ?></h2>
                </div>
                <div class="careerfy-description">
                  <?= $this->render('_form', [
                      'model' => $model,
                      'modeluecontact' => $modeluecontact,
                      'province' => $province,
                      'kota' => $kota,
                      'userid' => $model->userid,
                  ]) ?>
                  </div>

                </div>

                <?php if (Yii::$app->controller->action->id == 'update' OR Yii::$app->controller->action->id == 'create') { ?>
                </div>

              </div>
            <?php } ?>
          </div>
        </div>
        <!-- Main Section -->

      </div>
<?php endif; ?>
