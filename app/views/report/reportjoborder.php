<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use app\models\Hiring;
use app\models\Transrincian;
use app\models\Transjo;
use app\models\Recruitmentcandidate;
use yii\helpers\ArrayHelper;
use kartik\export\ExportMenu;
use app\models\Masterjobfamily;
use app\models\Mastersubjobfamily;
use app\models\Mappingjob;
use Symfony\Component\Finder\Finder;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Hiringsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Job Order Report';
$this->params['breadcrumbs'][] = $this->title;

if(Yii::$app->user->isGuest){
  $role = null;
}else{
  // $userid = Yii::$app->user->identity->id;
  $role = Yii::$app->user->identity->role;
}
app\assets\ReportAsset::register($this);
?>
<div class="hiring-index box box-default">
  <div class="box-body">
    <?php echo $this->render('_searchjo', [
            'model' => $searchModel,
            'area' => $area,
            'parea' => $parea,
            'areaish' => $areaish,
            'region' => $region,
            'jobfamily' => $jobfamily,
            'subjobfamily' => $subjobfamily,
          ]); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="col-md-6 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fa fa-tags"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total Job Order</span>
          <span class="info-box-number"><?php echo $dataProvider['dataProvider']->getTotalCount(); ?></span>
        </div>
        <!-- /.info-box-content -->
      </div>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total Kebutuhan Pekerja</span>
          <span class="info-box-number"><?php echo $dataProvider['totalkebutuhan']; ?></span>
        </div>
        <!-- /.info-box-content -->
      </div>
    </div>
    <!-- <div class="col-md-4 col-sm-4 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total Pemenuhan Pekerja (Hiring)</span>
          <span class="info-box-number"><?php //echo $dataProvider['totalpemenuhan']; ?></span>
        </div>
      </div>
    </div> -->

  </div>
  <!-- /.col -->
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Job Order Data</h3>
        <div class="box-tools pull-right">
          <?php
                $gridColumns = [
                    ['class' => 'kartik\grid\SerialColumn'],
                    'id',
                    'nojo',
                    [
                      'label' => 'Type JO',
                      'attribute' => 'typejo',
                      'format' => 'raw',
                      'value'=>function ($data) {

                        return ($data->typejo == 1)?"New Project" : "Replacement";

                    }

                    ],
                    [
                      'label' => 'Type SAP',
                      'attribute' => 'typejo',
                      'format' => 'raw',
                      'value'=>function ($data) {

                        return ($data->transjo)?(($data->transjo->flag_peralihan == 1)?"Peralihan" : "ISH"):'-';

                    }

                    ],

                    [
                      'label' => 'Due Date',
                      'format' => ['date', 'php:Y-m-d'],
                      'value'=>function ($data) {
                        if($data->typejo == 1){
                          return ($data->transjo)? $data->transjo->bekerja:'';

                        }else{
                          return ($data->transperner)? $data->transperner->tgl_resign:'';

                        }
                      }

                    ],
                    [
                      'label' => 'Tanggal Approved JO',
                      'format' => ['date', 'php:Y-m-d'],
                      'value'=>function ($data) {
                        if($data->typejo == 1){
                          return ($data->transrincian)? (($data->transrincian->lup_skema AND $data->transrincian->lup_skema <> '0000-00-00')?$data->transrincian->lup_skema : ""):'';

                        }else{
                          return ($data->transperner)? (($data->transperner->lup_skema AND $data->transperner->lup_skema <> '0000-00-00')?$data->transperner->lup_skema : ""):'';

                        }

                    }

                    ],
                    [
                      'label' => 'Area (SAP)',
                      'attribute' => 'area_sap',
                      'format' => 'html',
                      'value'=>function ($data) {

                        return ($data->areasap)?$data->areasap->value2 : "";
                    }

                    ],
                    [
                      'label' => 'Project',
                      'format' => 'html',
                      'value'=>function ($data) {

                        // return ($data->transjo->n_project == '' || $data->transjo->n_project == 'Pilih')?$data->transjo->project : $data->transjo->n_project;
                        return $data->n_project;
                    }

                    ],
                    [
                      'label' => 'Personal Area(SAP)',
                      'attribute' => 'persa_sap',
                      'format' => 'raw',
                      'value'=>function ($data) {

                        return ($data->persasap)?$data->persasap->value2 : "";

                    }

                    ],
                    [
                      'label' => 'Jabatan (SAP)',
                      // 'show' => false,
                      // 'attribute' => 'jabatansap',
                      // 'contentOptions'=>['style'=>'width: 150px;'],
                      'format' => 'raw',
                      'value'=>function ($data) {
                        if ($data->hire_jabatan_sap) {
                          if (is_numeric($data->hire_jabatan_sap)) {
                            if ($data->jabatansap) {
                              return $data->jabatansap->value2;
                            } else {
                              return "-";
                            }
                          } else {
                            return "-";
                          }
                        } else {
                          return "-";
                        }
                        // return ($data->hire_jabatan_sap) ? ((is_numeric($data->hire_jabatan_sap)) ? $data->jabatansap->value2 : '-') : '-';
                      }


                    ],
                    'gender',
                    'pendidikan',
                    [
                      'label' => 'Jumlah',
                      'format' => 'raw',
                      'value'=>function ($data) {
                      return ($data->jumlah)?$data->jumlah:"";
                    }

                    ],
                    [
                      'label' => 'Jumlah Pelamar',
                      'format' => 'raw',
                      'value'=>function ($data) {
                        $getcandidate = Recruitmentcandidate::find()->where(['recruitreqid'=>$data->id])->all();
                      return ($getcandidate)?count($getcandidate):"";
                    }

                    ],
                    [
                      'label' => 'Status',
                      'attribute' => 'status_rekrut',
                      'format' => 'raw',
                      'value'=>function ($data) {
                        switch ($data->status_rekrut) {
                          case 1:
                            $status = "On Progress";
                            break;
                          case 2:
                            $status = "Done";
                            break;
                          case 3:
                            $status = "On Progress (Revised JO)";
                            break;
                          case 4:
                            $status = "Done (Revised JO)";
                            break;

                          default:
                            $status = '';
                            break;
                        }
                      return $status;
                    }
                    ],

                    [
                      'label' => 'Jumlah Pemenuhan (Hiring)',
                      'format' => 'raw',
                      'value'=>function ($data) {
                        $hired = Hiring::find()->where(['recruitreqid'=>$data->id,'statushiring'=>[4,7,8]])->count();
                        $hiredpending = Hiring::find()->where(['recruitreqid'=>$data->id,'statushiring'=>3])->count();
                        return ($hired)?$hired:(($hiredpending)?"Fail On Hiring":"-");
                      }
                    ],

                    [
                      'label' => 'Area ISH',
                      'format' => 'raw',
                      'value'=>function ($data) {
                          return ($data->areasap)? 'Area '.$data->areasap->areaid:'';
                    }

                    ],
                    [
                      'label' => 'Region',
                      'format' => 'raw',
                      'value'=>function ($data) {
                          return ($data->areasap)? 'Region '.$data->areasap->regionalid:'';
                    }

                    ],
                    [
                      'label' => 'Bulan',
                      'format' => ['date', 'php:m'],
                      'value'=>function ($data) {
                        if($data->typejo == 1){
                          return ($data->transrincian)? (($data->transrincian->lup_skema AND $data->transrincian->lup_skema <> '0000-00-00')?$data->transrincian->lup_skema : ""):'';

                        }else{
                          return ($data->transperner)? (($data->transperner->lup_skema AND $data->transperner->lup_skema <> '0000-00-00')?$data->transperner->lup_skema : ""):'';

                        }
                    }
                    ],

                    //add by kaha
                    [
                      'label' => 'Job Family',
                      'format' => 'raw',
                      'value' => 'mappingjob.subjobfam.jobfam.jobfamily',
                    ],

                    [
                      'label' => 'Sub Job Family',
                      'format' => 'raw',
                      'value' => 'mappingjob.subjobfam.subjobfamily',
                    ],

                    // ['class' => 'kartik\grid\ActionColumn', 'urlCreator'=>function(){return '#';}]
                ];
                echo ExportMenu::widget([
                    'dataProvider' => $dataProvider['dataProvider'],
                    'columns' => $gridColumns,
                    // 'target'=> ExportMenu::TARGET_BLANK,
                    'batchSize' => 10,
                    'selectedColumns' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21],
                    'columnSelectorOptions'=>[
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
        <?php
          echo GridView::widget([
              'dataProvider' => $dataProvider['dataProvider'],
              // 'filterModel' => $searchModel,
              'layout' => "{items}\n{summary}\n{pager}",
              'columns' => [
                  ['class' => 'yii\grid\SerialColumn'],
                  // 'id',
                  'nojo',
                  [
                    'label' => 'Create JO',
                    'attribute' => 'tanggal',
                    'format' => ['date', 'php:d-m-Y'],
                    'value'=>function ($data) {

                      return ($data->transjo)?$data->transjo->tanggal : "";
                  }

                  ],
                  [
                    'label' => 'Type JO',
                    'attribute' => 'typejo',
                    'format' => 'raw',
                    'value'=>function ($data) {

                      return ($data->typejo == 1)?"New Project" : "Replacement";

                  }

                  ],
                  [
                    'label' => 'Personal Area',
                    'attribute' => 'persa_sap',
                    'format' => 'raw',
                    'value'=>function ($data) {

                      return ($data->persasap)?$data->persasap->value2 : "";

                  }

                  ],
                  [
                    'label' => 'Area',
                    'attribute' => 'area_sap',
                    'format' => 'html',
                    'value'=>function ($data) {

                      return ($data->areasap)?$data->areasap->value2 : "";
                  }

                  ],
                  [
                    'label' => 'Status',
                    'attribute' => 'status_rekrut',
                    'format' => 'raw',
                    'value'=>function ($data) {
                      switch ($data->status_rekrut) {
                        case 1:
                          $status = "On Progress";
                          break;
                        case 2:
                          $status = "Done";
                          break;
                        case 3:
                          $status = "On Progress (Revised JO)";
                          break;
                        case 4:
                          $status = "Done (Revised JO)";
                          break;
                        default:
                          $status = '';
                          break;
                      }
                    return $status;
                  }

                  ],
                  [
                    'label' => 'Jumlah',
                    'format' => 'raw',
                    'value'=>function ($data) {
                    return ($data->jumlah)?$data->jumlah:"";
                    }
                  ],
                  
                  // add by kaha
                  [
                    'label' => 'Job Family',
                    'format' => 'raw',
                    'value' => 'mappingjob.subjobfam.jobfam.jobfamily',
                  ],
                  
                  [
                    'label' => 'Sub Job Family',
                    'format' => 'raw',
                    'value' => 'mappingjob.subjobfam.subjobfamily',
                  ],

                  [
                    'label' => 'Hired',
                    'format' => 'raw',
                    'value'=>function ($data) {
                      $tr = Transrincian::find()->where(['id'=> $data->id])->one();
                      $transjo = Transjo::find()->where(['nojo'=> $tr->nojo])->one();
                      if($transjo->flag_peralihan == 1 and $tr->status_rekrut == 2 and ($transjo->new_rekrut == 1 OR $transjo->new_rekrut == 3)){
                          return ($data->jumlah)?$data->jumlah:"";

                      }else{
                      $hired = Hiring::find()->where(['recruitreqid'=>$data->id,'statushiring'=>[4,7,8]])->count();
                      $hiredpending = Hiring::find()->where(['recruitreqid'=>$data->id,'statushiring'=>3])->count();
                      return ($hired)?$hired:(($hiredpending)?"Fail On Hiring":"-");
                    }
                  }

                  ],
              ],
          ]);
          ?>
      </div>
    </div>
  </div>
</div>