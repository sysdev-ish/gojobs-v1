<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use linslin\yii2\curl;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Transrincian */

$this->title = 'View Workorder';
$this->params['breadcrumbs'][] = ['label' => 'Workorder', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'View';

?>
<div class="row">
  <div class="col-md-4">
    <div class="workorder-view box box-solid">

      <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
          'model' => $model,
          'template' => '<tr><th width="30%" style="text-align:right;">{label}</th><td>{value}</td></tr>',
          'options' => ['class' => 'table table-striped detail-view'],
          'attributes' => [
            'id',
            'wo_number',
            [
              'label' => 'Job Function',
              'attribute' => 'jobfunc',
              'format' => 'html',
              'value' => function ($data) {
                return ($data->job_code) ? $data->jobsap->jabatansap : $data->job;
              }
            ],

            [
              'label' => 'Project',
              'format' => 'html',
              'value' => function ($data) {
                return $data->project_name;
              }
            ],

            [
              'label' => 'Lama Project',
              'format' => 'html',
              'value' => function ($data) {

                return ($data->project_end) ? $data->project_end : "-";
              }
            ],

            [
              'label' => 'Type Contract',
              'attribute' => 'type',
              'format' => 'html',
              'value' => function ($data) {
                // return $data->type_contract;
                return ($data->type_contract) ? $data->contract->contract_name : "-";
              }
            ],
            'city.city_name',
            'total_job',
            [
              'label' => 'Status',
              'format' => 'html',
              'value' => function ($data) {

                switch ($data->status) {
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
              'label' => 'Personal Area (SAP)',
              'format' => 'html',
              'value' => function ($data) {

                return (Yii::$app->utils->getpersonalarea($data->personal_area)) ? Yii::$app->utils->getpersonalarea($data->personal_area) . '-' . $data->personal_area : "";
              }

            ],

            [
              'label' => 'Area (SAP)',
              'format' => 'html',
              'value' => function ($data) {

                return (Yii::$app->utils->getarea($data->area)) ? Yii::$app->utils->getarea($data->area) . '-' . $data->area : "";
              }

            ],

            [
              'label' => 'Skilllayanan (SAP)',
              'format' => 'html',
              'value' => function ($data) {

                return (Yii::$app->utils->getskilllayanan($data->skill_layanan)) ? Yii::$app->utils->getskilllayanan($data->skill_layanan) . '-' . $data->skill_layanan : "";
              }

            ],

            [
              'label' => 'Payroll Area (SAP)',
              'format' => 'html',
              'value' => function ($data) {
                return (Yii::$app->utils->getpayrollarea($data->payroll_area)) ? Yii::$app->utils->getpayrollarea($data->payroll_area) . '-' . $data->payroll_area : "";
              }

            ],

            [
              'label' => 'Jabatan (SAP)',
              'format' => 'html',
              'value' => function ($data) {
                return ($data->job_code) ? $data->jobsap->jabatansap . '-' . $data->job_code : "";
              }
            ],

            [
              'label' => 'Level (SAP)',
              'format' => 'html',
              'value' => function ($data) {
                $curl = new curl\Curl();
                $getlevels = $curl->setPostParams([
                  'level' => $data->level,
                  'token' => 'ish**2019',
                ])
                  ->post('http://192.168.88.5/service/index.php/sap_profile/getlevel');
                $level  = json_decode($getlevels);
                return ($level) ? $level . '-' . $data->level : "";
              }
            ],
          ],
        ]) ?>
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Job Description & Requirement</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
          <tbody>
            <tr>
              <th>Description</th>
              <th>Requirement</th>
              <th></th>
            </tr>
                <tr>
                  <td><?php echo $model->job_description; ?></td>
                  <td><?php echo $model->job_requirement; ?></td>
                </tr>
          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
  </div>

</div>