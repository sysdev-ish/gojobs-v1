<?php

use app\models\Hiring;
use app\models\Transrincian;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use kartik\select2\Select2;
use linslin\yii2\curl;

/* @var $this yii\web\View */
/* @var $model app\models\Chagerequestjo */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
  <div class="col-sm-12">
    <blockquote>
      <p>Approval Change Cancel Join for <b><?php echo $model->fullname; ?></b> perner (<?php echo $model->perner; ?>).</p>
      <small>Personal Area (SAP) <cite title="Source Title"><b>
            <?php if ($model->userid) {
              $cekhiring = Hiring::find()->where('userid =' . $model->userid . ' and (statushiring = 4 OR statushiring = 7)')->orderBy(["id" => SORT_DESC])->one();
              if ($cekhiring) {
                $getjo = Transrincian::find()->where(['id' => $cekhiring->recruitreqid])->one();
                $persa = (Yii::$app->utils->getpersonalarea($getjo->persa_sap)) ? Yii::$app->utils->getpersonalarea($getjo->persa_sap) : "";
              } else {
                $persa = "-";
              }
            } else {
              $curl = new curl\Curl();
              $getdatapekerjabyperner =  $curl->setPostParams([
                'perner' => $model->perner,
                'token' => 'ish**2019',
              ])
                ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerja');
              $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
              $persa = $datapekerjabyperner[0]->WKTXT;
            }
            echo $persa;
            ?>
          </b></cite>
      </small>

      <small>Area (SAP) <cite title="Source Title"><b>
            <?php if ($model->userid) {
              $cekhiring = Hiring::find()->where('userid =' . $model->userid . ' and (statushiring = 4 OR statushiring = 7)')->orderBy(["id" => SORT_DESC])->one();
              if ($cekhiring) {
                $getjo = Transrincian::find()->where(['id' => $cekhiring->recruitreqid])->one();
                $area = (Yii::$app->utils->getarea($getjo->area_sap)) ? Yii::$app->utils->getarea($getjo->area_sap) : "";
              } else {
                $area = "-";
              }
            } else {
              $curl = new curl\Curl();
              $getdatapekerjabyperner =  $curl->setPostParams([
                'perner' => $model->perner,
                'token' => 'ish**2019',
              ])
                ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerja');
              $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
              $area = $datapekerjabyperner[0]->BTRTX;
            }
            echo $area;
            ?>
          </b></cite>
      </small>

      <small>Skill Layanan (SAP) <cite title="Source Title"><b>
            <?php if ($model->userid) {
              $cekhiring = Hiring::find()->where('userid =' . $model->userid . ' and (statushiring = 4 OR statushiring = 7)')->orderBy(["id" => SORT_DESC])->one();
              if ($cekhiring) {
                $getjo = Transrincian::find()->where(['id' => $cekhiring->recruitreqid])->one();
                $skilllayanan = (Yii::$app->utils->getskilllayanan($getjo->skill_sap)) ? Yii::$app->utils->getskilllayanan($getjo->skill_sap) : "";
              } else {
                $skilllayanan = "-";
              }
            } else {
              $curl = new curl\Curl();
              $getdatapekerjabyperner =  $curl->setPostParams([
                'perner' => $model->perner,
                'token' => 'ish**2019',
              ])
                ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerja');
              $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
              $skilllayanan = $datapekerjabyperner[0]->PEKTX;
            }
            echo $skilllayanan;
            ?></b></cite>
      </small>

      <small>Payroll Area (SAP) <cite title="Source Title"><b>
            <?php if ($model->userid) {
              $cekhiring = Hiring::find()->where('userid =' . $model->userid . ' and (statushiring = 4 OR statushiring = 7)')->orderBy(["id" => SORT_DESC])->one();
              if ($cekhiring) {
                $getjo = Transrincian::find()->where(['id' => $cekhiring->recruitreqid])->one();
                $payrollarea = (Yii::$app->utils->getpayrollarea($getjo->abkrs_sap)) ? Yii::$app->utils->getpayrollarea($getjo->abkrs_sap) : "";
              } else {
                $payrollarea = "-";
              }
            } else {
              $curl = new curl\Curl();
              $getdatapekerjabyperner =  $curl->setPostParams([
                'perner' => $model->perner,
                'token' => 'ish**2019',
              ])
                ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerja');
              $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
              $payrollarea = $datapekerjabyperner[0]->ABTXT;
            }
            echo $payrollarea; ?></b></cite>
      </small>

      <small>Jabatan (SAP) <cite title="Source Title"><b>
            <?php if ($model->userid) {
              $cekhiring = Hiring::find()->where('userid =' . $model->userid . ' and (statushiring = 4 OR statushiring = 7)')->orderBy(["id" => SORT_DESC])->one();
              if ($cekhiring) {
                $getjo = Transrincian::find()->where(['id' => $cekhiring->recruitreqid])->one();
                $jabatan = (Yii::$app->utils->getjabatan($getjo->hire_jabatan_sap)) ? Yii::$app->utils->getjabatan($getjo->hire_jabatan_sap) : "";
              } else {
                $jabatan = "-";
              }
            } else {
              $curl = new curl\Curl();
              $getdatapekerjabyperner =  $curl->setPostParams([
                'perner' => $model->perner,
                'token' => 'ish**2019',
              ])
                ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerja');
              $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
              // var_dump($datapekerjabyperner);die;
              $jabatan = $datapekerjabyperner[0]->PLATX;
            }
            echo $jabatan; ?></b></cite></small>
      <small>level (SAP) <cite title="Source Title"><b>
        <?php if ($model->userid) {
        $cekhiring = Hiring::find()->where('userid =' . $model->userid . ' and (statushiring = 4 OR statushiring = 7)')->orderBy(["id" => SORT_DESC])->one();
        if ($cekhiring) {
          $getjo = Transrincian::find()->where(['id' => $cekhiring->recruitreqid])->one();
          $curl = new curl\Curl();
          $getlevels = $curl->setPostParams([
            'level' => $getjo->level_sap,
            'token' => 'ish**2019',
          ])
            ->post('http://192.168.88.5/service/index.php/sap_profile/getlevel');
          $level  = json_decode($getlevels);
          $level = ($level) ? $level : "";
        } else {
          $level = "-";
        }
      } else {
        $curl = new curl\Curl();
        $getdatapekerjabyperner =  $curl->setPostParams([
          'perner' => $model->perner,
          'token' => 'ish**2019',
        ])
          ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerja');
        $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
        $level = $datapekerjabyperner[0]->TRFAR_TXT;
      }
      echo $level; ?></b></cite>
      </small>
    </blockquote>
  </div>
  <div class="col-md-12">
    <div class="chagerequestjo-form">
      <?php $form = ActiveForm::begin(); ?>
      <div class="box-body table-responsive">

        <?php
        $data = [8 => 'Approve', 5 => 'Reject', 6 => 'Revise'];
        echo   $form->field($model, 'status')->widget(Select2::classname(), [
          'data' => $data,
          'options' => ['placeholder' => '- select -'],
          'pluginOptions' => [
            'allowClear' => false,
            'initialize' => true,
          ],
          ])->label('Action');
        ?>
      </div>
      <br>
      <div class="box-footer">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success btn-flat pull-right']) ?>
      </div>
      <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>