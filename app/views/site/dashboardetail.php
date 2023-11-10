<?php

/* @var $this yii\web\View */

use kartik\date\DatePicker;
use yii\helpers\Html;
use kartik\select2\Select2;
use Mpdf\Tag\Select;
use yii\widgets\ActiveForm;

$this->title = 'Dashboard Detail';
$this->params['breadcrumbs'][] = $this->title;
app\assets\DashboardAsset::register($this);
?>
<style>
  .form-group {
    margin-top: -10px;
    margin-right: 10px;
  }

  canvas {
    -moz-user-select: none;
    -webkit-user-select: none;
    -ms-user-select: none;
  }
</style>
<div class="site-dashboard">
  <div class="row">
    <div class="col-lg-3">
      <div class="box box-default collapsed-box">
        <div class="box-header with-border">
          <h3 class="box-title">Search Data by Year</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
            </button>
          </div>
        </div>

        <div class="box-body">
          <?php $form = ActiveForm::begin([
            'action' => ['dashboard'],
            'method' => 'post',

          ]); ?>
          <div class="input-group">
            <div class="col-lg-12">
              <?php
              $thisYear = date('Y', time());
              $thisYeard = date('Y', time());
              $thisMonth = date('n', time());
              for ($yearNum = 2019; $yearNum <= $thisYear; $yearNum++) {
                $years[$yearNum] = $yearNum;
              }
              echo $form->field($model, 'yeardata')->widget(Select2::classname(), [
                'data' => $years,
                'options' => ['placeholder' => '- Year -', 'id' => 'yeardata'],
                'pluginOptions' => [
                  'allowClear' => true
                ],
              ])->label(false);
              ?>
            </div>
            <span class="input-group-btn">
              <?= Html::submitButton('Filter', ['class' => 'btn btn-info']) ?>
            </span>
          </div>
          <?php ActiveForm::end(); ?>
        </div>
      </div>
    </div>
    <div class="col-lg-9">
      <div class="box box-default collapsed-box">
        <div class="box-header with-border">
          <h3 class="box-title">Search Data</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
            </button>
          </div>
        </div>

        <div class="box-body">
          <?php $form = ActiveForm::begin([
            'action' => ['dashboardetail'],
            'method' => 'post',

          ]); ?>
          <div class="input-group">
            <div class="col-lg-4">
              <?= $form->field($model, 'start_date')->widget(
                DatePicker::className(),
                [
                  'type' => DatePicker::TYPE_RANGE,
                  'options' => ['placeholder' => 'Date', 'autocomplete' => 'off'],
                  'readonly' => false,
                  'removeButton' => true,
                  'attribute2' => 'end_date',
                  'pluginOptions' => [
                    'autoclose' => true,
                    'startDate' => '-4y',
                    'endDate' => '-0y',
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true
                  ]
                ]
              )->label('Date Range');
              ?>
            </div>
            <div class="col-lg-4">
              <?php echo $form->field($model, 'persa_sap')->widget(Select2::classname(), [
                'data' => $parea,
                'options' => ['placeholder' => '- Persa -', 'id' => 'persa_sap'],
                'pluginOptions' => [
                  'allowClear' => true,
                  'multiple' => true
                ],
              ])->label('Personal Area'); ?>
            </div>
            <div class="col-lg-4">
              <?php echo $form->field($model, 'area_sap')->widget(Select2::classname(), [
                'data' => $area,
                'options' => ['placeholder' => '- Area -', 'id' => 'area_sap'],
                'pluginOptions' => [
                  'allowClear' => true,
                  'multiple' => true
                ],
              ])->label('Area'); ?>
            </div>
            <span class="input-group-btn">
              <?= Html::submitButton('Filter', ['class' => 'btn btn-info']) ?>
            </span>
          </div>
          <?php ActiveForm::end(); ?>
        </div>
      </div>
    </div>
  </div>

  <h4> Job Order </h4>
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?php echo $totaljo; ?>
            <!-- <span style="padding-left:10px; font-size:large; font-style:italic; font-weight: 300;">orang</span> -->
          </h3>
          <p>Total Kebutuhan Job Order</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3><?php echo $totalclosed; ?></h3>

          <p>Total Pemenuhan Job Order</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><?php echo $totalpending; ?></h3>

          <p>Total GAP Pemenuhan Job Order</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3><?php echo $totalstopjo; ?></h3>

          <p>Total Stop Job Order</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
      </div>
    </div>
    <!-- ./col -->
  </div>

  <h4> Employee </h4>
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?php echo $totalemp; ?></h3>

          <p>Total Kebutuhan Pekerja</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3><?php
              // echo $totalempclosed;

              echo $totalhiring; ?></h3>

          <p>Total Pemenuhan Pekerja (Hiring)</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><?php
              // echo $totalemppending;
              $pendingemp = $totalemp - $totalhiring;
              echo $pendingemp;
              ?></h3>

          <p>Total GAP Pemenuhan Pekerja</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
      </div>
    </div>
    <!-- ./col -->

    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3><?php echo $totalpekerjastopjo; ?></h3>

          <p>Total Stop Pekerja</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
      </div>
    </div>
  </div>

  <h4> Candidate </h4>
  <div class="row">
    <div class="col-lg-6 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?php
              echo $totalapplicant;
              ?></h3>

          <p>Total Pelamar</p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
      </div>
    </div>
    <!-- ./col -->
    <!-- <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-green">
        <div class="inner">
          <h3><? //php echo $candidatecount; 
              ?></h3>

          <p>Total Candidate</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
      </div>
    </div> -->
    <div class="col-lg-6 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?php echo $totalophiring; ?></h3>

          <p>Total On Process Hiring</p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
      </div>
    </div>
    <!-- ./col -->

    <!-- <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-green">
        <div class="inner">
          <h3><? //php echo $totalhiring; 
              ?></h3>

          <p>Total Hiring</p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
      </div>
    </div> -->
  </div>

  <div class="row">
    <div class="col-lg-2 col-xs-12">
    </div>
    <div class="col-lg-8 col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Recruitment Process</h3>
        </div>

        <div class="box-body no-padding">
          <table class="table table-striped">
            <tbody>
              <tr>
                <th style="width: 10px">#</th>
                <th>Task</th>
                <th style="width: 40px">Count</th>
              </tr>

              <tr>
                <td>1.</td>
                <td>Psikotest</td>

                <td align="right"><span class="badge bg-light-blue"><?php echo $psikotestapp; ?></span></td>
              </tr>
              <tr>
                <td></td>
                <td style="padding-left:30px;">On Psikotest</td>

                <td align="right"><span class="badge bg-default"><?php echo $onpsicount; ?></span></td>
              </tr>
              <tr>
                <td></td>
                <td style="padding-left:30px;">Pass</td>

                <td align="right"><span class="badge bg-default"><?php echo $passpsicount; ?></span></td>
              </tr>
              <tr>
                <td></td>
                <td style="padding-left:30px;">Fail</td>

                <td align="right"><span class="badge bg-default"><?php echo $failpsicount; ?></span></td>
              </tr>

              <tr>
                <td>2.</td>
                <td>Interview</td>

                <td align="right"><span class="badge bg-light-blue"><?php echo $interviewapp; ?></span></td>
              </tr>
              <tr>
                <td></td>
                <td style="padding-left:30px;">On Interview</td>

                <td align="right"><span class="badge bg-default"><?php echo $onintcount; ?></span></td>
              </tr>
              <tr>
                <td></td>
                <td style="padding-left:30px;">Pass</td>

                <td align="right"><span class="badge bg-default"><?php echo $passintcount; ?></span></td>
              </tr>
              <tr>
                <td></td>
                <td style="padding-left:30px;">Fail</td>

                <td align="right"><span class="badge bg-default"><?php echo $failintcount; ?></span></td>
              </tr>

              <tr>
                <td>3.</td>
                <td>User Interview</td>

                <td align="right"><span class="badge bg-light-blue"><?php echo $uinterviewapp; ?></span></td>
              </tr>
              <tr>
                <td></td>
                <td style="padding-left:30px;">On User Interview</td>

                <td align="right"><span class="badge bg-default"><?php echo $onuinterviewcount; ?></span></td>
              </tr>
              <tr>
                <td></td>
                <td style="padding-left:30px;">Pass</td>

                <td align="right"><span class="badge bg-default"><?php echo $passuinterviewcount; ?></span></td>
              </tr>
              <tr>
                <td></td>
                <td style="padding-left:30px;">Fail</td>

                <td align="right"><span class="badge bg-default"><?php echo $failuinterviewcount; ?></span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-lg-2 col-xs-12">
    </div>
  </div>