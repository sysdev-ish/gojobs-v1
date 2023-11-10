<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Userformaleducation;
use app\models\Mastereducation;
use app\models\Userabout;
use app\models\Recruitmentcandidate;
use app\models\Uploadocument;
use app\models\Userprofile;
use app\models\Uservaksin;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Hiringsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Applicant Document Report';
$this->params['breadcrumbs'][] = $this->title;

if (Yii::$app->user->isGuest) {
  $role = null;
} else {
  $role = Yii::$app->user->identity->role;
}
app\assets\ReportAsset::register($this);
?>
<div class="hiring-index box box-default">
  <div class="box-body">
    <?php echo $this->render('_searchapplicant', ['model' => $searchModel, 'education' => $education, 'statuscandidate' => $statuscandidate, 'mastercity' => $mastercity, 'province' => $province]); ?>
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
            // ['class' => 'kartik\grid\SerialColumn'],
            ['class' => 'yii\grid\SerialColumn'],
            'fullname',
            [
              'label' => 'Domicile City',
              'format' => 'raw',
              'value' => function ($data) {
                return ($data->city) ? $data->city->kota : "";
              }
            ],

            [
              'label' => 'Tanggal Lahir',
              'format' => 'html',
              'value' => function ($data) {
                return ($data) ? $data->birthdate : "";
              }
            ],

            [
              'label' => 'Jenis Kelamin',
              'format' => 'html',
              'value' => function ($data) {
                return ($data) ? $data->gender : "";
              }
            ],

            [
              'label' => 'Status Pernikahan',
              'format' => 'html',
              'value' => function ($data) {
                return ($data) ? $data->maritalstatus : "";
              }
            ],

            [
              'label' => 'Posisi yang Dilamar',
              'format' => 'html',
              'value' => function ($data) {
                $id = Recruitmentcandidate::find()->where(['userid' => $data->userid])->one();
                if ($id) {
                  return ($id->recrequest) ? $id->recrequest->jabatan_sap_nm : "";
                } else {
                  return "";
                }
              }
            ],

            [
              'label' => 'Pengalaman Kerja',
              'format' => 'html',
              'value' => function ($data) {
                return ($data->userworkexperience) ? $data->userworkexperience->lastposition : "";
              }
            ],

            [
              'label' => 'No KTP',
              'format' => 'text',
              'value' => function ($data) {
                return ($data->identitynumber and (is_numeric($data->identitynumber))) ? number_format($data->identitynumber, 0, ",", " ") : "";
              }
            ],

            [
              'label' => 'No NPWP',
              'format' => 'text',
              'value' => function ($data) {
                return (($data->havenpwp == 1 or $data->npwpnumber <> 0) and (is_numeric($data->npwpnumber))) ? number_format($data->npwpnumber, 0, ",", " ") : "";
              }
            ],


            [
              'label' => 'Pendidikan terakhir',
              'format' => 'raw',
              'value' => function ($data) {
                  return ($data->education) ? $data->education->masteredu->education : "";
              }
            ],

            [
              'label' => 'Nama Sekolah / Universitas terakhir',
              'format' => 'raw',
              'value' => function ($data) {
                return ($data->education) ? $data->education->institutions : "";
              }
            ],

            [
              'label' => 'Jurusan',
              'format' => 'raw',
              'value' => function ($data) {
                return ($data->education) ? $data->education->majoring : "";
              }
            ],


            [
              'label' => 'Surat Lamaran',
              'format' => 'html',
              'contentOptions' => ['style' => 'width: 100px;'],
              'value' => function ($data) {
                return ($data->upload) ? (($data->upload->suratlamarankerja) ? "V" : "X") : "X";
              }
            ],

            [
              'label' => 'Curiculum Vitae',
              'format' => 'html',
              'contentOptions' => ['style' => 'width: 100px;'],
              'value' => function ($data) {
                return ($data->upload) ? "V" : "X";
              }
            ],

            [
              'label' => 'Copy Ijazah',
              'format' => 'html',
              'contentOptions' => ['style' => 'width: 100px;'],
              'value' => function ($data) {
                return ($data->upload) ? (($data->upload->ijazah) ? "V" : "X") : "X";
              }
            ],

            [
              'label' => 'Transkip Nilai',
              'format' => 'html',
              'contentOptions' => ['style' => 'width: 100px;'],
              'value' => function ($data) {
                return ($data->upload) ? (($data->upload->transkipnilai) ? "V" : "X") : "X";
              }
            ],

            [
              'label' => 'KTP',
              'format' => 'html',
              'contentOptions' => ['style' => 'width: 100px;'],
              'value' => function ($data) {
                return ($data->upload) ? (($data->upload->ktp) ? "V" : "X") : "X";
              }
            ],

            [
              'label' => 'NPWP',
              'format' => 'html',
              'contentOptions' => ['style' => 'width: 100px;'],
              'value' => function ($data) {
                return ($data->upload) ? (($data->upload->npwp) ? "V" : "X") : "X";
              }
            ],

            [
              'label' => 'Jamsostek',
              'format' => 'html',
              'contentOptions' => ['style' => 'width: 100px;'],
              'value' => function ($data) {
                return ($data->upload) ? (($data->upload->jamsostek) ? "V" : "X") : "X";
              }
            ],

            [
              'label' => 'BPJS Kesehatan',
              'format' => 'html',
              'contentOptions' => ['style' => 'width: 100px;'],
              'value' => function ($data) {
                return ($data->upload) ? (($data->upload->bpjskesehatan) ? "V" : "X") : "X";
              }
            ],

            [
              'label' => 'Surat Keterangan Sehat',
              'format' => 'html',
              'contentOptions' => ['style' => 'width: 100px;'],
              'value' => function ($data) {
                return ($data->upload) ? (($data->upload->suratketerangansehat) ? "V" : "X") : "X";
              }
            ],

            [
              'label' => 'Status Vaksin',
              'format' => 'html',
              'contentOptions' => ['style' => 'width: 100px;'],
              'value' => function ($data) {
                $vaksin = Uservaksin::find()->where(['userid' => $data->userid])->one();
                if ($vaksin) {
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
              'format' => ['date', 'php:Y-m-d'],
              'value' => function ($data) {

                return ($data->datavaksin) ? $data->datavaksin->tanggalvaksin1 : "";
              }
            ],

            [
              'label' => 'Lokasi Vaksin 1',
              'format' => 'html',
              'value' => function ($data) {

                return ($data->datavaksin) ? $data->datavaksin->lokasivaksin1 : "";
              }
            ],

            [
              'label' => 'Sertifikat Vaksin 1',
              'format' => 'html',
              'contentOptions' => ['style' => 'width: 100px;'],
              'value' => function ($data) {

                return ($data->datavaksin) ? (($data->datavaksin->sertvaksin1) ? "V" : "X") : "X";
              }
            ],

            [
              'label' => 'Tanggal Vaksin 2',
              'format' => ['date', 'php:Y-m-d'],
              'value' => function ($data) {

                return ($data->datavaksin) ? $data->datavaksin->tanggalvaksin2 : "";
              }
            ],

            [
              'label' => 'Lokasi Vaksin 2',
              'format' => 'html',
              'value' => function ($data) {

                return ($data->datavaksin) ? $data->datavaksin->lokasivaksin2 : "";
              }
            ],

            [
              'label' => 'Sertifikat Vaksin 2',
              'format' => 'html',
              'contentOptions' => ['style' => 'width: 100px;'],
              'value' => function ($data) {

                return ($data->datavaksin) ? (($data->datavaksin->sertvaksin2) ? "V" : "X") : "X";
              }
            ],

            [
              'label' => 'Info Recruitment',
              'format' => 'html',
              'contentOptions' => ['style' => 'width: 100px;'],
              'value' => function ($data) {
                return ($data->uabout) ? $data->uabout->masterinforec->infoofrecruitment : "";
              }
            ],

            ['class' => 'yii\grid\ActionColumn', 'urlCreator' => function () {
              return '#';
            }]
          ];
          echo ExportMenu::widget([
            'dataProvider' => $dataProvider['dataProvider'],
            'columns' => $gridColumns,
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
              'format' => 'raw',
              'value' => function ($data) {
                return $data->fullname;
              }

            ],

            [
              'label' => 'Last Education',
              'format' => 'raw',
              'value' => function ($data) {
                return ($data->education) ? $data->education->masteredu->education : "";
              }
            ],

            [
              'label' => 'Majoring',
              'format' => 'raw',
              'value' => function ($data) {
                return ($data->education) ? $data->education->majoring : "";
              }
            ],

            [
              'label' => 'Domicile City',
              'format' => 'raw',
              'value' => function ($data) {

                return ($data->city) ? $data->city->kota : "";
              }

            ],

            [
              'label' => 'Surat Lamaran',
              'format' => 'html',
              'contentOptions' => ['style' => 'width: 100px;'],
              'value' => function ($data) {
                return ($data->upload) ? (($data->upload->suratlamarankerja) ? "<span class='text-green'><i class='fa fa-check'></i></span>" : "<span class='text-red'><i class='fa fa-close (alias)'></i></span>") : "<span class='text-red'><i class='fa fa-close (alias)'></i></span>";
              }

            ],

            [
              'label' => 'Curiculum Vitae',
              'format' => 'html',
              'contentOptions' => ['style' => 'width: 100px;'],
              'value' => function ($data) {
                return ($data->upload) ? "<span class='text-green'><i class='fa fa-check'></i></span>" : "<span class='text-red'><i class='fa fa-close (alias)'></i></span>";
              }

            ],

            [
              'label' => 'Copy Ijazah',
              'format' => 'html',
              'contentOptions' => ['style' => 'width: 100px;'],
              'value' => function ($data) {
                return ($data->upload) ? (($data->upload->ijazah) ? "<span class='text-green'><i class='fa fa-check'></i></span>" : "<span class='text-red'><i class='fa fa-close (alias)'></i></span>") : "<span class='text-red'><i class='fa fa-close (alias)'></i></span>";
              }

            ],

            [
              'label' => 'Transkip Nilai',
              'format' => 'html',
              'contentOptions' => ['style' => 'width: 100px;'],
              'value' => function ($data) {
                return ($data->upload) ? (($data->upload->transkipnilai) ? "<span class='text-green'><i class='fa fa-check'></i></span>" : "<span class='text-red'><i class='fa fa-close (alias)'></i></span>") : "<span class='text-red'><i class='fa fa-close (alias)'></i></span>";
              }
            ],

            [
              'label' => 'KTP',
              'format' => 'html',
              'contentOptions' => ['style' => 'width: 100px;'],
              'value' => function ($data) {
                return ($data->upload) ? (($data->upload->ktp) ? "<span class='text-green'><i class='fa fa-check'></i></span>" : "<span class='text-red'><i class='fa fa-close (alias)'></i></span>") : "<span class='text-red'><i class='fa fa-close (alias)'></i></span>";
              }
            ],

            [
              'label' => 'NPWP',
              'format' => 'html',
              'contentOptions' => ['style' => 'width: 100px;'],
              'value' => function ($data) {
                return ($data->upload) ? (($data->upload->npwp) ? "<span class='text-green'><i class='fa fa-check'></i></span>" : "<span class='text-red'><i class='fa fa-close (alias)'></i></span>") : "<span class='text-red'><i class='fa fa-close (alias)'></i></span>";
              }
            ],

            [
              'label' => 'Jamsostek',
              'format' => 'html',
              'contentOptions' => ['style' => 'width: 100px;'],
              'value' => function ($data) {
                return ($data->upload) ? (($data->upload->jamsostek) ? "<span class='text-green'><i class='fa fa-check'></i></span>" : "<span class='text-red'><i class='fa fa-close (alias)'></i></span>") : "<span class='text-red'><i class='fa fa-close (alias)'></i></span>";
              }
            ],

            [
              'label' => 'BPJS Kesehatan',
              'format' => 'html',
              'contentOptions' => ['style' => 'width: 100px;'],
              'value' => function ($data) {
                return ($data->upload) ? (($data->upload->bpjskesehatan) ? "<span class='text-green'><i class='fa fa-check'></i></span>" : "<span class='text-red'><i class='fa fa-close (alias)'></i></span>") : "<span class='text-red'><i class='fa fa-close (alias)'></i></span>";
              }
            ],

            [
              'label' => 'Surat Keterangan Sehat',
              'format' => 'html',
              'contentOptions' => ['style' => 'width: 100px;'],
              'value' => function ($data) {
                return ($data->upload) ? (($data->upload->suratketerangansehat) ? "<span class='text-green'><i class='fa fa-check'></i></span>" : "<span class='text-red'><i class='fa fa-close (alias)'></i></span>") : "<span class='text-red'><i class='fa fa-close (alias)'></i></span>";
              }
            ],

            [
              'label' => 'Info Recruitment',
              'format' => 'html',
              'contentOptions' => ['style' => 'width: 100px;'],
              'value' => function ($data) {
                return ($data->uabout) ? $data->uabout->masterinforec->infoofrecruitment : "";
              }
            ],

            [
              'class' => 'yii\grid\ActionColumn',
              'contentOptions' => ['style' => 'min-width: 50px;'],
              'template' => '<div class="btn-group pull-right">{download}</div>',
              'buttons' => [
                'download' => function ($url, $model) {
                  return Html::a('<i class="fa fa-download" style="font-size:12pt;"></i>', ['download', 'userid' => $model->userid], ['class' => 'btn btn-sm btn-primary', 'data-toggle' => 'tooltip', 'title' => 'Download', 'target' => '_blank']);
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
  //     value    : <?php //echo ($dataProvider['byedusd'])?$dataProvider['byedusd']->getTotalCount():0; 
                    ?>,
  //     color    : '#f56954',
  //     highlight: '#f56954',
  //     label    : 'Elementary school'
  //   },
  //   {
  //     value    : <?php //echo ($dataProvider['byedusmp'])?$dataProvider['byedusmp']->getTotalCount():0; 
                    ?>,
  //     color    : '#00a65a',
  //     highlight: '#00a65a',
  //     label    : 'Junior high school'
  //   },
  //   {
  //     value    : <?php //echo ($dataProvider['byedusma'])?$dataProvider['byedusma']->getTotalCount():0; 
                    ?>,
  //     color    : '#f39c12',
  //     highlight: '#f39c12',
  //     label    : 'Senior high school'
  //   },
  //   {
  //     value    : <?php //echo ($dataProvider['byedud3'])?$dataProvider['byedud3']->getTotalCount():0; 
                    ?>,
  //     color    : '#00c0ef',
  //     highlight: '#00c0ef',
  //     label    : 'Associate degree'
  //   },
  //   {
  //     value    : <?php //echo ($dataProvider['byedus1'])?$dataProvider['byedus1']->getTotalCount():0; 
                    ?>,
  //     color    : '#3c8dbc',
  //     highlight: '#3c8dbc',
  //     label    : 'Bachelor degree'
  //   },
  //   {
  //     value    : <?php //echo ($dataProvider['byedus2'])?$dataProvider['byedus2']->getTotalCount():0; 
                    ?>,
  //     color    : '#d2d6de',
  //     highlight: '#d2d6de',
  //     label    : 'Master degree'
  //   },
  //   {
  //     value    : <?php //echo ($dataProvider['byedus3'])?$dataProvider['byedus3']->getTotalCount():0; 
                    ?>,
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