<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Userhealth */

$this->title = 'Additional Info';
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
      <div class="userhealth-view box box-solid" style="padding: 10px;">
        <div class="box-header with-border">
          <h3 class="box-title"><?= Yii::t('app', 'Additional Info') ?></h3>
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
          <div class="box-footer box-comments" style="margin-bottom:5px; margin-top:20px;">
            <span class="username">
              <?= Yii::t('app', 'Medical History') ?>
            </span>
          </div>
          <?= DetailView::widget([
            'model' => $model,
            'template' => '<div class="row"><div class="col-xs-8 col-md-6" style="text-align:left; margin-bottom:2px;"><strong>{label}</strong></div><div class="col-xs-4 col-md-6" style="text-align:left;">{value}</div></div>',
            'options' => ['class' => 'table no-border detail-view'],
            'attributes' => [
              [
                'attribute' => 'sick',
                'format' => 'html',
                'value' => function ($model) {
                  return ($model->sick == 1) ? "<span class='label label-success'>Yes</span>" : "<span class='label label-danger'>No</span>";
                }

              ],
              'when',
              'effect',
              'illnessdesc',
              [
                'attribute' => 'accident',
                'format' => 'html',
                'value' => function ($model) {
                  return ($model->accident == 1) ? "<span class='label label-success'>Yes</span>" : "<span class='label label-danger'>No</span>";
                }

              ],
              'whenaccident',
              'efffectaccident',
              'accidentdesc',
            ],
          ]) ?>
          <div class="box-footer box-comments" style="margin-bottom:5px; margin-top:20px;">
            <span class="username">
              About you
            </span>
          </div>
          <?php if ($modelabout != '-') : ?>
            <?= DetailView::widget([
              'model' => $modelabout,
              'template' => '<div class="row"><div class="col-xs-8 col-md-6" style="text-align:left; margin-bottom:8px;"><strong>{label}</strong></div><div class="col-xs-4 col-md-6" style="text-align:left;">{value}</div></div>',
              'attributes' => [

                'strengths',
                'weakness',
                'ambitionandhopefullness',
              ],
            ]) ?>
            <div class="box-footer box-comments" style="margin-bottom:5px; margin-top:20px;">
              <span class="username">
                Other people's opinions about you
              </span>
            </div>
            <?= DetailView::widget([
              'model' => $modelabout,
              'template' => '<div class="row"><div class="col-xs-8 col-md-6" style="text-align:left; margin-bottom:8px;"><strong>{label}</strong></div><div class="col-xs-4 col-md-6" style="text-align:left;">{value}</div></div>',
              'attributes' => [

                'strengthsopinion',
                'weaknessopinion',
              ],
            ]) ?>
          <?php else : ?>
            <span style="margin-left:30px;">No data..</span>
          <?php endif; ?>
          <div class="box-footer box-comments" style="margin-bottom:5px; margin-top:20px;">
            <span class="username">
              Other Information
            </span>
          </div>
          <?php if ($modelabout != '-') : ?>
            <?= DetailView::widget([
              'model' => $modelabout,
              'template' => '<div class="row"><div class="col-xs-8 col-md-6" style="text-align:left; margin-bottom:8px;"><strong>{label}</strong></div><div class="col-xs-4 col-md-6" style="text-align:left;">{value}</div></div>',
              'attributes' => [
                [
                  'attribute' => 'readyshift',
                  'format' => 'html',
                  'value' => function ($model) {
                    return ($model->readyshift == 1) ? "<span class='label label-success'>Yes</span>" : "<span class='label label-danger'>No</span>";
                  }

                ],
                [
                  'attribute' => 'readyovertime',
                  'format' => 'html',
                  'value' => function ($model) {
                    return ($model->readyovertime == 1) ? "<span class='label label-success'>Yes</span>" : "<span class='label label-danger'>No</span>";
                  }

                ],
                [
                  'attribute' => 'readyoverstay',
                  'format' => 'html',
                  'value' => function ($model) {
                    return ($model->readyoverstay == 1) ? "<span class='label label-success'>Yes</span>" : "<span class='label label-danger'>No</span>";
                  }

                ],
                [
                  'attribute' => 'readyoutcity',
                  'format' => 'html',
                  'value' => function ($model) {
                    return ($model->readyoutcity == 1) ? "<span class='label label-success'>Yes</span>" : "<span class='label label-danger'>No</span>";
                  }

                ],
                'joblikeskill',
                'jobunlikeskill',

                [
                  'attribute' => 'havepsikotest',
                  'format' => 'html',
                  'value' => function ($model) {
                    return ($model->havepsikotest == 1) ? "<span class='label label-success'>Yes</span>" : "<span class='label label-danger'>No</span>";
                  }

                ],
                'whenpsikotest',
                'purposepsikotest',
                [
                  'attribute' => 'expectsalary',
                  'format' => 'html',
                  'value' => function ($model) {
                    return number_format($model->expectsalary);
                  }

                ],
                'readyforwork',
                // 'bankid.bank.bank',
                [
                  'attribute' => 'bankid',
                  'format' => 'html',
                  'value' => function ($model) {
                    return ($model->bankid == null) ? '' : $model->bankname->bank;
                  }

                ],
                'bankaccountnumber',
                [
                  'attribute' => 'passbook',
                  'format' => 'raw',
                  'value' => function ($model) {
                    return ($model->passbook) ? Html::a('<i class="fa fa-download"></i> ' . $model->passbook, ['/app/assets/upload/bankaccount/' . $model->passbook], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted']) : '-';
                  }

                ],
                [
                  'attribute' => 'infoofrecruitmentid',
                  'format' => 'html',
                  'value' => function ($model) {
                    return ($model->infoofrecruitmentid == null) ? '' : $model->masterinforec->infoofrecruitment;
                  }

                ],
              ],
            ]) ?>
          <?php else : ?>
            <span style="margin-left:30px;">No data..</span>
          <?php endif; ?>
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
                <h2>My Additional Info</h2>
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
                <div class="box-body" style="margin: 10px;">
                  <?= DetailView::widget([
                    'model' => $model,
                    'template' => '<div class="row"><div class="col-xs-8 col-md-6" style="text-align:left; margin-bottom:8px;"><strong>{label}</strong></div><div class="col-xs-4 col-md-6" style="text-align:left;">{value}</div></div>',
                    'attributes' => [
                      [
                        'attribute' => 'sick',
                        'format' => 'html',
                        'value' => function ($model) {
                          return ($model->sick == 1) ? "<span class='label label-success'>Yes</span>" : "<span class='label label-danger'>No</span>";
                        }

                      ],
                      'when',
                      'effect',
                      'illnessdesc',
                      [
                        'attribute' => 'accident',
                        'format' => 'html',
                        'value' => function ($model) {
                          return ($model->accident == 1) ? "<span class='label label-success'>Yes</span>" : "<span class='label label-danger'>No</span>";
                        }

                      ],
                      'whenaccident',
                      'efffectaccident',
                      'accidentdesc',
                    ],
                  ]) ?>
                  <div class="careerfy-candidate-title" style="margin-bottom: 0px;">
                    <h6><i class="careerfy-icon careerfy-user"></i> About you</h6>
                  </div>
                  <?php if ($modelabout != '-') : ?>
                    <?= DetailView::widget([
                      'model' => $modelabout,
                      'template' => '<div class="row"><div class="col-xs-8 col-md-6" style="text-align:left; margin-bottom:8px;"><strong>{label}</strong></div><div class="col-xs-4 col-md-6" style="text-align:left;">{value}</div></div>',

                      'attributes' => [

                        'strengths',
                        'weakness',
                        'ambitionandhopefullness',
                      ],
                    ]) ?>
                    <div class="careerfy-candidate-title" style="margin-bottom: 0px;">
                      <h6><i class="careerfy-icon careerfy-social-media"></i> Strength Weakness</h6>
                    </div>

                    <?= DetailView::widget([
                      'model' => $modelabout,
                      'template' => '<div class="row"><div class="col-xs-8 col-md-6" style="text-align:left; margin-bottom:8px;"><strong>{label}</strong></div><div class="col-xs-4 col-md-6" style="text-align:left;">{value}</div></div>',

                      'attributes' => [

                        'strengthsopinion',
                        'weaknessopinion',
                      ],
                    ]) ?>
                  <?php else : ?>
                    <span style="margin-left:30px;">No data..</span>
                  <?php endif; ?>
                  <div class="careerfy-candidate-title" style="margin-bottom: 0px;">
                    <h6><i class="careerfy-icon careerfy-design-skills"></i> Others</h6>
                  </div>
                  <?php if ($modelabout != '-') : ?>
                    <?= DetailView::widget([
                      'model' => $modelabout,
                      'template' => '<div class="row"><div class="col-xs-8 col-md-6" style="text-align:left; margin-bottom:8px;"><strong>{label}</strong></div><div class="col-xs-4 col-md-6" style="text-align:left;">{value}</div></div>',

                      'attributes' => [
                        [
                          'attribute' => 'readyshift',
                          'format' => 'html',
                          'value' => function ($model) {
                            return ($model->readyshift == 1) ? "<span class='label label-success'>Yes</span>" : "<span class='label label-danger'>No</span>";
                          }

                        ],
                        [
                          'attribute' => 'readyovertime',
                          'format' => 'html',
                          'value' => function ($model) {
                            return ($model->readyovertime == 1) ? "<span class='label label-success'>Yes</span>" : "<span class='label label-danger'>No</span>";
                          }

                        ],
                        [
                          'attribute' => 'readyoverstay',
                          'format' => 'html',
                          'value' => function ($model) {
                            return ($model->readyoverstay == 1) ? "<span class='label label-success'>Yes</span>" : "<span class='label label-danger'>No</span>";
                          }

                        ],
                        [
                          'attribute' => 'readyoutcity',
                          'format' => 'html',
                          'value' => function ($model) {
                            return ($model->readyoutcity == 1) ? "<span class='label label-success'>Yes</span>" : "<span class='label label-danger'>No</span>";
                          }

                        ],
                        'joblikeskill',
                        'jobunlikeskill',

                        [
                          'attribute' => 'havepsikotest',
                          'format' => 'html',
                          'value' => function ($model) {
                            return ($model->havepsikotest == 1) ? "<span class='label label-success'>Yes</span>" : "<span class='label label-danger'>No</span>";
                          }

                        ],
                        'whenpsikotest',
                        'purposepsikotest',
                        [
                          'attribute' => 'expectsalary',
                          'format' => 'html',
                          'value' => function ($model) {
                            return number_format($model->expectsalary);
                          }

                        ],
                        'readyforwork',
                        // 'bankid.bank.bank',
                        [
                          'attribute' => 'bankid',
                          'format' => 'html',
                          'value' => function ($model) {
                            return ($model->bankid == null) ? '' : $model->bankname->bank;
                          }

                        ],
                        'bankaccountnumber',
                      ],
                    ])
                    ?>
                  <?php else : ?>
                    <span style="margin-left:30px;">No data..</span>
                  <?php endif; ?>
                </div>
                <?php if ($model) {
                  echo  Html::a('Previous', ['/userreference/views', 'userid' => $userid], [
                    'class' => 'btn btn-sm btn-default text-muted',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'bottom',
                    'title' => 'Previous',
                  ]);
                  echo  Html::a('Next', ['/uploadocument/views', 'userid' => $userid], [
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