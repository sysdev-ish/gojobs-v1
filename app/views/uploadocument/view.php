<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Uploadocument */

$this->title = 'Documents';
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
          <h3 class="box-title">User Profile</h3>
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
          <?= DetailView::widget([
            'model' => $model,
            'template' => '<div class="row" style="margin-bottom: 6px;"><div class="col-xs-4 col-lg-4">{label}</div><div class="col-xs-8 col-lg-8">{value}</div></div>',
            // 'template' => '<tr><th width="30%" style="text-align:right;">{label}</th><td style="text-align:left;">{value}</td></tr>',
            // 'options' => ['class' => 'table table-striped detail-view'],
            'attributes' => [
              [
                'attribute' => 'ijazah',
                'format' => 'raw',
                'value' => function ($model) {
                  return ($model->ijazah) ? Html::a('<i class="fa fa-download"></i> ' . $model->ijazah, ['/app/assets/upload/ijazah/' . $model->ijazah], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted']) : '-';
                }

              ],
              [
                'attribute' => 'transkipnilai',
                'format' => 'raw',
                'value' => function ($model) {
                  return ($model->transkipnilai) ? Html::a('<i class="fa fa-download"></i> ' . $model->transkipnilai, ['/app/assets/upload/transkipnilai/' . $model->transkipnilai], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted']) : '-';
                }

              ],
              [
                'attribute' => 'suratketerangansehat',
                'format' => 'raw',
                'value' => function ($model) {
                  return ($model->suratketerangansehat) ? Html::a('<i class="fa fa-download"></i> ' . $model->suratketerangansehat, ['/app/assets/upload/suratketerangansehat/' . $model->suratketerangansehat], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted']) : '-';
                }

              ],
              [
                'attribute' => 'kartukeluarga',
                'format' => 'raw',
                'value' => function ($model) {
                  return ($model->kartukeluarga) ? Html::a('<i class="fa fa-download"></i> ' . $model->kartukeluarga, ['/app/assets/upload/kartukeluarga/' . $model->kartukeluarga], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted']) : '-';
                }

              ],
              [
                'attribute' => 'ktp',
                'format' => 'raw',
                'value' => function ($model) {
                  return ($model->ktp) ? Html::a('<i class="fa fa-download"></i> ' . $model->ktp, ['/app/assets/upload/ktp/' . $model->ktp], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted']) : '-';
                }

              ],
              [
                'attribute' => 'jamsostek',
                'format' => 'raw',
                'value' => function ($model) {
                  return ($model->jamsostek) ? Html::a('<i class="fa fa-download"></i> ' . $model->jamsostek, ['/app/assets/upload/jamsostek/' . $model->jamsostek], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted']) : '-';
                }

              ],
              [
                'attribute' => 'bpjskesehatan',
                'format' => 'raw',
                'value' => function ($model) {
                  return ($model->bpjskesehatan) ? Html::a('<i class="fa fa-download"></i> ' . $model->bpjskesehatan, ['/app/assets/upload/bpjskesehatan/' . $model->bpjskesehatan], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted']) : '-';
                }

              ],
              [
                'attribute' => 'npwp',
                'format' => 'raw',
                'value' => function ($model) {
                  return ($model->npwp) ? Html::a('<i class="fa fa-download"></i> ' . $model->npwp, ['/app/assets/upload/npwp/' . $model->npwp], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted']) : '-';
                }

              ],
              [
                'attribute' => 'suratlamarankerja',
                'format' => 'raw',
                'value' => function ($model) {
                  return ($model->suratlamarankerja) ? Html::a('<i class="fa fa-download"></i> ' . $model->suratlamarankerja, ['/app/assets/upload/suratlamarankerja/' . $model->suratlamarankerja], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted']) : '-';
                }

              ],
            ],
          ]) ?>
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
                <div class="box-body no-padding">
                  <?= DetailView::widget([
                    'model' => $model,
                    'template' => '<div class="row" style="margin-bottom: 6px;"><div class="col-xs-4 col-lg-4">{label}</div><div class="col-xs-8 col-lg-8">{value}</div></div>',
                    // 'options' => ['class' => 'table no-border detail-view'],
                    'attributes' => [
                      [
                        'attribute' => 'ijazah',
                        'format' => 'raw',
                        'value' => function ($model) {
                          return ($model->ijazah) ? Html::a('<i class="fa fa-download"></i> ' . $model->ijazah, ['/app/assets/upload/ijazah/' . $model->ijazah], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted']) : '-';
                        }

                      ],
                      [
                        'attribute' => 'transkipnilai',
                        'format' => 'raw',
                        'value' => function ($model) {
                          return ($model->transkipnilai) ? Html::a('<i class="fa fa-download"></i> ' . $model->transkipnilai, ['/app/assets/upload/transkipnilai/' . $model->transkipnilai], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted']) : '-';
                        }

                      ],
                      [
                        'attribute' => 'suratketerangansehat',
                        'format' => 'raw',
                        'value' => function ($model) {
                          return ($model->suratketerangansehat) ? Html::a('<i class="fa fa-download"></i> ' . $model->suratketerangansehat, ['/app/assets/upload/suratketerangansehat/' . $model->suratketerangansehat], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted']) : '-';
                        }

                      ],
                      [
                        'attribute' => 'kartukeluarga',
                        'format' => 'raw',
                        'value' => function ($model) {
                          return ($model->kartukeluarga) ? Html::a('<i class="fa fa-download"></i> ' . $model->kartukeluarga, ['/app/assets/upload/kartukeluarga/' . $model->kartukeluarga], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted']) : '-';
                        }

                      ],
                      [
                        'attribute' => 'ktp',
                        'format' => 'raw',
                        'value' => function ($model) {
                          return ($model->ktp) ? Html::a('<i class="fa fa-download"></i> ' . $model->ktp, ['/app/assets/upload/ktp/' . $model->ktp], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted']) : '-';
                        }

                      ],
                      [
                        'attribute' => 'jamsostek',
                        'format' => 'raw',
                        'value' => function ($model) {
                          return ($model->jamsostek) ? Html::a('<i class="fa fa-download"></i> ' . $model->jamsostek, ['/app/assets/upload/jamsostek/' . $model->jamsostek], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted']) : '-';
                        }

                      ],
                      [
                        'attribute' => 'bpjskesehatan',
                        'format' => 'raw',
                        'value' => function ($model) {
                          return ($model->bpjskesehatan) ? Html::a('<i class="fa fa-download"></i> ' . $model->bpjskesehatan, ['/app/assets/upload/bpjskesehatan/' . $model->bpjskesehatan], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted']) : '-';
                        }

                      ],
                      [
                        'attribute' => 'npwp',
                        'format' => 'raw',
                        'value' => function ($model) {
                          return ($model->npwp) ? Html::a('<i class="fa fa-download"></i> ' . $model->npwp, ['/app/assets/upload/npwp/' . $model->npwp], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted']) : '-';
                        }

                      ],
                    ],
                  ]) ?>
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