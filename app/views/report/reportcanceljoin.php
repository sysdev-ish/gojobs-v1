<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use app\models\Masterstatuscr;
use app\models\Transrincian;
use app\models\Transperner;
use app\models\Transrincianori;
use app\models\canceljoin;
use app\models\Hiring;
use kartik\export\ExportMenu;
use linslin\yii2\curl;


/* @var $this yii\web\View */
/* @var $searchModel app\models\canceljoinsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Report Cancel Join';
$this->params['breadcrumbs'][] = $this->title;

if (Yii::$app->user->isGuest) {
  $role = null;
} else {
  // $userid = Yii::$app->user->identity->id;
  $role = Yii::$app->user->identity->role;
}
app\assets\ReportAsset::register($this);
?>
<div class="canceljoin-index box box-default">
  <div class="box-body">
    <?php echo $this->render('_searchcanceljoin', [
      'model' => $searchModel,
      'status' => $status,
      'segmen' => $segmen,
    ]); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Total Cancel Join</span>
          <span class="info-box-number"><?php echo $dataProvider['dataProvider']->getTotalCount(); ?></span>
        </div>
      </div>
  </div>
  <!-- /.col -->
  <div class="col-md-12 col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Data Cancel Join</h3>
        <div class="box-tools pull-right">
          <?php
          $gridColumns = [
            ['class' => 'kartik\grid\SerialColumn'],
            'userprofile.fullname',
            'perner',

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
              'label' => 'Tanggal Create Canceljoin',
              'format' => ['date', 'php:Y-m-d'],
              'value' => function ($data) {
                return ($data) ? $data->createtime : "-";
              }
            ],

            [
              'label' => 'Tanggal Approved Cancel Join',
              'format' => ['date', 'php:Y-m-d'],
              'value' => function ($data) {
                return ($data) ? $data->updatetime : "-";
              }
            ],

            [
              'label' => 'Reason',
              'format' => 'raw',
              'value' => function ($data) {
                return ($data->reason) ? $data->canceljoinreason->reason : "<i class='text-red'>not set</i>";
              }
            ],

            [
              'label' => 'Cancel Date',
              'format' => ['date', 'php:Y-m-d'],
              'value' => function ($data) {
                  return ($data) ? $data->canceldate : '-';
              }
            ],

            [
              'label' => 'Remarks',
              'format' => 'html',
              'value' => function ($data) {
                return ($data) ? $data->userremarks : '';
              }
            ],

            [
              'label' => 'Segmen',
              'format' => 'raw',
              'value' => function ($data) {

                $cekhiring = Hiring::find()->where('userid =' . $data->userid . ' and (statushiring = 4 OR statushiring = 6)')->orderBy(["id" => SORT_DESC])->one();
                if ($cekhiring) {
                  $getjo = Transrincian::find()->where(['id' => $cekhiring->recruitreqid])->one();
                }
                // var_dump($getjo->transjo);die;
                return ($getjo->transjo->segmen) ? $getjo->transjo->segmen->divisi : '-';
              }
            ],

            [
              'label' => 'Status',
              'format' => 'raw',
              'value' => function ($data) {
                return ($data->statusprocess) ? $data->statusprocess->statusname : '-';
              }
            ],

          ];
          echo ExportMenu::widget([
            'dataProvider' => $dataProvider['dataProvider'],
            'columns' => $gridColumns,
            'batchSize' => 10,
            'columnSelectorOptions' => [
              'label' => 'Columns',
            ],
            'exportConfig' => [
              ExportMenu::FORMAT_HTML => false,
              ExportMenu::FORMAT_TEXT => false,
              ExportMenu::FORMAT_PDF => false,
            ]
          ]);

          ?>
        </div>
      </div>
      <div class="box-body">
        <?php echo GridView::widget([
          'dataProvider' => $dataProvider['dataProvider'],
          'layout' => "{items}\n{summary}\n{pager}",
          'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
              'label' => 'Full Name',
              'attribute' => 'fullname',
              'format' => 'raw',
              'value' => function ($data) {
                return $data->userprofile->fullname;
              }
            ],

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
              'attribute' => 'perner',
              'format' => 'raw',
              'value' => function ($data) {
                return ($data->perner) ? $data->perner : "";
              }
            ],

            [
              'attribute' => 'createdby',
              'format' => 'html',
              'value' => function ($data) {

                return ($data->createduser) ? $data->createduser->name : "";
              }
            ],

            [
              'label' => 'Cancel Join Reason',
              'format' => 'html',
              'value' => function ($data) {
                return ($data->reason) ? $data->canceljoinreason->reason : "<i class='text-red'>not set</i>";
              }
            ],

            [
              'label' => 'Cancel Date',
              'format' => ['date', 'php:Y-m-d'],
              'value' => function ($data) {
                return ($data) ? $data->canceldate : '-';
              }
            ],

            [
              'label' => 'Segmen',
              'format' => 'raw',
              'value' => function ($data) {

                $cekhiring = Hiring::find()->where('userid =' . $data->userid . ' and (statushiring = 4 OR statushiring = 6)')->orderBy(["id" => SORT_DESC])->one();
                if ($cekhiring) {
                  $getjo = Transrincian::find()->where(['id' => $cekhiring->recruitreqid])->one();
                }
                // var_dump($getjo->transjo);die;
                return ($getjo->transjo->segmen) ? $getjo->transjo->segmen->divisi : '-';
              }
            ],

            [
              'label' => 'Status',
              'format' => 'raw',
              'value' => function ($data) {
                return ($data->statusprocess) ? $data->statusprocess->statusname : '-';
              }
            ],

          ],
        ]); ?>
      </div>
    </div>
  </div>
</div>