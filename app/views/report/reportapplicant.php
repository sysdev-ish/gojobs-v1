<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use app\models\Masterstatushiring;
use app\models\Transrincian;
use app\models\Userfamily;
use app\models\Userformaleducation;
use app\models\Mastereducation;
use app\models\Userworkexperience;
use app\models\Userabout;
use app\models\Recruitmentcandidate;
use app\models\Masterinfoofrecruitment;
use app\models\Interview;
use app\models\Psikotest;
use app\models\Userinterview;
use app\models\Tsoftskill;
use app\models\Thardskill;
use app\models\Tpasif;
use app\models\Taktif;
use app\models\User;
use app\models\Sappayrollarea;
use app\models\Sappersonalarea;
use app\models\Saparea;
use app\models\Uploadocument;
use app\models\Userprofile;
use app\models\Sapskilllayanan;
use app\models\Uservaksin;
use yii\helpers\ArrayHelper;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Hiringsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Applicant Document Report';
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
    <?php echo $this->render('_searchapplicant', ['model' => $searchModel,'education' => $education,'statuscandidate' => $statuscandidate, 'mastercity'=>$mastercity]); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="info-box">
      <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Total Applicant</span>
        <span class="info-box-number"><?php echo $dataProvider['dataProvider']->getTotalCount(); ?></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-institution (alias)"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Hired By Personal Area</span>
              <span class="info-box-number"><?php //echo $dataProvider['bypersonalarea']->getTotalCount(); ?></span>
            </div>
          </div> -->
  </div>
  <!-- /.col -->
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Applicant Data</h3>
        <div class="box-tools pull-right">
          <?php
                $gridColumns = [
                    ['class' => 'kartik\grid\SerialColumn'],
                    'fullname',

                    [
                      // 'class' => 'kartik\grid\EditableColumn',
                      'label' => 'No KTP',
                      'format'=>'text',
                      'value'=>function ($data) {
                        // if((is_numeric($data->identitynumber))){
                        //   var_dump($data->identitynumber);die;
                        // }
                        // $identitynumber = preg_replace('/\[.*\]/U', '', $data->identitynumber);
                        return ($data->identitynumber and (is_numeric($data->identitynumber)))? number_format($data->identitynumber,0,","," ") : "";
                      }
                    ],
                    
                    [
                      'label' => 'No NPWP',
                      'format'=>'text',
                      'value'=>function ($data) {
                        // $npwpnumber = preg_replace('/\[.*\]/U', '', $data->npwpnumber);

                        return (($data->havenpwp == 1 OR $data->npwpnumber <> 0) and (is_numeric($data->npwpnumber)))?number_format($data->npwpnumber,0,","," ") : "";
                        // return $data->npwpnumber;
                      }
                    ],
                    

                    [
                      'label' => 'Pendidikan terakhir',
                      'format' => 'raw',
                      'value'=>function ($data) {
                        $lasteducation = Userformaleducation::find()->where(['userid' => $data->userid])->orderBy([
                                      'educationallevel' => SORT_DESC //specify sort order ASC for ascending DESC for descending
                                      ])->one();
                        if($lasteducation){
                          $eduname = Mastereducation::find()->where(['idmastereducation' => $lasteducation->educationallevel])->one();
                          return ($eduname)?$eduname->education : "";
                        }else{
                          return "";
                        }
                      }
                    ],
                    
                    [
                      'label' => 'Nama Sekolah / Universitas terakhir',
                      'format' => 'raw',
                      'value'=>function ($data) {
                        $lasteducation = Userformaleducation::find()->where(['userid' => $data->userid])->orderBy([
                                      'educationallevel' => SORT_DESC //specify sort order ASC for ascending DESC for descending
                                      ])->one();

                        return ($lasteducation)?$lasteducation->institutions : "";
                      }
                    ],
                    
                    [
                      'label' => 'Jurusan',
                      'format' => 'raw',
                      'value'=>function ($data) {
                        $lasteducation = Userformaleducation::find()->where(['userid' => $data->userid])->orderBy([
                                      'educationallevel' => SORT_DESC //specify sort order ASC for ascending DESC for descending
                                      ])->one();
                        return ($lasteducation)?$lasteducation->majoring : "";
                      }
                    ],
                    

                    [
                      'label' => 'Surat Lamaran',
                      'format' => 'html',
                      'contentOptions'=>['style'=>'width: 100px;'],
                      'value'=>function ($data) {
                        $doc = Uploadocument::find()->where(['userid' => $data->userid])->one();
                        return ($doc)?(($doc->suratlamarankerja)?"V":"X") : "X";
                      }
                    ],
                    
                    [
                      'label' => 'Curiculum Vitae',
                      'format' => 'html',
                      'contentOptions'=>['style'=>'width: 100px;'],
                      'value'=>function ($data) {
                        $doc = Userprofile::find()->where(['userid' => $data->userid])->one();
                        return ($doc)?"V":"X";
                      }
                    ],
                    
                    [
                      'label' => 'Copy Ijazah',
                      'format' => 'html',
                      'contentOptions'=>['style'=>'width: 100px;'],
                      'value'=>function ($data) {
                        $doc = Uploadocument::find()->where(['userid' => $data->userid])->one();
                        return ($doc)?(($doc->ijazah)?"V":"X") : "X";
                      }
                    ],
                    
                    [
                      'label' => 'Transkip Nilai',
                      'format' => 'html',
                      'contentOptions'=>['style'=>'width: 100px;'],
                      'value'=>function ($data) {
                        $doc = Uploadocument::find()->where(['userid' => $data->userid])->one();
                        return ($doc)?(($doc->transkipnilai)?"V":"X") : "X";
                      }
                    ],
                    
                    [
                      'label' => 'KTP',
                      'format' => 'html',
                      'contentOptions'=>['style'=>'width: 100px;'],
                      'value'=>function ($data) {
                        $doc = Uploadocument::find()->where(['userid' => $data->userid])->one();
                        return ($doc)?(($doc->ktp)?"V":"X") : "X";
                      }
                    ],
                    
                    [
                      'label' => 'NPWP',
                      'format' => 'html',
                      'contentOptions'=>['style'=>'width: 100px;'],
                      'value'=>function ($data) {
                        $doc = Uploadocument::find()->where(['userid' => $data->userid])->one();
                        return ($doc)?(($doc->npwp)?"V":"X") : "X";
                      }
                    ],
                    
                    [
                      'label' => 'Jamsostek',
                      'format' => 'html',
                      'contentOptions'=>['style'=>'width: 100px;'],
                      'value'=>function ($data) {
                        $doc = Uploadocument::find()->where(['userid' => $data->userid])->one();
                        return ($doc)?(($doc->jamsostek)?"V":"X") : "X";
                      }
                    ],
                    
                    [
                      'label' => 'BPJS Kesehatan',
                      'format' => 'html',
                      'contentOptions'=>['style'=>'width: 100px;'],
                      'value'=>function ($data) {
                        $doc = Uploadocument::find()->where(['userid' => $data->userid])->one();
                        return ($doc)?(($doc->bpjskesehatan)?"V":"X") : "X";
                      }
                    ],
                    
                    [
                      'label' => 'Surat Keterangan Sehat',
                      'format' => 'html',
                      'contentOptions'=>['style'=>'width: 100px;'],
                      'value'=>function ($data) {
                        $doc = Uploadocument::find()->where(['userid' => $data->userid])->one();
                        return ($doc)?(($doc->suratketerangansehat)?"V":"X") : "X";
                      }
                    ],
                    
                    [
                      'label' => 'Status Vaksin',
                      'format' => 'html',
                      'contentOptions'=>['style'=>'width: 100px;'],
                      'value'=>function ($data) {
                        $vaksin = Uservaksin::find()->where(['userid' => $data->userid])->one();
                        if($vaksin){
                          switch ($vaksin->statusvaksin) {
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
                        }else{
                          $value = "Belum Vaksin";
                        }

                        return $value;
                      }
                    ],
                    
                    [
                      'label'=>'Alasan',
                      'format' => 'html',
                      'value' => function($data){
                          $vaksin = Uservaksin::find()->where(['userid' => $data->userid])->one();

                          return ($vaksin)?(($vaksin->alasan)?(($vaksin->alasanvaksin)?$vaksin->alasanvaksin->alasan:''):''):'';

                      }

                    ],
                    [
                      'label' => 'Tanggal Vaksin 1',
                      'format' => ['date', 'php:Y-m-d'],
                      'value'=>function ($data) {
                        $vaksin = Uservaksin::find()->where(['userid' => $data->userid])->one();

                        return ($vaksin)?$vaksin->tanggalvaksin1 : "";
                      }
                    ],
                    
                    [
                      'label' => 'Lokasi Vaksin 1',
                      'format' => 'html',
                      'value'=>function ($data) {
                        $vaksin = Uservaksin::find()->where(['userid' => $data->userid])->one();

                        return ($vaksin)?$vaksin->lokasivaksin1 : "";
                      }
                    ],
                    
                    [
                      'label' => 'Sertifikat Vaksin 1',
                      'format' => 'html',
                      'contentOptions'=>['style'=>'width: 100px;'],
                      'value'=>function ($data) {
                        $vaksin = Uservaksin::find()->where(['userid' => $data->userid])->one();

                        return ($vaksin)?(($vaksin->sertvaksin1)?"V":"X") : "X";
                      }
                    ],
                    
                    [
                      'label' => 'Tanggal Vaksin 2',
                      'format' => ['date', 'php:Y-m-d'],
                      'value'=>function ($data) {
                        $vaksin = Uservaksin::find()->where(['userid' => $data->userid])->one();

                        return ($vaksin)?$vaksin->tanggalvaksin2 : "";
                      }
                    ],
                    
                    [
                      'label' => 'Lokasi Vaksin 2',
                      'format' => 'html',
                      'value'=>function ($data) {
                        $vaksin = Uservaksin::find()->where(['userid' => $data->userid])->one();

                        return ($vaksin)?$vaksin->lokasivaksin2 : "";
                      }
                    ],
                    
                    [
                      'label' => 'Sertifikat Vaksin 2',
                      'format' => 'html',
                      'contentOptions'=>['style'=>'width: 100px;'],
                      'value'=>function ($data) {
                        $vaksin = Uservaksin::find()->where(['userid' => $data->userid])->one();

                        return ($vaksin)?(($vaksin->sertvaksin2)?"V":"X") : "X";
                      }
                    ],
                    

                    // [
                    //   'label' => 'Tahun Lulus Sekolah/ Universitas',
                    //   'format' => ['date', 'php:Y'],
                    //   'value'=>function ($data) {
                    //     $lasteducation = Userformaleducation::find()->where(['userid' => $data->userid])->orderBy([
                    //                   'educationallevel' => SORT_DESC //specify sort order ASC for ascending DESC for descending
                    //                   ])->one();
                    //     return ($lasteducation)?$lasteducation->enddate : "";
                    // }
                    //
                    // ],

                    ['class' => 'kartik\grid\ActionColumn', 'urlCreator'=>function(){return '#';}]
                ];
                echo ExportMenu::widget([
                    'dataProvider' => $dataProvider['dataProvider'],
                    'columns' => $gridColumns,
                    // 'target'=> ExportMenu::TARGET_BLANK,
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
      <div class="box-body table-responsive">
        <?php echo GridView::widget([
            'dataProvider' => $dataProvider['dataProvider'],
            // 'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                  'label' => 'Full Name',
                  'attribute' => 'fullname',
                  // 'contentOptions'=>['style'=>'width: 100px;'],
                  'format' => 'raw',
                  'value'=>function ($data) {
                    return $data->fullname;
                }

                ],
                
                [
                  'label' => 'last education',
                  'format' => 'raw',
                  'value'=>function ($data) {
                    $lasteducation = Userformaleducation::find()->where(['userid' => $data->userid])->orderBy([
                                  'educationallevel' => SORT_DESC //specify sort order ASC for ascending DESC for descending
                                  ])->one();
                    if($lasteducation){
                      $eduname = Mastereducation::find()->where(['idmastereducation' => $lasteducation->educationallevel])->one();
                      return ($eduname)?$eduname->education : "";
                    }else{
                      return "";
                    }


                }

                ],
                
                [
                  'label' => 'Majoring',
                  'format' => 'raw',
                  'value'=>function ($data) {
                    $lasteducation = Userformaleducation::find()->where(['userid' => $data->userid])->orderBy([
                                  'educationallevel' => SORT_DESC //specify sort order ASC for ascending DESC for descending
                                  ])->one();
                    return ($lasteducation)?$lasteducation->majoring : "";
                }

                ],
                
                [
                  'label' => 'Domicile City',
                  'format' => 'raw',
                  'value'=>function ($data) {

                    return ($data->city)?$data->city->kota : "";
                }

                ],

              [
                'label' => 'Surat Lamaran',
                'format' => 'html',
                'contentOptions'=>['style'=>'width: 100px;'],
                'value'=>function ($data) {
                  $doc = Uploadocument::find()->where(['userid' => $data->userid])->one();
                  return ($doc)?(($doc->suratlamarankerja)?"<span class='text-green'><i class='fa fa-check'></i></span>":"<span class='text-red'><i class='fa fa-close (alias)'></i></span>") : "<span class='text-red'><i class='fa fa-close (alias)'></i></span>";
              }

              ],

              [
                'label' => 'Curiculum Vitae',
                'format' => 'html',
                'contentOptions'=>['style'=>'width: 100px;'],
                'value'=>function ($data) {
                  $doc = Userprofile::find()->where(['userid' => $data->userid])->one();
                  return ($doc)?"<span class='text-green'><i class='fa fa-check'></i></span>":"<span class='text-red'><i class='fa fa-close (alias)'></i></span>";
              }

              ],

              [
                'label' => 'Copy Ijazah',
                'format' => 'html',
                'contentOptions'=>['style'=>'width: 100px;'],
                'value'=>function ($data) {
                  $doc = Uploadocument::find()->where(['userid' => $data->userid])->one();
                  return ($doc)?(($doc->ijazah)?"<span class='text-green'><i class='fa fa-check'></i></span>":"<span class='text-red'><i class='fa fa-close (alias)'></i></span>") : "<span class='text-red'><i class='fa fa-close (alias)'></i></span>";
              }

              ],

              [
                'label' => 'Transkip Nilai',
                'format' => 'html',
                'contentOptions'=>['style'=>'width: 100px;'],
                'value'=>function ($data) {
                  $doc = Uploadocument::find()->where(['userid' => $data->userid])->one();
                  return ($doc)?(($doc->transkipnilai)?"<span class='text-green'><i class='fa fa-check'></i></span>":"<span class='text-red'><i class='fa fa-close (alias)'></i></span>") : "<span class='text-red'><i class='fa fa-close (alias)'></i></span>";
                }
              ],

              [
                'label' => 'KTP',
                'format' => 'html',
                'contentOptions'=>['style'=>'width: 100px;'],
                'value'=>function ($data) {
                  $doc = Uploadocument::find()->where(['userid' => $data->userid])->one();
                  return ($doc)?(($doc->ktp)?"<span class='text-green'><i class='fa fa-check'></i></span>":"<span class='text-red'><i class='fa fa-close (alias)'></i></span>") : "<span class='text-red'><i class='fa fa-close (alias)'></i></span>";
                }
              ],

              [
                'label' => 'NPWP',
                'format' => 'html',
                'contentOptions'=>['style'=>'width: 100px;'],
                'value'=>function ($data) {
                  $doc = Uploadocument::find()->where(['userid' => $data->userid])->one();
                  return ($doc)?(($doc->npwp)?"<span class='text-green'><i class='fa fa-check'></i></span>":"<span class='text-red'><i class='fa fa-close (alias)'></i></span>") : "<span class='text-red'><i class='fa fa-close (alias)'></i></span>";
                }
              ],

              [
                'label' => 'Jamsostek',
                'format' => 'html',
                'contentOptions'=>['style'=>'width: 100px;'],
                'value'=>function ($data) {
                  $doc = Uploadocument::find()->where(['userid' => $data->userid])->one();
                  return ($doc)?(($doc->jamsostek)?"<span class='text-green'><i class='fa fa-check'></i></span>":"<span class='text-red'><i class='fa fa-close (alias)'></i></span>") : "<span class='text-red'><i class='fa fa-close (alias)'></i></span>";
                }
              ],

              [
                'label' => 'BPJS Kesehatan',
                'format' => 'html',
                'contentOptions'=>['style'=>'width: 100px;'],
                'value'=>function ($data) {
                  $doc = Uploadocument::find()->where(['userid' => $data->userid])->one();
                  return ($doc)?(($doc->bpjskesehatan)?"<span class='text-green'><i class='fa fa-check'></i></span>":"<span class='text-red'><i class='fa fa-close (alias)'></i></span>") : "<span class='text-red'><i class='fa fa-close (alias)'></i></span>";
                }
              ],

              [
                'label' => 'Surat Keterangan Sehat',
                'format' => 'html',
                'contentOptions'=>['style'=>'width: 100px;'],
                'value'=>function ($data) {
                  $doc = Uploadocument::find()->where(['userid' => $data->userid])->one();
                  return ($doc)?(($doc->suratketerangansehat)?"<span class='text-green'><i class='fa fa-check'></i></span>":"<span class='text-red'><i class='fa fa-close (alias)'></i></span>") : "<span class='text-red'><i class='fa fa-close (alias)'></i></span>";
                }
              ],

              ['class' => 'yii\grid\ActionColumn',
              'contentOptions'=>['style'=>'min-width: 50px;'],
              'template'=>'<div class="btn-group pull-right">{download}</div>',
              'buttons'=>[
                'download' => function ($url, $model) {

                  // if($model->documentpsikotest){
                  //   $disabled = false;
                  // }else{
                  //   $disabled = true;
                  // }
                  return Html::a('<i class="fa fa-download" style="font-size:12pt;"></i>', ['download', 'userid'=>$model->userid], ['class' => 'btn btn-sm btn-primary','data-toggle' => 'tooltip', 'title'=> 'Download','target'=>'_blank' ]);
                },
              ]
            ],

            ],
        ]); ?>
      </div>
    </div>
  </div>
</div>
<script>
  //-------------
  //- PIE CHART -
  //-------------
  // Get context with jQuery - using jQuery's .get() method.
  // var PieData        = [
  //   {
  //     value    : <?php //echo ($dataProvider['byedusd'])?$dataProvider['byedusd']->getTotalCount():0; ?>,
  //     color    : '#f56954',
  //     highlight: '#f56954',
  //     label    : 'Elementary school'
  //   },
  //   {
  //     value    : <?php //echo ($dataProvider['byedusmp'])?$dataProvider['byedusmp']->getTotalCount():0; ?>,
  //     color    : '#00a65a',
  //     highlight: '#00a65a',
  //     label    : 'Junior high school'
  //   },
  //   {
  //     value    : <?php //echo ($dataProvider['byedusma'])?$dataProvider['byedusma']->getTotalCount():0; ?>,
  //     color    : '#f39c12',
  //     highlight: '#f39c12',
  //     label    : 'Senior high school'
  //   },
  //   {
  //     value    : <?php //echo ($dataProvider['byedud3'])?$dataProvider['byedud3']->getTotalCount():0; ?>,
  //     color    : '#00c0ef',
  //     highlight: '#00c0ef',
  //     label    : 'Associate degree'
  //   },
  //   {
  //     value    : <?php //echo ($dataProvider['byedus1'])?$dataProvider['byedus1']->getTotalCount():0; ?>,
  //     color    : '#3c8dbc',
  //     highlight: '#3c8dbc',
  //     label    : 'Bachelor degree'
  //   },
  //   {
  //     value    : <?php //echo ($dataProvider['byedus2'])?$dataProvider['byedus2']->getTotalCount():0; ?>,
  //     color    : '#d2d6de',
  //     highlight: '#d2d6de',
  //     label    : 'Master degree'
  //   },
  //   {
  //     value    : <?php //echo ($dataProvider['byedus3'])?$dataProvider['byedus3']->getTotalCount():0; ?>,
  //     color    : '#000',
  //     highlight: '#000',
  //     label    : 'Doctoral degree'
  //   }
  // ]
  // var pieOptions     = {
  //   //Boolean - Whether we should show a stroke on each segment
  //   segmentShowStroke    : true,
  //   //String - The colour of each segment stroke
  //   segmentStrokeColor   : '#fff',
  //   //Number - The width of each segment stroke
  //   segmentStrokeWidth   : 2,
  //   //Number - The percentage of the chart that we cut out of the middle
  //   percentageInnerCutout: 50, // This is 0 for Pie charts
  //   //Number - Amount of animation steps
  //   animationSteps       : 100,
  //   //String - Animation easing effect
  //   animationEasing      : 'easeOutBounce',
  //   //Boolean - Whether we animate the rotation of the Doughnut
  //   animateRotate        : true,
  //   //Boolean - Whether we animate scaling the Doughnut from the centre
  //   animateScale         : false,
  //   //Boolean - whether to make the chart responsive to window resizing
  //   responsive           : true,
  //   // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
  //   maintainAspectRatio  : true,
  //   //String - A legend template
  //   // legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
  // }
  // //Create pie or douhnut chart
  // // You can switch between pie and douhnut using the method below.
  // window.onload = function(){
  // 			var ctx = document.getElementById("pieChart").getContext("2d");
  // 			window.myPie = new Chart(ctx).Pie(PieData, pieOptions);
  // 		};
</script>