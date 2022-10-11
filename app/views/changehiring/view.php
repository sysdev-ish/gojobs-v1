<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use linslin\yii2\curl;
use app\models\Hiring;
use app\models\Transrincian;


/* @var $this yii\web\View */
/* @var $model app\models\changehiring */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'changehirings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="changehiring-view box box-solid">

  <div class="box-body table-responsive no-padding">
    <?= DetailView::widget([
      'model' => $model,
      'attributes' => [
        'id',
        'perner',
        'fullname',
        'userid',

        [
          'label' => 'No JO',
          'format' => 'html',
          'value' => function ($data) {
            if ($data->userid) {
              $cekhiring = Hiring::find()->where('userid =' . $data->userid . ' and (statushiring = 4 OR statushiring = 6)')->orderBy(["id" => SORT_DESC])->one();
              if ($cekhiring) {
                $getjo = Transrincian::find()->where(['id' => $cekhiring->recruitreqid])->one();
              }
              return ($getjo) ? $getjo->nojo : '-';
            }
          }
        ],

        [
          'label' => 'Personal Area',
          'format' => 'html',
          'value' => function ($data) {
            if ($data->userid) {
              $cekhiring = Hiring::find()->where('userid =' . $data->userid . ' and (statushiring = 4 OR statushiring = 6)')->orderBy(["id" => SORT_DESC])->one();
              if ($cekhiring) {
                $getjo = Transrincian::find()->where(['id' => $cekhiring->recruitreqid])->one();
                $persa = (Yii::$app->utils->getpersonalarea($getjo->persa_sap)) ? Yii::$app->utils->getpersonalarea($getjo->persa_sap) : "";
              } else {
                $persa = "-";
              }
            }
            return $persa;
          }
        ],

        [
          'label' => 'Area',
          'format' => 'html',
          'value' => function ($data) {
            if ($data->userid) {
              $cekhiring = Hiring::find()->where('userid =' . $data->userid . ' and (statushiring = 4 OR statushiring = 6)')->orderBy(["id" => SORT_DESC])->one();
              if ($cekhiring) {
                $getjo = Transrincian::find()->where(['id' => $cekhiring->recruitreqid])->one();
                $area = (Yii::$app->utils->getarea($getjo->area_sap)) ? Yii::$app->utils->getarea($getjo->area_sap) : "";
              } else {
                $area = "-";
              }
            }
            return $area;
          }
        ],

        [
          'label' => 'Skill Layanan',
          'format' => 'html',
          'value' => function ($data) {
            if ($data->userid) {
              $cekhiring = Hiring::find()->where('userid =' . $data->userid . ' and (statushiring = 4 OR statushiring = 6)')->orderBy(["id" => SORT_DESC])->one();
              if ($cekhiring) {
                $getjo = Transrincian::find()->where(['id' => $cekhiring->recruitreqid])->one();
                $skilllayanan = (Yii::$app->utils->getskilllayanan($getjo->skill_sap)) ? Yii::$app->utils->getskilllayanan($getjo->skill_sap) : "";
              } else {
                $skilllayanan = "-";
              }
            }
            return $skilllayanan;
          }
        ],

        [
          'label' => 'Payroll Area',
          'format' => 'html',
          'value' => function ($data) {
            if ($data->userid) {
              $cekhiring = Hiring::find()->where('userid =' . $data->userid . ' and (statushiring = 4 OR statushiring = 6)')->orderBy(["id" => SORT_DESC])->one();
              if ($cekhiring) {
                $getjo = Transrincian::find()->where(['id' => $cekhiring->recruitreqid])->one();
                $payrollarea = (Yii::$app->utils->getpayrollarea($getjo->abkrs_sap)) ? Yii::$app->utils->getpayrollarea($getjo->abkrs_sap) : "";
              } else {
                $payrollarea = "-";
              }
            }
            return $payrollarea;
          }
        ],

        [
          'label' => 'Jabatan',
          'format' => 'html',
          'value' => function ($data) {
            if ($data->userid) {
              $cekhiring = Hiring::find()->where('userid =' . $data->userid . ' and (statushiring = 4 OR statushiring = 6)')->orderBy(["id" => SORT_DESC])->one();
              if ($cekhiring) {
                $getjo = Transrincian::find()->where(['id' => $cekhiring->recruitreqid])->one();
                $jabatan = (Yii::$app->utils->getjabatan($getjo->hire_jabatan_sap)) ? Yii::$app->utils->getjabatan($getjo->hire_jabatan_sap) : "";
              } else {
                $jabatan = "-";
              }
            }
            return $jabatan;
          }
        ],

        [
          'label' => 'Level',
          'format' => 'html',
          'value' => function ($data) {
            if ($data->userid) {
              $cekhiring = Hiring::find()->where('userid =' . $data->userid . ' and (statushiring = 4 OR statushiring = 6)')->orderBy(["id" => SORT_DESC])->one();
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
            }
            return $level;
          }
        ],

        [
          'attribute' => 'reason',
          'format' => 'html',
          'value' => function ($data) {
            return ($data->reason) ? $data->canceljoinreason->reason : "<i class='text-red'>not set</i>";
          }
        ],

        'cancelhiring',

        [
          'label' => 'Approver',
          'attribute' => 'approveduser',
          'format' => 'html',
          'value' => function ($data) {
            return ($data->approveduser) ? $data->approveduser->name : "PM";
          }
        ],
        [
          'label' => 'Status',
          'attribute' => 'status',
          'format' => 'html',
          'value' => function ($data) {
            if ($data->status == 1) {
              $label = 'label-danger';
            } elseif ($data->status == 2 or $data->status == 3 or $data->status == 6) {
              $label = 'label-warning';
            } elseif ($data->status == 4 or $data->status == 9) {
              $label = 'label-success';
            } elseif ($data->status == 8) {
              $label = 'label-info';
            } else {
              $label = 'label-danger';
            }
            return '<span class="label ' . $label . '">' . $data->statusprocess->statusname . '</span>';
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
        'updatetime',
        'approvedtime',
      ],
    ]) ?>
  </div>
</div>