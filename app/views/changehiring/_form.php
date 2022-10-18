<?php

use app\models\Transrincian;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Changehiring */
/* @var $form yii\widgets\ActiveForm */

$url = \yii\helpers\Url::to(['transrincian/recreqlist']);
$recruitreqs = empty($model->recruitreqid) ? '' : Transrincian::findOne($model->recruitreqid)->nojo;
$model->cancelhiring = ($model->cancelhiring == "0000-00-00") ? null : $model->cancelhiring;
?>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
  <div class="col-md-4">
    <div class="chagerequestdata-form box box-default">
      <div class="box-body table-responsive">
        <?= $form->field($model, 'userid')->widget(Select2::classname(), [
          'data' => $name,
          'options' => [
            'placeholder' => '- select -', 'id' => 'userid',
            'onChange' => "getdataforchangereq();",
            'allowClear' => true,
            'minimumInputLength' => 3,
            'language' => [
              'errorLoading' => new \yii\web\JsExpression("function () { return 'Waiting for results...'; }"),
            ],
          ],
          'pluginOptions' => [
            'allowClear' => false,
            'initialize' => true,
          ],
        ])->label('Name / Perner');
        ?>

        <?= $form->field($model, 'checkperner')->hiddenInput(['id' => 'checkperner'])->label(false) ?>
        <?= $form->field($model, 'cancelhiring')->widget(
          DatePicker::className(),
          [
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'options' => ['placeholder' => 'Date', 'id' => 'cancelhiring', 'onChange' => "autosave();"],
            'pluginOptions' => [
              'autoclose' => true,
              'format' => 'yyyy-mm-dd',
              'todayHighlight' => true
            ]
          ]
        );
        ?>

        <?php echo $form->field($model, 'typechangehiring')->widget(Select2::classname(), [
          'data' => ['1' => 'Perubahan Nomor JO', '2' => 'Tukar JO', '3' => 'Perubahan Tanggal Hiring', '4' => 'Perubahan Periode Kontrak'],
          'options' => [
            'placeholder' => '- select -', 'id' => 'typechangehiring',
            'onChange' => "
              if ($(this).val() == 1) {
                $('#formreason').show(); 
                $('#formchangenojo').show();
              }
              else if($(this).val() == 2){
                $('#formreason').hide();
                $('#formchangenojo').hide();
                $('#formchangejo').show();
              }
              else if ($(this).val() == 3) {
                $('#formreason').hide();
                $('#formchangenojo').hide();
                $('#formdatehiring').show();
              }
              else if ($(this).val() == 4) {
                $('#formreason').hide();
                $('#formchangenojo').hide();
                $('#formcontractperiode').show();
              }
              ;
              ",
          ],
          'pluginOptions' => [
            'allowClear' => true
          ],
        ]);
        ?>
        <?php
        switch ($model->typechangehiring) {
          case '1':
            $displayreason = "";
            $displayformchangenojo = "";
            $displayformchangejo = "display:none;";
            $displayformdatehiring = "display:none;";
            $displayformcontractperiode = "display:none;";
            break;
          case '2':
            $displayreason = "display:none;";
            $displayformchangenojo = "display:none;";
            $displayformchangejo = "";
            $displayformdatehiring = "display:none;";
            $displayformcontractperiode = "display:none;";
            break;
          case '3':
            $displayreason = "display:none;";
            $displayformchangenojo = "display:none;";
            $displayformchangejo = "display:none;";
            $displayformdatehiring = "";
            $displayformcontractperiode = "display:none;";
            break;
          case '4':
            $displayreason = "display:none;";
            $displayformchangenojo = "display:none;";
            $displayformchangejo = "display:none;";
            $displayformdatehiring = "display:none;";
            $displayformcontractperiode = "";
            break;

          default:
            $displayreason = "display:none;";
            $displayformchangenojo = "display:none;";
            $displayformchangejo = "display:none;";
            $displayformdatehiring = "display:none;";
            $displayformcontractperiode = "display:none;";
            break;
        }
        ?>
        <div id="formreason" style="<?php echo $displayreason; ?>">
          <?php echo $form->field($model, 'reason')->widget(Select2::classname(), [
            'data' => $reason,
            'options' => ['placeholder' => '- select -', 'id' => 'reason'],
            'pluginOptions' => [
              'allowClear' => true
            ],
          ])->label('Reason');
          ?>
        </div>
        <!-- condition one -->
        <div id="formchangenojo" style="<?php echo $displayformchangenojo; ?>">
          <?php echo $form->field($model, 'newrecruitreqid')->widget(Select2::classname(), [
            'model' => $model,
            'attribute' => 'perner',
            'initValueText' => $recruitreqs, // set the initial display text
            'options' => ['placeholder' => '- select -', 'id' => 'newrecruitreqid'],
            'pluginOptions' => [
              'dropdownParent' => new yii\web\JsExpression('$("#addcandidate-modal")'),
              'allowClear' => true,
              'minimumInputLength' => 3,
              'language' => [
                'errorLoading' => new \yii\web\JsExpression("function () { return 'Waiting for results...'; }"),
              ],
              'ajax' => [
                'url' => $url,
                'dataType' => 'json',
                'data' => new \yii\web\JsExpression('function(params) { return {q:params.term}; }'),

              ],
              'escapeMarkup' => new \yii\web\JsExpression('function (markup) { return markup; }'),
              'templateResult' => new \yii\web\JsExpression('function(a) {
                      if(a.sappersa){var projects = a.sappersa}else{var projects = "n/a"}
                      if(a.sapjabatan){var jabatans = a.sapjabatan}else{var jabatans = "n/a"}
                      if(a.sapskill){var skill = a.sapskill}else{var skill = "n/a"}
                      if(a.nojo == null){return "No Data";}else{return a.nojo+" <br> "+ jabatans  + " - " + a.saparea + " - " + projects+ " - " + skill;};
                    }'),
              'templateSelection' => new \yii\web\JsExpression('function (a) {
                      if(a.sappersa){var projects = a.sappersa;}else{var projects = "n/a"}
                      if(a.sapjabatan){var jabatans = a.sapjabatan;}else{var jabatans = "n/a"}
                      if(a.nojo == null){return "No Data";}else{return a.nojo};
                    }'),
            ],
          ])->label('New Recruitreqid');
          ?>
        </div>
        <!-- condition two -->
        <div id="formchangejo" style="<?php echo $displayformchangejo; ?>">
          <?= $form->field($model, 'newuserid')->widget(Select2::classname(), [
            'data' => $name,
            'options' => [
              'placeholder' => '- select -', 'id' => 'newuserid',
              'onChange' => "getdataforchangereq();",
              'allowClear' => true,
              'minimumInputLength' => 3,
              'language' => [
                'errorLoading' => new \yii\web\JsExpression("function () { return 'Waiting for results...'; }"),
              ],
            ],
            'pluginOptions' => [
              'allowClear' => false,
              'initialize' => true,
            ],
          ])->label('Name / Perner');
          ?>
        </div>
        <!-- condition three -->
        <div id="formdatehiring" style="<?php echo $displayformdatehiring; ?>">

        </div>
        <!-- condition four -->
        <div id="formcontractperiode" style="<?php echo $displayformcontractperiode; ?>">

        </div>
        <!-- end condition -->
      </div>
    </div>
  </div>

  <div class="col-md-8">
    <div class="box box-default">
      <div class="box-header with-border">
        <i class="fa fa-file-text"></i>
        <h3 class="box-title">Personal Information</h3>
      </div>
      <div class="box-body no-padding table-responsive">
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
              <td width="12%"><b>Level</b></td>
              <td width="30%" id="level">-</td>
            </tr>
            <tr>
              <td width="12%"><b>Hiring From</b></td>
              <td width="30%" id="hire">-</td>
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
    var userid = $('#userid').val();
    var cancelhiringid = $('#cancelhiring').val();
    var reasonid = $('#reason').val();
    var remarksval = $('#remarks').val();

    $.ajax({
      type: 'POST',
      cache: false,
      data: {
        userid: userid,
        cancelhiring: cancelhiringid,
        reason: reasonid,
        id: <?php echo $model->id; ?>,
      },
      url: '<?php echo Yii::$app->urlManager->createUrl(['changehiring/autosave']) ?>',
      success: function(data, textStatus, jqXHR) {}
    });
  }

  function getdataforchangereq() {
    var useridselect = $('#userid').val();
    $.ajax({
      type: 'POST',
      cache: false,
      data: {
        userid: useridselect,
        id: <?php echo $model->id; ?>,
      },
      url: '<?php echo Yii::$app->urlManager->createUrl(['changehiring/getuserabout']) ?>',
      success: function(data, textStatus, jqXHR) {
        // togleAction(useridselect);
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
        $("#checkperner").val(checkperner);

      },
    });
  }
</script>