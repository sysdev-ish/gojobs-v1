<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use linslin\yii2\curl;
use app\models\Hiring;
use app\models\Transrincian;

/* @var $this yii\web\View */
/* @var $model app\models\Chagerequestdata */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Chagerequestdatas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

function fetchSAPData($perner, $token = 'ish**2019')
{
  $curl = new curl\Curl();
  $response = $curl->setPostParams(['perner' => $perner, 'token' => $token])
    ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerjaall');
  return json_decode($response);
}

function fetchHiringAndJob($data)
{
  $cekhiring = Hiring::find()->where(['userid' => $data->userid, 'perner' => $data->perner, 'statushiring' => 4])->one();
  if ($cekhiring) {
    return Transrincian::findOne(['id' => $cekhiring->recruitreqid]);
  }
  return null;
}

?>
<div class="chagerequestdata-view">
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
              'value' => $model->perner ?: '',
            ],
            [
              'label' => 'Personal Area',
              'format' => 'html',
              'value' => function ($data) {
                $job = fetchHiringAndJob($data);
                if ($job) {
                  return Yii::$app->utils->getpersonalarea($job->persa_sap) ?: "Check Perner not Active";
                }
                $sapData = fetchSAPData($data->perner);
                return $sapData ? $sapData[0]->WKTXT : '';
              }
            ],
            [
              'label' => 'Area',
              'format' => 'html',
              'value' => function ($data) {
                $job = fetchHiringAndJob($data);
                if ($job) {
                  return Yii::$app->utils->getarea($job->area_sap) ?: "Check Perner not Active";
                }
                $sapData = fetchSAPData($data->perner);
                return $sapData ? $sapData[0]->BTRTX : '';
              }
            ],
            [
              'label' => 'Skill Layanan',
              'format' => 'html',
              'value' => function ($data) {
                $job = fetchHiringAndJob($data);
                if ($job) {
                  return Yii::$app->utils->getskilllayanan($job->skill_sap) ?: "Check Perner not Active";
                }
                $sapData = fetchSAPData($data->perner);
                return $sapData ? $sapData[0]->PEKTX : '';
              }
            ],
            [
              'label' => 'Payroll Area',
              'format' => 'html',
              'value' => function ($data) {
                $job = fetchHiringAndJob($data);
                if ($job) {
                  return Yii::$app->utils->getpayrollarea($job->abkrs_sap) ?: "Check Perner not Active";
                }
                $sapData = fetchSAPData($data->perner);
                return $sapData ? $sapData[0]->ABTXT : '';
              }
            ],
            [
              'label' => 'Jabatan',
              'format' => 'html',
              'value' => function ($data) {
                $job = fetchHiringAndJob($data);
                if ($job) {
                  return Yii::$app->utils->getjabatan($job->hire_jabatan_sap) ?: "Check Perner not Active";
                }
                $sapData = fetchSAPData($data->perner);
                return $sapData ? $sapData[0]->PLATX : '';
              }
            ],
            [
              'label' => 'Level',
              'format' => 'html',
              'value' => function ($data) {
                $job = fetchHiringAndJob($data);
                if ($job) {
                  $curl = new curl\Curl();
                  $response = $curl->setPostParams(['level' => $job->level_sap, 'token' => 'ish**2019'])
                    ->post('http://192.168.88.5/service/index.php/sap_profile/getlevel');
                  return json_decode($response) ?: '';
                }
                $sapData = fetchSAPData($data->perner);
                return $sapData ? $sapData[0]->TRFAR_TXT : '';
              }
            ],
            [
              'label' => 'Status',
              'format' => 'html',
              'value' => function ($data) {
                if (in_array($data->status, [2, 3, 7])) {
                  $sapData = fetchSAPData($data->perner);
                  $status = "Active";
                  if ($sapData) {
                    // $status = $sapData[0]->MASSN == "Z8" ? "Resi"
                    $status = $sapData && $sapData[0]->MASSN == "Z8" ? "Resign, Silakan Reject Pengajuan Perubahan Data Bank" : "Active";
                  } else {
                    $status = "Cancel Join";
                  }
                } else {
                  $status = $data->statusresign == 1 ? "Active" : "Resign";
                }
                return $status;
              }
            ],
            [
              'label' => 'Resign Reason',
              'format' => 'html',
              'value' => function ($data) {
                if (in_array($data->status, [2, 3, 7])) {
                  $sapData = fetchSAPData($data->perner);
                  return $sapData && $sapData[0]->MASSN == "Z8" ? $sapData[0]->MSGTX : "-";
                }
                return $data->resignreason;
              }
            ],
            [
              'label' => 'Resign Date',
              'format' => 'html',
              'value' => function ($data) {
                if (in_array($data->status, [2, 3, 7])) {
                  $sapData = fetchSAPData($data->perner);
                  if ($sapData && $sapData[0]->MASSN == "Z8") {
                    return $sapData[0]->DAT35 ? substr($sapData[0]->DAT35, 0, 4) . "-" . substr($sapData[0]->DAT35, 4, 2) . "-" . substr($sapData[0]->DAT35, 6, 2) : "-";
                  }
                }
                return $data->resigndate;
              }
            ],
            'createtime',
            'updatetime',
            'approvedtime',
            [
              'label' => 'Created By',
              'format' => 'html',
              'value' => $model->createduser->name ?: '',
            ],
            [
              'label' => 'Updated By',
              'format' => 'html',
              'value' => $model->updateduser->name ?: '',
            ],
            [
              'label' => 'Approved By',
              'format' => 'html',
              'value' => $model->approveduser->name ?: '',
            ],
          ],
        ]) ?>
      </div>
    </div>

    <div class="col-md-7">
      <div class="box-body table-responsive">
        <table class="table no-border">
          <tbody>
            <tr>
              <td width="20%" style="text-align:right;"><b>Bank Account</b></td>
              <td width="30%"><?= $bankaccountoldval ?: $bankaccount ?></td>
              <td rowspan="2" style="vertical-align: middle !important;font-size:14pt;"><span class="fa fa-retweet"></span></td>
              <td width="30%" class="text-red"><?= $bankaccountnewval ?></td>
            </tr>
            <tr>
              <td width="20%" style="text-align:right;"><b>Account Number</b></td>
              <td><?= $bankaccountnumberoldval ?: $bankaccountnumber ?><br>
                <?= ($bankaccountolddoc) ? Html::a('<i class="fa fa-download"></i> ' . $bankaccountolddoc, ['/app/assets/upload/bankaccount/' . $bankaccountolddoc], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted']) : '-' ?>
              </td>
              <td width="30%" class="text-red">
                <?= $bankaccountnumbernewval ?><br>
                <?= ($bankaccountnewdoc) ? Html::a('<i class="fa fa-download"></i> ' . $bankaccountnewdoc, ['/app/assets/upload/bankaccount/' . $bankaccountnewdoc], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted']) : '-' ?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <?php $form = ActiveForm::begin(); ?>
      <?php
      $sapData = fetchSAPData($model->perner);
      if ($sapData && $sapData[0]->MASSN == "Z8") {
        $statusOptions = [5 => 'Reject', 6 => 'Revise'];
      } else {
        $statusOptions = $model->status == 2 ? [3 => 'Approve', 5 => 'Reject', 6 => 'Revise'] : [4 => 'Approve', 5 => 'Reject', 6 => 'Revise'];
      }

      echo $form->field($model, 'status')->widget(Select2::classname(), [
        'data' => $statusOptions,
        'options' => ['placeholder' => '- select -', 'id' => 'status'],
        'pluginOptions' => ['allowClear' => false, 'initialize' => true],
      ])->label('Action');
      ?>

      <?= $form->field($model, 'remarks')->textArea(['maxlength' => true]) ?>
      <div class="box-footer">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success btn-flat pull-right']) ?>
      </div>
      <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>