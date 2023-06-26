<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Chagerequestresign */
/* @var $form yii\widgets\ActiveForm */

$datakaryawan = empty($model->perner) ? '' : $model->perner;
$model->resigndate = ($model->resigndate == "0000-00-00") ? null : $model->resigndate;
?>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
  <div class="col-md-4">
    <div class="chagerequestdata-form box box-default">
      <div class="box-body table-responsive">
        <?= $form->field($model, 'perner')->widget(Select2::classname(), [
          // 'data' => $datakaryawan,
          'initValueText' => $datakaryawan, // set the initial display text
          'options' => [
            'placeholder' => '- select -', 'id' => 'perner',
            'onChange' => "getdataforchangereq();",
          ],
          'pluginOptions' => [
            'allowClear' => true,
            'initialize' => true,
            'minimumInputLength' => 3,
            'language' => [
              'errorLoading' => new \yii\web\JsExpression("function () { return 'Waiting for results...'; }"),
            ],
            'ajax' => [
              'url' => \yii\helpers\Url::to(['chagerequestresign/getdatakaryawan']),
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
        <?= $form->field($model, 'checkperner')->hiddenInput(['id' => 'checkperner'])->label(false) ?>
        <?= $form->field($model, 'approvedby')->widget(Select2::classname(), [
          'data' => $approvalname,
          'options' => [
            'placeholder' => '- select -', 'id' => 'approvedby',
            'onChange' => "autosave();",
          ],
          'pluginOptions' => [
            'allowClear' => false,
            'initialize' => true,
          ],
        ])->label('Approve By');
        ?>
        <?= $form->field($model, 'resigndate')->widget(
          DatePicker::className(),
          [
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'options' => ['placeholder' => 'Date', 'id' => 'resigndate'],
            'pluginOptions' => [
              'autoclose' => true,
              'format' => 'yyyy-mm-dd',
              'todayHighlight' => true
            ]
          ]
        );
        ?>
        <?= $form->field($model, 'reason')->widget(Select2::classname(), [
          'data' => $reason,
          'options' => [
            'placeholder' => '- select -', 'id' => 'reason',
            // 'onChange' => "autosave();",
          ],
          'pluginOptions' => [
            'autoClose' => true,
            'allowClear' => true,
            'initialize' => true,
          ],
        ])->label('Reason');
        ?>
        <?= $form->field($model, 'userremarks')->textArea(['id' => 'userremarks', 'onChange' => "autosave();"])->label('Remarks');
        ?>
      </div>
    </div>
  </div>
  <div class="col-md-8">

    <div class="box box-default">
      <div class="box-header with-border">
        <i class="fa fa-file-text"></i>
        <h3 class="box-title">Personal Information</h3>
      </div>

      <div class="box-body table-responsive">
        <table class="table no-border">
          <tbody>
            <tr>
              <td width="12%"><b>Perner</b></td>
              <td width="30%" id="pernerdisp">-</td>
            </tr>
            <tr>
              <td width="12%"><b>Name</b></td>
              <td width="30%" id="name">-</td>
            </tr>
            <tr>
              <td width="12%"><b>Personal Area</b></td>
              <td width="30%" id="persa">-</td>
            </tr>
            <tr>
              <td width="12%"><b>Area</b></td>
              <td width="30%" id="area">-</td>
            </tr>
            <tr>
              <td width="12%"><b>Skill Layanan</b></td>
              <td width="30%" id="skilllayanan">-</td>
            </tr>
            <tr>
              <td width="12%"><b>Payroll Area</b></td>
              <td width="30%" id="payrollarea">-</td>
            </tr>
            <tr>
              <td width="12%"><b>Jabatan</b></td>
              <td width="30%" id="jabatan">-</td>
            </tr>
            <tr>
              <td width="12%"><b>level</b></td>
              <td width="30%" id="level">-</td>
            </tr>
            <tr>
              <td width="12%"><b>Hiring From</b></td>
              <td width="30%" id="hire">-</td>
            </tr>
            <tr>
              <td width="12%"><b>Reason Resign</b></td>
              <td width="30%" id="resign_reason">-</td>
            </tr>
            <tr>
              <td width="12%"><b>Tanggal Resign</b></td>
              <td width="30%" id="resign_date">-</td>
            </tr>
            <tr>
              <td width="12%"><b>Status Perner</b></td>
              <td width="30%" id="status">-</td>
            </tr>

          </tbody>
        </table>
      </div>
      <div class="box-footer">
        <?= Html::a('Save to draft', ['index'], ['class' => 'btn btn-danger btn-flat pull-right', 'style' => 'margin-left:10px;']) ?>

        <?= Html::submitButton('Submit', ['class' => 'btn btn-success btn-flat pull-right']) ?>
      </div>
    </div>
  </div>
</div>
<?php ActiveForm::end(); ?>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    getdataforchangereq();
  });

  function autosave() {
    var approvedbyid = $('#approvedby').val();
    // var resigndateid = $('#resigndate').val();
    var reasonid = $('#reason').val();
    var userremarksval = $('#userremarks').val();

    $.ajax({
      type: 'POST',
      cache: false,
      data: {
        approvedby: approvedbyid,
        // resigndate: resigndateid,
        // reason: reasonid,
        userremarks: userremarksval,
        id: <?php echo $model->id; ?>,
      },
      url: '<?php echo Yii::$app->urlManager->createUrl(['chagerequestresign/autosave']) ?>',
      success: function(data, textStatus, jqXHR) {}
    });
  }

  function getdataforchangereq() {
    var perner = $('#perner').val();
    $.ajax({
      type: 'POST',
      cache: false,
      data: {
        perner: perner,
        id: <?php echo $model->id; ?>,
      },
      url: '<?php echo Yii::$app->urlManager->createUrl(['chagerequestresign/getuserabout']) ?>',
      success: function(data, textStatus, jqXHR) {
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
        var status = '';
        var resign_reason = '';
        var resign_date = '';
        var checkperner = '';


        if (obj.perner) {
          var pernerres = obj.perner;
        }
        if (obj.name) {
          var name = obj.name;
        }
        if (obj.persa) {
          var persa = obj.persa;
        }
        if (obj.area) {
          var area = obj.area;
        }
        if (obj.skilllayanan) {
          var skilllayanan = obj.skilllayanan;
        }
        if (obj.payrollarea) {
          var payrollarea = obj.payrollarea;
        }
        if (obj.jabatan) {
          var jabatan = obj.jabatan;
        }
        if (obj.level) {
          var level = obj.level;
        }
        if (obj.hire) {
          var hire = obj.hire;
        }
        if (obj.status) {
          var status = obj.status;
        }
        if (obj.resign_date) {
          var resign_date = obj.resign_date;
        }
        if (obj.resign_reason) {
          var resign_reason = obj.resign_reason;
        }
        if (obj.checkperner) {
          var checkperner = obj.checkperner;
        }
        document.getElementById('pernerdisp').innerHTML = pernerres;
        document.getElementById('name').innerHTML = name;
        document.getElementById('persa').innerHTML = persa;
        document.getElementById('area').innerHTML = area;
        document.getElementById('skilllayanan').innerHTML = skilllayanan;
        document.getElementById('payrollarea').innerHTML = payrollarea;
        document.getElementById('jabatan').innerHTML = jabatan;
        document.getElementById('level').innerHTML = level;
        document.getElementById('hire').innerHTML = hire;
        document.getElementById('status').innerHTML = status;
        document.getElementById('resign_reason').innerHTML = resign_reason;
        document.getElementById('resign_date').innerHTML = resign_date;
        $("#checkperner").val(checkperner);
      },
    });
  }
</script>