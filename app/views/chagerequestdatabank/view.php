<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use linslin\yii2\curl;
use app\models\Hiring;
use app\models\Transrincian;

/* @var $this yii\web\View */
/* @var $model app\models\Chagerequestdata */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Chagerequestdatas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="chagerequestdata-view box box-solid">
  <div class="row">
    <div class="col-md-5">
      <div class="box-body table-responsive">
        <?= DetailView::widget([
          'model' => $model,
          'attributes' => [
            'id',
            'fullname',
            [
              'label' => 'Perner',
              'format' => 'html',
              'value' => function ($data) {

                return ($data->perner) ? $data->perner : "";
              }

            ],
            [
              'label' => 'Personal Area',
              'format' => 'html',
              'value' => function ($data) {
                if ($data->userid) {
                  $cekhiring = Hiring::find()->where(['userid' => $data->userid])->one();
                  $getjo = Transrincian::find()->where(['id' => $cekhiring->recruitreqid])->one();
                  $persa = (Yii::$app->utils->getpersonalarea($getjo->persa_sap)) ? Yii::$app->utils->getpersonalarea($getjo->persa_sap) : "";
                } else {
                  $curl = new curl\Curl();
                  $getdatapekerjabyperner =  $curl->setPostParams([
                    'perner' => $data->perner,
                    'token' => 'ish**2019',
                  ])
                    ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerjaall');
                  $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
                  $persa = ($datapekerjabyperner) ? $datapekerjabyperner[0]->WKTXT : "not found";
                }
                return $persa;
              }

            ],
            [
              'label' => 'Area',
              'format' => 'html',
              'value' => function ($data) {
                if ($data->userid) {
                  $cekhiring = Hiring::find()->where(['userid' => $data->userid])->one();
                  $getjo = Transrincian::find()->where(['id' => $cekhiring->recruitreqid])->one();
                  $area = (Yii::$app->utils->getarea($getjo->area_sap)) ? Yii::$app->utils->getarea($getjo->area_sap) : "";
                } else {
                  $curl = new curl\Curl();
                  $getdatapekerjabyperner =  $curl->setPostParams([
                    'perner' => $data->perner,
                    'token' => 'ish**2019',
                  ])
                    ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerjaall');
                  $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
                  $area = ($datapekerjabyperner) ? $datapekerjabyperner[0]->BTRTX : "not found";
                }
                return $area;
              }

            ],
            [
              'label' => 'Skill Layanan',
              'format' => 'html',
              'value' => function ($data) {
                if ($data->userid) {
                  $cekhiring = Hiring::find()->where(['userid' => $data->userid])->one();
                  $getjo = Transrincian::find()->where(['id' => $cekhiring->recruitreqid])->one();
                  $skilllayanan = (Yii::$app->utils->getskilllayanan($getjo->skill_sap)) ? Yii::$app->utils->getskilllayanan($getjo->skill_sap) : "";
                } else {
                  $curl = new curl\Curl();
                  $getdatapekerjabyperner =  $curl->setPostParams([
                    'perner' => $data->perner,
                    'token' => 'ish**2019',
                  ])
                    ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerjaall');
                  $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
                  $skilllayanan = ($datapekerjabyperner) ? $datapekerjabyperner[0]->PEKTX : "not found";
                }
                return $skilllayanan;
              }

            ],
            [
              'label' => 'Payroll Area',
              'format' => 'html',
              'value' => function ($data) {
                if ($data->userid) {
                  $cekhiring = Hiring::find()->where(['userid' => $data->userid])->one();
                  $getjo = Transrincian::find()->where(['id' => $cekhiring->recruitreqid])->one();
                  $payrollarea = (Yii::$app->utils->getpayrollarea($getjo->abkrs_sap)) ? Yii::$app->utils->getpayrollarea($getjo->abkrs_sap) : "";
                } else {
                  $curl = new curl\Curl();
                  $getdatapekerjabyperner =  $curl->setPostParams([
                    'perner' => $data->perner,
                    'token' => 'ish**2019',
                  ])
                    ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerjaall');
                  $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
                  $payrollarea = ($datapekerjabyperner) ? $datapekerjabyperner[0]->ABTXT : "not found";
                }
                return $payrollarea;
              }

            ],
            [
              'label' => 'Jabatan',
              'format' => 'html',
              'value' => function ($data) {
                if ($data->userid) {
                  $cekhiring = Hiring::find()->where(['userid' => $data->userid])->one();
                  $getjo = Transrincian::find()->where(['id' => $cekhiring->recruitreqid])->one();
                  $jabatan = (Yii::$app->utils->getjabatan($getjo->hire_jabatan_sap)) ? Yii::$app->utils->getjabatan($getjo->hire_jabatan_sap) : "";
                } else {
                  $curl = new curl\Curl();
                  $getdatapekerjabyperner =  $curl->setPostParams([
                    'perner' => $data->perner,
                    'token' => 'ish**2019',
                  ])
                    ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerjaall');
                  $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
                  $jabatan = ($datapekerjabyperner) ? $datapekerjabyperner[0]->PLATX : "not found";
                }
                return $jabatan;
              }

            ],
            [
              'label' => 'Level',
              'format' => 'html',
              'value' => function ($data) {
                if ($data->userid) {
                  $cekhiring = Hiring::find()->where(['userid' => $data->userid])->one();
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
                  $curl = new curl\Curl();
                  $getdatapekerjabyperner =  $curl->setPostParams([
                    'perner' => $data->perner,
                    'token' => 'ish**2019',
                  ])
                    ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerjaall');
                  $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
                  $level = ($datapekerjabyperner) ? $datapekerjabyperner[0]->TRFAR_TXT : "not found";
                }
                return $level;
              }

            ],
            [
              'label' => 'Status',
              'format' => 'html',
              'value' => function ($data) {
                if ($data->status == 2 or $data->status == 3 or $data->status == 7) {
                  $curl = new curl\Curl();
                  $getdatapekerjabyperner =  $curl->setPostParams([
                    'perner' => $data->perner,
                    'token' => 'ish**2019',
                  ])
                    ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerjaall');
                  $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
                  $status = "Active";

                  if ($datapekerjabyperner) {
                    if ($datapekerjabyperner[0]->MASSN == "Z8") {
                      $status = "Resign";
                    }
                  } else {
                    $status = "Cancel Join";
                  }
                } else {
                  $status = ($data->statusresign == 1) ? "Active" : "Resign";
                }

                return $status;
              }

            ],
            [
              'label' => 'Resign Reason',
              'format' => 'html',
              'value' => function ($data) {
                if ($data->status == 2 or $data->status == 3 or $data->status == 7) {
                  $curl = new curl\Curl();
                  $getdatapekerjabyperner =  $curl->setPostParams([
                    'perner' => $data->perner,
                    'token' => 'ish**2019',
                  ])
                    ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerjaall');
                  $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
                  $resignreason = ($datapekerjabyperner) ? (($datapekerjabyperner[0]->MASSN == "Z8") ? $datapekerjabyperner[0]->MSGTX : "-") : "not found";
                } else {
                  $resignreason = $data->resignreason;
                }

                return $resignreason;
              }

            ],
            [
              'label' => 'Resign Date',
              'format' => 'html',
              'value' => function ($data) {
                if ($data->status == 2 or $data->status == 3 or $data->status == 7) {
                  $curl = new curl\Curl();
                  $getdatapekerjabyperner =  $curl->setPostParams([
                    'perner' => $data->perner,
                    'token' => 'ish**2019',
                  ])
                    ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerjaall');
                  $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
                  $resigndate = "-";

                  if ($datapekerjabyperner) {
                    if ($datapekerjabyperner[0]->MASSN == "Z8") {
                      $resigndate = "-";

                      if ($datapekerjabyperner[0]->DAT35) {
                        $year = substr($datapekerjabyperner[0]->DAT35, 0, 4);
                        $month = substr($datapekerjabyperner[0]->DAT35, 4, 2);
                        $date = substr($datapekerjabyperner[0]->DAT35, 6, 2);
                        $resigndate = $year . "-" . $month . "-" . $date;
                      }
                    }
                  }
                } else {
                  $resigndate = $data->resigndate;
                }



                return $resigndate;
              }

            ],
            'createtime',
            'updatetime',
            'approvedtime',
            [
              'label' => 'Created By',
              'format' => 'html',
              'value' => function ($data) {

                return ($data->createduser) ? $data->createduser->name : "";
              }

            ],
            [
              'label' => 'Updated By',
              'format' => 'html',
              'value' => function ($data) {

                return ($data->updateduser) ? $data->updateduser->name : "";
              }

            ],
            [
              'label' => 'Approved By',
              'format' => 'html',
              'value' => function ($data) {

                return ($data->approveduser) ? $data->approveduser->name : "";
              }

            ],
            // 'kategorydata',
          ],
        ]) ?>
      </div>
    </div>
    <div class="col-md-7">
      <div class="box-body table-responsive">
        <table class="table no-border">
          <tbody>
            <?php if ($bankaccountoldval) : ?>
              <tr>
                <td width="20%" style="text-align:right;"><b>Bank Account</b></td>
                <td width="30%"><?php
                                echo $bankaccountoldval; ?></td>
                <td rowspan="2" style="vertical-align: middle !important;font-size:14pt;"><span class="fa fa-retweet"></span></td>
                <td width="30%" class="text-red"><?php echo $bankaccountnewval; ?></td>
              </tr>
              <tr>
                <td width="20%" style="text-align:right;"><b>Account Number</b></td>
                <td><?php echo $bankaccountnumberoldval . '<br>' .
                      (($bankaccountolddoc) ? Html::a('<i class="fa fa-download"></i> ' . $bankaccountolddoc, ['/app/assets/upload/bankaccount/' . $bankaccountolddoc], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted']) : '-'); ?></td>
                <td width="30%" class="text-red"><?php echo $bankaccountnumbernewval . '<br>' .
                                                    (($bankaccountnewdoc) ? Html::a('<i class="fa fa-download"></i> ' . $bankaccountnewdoc, ['/app/assets/upload/bankaccount/' . $bankaccountnewdoc], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted']) : '-'); ?> </td>
              </tr>
            <?php else : ?>
              <tr>
                <td width="20%" style="text-align:right;"><b>Bank Account</b></td>
                <td width="30%"><?php
                                echo $bankaccount; ?></td>
                <td rowspan="2" style="vertical-align: middle !important;font-size:14pt;"><span class="fa fa-retweet"></span></td>
                <td width="30%" class="text-red"><?php echo $bankaccountnewval; ?></td>
              </tr>
              <tr>
                <td width="20%" style="text-align:right;"><b>Account Number</b></td>
                <td><?php echo $bankaccountnumber . '<br>' .
                      (($bankaccountfile) ? Html::a('<i class="fa fa-download"></i> ' . $bankaccountfile, ['/app/assets/upload/bankaccount/' . $bankaccountfile], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted']) : '-'); ?></td>
                <td width="30%" class="text-red"><?php echo $bankaccountnumbernewval . '<br>' .
                                                    (($bankaccountnewdoc) ? Html::a('<i class="fa fa-download"></i> ' . $bankaccountnewdoc, ['/app/assets/upload/bankaccount/' . $bankaccountnewdoc], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted']) : '-'); ?> </td>
              </tr>
            <?php endif; ?>


          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>