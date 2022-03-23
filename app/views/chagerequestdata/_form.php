<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Chagerequestdata */
/* @var $form yii\widgets\ActiveForm */
Modal::begin([
    'header'=>'<h4 class="modal-title">Update Data</h4>',
    'id'=>'crformupdate-modal',
    'size'=>'modal-lg'
]);

echo "<div id='crformupdate'></div>";


Modal::end();
?>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
<div class="col-md-4">
<div class="chagerequestdata-form box box-default">

    <div class="box-body table-responsive">

        <?php

        echo   $form->field($model, 'userid')->widget(Select2::classname(), [
          'data' => $name,
          'options' => ['placeholder' => '- select -', 'id'=>'userid',
          'onChange'=>"getdataforchangereq();",
          ],
          'pluginOptions' => [
              'allowClear' => false,
              'initialize' => true,
          ],
        ])->label('Name');
        ?>

        <?php

        echo   $form->field($model, 'approvedby')->widget(Select2::classname(), [
          'data' => $approvalname,
          'options' => ['placeholder' => '- select -', 'id'=>'approvedby',
          'onChange'=>"autosaveapproval();",
          ],
          'pluginOptions' => [
              'allowClear' => false,
              'initialize' => true,
          ],
        ])->label('Approve By');
        ?>


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

                <h3 class="box-title">Document Information</h3>
                <?= $form->field($model, 'personaldatafill')->hiddenInput()->label(false) ?>
              </div>
              <!-- /.box-header -->
              <!-- <div class="box-body">
                <dl class="dl-horizontal">
                  <dt>No NPWP</dt>
                  <dd id="npwp">-</dd>
                  <dt>No BPJS Kesehatan</dt>
                  <dd id="bpjskes">-</dd>
                  <dt>No BPJS Tenaga Kerja</dt>
                  <dd id="bpjstk">-</dd>
                </dl>

              </div> -->
              <!-- /.box-body -->


            <!-- /.box-header -->
            <div class="box-body no-padding table-responsive">

              <table class="table table-striped">
                <tbody>
                <tr>
                  <td width="30%" style="text-align:right;"><b>No NPWP</b></td>
                  <td width="25%" id="npwp">-</td>
                  <td style="font-size:16pt;" id="npwpicon"></td>
                  <td width="25%" class="text-red" id="npwpnewval"></td>
                  <td width="10%" id="actionnpwp" style="display:none;">
                  <?php
                  echo  Html::button('<i class="fa fa-pencil" style="font-size:12pt;"></i>',[
                        'value'=>Yii::$app->urlManager->createUrl('crdtransaction/create?crdid='.$model->id.'&param=1&perner='), //<---- here is where you define the action that handles the ajax request
                        'class'=>'btn btn-sm btn-info updatenpwp-modal-click',
                        'data-toggle'=>'tooltip',
                        'data-placement'=>'bottom',
                        'title'=>'Update'
                    ]);?>
                  </td>
                </tr>
                <tr>
                  <td style="text-align:right;"><b>No BPJS Kesehatan</b></td>
                  <td id="bpjskes">-</td>
                  <td style="font-size:16pt;" id="bpjskesicon"></td>
                  <td class="text-red" id="bpjskesnewval"></td>
                  <td id="actionbpjs" style="display:none;">
                    <?php echo  Html::button('<i class="fa fa-pencil" style="font-size:12pt;"></i>',[
                          'value'=>Yii::$app->urlManager->createUrl('crdtransaction/create?crdid='.$model->id.'&param=2&perner='), //<---- here is where you define the action that handles the ajax request
                          'class'=>'btn btn-sm btn-info updatenpwp-modal-click',
                          'data-toggle'=>'tooltip',
                          'data-placement'=>'bottom',
                          'title'=>'Update'
                      ]);?>
                  </td>
                </tr>
                <tr>
                  <td style="text-align:right;"><b>No BPJS Tenaga Kerja</b></td>
                  <td id="bpjstk">-</td>
                  <td style="font-size:16pt;" id="bpjstkicon"></td>
                  <td class="text-red" id="bpjstknewval"></td>
                  <td id="actionjamsostek" style="display:none;">
                    <?php echo  Html::button('<i class="fa fa-pencil" style="font-size:12pt;"></i>',[
                          'value'=>Yii::$app->urlManager->createUrl('crdtransaction/create?crdid='.$model->id.'&param=3&perner='), //<---- here is where you define the action that handles the ajax request
                          'class'=>'btn btn-sm btn-info updatenpwp-modal-click',
                          'data-toggle'=>'tooltip',
                          'data-placement'=>'bottom',
                          'title'=>'Update'
                      ]);?>
                  </td>
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
    url: '<?php echo Yii::$app->urlManager->createUrl(['chagerequestdata/autosave']) ?>',
    success: function (data, textStatus, jqXHR) {
    }
    });
}
function getdataforchangereq() {
  var useridselect = $('#userid').val();
  $.ajax({
    type: 'POST',
    cache: false,
    data : {
      userid : useridselect,
      id : <?php echo $model->id; ?>,
    },
    url: '<?php echo Yii::$app->urlManager->createUrl(['chagerequestdata/getuserprofile']) ?>',
    success: function (data, textStatus, jqXHR) {
      togleAction(useridselect);
      var obj = JSON.parse(data);
      var pernerres = '';
      var name = '';
      var persa = '';
      var area = '';
      var skilllayanan = '';
      var payrollarea = '';
      var jabatan = '';
      var level = '';
      var hire = '';
      var npwpnumber = '';
      var bpjsnumber = '';
      var jamsosteknumber = '';

      var npwpfilelink = '';
      var bpjsfilelink = '';
      var jamsostekfilelink = '';

      var npwpnumbernewval = '';
      var bpjsnumbernewval = '';
      var jamsosteknumbernewval = '';

      var npwpfilenewdoclink = '';
      var bpjsfilenewdoclink = '';
      var jamsostekfilenewdoclink = '';

      var npwpnumbericon = '';
      var bpjsnumbericon = '';
      var jamsosteknumbericon = '';

      if(obj.perner){var pernerres = obj.perner;}
      if(obj.name){var name = obj.name;}
      if(obj.persa){var persa = obj.persa;}
      if(obj.area){var area = obj.area;}
      if(obj.skilllayanan){var skilllayanan = obj.skilllayanan;}
      if(obj.payrollarea){var payrollarea = obj.payrollarea;}
      if(obj.jabatan){var jabatan = obj.jabatan;}
      if(obj.level){var level = obj.level;}
      if(obj.hire){var hire = obj.hire;}
      if(obj.npwpnumber){var npwpnumber = obj.npwpnumber;}
      if(obj.bpjsnumber){var bpjsnumber = obj.bpjsnumber;}
      if(obj.jamsosteknumber){var jamsosteknumber = obj.jamsosteknumber;}


      if(obj.npwpfile){
        var npwpfilelink = '<br><a class="btn btn-sm btn-default text-muted" href="/rekrut/app/assets/upload/npwp/'+obj.npwpfile+'" target="_blank"><i class="fa fa-download"></i> '+obj.npwpfile+'</a>';
      }
      if(obj.bpjsfile){
        var bpjsfilelink = '<br><a class="btn btn-sm btn-default text-muted" href="/rekrut/app/assets/upload/bpjskesehatan/'+obj.bpjsfile+'" target="_blank"><i class="fa fa-download"></i> '+obj.bpjsfile+'</a>';
      }
      if(obj.jamsostekfile){
        var jamsostekfilelink = '<br><a class="btn btn-sm btn-default text-muted" href="/rekrut/app/assets/upload/jamsostek/'+obj.jamsostekfile+'" target="_blank"><i class="fa fa-download"></i> '+obj.jamsostekfile+'</a>';
      }


      if(obj.npwpnumbernewval){
        var npwpnumbernewval = obj.npwpnumbernewval;
        var npwpnumbericon = '<span class="fa fa-retweet"></span>';
      }
      if(obj.bpjsnumbernewval){
        var bpjsnumbernewval = obj.bpjsnumbernewval;
        var bpjsnumbericon = '<span class="fa fa-retweet"></span>';
      }
      if(obj.jamsosteknumbernewval){
        var jamsosteknumbernewval = obj.jamsosteknumbernewval;
        var jamsosteknumbericon = '<span class="fa fa-retweet"></span>';
      }

      if(obj.npwpfilenewdoc){
        var npwpfilenewdoclink = '<br><a class="btn btn-sm btn-default text-muted" href="/rekrut/app/assets/upload/npwp/'+obj.npwpfilenewdoc+'?='+ <?php echo rand(1,32000); ?> +'"  target="_blank"><i class="fa fa-download"></i> '+obj.npwpfilenewdoc+'</a>';
      }
      if(obj.bpjsfilenewdoc){
        var bpjsfilenewdoclink = '<br><a class="btn btn-sm btn-default text-muted" href="/rekrut/app/assets/upload/bpjskesehatan/'+obj.bpjsfilenewdoc+'?='+ <?php echo rand(1,32000); ?> +'" target="_blank"><i class="fa fa-download"></i> '+obj.bpjsfilenewdoc+'</a>';
      }
      if(obj.jamsostekfilenewdoc){
        var jamsostekfilenewdoclink = '<br><a class="btn btn-sm btn-default text-muted" href="/rekrut/app/assets/upload/jamsostek/'+obj.jamsostekfilenewdoc+'?='+ <?php echo rand(1,32000); ?> +'" target="_blank"><i class="fa fa-download"></i> '+obj.jamsostekfilenewdoc+'</a>';
      }
      document.getElementById('pernerdisp').innerHTML  = pernerres;
      document.getElementById('name').innerHTML  = name;
      document.getElementById('persa').innerHTML  = persa;
      document.getElementById('area').innerHTML  = area;
      document.getElementById('skilllayanan').innerHTML  = skilllayanan;
      document.getElementById('payrollarea').innerHTML  = payrollarea;
      document.getElementById('jabatan').innerHTML  = jabatan;
      document.getElementById('level').innerHTML  = level;
      document.getElementById('hire').innerHTML  = hire;
      document.getElementById('npwp').innerHTML  = npwpnumber + npwpfilelink;
      document.getElementById('bpjskes').innerHTML  = bpjsnumber + bpjsfilelink;
      document.getElementById('bpjstk').innerHTML  = jamsosteknumber + jamsostekfilelink;

      document.getElementById('npwpnewval').innerHTML  = npwpnumbernewval + npwpfilenewdoclink;
      document.getElementById('bpjskesnewval').innerHTML  = bpjsnumbernewval + bpjsfilenewdoclink;
      document.getElementById('bpjstknewval').innerHTML  = jamsosteknumbernewval + jamsostekfilenewdoclink;

      document.getElementById('npwpicon').innerHTML  = npwpnumbericon;
      document.getElementById('bpjskesicon').innerHTML  = bpjsnumbericon;
      document.getElementById('bpjstkicon').innerHTML  = jamsosteknumbericon;



    },
  });
}

function togleAction(useridselect) {
  // alert (useridselect);
  var x = document.getElementById('actionnpwp');
  var y = document.getElementById('actionbpjs');
  var z = document.getElementById('actionjamsostek');
  if (useridselect) {
    x.style.display = '';
    y.style.display = '';
    z.style.display = '';
  } else {
    x.style.display = 'none';
    y.style.display = 'none';
    z.style.display = 'none';
  }
}
</script>
