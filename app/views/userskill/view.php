<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Userforeignlanguage */

$this->title = 'Skill';
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
      <div class="userforeignlanguage-view box box-solid" style="padding: 10px;">
        <div class="box-header with-border">
          <h3 class="box-title">Skill</h3>
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
        <div class="box-body table-responsive">
          <div class="box-footer box-comments" style="margin-bottom:5px;">
            <span class="username">
              <?= Yii::t('app', 'Foreign language') ?>
            </span><!-- /.username -->
          </div>
          <table class="table table-striped">
            <tbody>
              <tr>
                <th><?= Yii::t('app', 'Language') ?></th>
                <th><?= Yii::t('app', 'Speaking') ?></th>
                <th><?= Yii::t('app', 'Writing') ?></th>
                <th><?= Yii::t('app', 'Reading') ?></th>
                <th><?= Yii::t('app', 'Understanding') ?></th>
              </tr>
              <?php foreach ($modelall as $key => $model) { ?>
                <tr>
                  <td><?php echo $model->language; ?></td>
                  <td><?php echo ($model->speaking == 1) ? "<span class='label label-success'>Active</span>" : "<span class='label label-danger'>Passive</span>"; ?></td>
                  <td><?php echo ($model->writing == 1) ? "<span class='label label-success'>Active</span>" : "<span class='label label-danger'>Passive</span>"; ?></td>
                  <td><?php echo ($model->reading == 1) ? "<span class='label label-success'>Active</span>" : "<span class='label label-danger'>Passive</span>"; ?></td>
                  <td><?php echo ($model->understanding == 1) ? "<span class='label label-success'>Active</span>" : "<span class='label label-danger'>Passive</span>"; ?></td>
                </tr>
              <?php } ?>

            </tbody>
          </table>
          <div class="box-footer box-comments" style="margin-bottom:5px; margin-top:20px;">
            <span class="username">
              <?= Yii::t('app', 'English Language Skill') ?>
            </span>
          </div>
          <?= DetailView::widget([
            'model' => $modeleskill,
            'template' => '<tr><th width="20%" style="text-align:right;">{label}</th><td>{value}</td></tr>',
            'options' => ['class' => 'table no-border detail-view'],
            'attributes' => [
              [
                'attribute' => 'havetoefl',
                'format' => 'html',
                'value' => function ($model) {
                  return ($model->havetoefl == 1) ? "<span class='label label-success'>Yes</span>" : "<span class='label label-danger'>No</span>";
                }

              ],
              'testtoefldate',
              'institutions',
              'toeflscore',
            ],
          ]) ?>

          <div class="box-footer box-comments" style="margin-bottom:5px; margin-top:20px;">
            <span class="username">
              <?= Yii::t('app', 'Computer Skill') ?>
            </span>
          </div>
          <div class="row">
            <div class="col-md-3">
              <?= DetailView::widget([
                'model' => $modelcskill,
                'template' => '<tr><th width="80%" style="text-align:right;padding-bottom:30px;">{label}</th><td>{value}</td></tr>',
                'options' => ['class' => 'table no-border detail-view'],
                'attributes' => [
                  [
                    'attribute' => 'msword',
                    'format' => 'html',
                    'value' => function ($model) {
                      return ($model->msword == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>";
                    }

                  ],
                  [
                    'attribute' => 'msexcel',
                    'format' => 'html',
                    'value' => function ($model) {
                      return ($model->msexcel == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>";
                    }

                  ],
                  [
                    'attribute' => 'android',
                    'format' => 'html',
                    'value' => function ($model) {
                      return ($model->android == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>";
                      return $model->android;
                    }

                  ],
                ],
              ]) ?>
            </div>

            <div class="col-md-3">
              <?= DetailView::widget([
                'model' => $modelcskill,
                'template' => '<tr><th width="80%" style="text-align:right;padding-bottom:30px;">{label}</th><td>{value}</td></tr>',
                'options' => ['class' => 'table no-border detail-view'],
                'attributes' => [
                  [
                    'attribute' => 'mspowerpoint',
                    'format' => 'html',
                    'value' => function ($model) {
                      return ($model->mspowerpoint == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>";
                    }

                  ],
                  [
                    'attribute' => 'sql',
                    'format' => 'html',
                    'value' => function ($model) {
                      return ($model->sql == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>";
                    }

                  ],
                  [
                    'attribute' => 'php',
                    'format' => 'html',
                    'value' => function ($model) {
                      return ($model->php == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>";
                    }

                  ],
                ],
              ]) ?>
            </div>
            <div class="col-md-3">
              <?= DetailView::widget([
                'model' => $modelcskill,
                'template' => '<tr><th width="80%" style="text-align:right;padding-bottom:30px;">{label}</th><td>{value}</td></tr>',
                'options' => ['class' => 'table no-border detail-view'],
                'attributes' => [
                  [
                    'attribute' => 'lan',
                    'format' => 'html',
                    'value' => function ($model) {
                      return ($model->lan == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>";
                    }

                  ],
                  [
                    'attribute' => 'wan',
                    'format' => 'html',
                    'value' => function ($model) {
                      return ($model->wan == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>";
                    }

                  ],
                  [
                    'attribute' => 'java',
                    'format' => 'html',
                    'value' => function ($model) {
                      return ($model->java == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>";
                    }

                  ],
                ],
              ]) ?>
            </div>
            <div class="col-md-3">
              <?= DetailView::widget([
                'model' => $modelcskill,
                'template' => '<tr><th width="80%" style="text-align:right;padding-bottom:30px;">{label}</th><td>{value}</td></tr>',
                'options' => ['class' => 'table no-border detail-view'],
                'attributes' => [
                  [
                    'attribute' => 'pascal',
                    'format' => 'html',
                    'value' => function ($model) {
                      return ($model->pascal == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>";
                    }

                  ],
                  [
                    'attribute' => 'clanguage',
                    'format' => 'html',
                    'value' => function ($model) {
                      return ($model->clanguage == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>";
                    }

                  ],

                ],
              ]) ?>
            </div>
            <div class="col-md-12">
              <?= DetailView::widget([
                'model' => $modelcskill,
                'template' => '<tr><th width="18%" style="text-align:right;">{label}</th><td>{value}</td></tr>',
                'options' => ['class' => 'table no-border detail-view'],
                'attributes' => [

                  'others',
                ],
              ]) ?>
            </div>
          </div>
          <div class="box-footer box-comments" style="margin-bottom:5px; margin-top:20px;">
            <span class="username">
              Internet
            </span>
          </div>
          <div class="row">
            <div class="col-md-12">
              <?= DetailView::widget([
                'model' => $modelcskill,
                'template' => '<tr><th width="40%" style="text-align:right;">{label}</th><td>{value}</td></tr>',
                'options' => ['class' => 'table no-border detail-view'],
                'attributes' => [

                  [
                    'attribute' => 'internetknowledge',
                    'format' => 'html',
                    'value' => function ($model) {
                      return ($model->internetknowledge == 3) ? "<span class='label label-success'>Good</span>" : (($model->internetknowledge == 2) ? "<span class='label label-warning'>Moderate</span>" : "<span class='label label-danger'>less</span>");
                    }

                  ],
                  'usinginternetpurpose',
                  'usinginternetfrequency',
                ],
              ]) ?>
            </div>
          </div>
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
                <h2><?= Yii::t('skill', 'My Skill') ?></h2>
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
                <div class="box-body table-responsive">
                  <div class="box-footer box-comments" style="margin-bottom:5px;">
                    <span class="username">
                      <?= Yii::t('app', 'Foreign language') ?>
                    </span><!-- /.username -->
                  </div>
                  <table class="table table-striped">
                    <tbody>
                      <tr>
                        <th><?= Yii::t('app', 'Language') ?></th>
                        <th><?= Yii::t('app', 'Speaking') ?></th>
                        <th><?= Yii::t('app', 'Writing') ?></th>
                        <th><?= Yii::t('app', 'Reading') ?></th>
                        <th><?= Yii::t('app', 'Understanding') ?></th>
                      </tr>
                      <?php foreach ($modelall as $key => $model) { ?>
                        <tr>
                          <td><?php echo $model->language; ?></td>
                          <td><?php echo ($model->speaking == 1) ? "<span class='label label-success'>Active</span>" : "<span class='label label-danger'>Passive</span>"; ?></td>
                          <td><?php echo ($model->writing == 1) ? "<span class='label label-success'>Active</span>" : "<span class='label label-danger'>Passive</span>"; ?></td>
                          <td><?php echo ($model->reading == 1) ? "<span class='label label-success'>Active</span>" : "<span class='label label-danger'>Passive</span>"; ?></td>
                          <td><?php echo ($model->understanding == 1) ? "<span class='label label-success'>Active</span>" : "<span class='label label-danger'>Passive</span>"; ?></td>
                        </tr>
                      <?php } ?>

                    </tbody>
                  </table>
                  <div class="box-footer box-comments" style="margin-bottom:5px; margin-top:20px;">
                    <span class="username">
                      <?= Yii::t('app', 'English Language Skill') ?>
                    </span>
                  </div>
                  <?= DetailView::widget([
                    'model' => $modeleskill,
                    'template' => '<tr><th width="20%" style="text-align:right;">{label}</th><td style="text-align:left;">{value}</td></tr>',
                    'options' => ['class' => 'table no-border detail-view'],
                    'attributes' => [
                      [
                        'attribute' => 'havetoefl',
                        'format' => 'html',
                        'value' => function ($model) {
                          return ($model->havetoefl == 1) ? "<span class='label label-success'>Yes</span>" : "<span class='label label-danger'>No</span>";
                        }

                      ],
                      'testtoefldate',
                      'institutions',
                      'toeflscore',
                    ],
                  ]) ?>

                  <div class="box-footer box-comments" style="margin-bottom:5px; margin-top:20px;">
                    <span class="username">
                      <?= Yii::t('app', 'Computer Skill') ?>
                    </span>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <?= DetailView::widget([
                        'model' => $modelcskill,
                        'template' => '<tr><th width="80%" style="text-align:right;padding-bottom:30px;">{label}</th><td style="text-align:left;">{value}</td></tr>',
                        'options' => ['class' => 'table no-border detail-view'],
                        'attributes' => [
                          [
                            'attribute' => 'msword',
                            'format' => 'html',
                            'value' => function ($model) {
                              return ($model->msword == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>";
                            }

                          ],
                          [
                            'attribute' => 'msexcel',
                            'format' => 'html',
                            'value' => function ($model) {
                              return ($model->msexcel == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>";
                            }

                          ],
                          [
                            'attribute' => 'android',
                            'format' => 'html',
                            'value' => function ($model) {
                              return ($model->android == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>";
                              // return $model->android;
                            }

                          ],
                        ],
                      ]) ?>
                    </div>

                    <div class="col-md-4">
                      <?= DetailView::widget([
                        'model' => $modelcskill,
                        'template' => '<tr><th width="80%" style="text-align:right;padding-bottom:30px;padding-left:0px;">{label}</th><td style="text-align:left;">{value}</td></tr>',
                        'options' => ['class' => 'table no-border detail-view'],
                        'attributes' => [
                          [
                            'attribute' => 'mspowerpoint',
                            'format' => 'html',
                            'value' => function ($model) {
                              return ($model->mspowerpoint == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>";
                            }

                          ],
                          [
                            'attribute' => 'sql',
                            'format' => 'html',
                            'value' => function ($model) {
                              return ($model->sql == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>";
                            }

                          ],
                          [
                            'attribute' => 'php',
                            'format' => 'html',
                            'value' => function ($model) {
                              return ($model->php == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>";
                            }

                          ],
                        ],
                      ]) ?>
                    </div>
                    <div class="col-md-2">
                      <?= DetailView::widget([
                        'model' => $modelcskill,
                        'template' => '<tr><th width="80%" style="text-align:right;padding-bottom:30px;">{label}</th><td style="text-align:left;">{value}</td></tr>',
                        'options' => ['class' => 'table no-border detail-view'],
                        'attributes' => [
                          [
                            'attribute' => 'lan',
                            'format' => 'html',
                            'value' => function ($model) {
                              return ($model->lan == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>";
                            }

                          ],
                          [
                            'attribute' => 'wan',
                            'format' => 'html',
                            'value' => function ($model) {
                              return ($model->wan == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>";
                            }

                          ],
                          [
                            'attribute' => 'java',
                            'format' => 'html',
                            'value' => function ($model) {
                              return ($model->java == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>";
                            }

                          ],
                        ],
                      ]) ?>
                    </div>
                    <div class="col-md-3">
                      <?= DetailView::widget([
                        'model' => $modelcskill,
                        'template' => '<tr><th width="80%" style="text-align:right;padding-bottom:30px;">{label}</th><td style="text-align:left;">{value}</td></tr>',
                        'options' => ['class' => 'table no-border detail-view'],
                        'attributes' => [
                          [
                            'attribute' => 'pascal',
                            'format' => 'html',
                            'value' => function ($model) {
                              return ($model->pascal == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>";
                            }

                          ],
                          [
                            'attribute' => 'clanguage',
                            'format' => 'html',
                            'value' => function ($model) {
                              return ($model->clanguage == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>";
                            }

                          ],

                        ],
                      ]) ?>
                    </div>
                    <div class="col-md-12">
                      <?= DetailView::widget([
                        'model' => $modelcskill,
                        'template' => '<tr><th width="18%" style="text-align:right;">{label}</th><td style="text-align:left;">{value}</td></tr>',
                        'options' => ['class' => 'table no-border detail-view'],
                        'attributes' => [

                          'others',
                        ],
                      ]) ?>
                    </div>
                  </div>
                  <div class="box-footer box-comments" style="margin-bottom:5px; margin-top:20px;">
                    <span class="username">
                      Internet
                    </span>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <?= DetailView::widget([
                        'model' => $modelcskill,
                        'template' => '<tr><th width="40%" style="text-align:right;">{label}</th><td style="text-align:left;">{value}</td></tr>',
                        'options' => ['class' => 'table no-border detail-view'],
                        'attributes' => [

                          [
                            'attribute' => 'internetknowledge',
                            'format' => 'html',
                            'value' => function ($model) {
                              return ($model->internetknowledge == 3) ? "<span class='label label-success'>Good</span>" : (($model->internetknowledge == 2) ? "<span class='label label-warning'>Moderate</span>" : "<span class='label label-danger'>less</span>");
                            }

                          ],
                          'usinginternetpurpose',
                          'usinginternetfrequency',
                        ],
                      ]) ?>
                    </div>
                  </div>
                </div>
              </div>
              <?php if ($model) {
                echo  Html::a('Previous', ['/usernonformaleducation/views', 'userid' => $userid], [
                  'class' => 'btn btn-sm btn-default text-muted',
                  'data-toggle' => 'tooltip',
                  'data-placement' => 'bottom',
                  'title' => 'Previous',
                ]);
                echo  Html::a('Next', ['/userworkexperience/views', 'userid' => $userid], [
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
    <!-- Main Section -->

  </div>
<?php endif; ?>