<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Userprofile */

$this->title = 'User Profile';
$this->params['breadcrumbs'][] = ['label' => 'User profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
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
                                          <h2>My Profile</h2>
                                          <?php if($model){
                                          echo  Html::a('<i class="fa fa-pencil-square-o"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-sm btn-default text-muted pull-right']);
                                          }
                                          ?>
                                        </div>
                                        <div class="careerfy-description">
                                          <?php
                                          if($model){
                                          echo DetailView::widget([
                                              'model' => $model,
                                              'template' =>'<tr><th width="30%" style="text-align:right;">{label}</th><td style="text-align:left;">{value}</td></tr>',
                                              'options' => ['class' => 'table no-border'],
                                              'attributes' => [
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
                                                  'domicilestatusdescription:ntext',
                                                  'addressktp:ntext',
                                                  'nationality',
                                                  'religion',
                                                  'maritalstatus',
                                                  'weddingdate',
                                                  'bloodtype',
                                                  'identitynumber',
                                                  'bpjsnumber',
                                                  'jamsosteknumber',
                                                  'npwpnumber',
                                                  'drivinglicencecarnumber',
                                                  'drivinglicencemotorcyclenumber',
                                              ],
                                          ]);
                                        }else{
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
