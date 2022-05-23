<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Changecanceljoin */
/* @var $form yii\widgets\ActiveForm */
$datakaryawan = empty($model->perner) ? '' : $model->perner;
$model->resigndate = ($model->resigndate == "0000-00-00")? null : $model->resigndate;
?>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
<div class="col-md-4">
<div class="chagerequestdata-form box box-default">

    <div class="box-body table-responsive">


        <?=  $form->field($model, 'perner')->widget(Select2::classname(), [
          // 'data' => $datakaryawan,
          'initValueText' => $datakaryawan, // set the initial display text
          'options' => ['placeholder' => '- select -', 'id'=>'perner',
                        'onChange'=>"getdataforchangereq();",
                      ],
          'pluginOptions' => [
              'allowClear' => true,
              'initialize' => true,
              'minimumInputLength' => 3,
              'language' => [
                  'errorLoading' => new \yii\web\JsExpression("function () { return 'Waiting for results...'; }"),
              ],
              'ajax' => [
                  'url' => \yii\helpers\Url::to(['changecanceljoin/getdatakaryawan']),
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
        <?= $form->field($model, 'checkperner')->hiddenInput(['id'=>'checkperner'])->label(false) ?>
        <?= $form->field($model, 'approvedby')->widget(Select2::classname(), [
          'data' => $approvalname,
          'options' => ['placeholder' => '- select -', 'id'=>'approvedby',
          'onChange'=>"autosave();",
          ],
          'pluginOptions' => [
              'allowClear' => false,
              'initialize' => true,
          ],
        ])->label('Approve By');
        ?>
        <?= $form->field($model, 'resigndate')->widget(
          DatePicker::className(), [
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'options' => ['placeholder' => 'Date', 'id'=>'resigndate', 'onChange'=>"autosave();"],
            'pluginOptions' => [
              'autoclose' => true,
              'format' => 'yyyy-mm-dd',
              'todayHighlight' => true
            ]
          ]);
          ?>
          <?= $form->field($model, 'reason')->widget(Select2::classname(), [
            'data' => $reason,
            'options' => ['placeholder' => '- select -', 'id'=>'reason',
            'onChange'=>"autosave();",
            ],
            'pluginOptions' => [
                'allowClear' => false,
                'initialize' => true,
            ],
          ])->label('Reason');
          ?>
          <?= $form->field($model, 'userremarks')->textArea(['id'=>'userremarks','onChange'=>"autosave();"])->label('Remarks');
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
function autosave() {
  var approvedbyid = $('#approvedby').val();
  var resigndateid = $('#resigndate').val();
  var reasonid = $('#reason').val();
  var userremarksval = $('#userremarks').val();

  $.ajax({
    type: 'POST',
    cache: false,
    data : {
      approvedby : approvedbyid,
      resigndate : resigndateid,
      reason : reasonid,
      userremarks : userremarksval,
      id : <?php echo $model->id; ?>,
    },
    url: '<?php echo Yii::$app->urlManager->createUrl(['changecanceljoin/autosave']) ?>',
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
    url: '<?php echo Yii::$app->urlManager->createUrl(['changecanceljoin/getuserabout']) ?>',
    success: function (data, textStatus, jqXHR) {
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
      var checkperner = '';


      if(obj.perner){var pernerres = obj.perner;}
      if(obj.name){var name = obj.name;}
      if(obj.persa){var persa = obj.persa;}
      if(obj.area){var area = obj.area;}
      if(obj.skilllayanan){var skilllayanan = obj.skilllayanan;}
      if(obj.payrollarea){var payrollarea = obj.payrollarea;}
      if(obj.jabatan){var jabatan = obj.jabatan;}
      if(obj.level){var level = obj.level;}
      if(obj.hire){var hire = obj.hire;}
      if(obj.checkperner){var checkperner = obj.checkperner;}


      document.getElementById('pernerdisp').innerHTML  = pernerres;
      document.getElementById('name').innerHTML  = name;
      document.getElementById('persa').innerHTML  = persa;
      document.getElementById('area').innerHTML  = area;
      document.getElementById('skilllayanan').innerHTML  = skilllayanan;
      document.getElementById('payrollarea').innerHTML  = payrollarea;
      document.getElementById('jabatan').innerHTML  = jabatan;
      document.getElementById('level').innerHTML  = level;
      document.getElementById('hire').innerHTML  = hire;
      $("#checkperner").val(checkperner);



    },
  });
}
</script>
