<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Userabout;
use app\models\Userinterview;
use app\models\Psikotest;

/* @var $this yii\web\View */
/* @var $model app\models\Userprofile */

$this->title = 'User Profile';
$this->params['breadcrumbs'][] = ['label' => 'User profiles', 'url' => ['index']];
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
      <?php if (Yii::$app->controller->action->id == 'viewshortwd') : ?>
        <?php
        $usesrinterview = Userinterview::find()->where(['recruitmentcandidateid' => $recid])->one();
        if ($usesrinterview) {
          if ($usesrinterview->documentinterview) {
            $disabled = false;
          } else {
            $disabled = true;
          }
          // echo Html::a('<i class="fa fa-download" style="font-size:12pt;"></i>', ['/app/assets/upload/documentinterview/'.$usesrinterview->documentinterview], ['class' => 'btn btn-sm btn-primary','disabled' => $disabled,'data-toggle' => 'tooltip', 'title'=> 'Download','target'=>'_blank' ]);
          echo Html::a('<i class="fa fa-download"></i> Form User Interview', ['/app/assets/upload/documentinterview/' . $usesrinterview->documentinterview], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted  btn-block', 'disabled' => $disabled]);
        }
        $psikotest = Psikotest::find()->where(['recruitmentcandidateid' => $recid])->one();
        if ($psikotest) {
          if ($psikotest->documentpsikotest) {
            $disabled = false;
          } else {
            $disabled = true;
          }
          // echo Html::a('<i class="fa fa-download" style="font-size:12pt;"></i>', ['/app/assets/upload/documentpsikotest/'.$psikotest->documentpsikotest], ['class' => 'btn btn-sm btn-primary','disabled' => $disabled,'data-toggle' => 'tooltip', 'title'=> 'Download','target'=>'_blank' ]);
          echo Html::a('<i class="fa fa-download"></i> Psychogram', ['/app/assets/upload/documentpsikotest/' . $psikotest->documentpsikotest], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted  btn-block', 'disabled' => $disabled]);
        }
        ?>
      <?php endif; ?>
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
                echo  Html::a('<i class="fa fa-pencil-square-o"></i>', ['update', 'id' => $model->id], [
                  'class' => 'btn btn-sm btn-default text-muted',
                  'data-toggle' => 'tooltip',
                  'data-placement' => 'bottom',
                  'title' => 'Update',
                ]);
              } elseif (Yii::$app->utils->permission($role, 'm49')) {
                echo  Html::a('<i class="fa fa-pencil-square-o"></i>', ['update', 'id' => $model->id], [
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
        <!-- <div class="box-body table-responsive no-padding"> -->
        <div class="box-body">
          <?php
          if ($model) {
            echo DetailView::widget([
              'model' => $model,
              // 'template' => '<tr><th width="30%" style="text-align:right;">{label}</th><td>{value}</td></tr>',
              'template' => '<div class="row" style="margin-bottom:8px;"><div class="col-xs-4 col-md-4"><strong>{label}</strong></div><div class="col-xs-4 col-md-4">{value}</div></div>',
              // 'options' => ['class' => 'table table-striped detail-view'],
              'attributes' => [
                'userid',
                [
                  'label' => 'Username',
                  'format' => 'html',
                  'value' => function ($data) {

                    return ($data->userlogin->username) ? $data->userlogin->username : '';
                  }

                ],
                [
                  'label' => 'email',
                  'format' => 'html',
                  'value' => function ($data) {

                    return ($data->userlogin->email) ? $data->userlogin->email : '';
                  }

                ],
                'fullname',
                'nickname',
                'gender',
                'birthdate',
                'birthplace',
                'province.provinsi',
                'city.kota',
                'address:ntext',
                'postalcode',
                'phone',
                'domicilestatus',
                'addressktp:ntext',
                'nationality',
                'religion',
                'maritalstatus',
                'weddingdate',
                'bloodtype',
                'identitynumber',
                'kknumber',
                'bpjsnumber',
                'jamsosteknumber',
                'npwpnumber',
                'drivinglicencecarnumber',
                'drivinglicencemotorcyclenumber',
                // 'masterjobfamily.jobfamily',
                // 'mastersubjobfamily.subjobfamily',

                [
                  'label' => 'Bank Name',
                  'format' => 'html',
                  'value' => function ($data) {
                    $checkuabout = Userabout::find()->where(['userid' => $data->userid])->one();
                    if ($checkuabout <> null) {
                      return ($data->uabout->bankid) ? $data->uabout->bankname->bank : '';
                    } else {
                      return '';
                    }
                  }

                ],
                'uabout.bankaccountnumber',
                [
                  'attribute' => 'passbook',
                  'format' => 'raw',
                  'value' => function ($model) {
                    return ($model->uabout) ? (($model->uabout->passbook) ? Html::a('<i class="fa fa-download"></i> ' . $model->uabout->passbook, ['/app/assets/upload/bankaccount/' . $model->uabout->passbook], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted']) : '-') : '-';
                  }

                ],
                [
                  'label' => 'Status Vaksin',
                  'format' => 'html',
                  'value' => function ($data) {
                    if ($data->datavaksin) {
                      switch ($data->datavaksin->statusvaksin) {
                        case '1':
                          $value = "Belum Vaksin";

                          break;
                        case '2':
                          $value = "Vaksin 1";

                          break;
                        case '3':
                          $value = "Vaksin 2";

                          break;

                        default:
                          $value = "Belum Vaksin";
                          break;
                      }
                    } else {
                      $value = "Belum Vaksin";
                    }


                    return $value;
                  }

                ],

                [
                  'label' => 'Alasan',
                  'format' => 'html',
                  'value' => function ($data) {

                    return ($data->datavaksin) ? (($data->datavaksin->alasan) ? (($data->datavaksin->alasanvaksin) ? $data->datavaksin->alasanvaksin->alasan : '') : '') : '';
                  }

                ],
                [
                  'label' => 'Tanggal Vaksin 1',
                  'format' => 'html',
                  'value' => function ($data) {

                    return ($data->datavaksin) ? (($data->datavaksin->tanggalvaksin1) ? $data->datavaksin->tanggalvaksin1 : '') : '';
                  }

                ],
                [
                  'label' => 'Lokasi Vaksin 1',
                  'format' => 'html',
                  'value' => function ($data) {

                    return ($data->datavaksin) ? (($data->datavaksin->lokasivaksin1) ? $data->datavaksin->lokasivaksin1 : '') : '';
                  }

                ],
                [
                  'attribute' => 'Sertifikat Vaksin 1',
                  'format' => 'raw',
                  'value' => function ($data) {
                    return ($data->datavaksin) ? (($data->datavaksin->sertvaksin1) ? Html::a('<i class="fa fa-download"></i> ' . $data->datavaksin->sertvaksin1, ['/app/assets/upload/sertifikatvaksin/' . $data->datavaksin->sertvaksin1], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted']) : '-') : '';
                  }

                ],
                [
                  'label' => 'Tanggal Vaksin 2',
                  'format' => 'html',
                  'value' => function ($data) {

                    return ($data->datavaksin) ? (($data->datavaksin->tanggalvaksin2) ? $data->datavaksin->tanggalvaksin2 : '') : '';
                  }

                ],
                [
                  'label' => 'Lokasi Vaksin 2',
                  'format' => 'html',
                  'value' => function ($data) {

                    return ($data->datavaksin) ? (($data->datavaksin->lokasivaksin2) ? $data->datavaksin->lokasivaksin2 : '') : '';
                  }

                ],
                [
                  'attribute' => 'Sertifikat Vaksin 2',
                  'format' => 'raw',
                  'value' => function ($data) {
                    return ($data->datavaksin) ? (($data->datavaksin->sertvaksin2) ? Html::a('<i class="fa fa-download"></i> ' . $data->datavaksin->sertvaksin2, ['/app/assets/upload/sertifikatvaksin/' . $data->datavaksin->sertvaksin2], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted']) : '-') : '';
                  }

                ],
              ],
            ]);
          } else {
            echo "No data..";
          } ?>
        </div>
      </div>
    </div>
  </div>
<?php else : ?>

  <div class="careerfy-subheader careerfy-subheader-with-bg">
    <span class="careerfy-banner-transparent"></span>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="careerfy-page-title">
            <h1>Profile</h1>
            <!-- <p>Thousands of prestigious employers for you, search for a recruiter right now.</p> -->
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
                <h2><?= Yii::t('app', 'My Profile') ?></h2>
                <!-- validation rule -->
                <?php if ($model) {
                  if (!Yii::$app->utils->aplhired($model->userid)) {
                    echo  Html::a('<i class="fa fa-pencil-square-o"></i>', ['update', 'id' => $model->id], [
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
                <?php
                if ($model) {
                  echo DetailView::widget([
                    'model' => $model,
                    'template' => '<div class="row" style="margin-bottom:8px;"><div class="col-xs-4 col-md-4"><strong>{label}</strong></div><div class="col-xs-4 col-md-4">{value}</div></div>',
                    // 'options' => ['class' => 'table no-border'],
                    'attributes' => [
                      [
                        'label' => 'Username',
                        'format' => 'html',
                        'value' => function ($data) {
                          return ($data->userlogin->username) ? $data->userlogin->username : '';
                        }
                      ],
                      [
                        'label' => 'email',
                        'format' => 'html',
                        'value' => function ($data) {
                          return ($data->userlogin->email) ? $data->userlogin->email : '';
                        }
                      ],
                      'fullname',
                      'nickname',
                      'gender',
                      'birthdate',
                      'birthplace',
                      'province.provinsi',
                      'city.kota',
                      'address:ntext',
                      'postalcode',
                      'phone',
                      'domicilestatus',
                      'addressktp:ntext',
                      'nationality',
                      'religion',
                      'maritalstatus',
                      'weddingdate',
                      'bloodtype',
                      'identitynumber',
                      'kknumber',
                      'bpjsnumber',
                      'jamsosteknumber',
                      'npwpnumber',
                      'drivinglicencecarnumber',
                      'drivinglicencemotorcyclenumber',
                    ],
                  ]);
                  echo  Html::a('Next', ['/userfamily/views', 'userid' => $userid], [
                    'class' => 'pull-right btn btn-sm btn-info text-muted',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'bottom',
                    'title' => 'Update',
                  ]);
                } else {
                  echo "No data..";
                } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Main Section -->

  </div>
<?php endif; ?>