<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Useremergencycontact */

$this->title = 'Emergency Contact';
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
<div class="useremergencycontact-view box box-solid">
  <div class="box-header with-border">
    <h3 class="box-title"><?= Yii::t('app', 'Emergency Contact') ?></h3>
    <span class="pull-right">
      <!-- validation rule -->
        <?php if(Yii::$app->user->isGuest){
          $role = null;
        }else{
          $role = Yii::$app->user->identity->role;
        }
        if($model){
          if(!Yii::$app->utils->aplhired($model->userid)){
            echo  Html::a('<i class="fa fa-pencil-square-o"></i>', ['update', 'id' => $model->userid], ['class' => 'btn btn-sm btn-default text-muted',
              'data-toggle'=>'tooltip',
              'data-placement'=>'bottom',
              'title'=>'Update',
            ]);
          }
          elseif(Yii::$app->utils->permission($role,'m49')){
              echo  Html::a('<i class="fa fa-pencil-square-o"></i>', ['update', 'id' => $model->userid], ['class' => 'btn btn-sm btn-default text-muted',
              'data-toggle'=>'tooltip',
              'data-placement'=>'bottom',
              'title'=>'Update',
            ]);
            }
          }
        ?>
      <!-- end validation rule -->
    </span>
  </div>
    <div class="box-body table-responsive">
      <table class="table table-striped">
            <tbody><tr>
              <th><?= Yii::t('app', 'Full name') ?></th>
              <th><?= Yii::t('app', 'Address') ?></th>
              <th><?= Yii::t('app', 'Phone') ?></th>
              <th><?= Yii::t('app', 'Relationship') ?></th>
            </tr>
            <?php foreach ($modelall as $key => $model) { ?>
            <tr>
              <td><?php echo $model->fullname; ?></td>
              <td><?php echo $model->address; ?></td>
              <td><?php echo $model->phone; ?></td>
              <td><?php echo $model->relationship; ?></td>
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
                  <h2><?= Yii::t('app', 'My Emergency Contact') ?></h2>
                  <!-- validation rule -->
                      <?php if($model){
                        if(!Yii::$app->utils->aplhired($model->userid)){
                          echo  Html::a('<i class="fa fa-pencil-square-o"></i>', ['update', 'id' => $model->userid], ['class' => 'pull-right btn btn-sm btn-default text-muted',
                          'data-toggle'=>'tooltip',
                          'data-placement'=>'bottom',
                          'title'=>'Update',
                        ]);
                      }
                    }
                      ?>
                    <!-- end validation rule -->
                </div>
                <div class="careerfy-description">
                  <div class="careerfy-resume-education">
                    <ul class="careerfy-row">
                      <?php foreach ($modelall as $key => $model) { ?>
                        <li class="careerfy-column-12" style="padding-bottom:50px;">
                          <div class="careerfy-resume-education-wrap">
                            <small><?php echo $model->relationship; ?></small>
                            <h2><a href="#"><?php echo $model->fullname; ?></a></h2>
                            <span><?php echo $model->phone; ?> - <?php echo $model->address; ?></span>
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
      </div>
      <!-- Main Section -->

    </div>
<?php endif; ?>
