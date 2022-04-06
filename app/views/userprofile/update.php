<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Userprofile */

$this->title = 'User Profile';
$this->params['breadcrumbs'][] = 'Update';

?>
<?php if(Yii::$app->utils->getlayout() == 'main'): ?>
  <?php if (Yii::$app->controller->action->id == 'update' OR Yii::$app->controller->action->id == 'create') { ?>
    <div class="row">
      <div class="col-md-3">
        <?= $this->render(
          '/layouts/leftprofile.php',
          [
            'userid'=>$userid,
          ]
          ) ?>
        </div>
        <div class="col-md-9">
        <?php } ?>
        <div class="userprofile-update">

          <?= $this->render('_form', [
            'model' => $model,
            'province' => $province,
            'kota' => $kota,
            'provincektp' => $provincektp,
            'kotaktp' => $kotaktp,
            'userid'=>$userid,
            'modelvaksin' => $modelvaksin,
            'alasanvaksin'=>$alasanvaksin,
            // 'jobfamily'=>$jobfamily,
            // 'subjobfamily'=>$subjobfamily,
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
                      <h2><?= Yii::t('app', 'Update My Profile') ?></h2>
                    </div>
                    <div class="careerfy-description">
                      <?= $this->render('_form', [
                        'model' => $model,
                        'province' => $province,
                        'kota' => $kota,
                        'provincektp' => $provincektp,
                        'kotaktp' => $kotaktp,
                        'userid'=>$model->userid,
                        'modelvaksin' => $modelvaksin,
                        'alasanvaksin'=>$alasanvaksin,
                        // 'jobfamily' => $jobfamily,
                        // 'subjobfamily' => $subjobfamily,
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
