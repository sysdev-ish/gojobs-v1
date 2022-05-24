<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use app\models\Transrincian;

/* @var $this yii\web\View */
/* @var $model app\models\Chagerequestdata */
/* @var $form yii\widgets\ActiveForm */
Modal::begin([
    'header'=>'<h4 class="modal-title">Update Data</h4>',
    'id'=>'crformupdatebank-modal',
    'size'=>'modal-lg'
]);

echo "<div id='crformupdatebank'></div>";


Modal::end();
$datakaryawan = empty($model->perner) ? '' : $model->perner;
?>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
<div class="col-md-4">
<div class="chagerequestdata-form box box-default">

    <div class="box-body table-responsive">


        <?php
        echo   $form->field($model, 'perner')->widget(Select2::classname(), [
          // 'data' => $datakaryawan,
          'initValueText' => $datakaryawan, // set the initial display text
          'options' => ['placeholder' => '- select -', 'id'=>'perner',
                        'onChange'=>"getdataforchangereq();",
                      ],
          'pluginOptions' => [
              'allowClear' => true,
              'initialize' => true,
              'minimumInputLength' => 6,
              'language' => [
                  'errorLoading' => new \yii\web\JsExpression("function () { return 'Waiting for results...'; }"),
              ],
              'ajax' => [
                  'url' => \yii\helpers\Url::to(['chagerequestdatabank/getdatakaryawan']),
                  'dataType' => 'json',
                  'data' => new \yii\web\JsExpression('function(params) { return {q:params.term}; }'),


              ],
              'escapeMarkup' => new \yii\web\JsExpression('function (markup) { return markup; }'),
              'templateResult' => new \yii\web\JsExpression('function(a) {
                if(a.id == "" || a.id == null){return "No Data";}else{return a.id+" - "+  a.CNAME};
              }'),
              // 'templateSelection' => new \yii\web\JsExpression('function (a) { return a.nojo + " | " + a.name_job_function + " | " + a.city_name; }'),
              'templateSelection' => new \yii\web\JsExpression('function (a) {
                // alert(a);
                if(a.id == "" || a.id == null){return "No Data";}else{return a.id};
              }'),
              ],
        ])->label('Perner / Name');
        ?>
        <?= $form->field($model, 'approvedby')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'approvedby2')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'approvedbyname')->textInput(['disabled' => true])->label('Approval 1') ?>
        <?= $form->field($model, 'approvedby2name')->textInput(['disabled' => true])->label('Approval 2') ?>



    </div>
    </div>


</div>
<div class="col-md-8">

  <div class="box box-solid">
              <div class="box-header with-border">
                <i class="fa fa-file-text"></i>

                <h3 class="box-title">Personal Information</h3>
              </div>

            <div class="box-body no-padding table-responsive">
              <table class="table no-border">
                <tbody>
                  <tr>
                    <td width="12%" style="text-align:right;"><b>Perner</b></td>
                    <td width="30%" id="pernerdisp">-</td>
                  </tr>
                  <tr>
                    <td width="12%" style="text-align:right;"><b>Name</b></td>
                    <td width="30%" id="name">-</td>
                  </tr>
                  <tr>
                    <td width="12%" style="text-align:right;"><b>Personal Area</b></td>
                    <td width="30%" id="persa">-</td>
                  </tr>
                  <tr>
                    <td width="12%" style="text-align:right;"><b>Area</b></td>
                    <td width="30%" id="area">-</td>
                  </tr>
                  <tr>
                    <td width="12%" style="text-align:right;"><b>Skill Layanan</b></td>
                    <td width="30%" id="skilllayanan">-</td>
                  </tr>
                  <tr>
                    <td width="12%" style="text-align:right;"><b>Payroll Area</b></td>
                    <td width="30%" id="payrollarea">-</td>
                  </tr>
                  <tr>
                    <td width="12%" style="text-align:right;"><b>Jabatan</b></td>
                    <td width="30%" id="jabatan">-</td>
                  </tr>
                  <tr>
                    <td width="12%" style="text-align:right;"><b>level</b></td>
                    <td width="30%" id="level">-</td>
                  </tr>
                  <tr>
                    <td width="12%" style="text-align:right;"><b>Status</b></td>
                    <td width="30%" id="status">-</td>
                  </tr>
                  <tr>
                    <td width="12%" style="text-align:right;"><b>Resign reason</b></td>
                    <td width="30%" id="resignreason">-</td>
                  </tr>
                  <tr>
                    <td width="12%" style="text-align:right;"><b>Resign Date</b></td>
                    <td width="30%" id="resigndate">-</td>
                  </tr>
                  <tr>
                    <td width="12%" style="text-align:right;"><b>Hiring From</b></td>
                    <td width="30%" id="hire">-</td>
                  </tr>

              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>
  <div class="box box-solid">
              <div class="box-header with-border">
                <i class="fa fa-file-text"></i>

                <h3 class="box-title">Bank Account Information</h3>
              </div>

            <div class="box-body no-padding table-responsive">
              <table class="table no-border">
                <tbody>
                <tr>
                  <td width="20%" style="text-align:right;"><b>Bank Account</b></td>
                  <td width="30%" id="bankaccount">-</td>
                  <td rowspan="2" style="vertical-align: middle !important;font-size:16pt;" id="bankaccounticon"></td>
                  <td width="30%" class="text-red" id="bankaccountnewval"></td>
                  <td rowspan="2" style="vertical-align: middle !important;" width="10%" id="actionbankaccount" style="display:none;">
                  <?php
                  echo  Html::button('<i class="fa fa-pencil" style="font-size:12pt;"></i>',[
                        'value'=>Yii::$app->urlManager->createUrl('crdtransaction/create?crdid='.$model->id.'&param=4'), //<---- here is where you define the action that handles the ajax request
                        'class'=>'btn btn-sm btn-info updatebankacc-modal-click',
                        'data-toggle'=>'tooltip',
                        'data-placement'=>'bottom',
                        'title'=>'Update'
                    ]);?>
                  </td>
                </tr>
                <tr>
                  <td width="30%" style="text-align:right;"><b>Account number</b></td>
                  <td width="25%" id="bankaccountnumber">-</td>
                  <td width="30%" class="text-red" id="bankaccountnumbernewval"></td>
                  <td></td>
                </tr>


              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>


</div>
<div class="col-md-12">
<div class="box box-solid">
<div class="box-footer">
    <?= Html::a('Save to draft', ['index'], ['class' => 'btn btn-danger btn-flat pull-right', 'style'=>'margin-left:10px;']) ?>

    <?= Html::submitButton('Submit', ['class' => 'btn btn-success btn-flat pull-right']) ?>
</div>
</div>
</div>
</div>
<?php ActiveForm::end(); ?>

<script>
document.addEventListener("DOMContentLoaded", function(){
    getdataforchangereq();
});
function autosaveapproval() {
  var approvedbyid = $('#approvedby').val();

  $.ajax({
    type: 'POST',
    cache: false,
    data : {
      approvedby : approvedbyid,
      id : <?php echo $model->id; ?>,
    },
    url: '<?php echo Yii::$app->urlManager->createUrl(['chagerequestdatabank/autosave']) ?>',
    success: function (data, textStatus, jqXHR) {
    }
    });
}
function getdataforchangereq() {
  var perner = $('#perner').val();
  $.ajax({
    type: 'POST',
    cache: false,
    data : {
      perner : perner,
      id : <?php echo $model->id; ?>,
    },
    url: '<?php echo Yii::$app->urlManager->createUrl(['chagerequestdatabank/getuserabout']) ?>',
    success: function (data, textStatus, jqXHR) {
      togleAction(perner);
      var obj = JSON.parse(data);
      var pernerres = '';
      var name = '';
      var persa = '';
      var area = '';
      var skilllayanan = '';
      var payrollarea = '';
      var jabatan = '';
      var level = '';
      var status = '';
      var resignreason = '';
      var resigndate = '';
      var hire = '';
      var bankaccount = '';
      var bankaccountnumber = '';

      var bankaccountfile = '';

      var bankaccountnewval = '';
      var bankaccountnumbernewval = '';

      var bankaccountnewdoc = '';

      var bankaccounticon = '';

      if(obj.perner){var pernerres = obj.perner;}
      if(obj.name){var name = obj.name;}
      if(obj.persa){var persa = obj.persa;}
      if(obj.area){var area = obj.area;}
      if(obj.skilllayanan){var skilllayanan = obj.skilllayanan;}
      if(obj.payrollarea){var payrollarea = obj.payrollarea;}
      if(obj.jabatan){var jabatan = obj.jabatan;}
      if(obj.level){var level = obj.level;}
      if(obj.resignreason){var resignreason = obj.resignreason;}
      if(obj.resigndate){var resigndate = obj.resigndate;}
      if(obj.status){var status = obj.status;}
      if(obj.hire){var hire = obj.hire;}
      if(obj.bankaccount){var bankaccount = obj.bankaccount;}
      if(obj.bankaccountnumber){var bankaccountnumber = obj.bankaccountnumber;}


      if(obj.bankaccountfile){
        var bankaccountfile = '<br><a class="btn btn-sm btn-default text-muted" href="/rekrut/app/assets/upload/bankaccount/'+obj.bankaccountfile+'" target="_blank"><i class="fa fa-download"></i> '+obj.bankaccountfile+'</a>';
      }



      if(obj.bankaccountnewval){
        var bankaccountnewval = obj.bankaccountnewval;
        var bankaccountnumbernewval = obj.bankaccountnumbernewval;
        var bankaccounticon = '<span class="fa fa-retweet"></span>';
      }

      if(obj.bankaccountnewdoc){
        var bankaccountnewdoc = '<br><a class="btn btn-sm btn-default text-muted" href="/rekrut/app/assets/upload/bankaccount/'+obj.bankaccountnewdoc+'?='+ <?php echo rand(1,32000); ?> +'"  target="_blank"><i class="fa fa-download"></i> '+obj.bankaccountnewdoc+'</a>';
      }
      document.getElementById('pernerdisp').innerHTML  = pernerres;
      document.getElementById('name').innerHTML  = name;
      document.getElementById('persa').innerHTML  = persa;
      document.getElementById('area').innerHTML  = area;
      document.getElementById('skilllayanan').innerHTML  = skilllayanan;
      document.getElementById('payrollarea').innerHTML  = payrollarea;
      document.getElementById('jabatan').innerHTML  = jabatan;
      document.getElementById('level').innerHTML  = level;
      document.getElementById('status').innerHTML  = status;
      document.getElementById('resignreason').innerHTML  = resignreason;
      document.getElementById('resigndate').innerHTML  = resigndate;
      document.getElementById('hire').innerHTML  = hire;
      document.getElementById('bankaccount').innerHTML  = bankaccount;
      document.getElementById('bankaccountnumber').innerHTML  =  bankaccountnumber + bankaccountfile;

      document.getElementById('bankaccountnewval').innerHTML  = bankaccountnewval;
      document.getElementById('bankaccountnumbernewval').innerHTML  =  bankaccountnumbernewval  + bankaccountnewdoc;

      document.getElementById('bankaccounticon').innerHTML  = bankaccounticon;



    },
  });
}

function togleAction(perner) {
  var x = document.getElementById('actionbankaccount');
  if (perner) {
    x.style.display = '';
  } else {
    x.style.display = 'none';
  }
}
</script>
