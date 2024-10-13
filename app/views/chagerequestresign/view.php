<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use linslin\yii2\curl;
use app\models\Hiring;
use app\models\Transrincian;


/* @var $this yii\web\View */
/* @var $model app\models\Chagerequestresign */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Chagerequestresigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chagerequestresign-view box box-solid">

  <div class="box-body table-responsive no-padding">
    <?= DetailView::widget([
      'model' => $model,
      'attributes' => [
        'id',
        'perner',
        'fullname',
        [
          'label' => 'Personal Area',
          'format' => 'html',
          'value' => function ($data) {
            if ($data->userid) {
              $cekhiring = Hiring::find()->where('userid =' . $data->userid . ' and (statushiring = 4 OR statushiring = 7)')->orderBy(["id" => SORT_DESC])->one();

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
              $persa = $datapekerjabyperner[0]->WKTXT;
            }
            return $persa;
          }

        ],
        [
          'label' => 'Area',
          'format' => 'html',
          'value' => function ($data) {
            if ($data->userid) {
              $cekhiring = Hiring::find()->where('userid =' . $data->userid . ' and (statushiring = 4 OR statushiring = 7)')->orderBy(["id" => SORT_DESC])->one();
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
              $area = $datapekerjabyperner[0]->BTRTX;
            }
            return $area;
          }

        ],
        [
          'label' => 'Skill Layanan',
          'format' => 'html',
          'value' => function ($data) {
            if ($data->userid) {
              $cekhiring = Hiring::find()->where('userid =' . $data->userid . ' and (statushiring = 4 OR statushiring = 7)')->orderBy(["id" => SORT_DESC])->one();
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
              $skilllayanan = $datapekerjabyperner[0]->PEKTX;
            }
            return $skilllayanan;
          }

        ],
        [
          'label' => 'Payroll Area',
          'format' => 'html',
          'value' => function ($data) {
            if ($data->userid) {
              $cekhiring = Hiring::find()->where('userid =' . $data->userid . ' and (statushiring = 4 OR statushiring = 7)')->orderBy(["id" => SORT_DESC])->one();
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
              $payrollarea = $datapekerjabyperner[0]->ABTXT;
            }
            return $payrollarea;
          }

        ],
        [
          'label' => 'Jabatan',
          'format' => 'html',
          'value' => function ($data) {
            if ($data->userid) {
              $cekhiring = Hiring::find()->where('userid =' . $data->userid . ' and (statushiring = 4 OR statushiring = 7)')->orderBy(["id" => SORT_DESC])->one();
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
              $jabatan = $datapekerjabyperner[0]->PLATX;
            }
            return $jabatan;
          }

        ],
        [
          'label' => 'Level',
          'format' => 'html',
          'value' => function ($data) {
            if ($data->userid) {
              $cekhiring = Hiring::find()->where('userid =' . $data->userid . ' and (statushiring = 4 OR statushiring = 7)')->orderBy(["id" => SORT_DESC])->one();
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
              $level = $datapekerjabyperner[0]->TRFAR_TXT;
            }
            return $level;
          }

        ],
        [
          'attribute' => 'reason',
          'format' => 'html',
          'value' => function ($data) {
            return ($data->reason) ? $data->resignreason->reason : "<i class='text-red'>not set</i>";
          }

        ],
        'resigndate',

        [

          'label' => 'Approver',
          'attribute' => 'approveduser',
          'format' => 'html',
          'value' => function ($data) {

            return ($data->approveduser) ? $data->approveduser->name : "";
          }

        ],
        'approvedtime',
        // 'status',
        [
          'attribute' => 'status',
          'format' => 'html',
          'value' => function ($data) {

            return ($data->status) ? $data->statusprocess->statusname : "";
          }

        ],
        'remarks',
        [
          'attribute' => 'createdby',
          'format' => 'html',
          'value' => function ($data) {

            return ($data->createduser) ? $data->createduser->name : "";
          }

        ],
        'createtime',
        [
          'attribute' => 'updatedby',
          'format' => 'html',
          'value' => function ($data) {

            return ($data->updateduser) ? $data->updateduser->name : "";
          }

        ],
        'updatetime',
      ],
    ]) ?>
  </div>
</div>