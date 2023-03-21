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

$recruitreqs = empty($model->recruitreqid) ? '' : Transrincian::findOne($model->recruitreqid)->nojo;
$model->changehiring = ($model->changehiring == "0000-00-00") ? null : $model->changehiring;
?>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
  <div class="col-md-4">
    <div class="chagerequestdata-form box box-default">
      <div class="box-body table-responsive">
        <?= $form->field($model, 'userid')->widget(Select2::classname(), [
          'data' => $data,
          'options' => [
            'placeholder' => '- select -', 'id' => 'userid',
            'onChange' => "getdataforchangereq();",
          ],
          'pluginOptions' => [
            'minimumInputLength' => 3,
            'language' => [
              'errorLoading' => new \yii\web\JsExpression("function () { return 'Waiting for results...'; }"),
            ],
            'allowClear' => true,
            'initialize' => true,
          ],
        ])->label('Perner Existing');
        ?>

        <?= $form->field($model, 'checkperner')->hiddenInput(['id' => 'checkperner'])->label(false) ?>
        <?= $form->field($model, 'changehiring')->widget(
          DatePicker::className(),
          [
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'options' => ['placeholder' => 'Date', 'id' => 'changehiring', 'onChange' => "autosave();"],
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
                $('#formchangejo').hide();
                $('#formdatehiring').hide();
                $('#formcontractperiode').hide();
                
                $('#infocaseone').show();
                $('#infocasetwo').hide();
                $('#infocasethree').hide();
                $('#infocasefour').hide();

              }
              else if($(this).val() == 2){
                $('#formreason').show();
                $('#formchangenojo').hide();
                $('#formchangejo').show();
                $('#formdatehiring').hide();
                $('#formcontractperiode').hide();

                $('#infocaseone').hide();
                $('#infocasetwo').show();
                $('#infocasethree').hide();
                $('#infocasefour').hide();
              }
              else if ($(this).val() == 3) {
                $('#formreason').show();
                $('#formchangenojo').hide();
                $('#formchangejo').hide();
                $('#formdatehiring').show();
                $('#formcontractperiode').hide();

                $('#infocaseone').hide();
                $('#infocasetwo').hide();
                $('#infocasethree').show();
                $('#infocasefour').hide();
              }
              else if ($(this).val() == 4) {
                $('#formreason').show();
                $('#formchangenojo').hide();
                $('#formchangejo').hide();
                $('#formdatehiring').hide();
                $('#formcontractperiode').show();

                $('#infocaseone').hide();
                $('#infocasetwo').hide();
                $('#infocasethree').hide();
                $('#infocasefour').show();
              }
              autosave();
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
            $displayformcaseone = "";
            $displayformcasetwo = "display:none;";
            $displayformcasethree = "display:none;";
            $displayformcasefour = "display:none;";
            break;
          case '2':
            $displayreason = "";
            $displayformchangenojo = "display:none;";
            $displayformchangejo = "";
            $displayformdatehiring = "display:none;";
            $displayformcontractperiode = "display:none;";
            $displayformcaseone = "display:none;";
            $displayformcasetwo = "";
            $displayformcasethree = "display:none;";
            $displayformcasefour = "display:none;";
            break;
          case '3':
            $displayreason = "";
            $displayformchangenojo = "display:none;";
            $displayformchangejo = "display:none;";
            $displayformdatehiring = "";
            $displayformcontractperiode = "display:none;";
            $displayformcaseone = "display:none;";
            $displayformcasetwo = "display:none;";
            $displayformcasethree = "";
            $displayformcasefour = "display:none;";
            break;
          case '4':
            $displayreason = "";
            $displayformchangenojo = "display:none;";
            $displayformchangejo = "display:none;";
            $displayformdatehiring = "display:none;";
            $displayformcontractperiode = "";
            $displayformcaseone = "display:none;";
            $displayformcasetwo = "display:none;";
            $displayformcasethree = "display:none;";
            $displayformcasefour = "";
            break;

          default:
            $displayreason = "";
            $displayformchangenojo = "display:none;";
            $displayformchangejo = "display:none;";
            $displayformdatehiring = "display:none;";
            $displayformcontractperiode = "display:none;";
            $displayformcaseone = "";
            $displayformcasetwo = "display:none;";
            $displayformcasethree = "display:none;";
            $displayformcasefour = "display:none;";
            break;
        }
        ?>
        <div id="formreason" style="<?php echo $displayreason; ?>">
          <?php echo $form->field($model, 'reason')->widget(Select2::classname(), [
            'data' => $reason,
            'options' => ['placeholder' => '- select -', 'id' => 'reason', 'onChange' => 'autosave();'],
            'pluginOptions' => [
              'allowClear' => true,
              'initialize' => true
            ],
          ])->label('Reason');
          ?>
        </div>
        <!-- condition one -->
        <div id="formchangenojo" style="<?php echo $displayformchangenojo; ?>">
          <?php echo $form->field($model, 'recruitreqid')->widget(Select2::classname(), [
            'initValueText' => $recruitreqs, // set the initial display text
            'options' => [
              'placeholder' => '- select -',
              'id' => 'recruitreqid',
              'onChange' => 'getdatanewrecruitreqid'
            ],
            'pluginOptions' => [
              'allowClear' => true,
              'minimumInputLength' => 3,
              'language' => [
                'errorLoading' => new \yii\web\JsExpression("function () { return 'Waiting for results...'; }"),
              ],
              'ajax' => [
                'url' => \yii\helpers\Url::to(['changehiring/recreqlist']),
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
            'data' => $data,
            'options' => [
              'placeholder' => '- select -', 'id' => 'newuserid',
              'onChange' => "getdataforreplacechangereq();",
              'minimumInputLength' => 3,
              'language' => [
                'errorLoading' => new \yii\web\JsExpression("function () { return 'Waiting for results...'; }"),
              ],
            ],
            'pluginOptions' => [
              'allowClear' => true,
              'initialize' => true,
            ],
          ])->label('Perner Replacement/ Swap JO');
          ?>
        </div>
        <!-- condition three -->
        <div id="formdatehiring" style="<?php echo $displayformdatehiring; ?>">
          <?= $form->field($model, 'tglinput')->widget(
            DatePicker::className(),
            [
              'type' => DatePicker::TYPE_COMPONENT_APPEND,
              'options' => ['placeholder' => 'Date', 'id' => 'tglinput', 'onChange' => 'getchangedatehiring();'],
              'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
              ]
            ]
          );
          ?>
        </div>
        <!-- condition four -->
        <div id="formcontractperiode" style="<?php echo $displayformcontractperiode; ?>">
          <?= $form->field($model, 'awalkontrak')->widget(
            DatePicker::className(),
            [
              'type' => DatePicker::TYPE_COMPONENT_APPEND,
              'options' => ['placeholder' => 'Date', 'id' => 'awalkontrak', 'onChange' => 'getstartcontract();'],
              'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
              ]
            ]
          );
          ?>
          <?= $form->field($model, 'akhirkontrak')->widget(
            DatePicker::className(),
            [
              'type' => DatePicker::TYPE_COMPONENT_APPEND,
              'options' => ['placeholder' => 'Date', 'id' => 'akhirkontrak', 'onChange' => 'getendcontract();'],
              'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
              ]
            ]
          );
          ?>
        </div>
        <!-- end condition -->
        <?= $form->field($model, 'userremarks')->textArea(['id' => 'userremarks', 'onChange' => "autosave();"])->label('Remarks');
        ?>
      </div>
    </div>
  </div>

  <div class="col-md-8">
    <div class="box box-default">
      <div class="box-header with-border">
        <i class="fa fa-file-text"></i>
        <h3 class="box-title">Personal Information Existing</h3>
      </div>
      <div class="box-body no-padding table-responsive">
        <table class="table no-border">
          <tbody>
            <tr>
              <td width="20%"><b>Perner</b></td>
              <td width="30%" id="pernerdisp">-</td>
            </tr>
            <tr>
              <td width="20%"><b>No JO (Recruitreqid)</b></td>
              <td width="30%" id="nojo">-</td>
            </tr>
            <tr>
              <td width="20%"><b>Name</b></td>
              <td width="30%" id="name">-</td>
            </tr>
            <tr>
              <td width="20%"><b>Personal Area</b></td>
              <td width="30%" id="persa">-</td>
            </tr>
            <tr>
              <td width="20%"><b>Area</b></td>
              <td width="30%" id="area">-</td>
            </tr>
            <tr>
              <td width="20%"><b>Skill Layanan</b></td>
              <td width="30%" id="skilllayanan">-</td>
            </tr>
            <tr>
              <td width="20%"><b>Payroll Area</b></td>
              <td width="30%" id="payrollarea">-</td>
            </tr>
            <tr>
              <td width="20%"><b>Jabatan</b></td>
              <td width="30%" id="jabatan">-</td>
            </tr>
            <tr>
              <td width="20%"><b>Level</b></td>
              <td width="30%" id="level">-</td>
            </tr>
            <tr>
              <td width="20%"><b>Hiring From</b></td>
              <td width="30%" id="hire">-</td>
            </tr>
            <tr>
              <td width="20%"><b>Hiring Date Existing</b></td>
              <td width="30%" id="hiringdate">-</td>
            </tr>
            <tr>
              <td width="20%"><b>Contract Periode Existing</b></td>
              <td width="30%"><span id="cpstart">-</span> s/d <span id="cpend">-</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="box box-default">
      <div class="box-header with-border">
        <i class="fa fa-file-text"></i>
        <h3 class="box-title">Data Information Replacement</h3>
      </div>
      <div class="box-body no-padding table-responsive">
        <!-- info one -->
        <table class="table no-border" id="infocaseone" style="<?php echo $displayformcaseone; ?>">
          <tbody>
            <tr>
              <td width="20%"><b>No JO</b></td>
              <td width="30%" id="newrec_recruitreqid">-</td>
            </tr>
            <tr>
              <td width="20%"><b>Personal Area</b></td>
              <td width="30%" id="newrec_persa">-</td>
            </tr>
            <tr>
              <td width="20%"><b>Area</b></td>
              <td width="30%" id="newrec_area">-</td>
            </tr>
            <tr>
              <td width="20%"><b>Skill Layanan</b></td>
              <td width="30%" id="newrec_skilllayanan">-</td>
            </tr>
            <tr>
              <td width="20%"><b>Payroll Area</b></td>
              <td width="30%" id="newrec_payrollarea">-</td>
            </tr>
            <tr>
              <td width="20%"><b>Jabatan</b></td>
              <td width="30%" id="newrec_jabatan">-</td>
            </tr>
            <tr>
              <td width="20%"><b>Level</b></td>
              <td width="30%" id="newrec_level">-</td>
            </tr>
          </tbody>
        </table>
        <!-- info two -->
        <table class="table no-border" id="infocasetwo" style="<?php echo $displayformcasetwo; ?>">
          <tbody>
            <tr>
              <td width="20%"><b>Perner</b></td>
              <td width="30%" id="newpernerdisp">-</td>
            </tr>
            <tr>
              <td width="20%"><b>No JO (Recruitreqid)</b></td>
              <td width="30%" id="newnojo">-</td>
            </tr>
            <tr>
              <td width="20%"><b>Name</b></td>
              <td width="30%" id="newname">-</td>
            </tr>
            <tr>
              <td width="20%"><b>Personal Area</b></td>
              <td width="30%" id="newpersa">-</td>
            </tr>
            <tr>
              <td width="20%"><b>Area</b></td>
              <td width="30%" id="newarea">-</td>
            </tr>
            <tr>
              <td width="20%"><b>Skill Layanan</b></td>
              <td width="30%" id="newskilllayanan">-</td>
            </tr>
            <tr>
              <td width="20%"><b>Payroll Area</b></td>
              <td width="30%" id="newpayrollarea">-</td>
            </tr>
            <tr>
              <td width="20%"><b>Jabatan</b></td>
              <td width="30%" id="newjabatan">-</td>
            </tr>
            <tr>
              <td width="20%"><b>Level</b></td>
              <td width="30%" id="newlevel">-</td>
            </tr>
            <tr>
              <td width="20%"><b>Hiring From</b></td>
              <td width="30%" id="newhire">-</td>
            </tr>
          </tbody>
        </table>
        <!-- info three -->
        <table class="table no-border" id="infocasethree" style="<?php echo $displayformcasethree; ?>">
          <tbody>
            <tr>
              <td width="20%"><b>Hiring Date Replacement</b></td>
              <td width="30%" id="hiringdatereplacement">-</td>
            </tr>
          </tbody>
        </table>
        <!-- info four -->
        <table class="table no-border" id="infocasefour" style="<?php echo $displayformcasefour; ?>">
          <tbody>
            <tr>
              <td width="20%"><b>Contract Periode Replacement</b></td>
              <td width="30%"><span id="cpstartreplacemmet">-</span> s/d <span id="cpendreplacement">-</span></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="box-footer">
        <div class="pull-right">
          <?= Html::a('Save to draft', ['index'], ['class' => 'btn btn-danger btn-flat', 'style' => 'margin-right:10px;']) ?>
          <?= Html::submitButton('Submit', ['class' => 'btn btn-success btn-flat']) ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php ActiveForm::end(); ?>

<script>
  function autosave() {
    var userid = $('#userid').val();
    var changehiringdate = $('#changehiring').val();
    var reasonid = $('#reason').val();
    var typechangehiring = $('#typechangehiring').val();
    var userremarks = $('#userremarks').val();

    $.ajax({
      type: 'POST',
      cache: false,
      data: {
        userid: userid,
        changehiring: changehiringdate,
        reason: reasonid,
        typechangehiring: typechangehiring,
        userremarks: userremarks,
        id: <?php echo $model->id; ?>,
      },
      url: '<?php echo Yii::$app->urlManager->createUrl(['changehiring/autosave']) ?>',
      success: function(data, textStatus, jqXHR) {}
    });
  }

  document.addEventListener("DOMContentLoaded", function() {
    getdatanewrecruitreqid();
  });

  function getdatanewrecruitreqid() {
    var newrecruitreqidselect = $('#id').val();
    $.ajax({
      type: 'POST',
      cache: false,
      data: {
        recruitreqid: newrecruitreqidselect,
        id: <?php echo $model->id; ?>,
      },
      url: '<?php echo Yii::$app->urlManager->createUrl(['changehiring/getnewrecruitreqid']) ?>',
      success: function(data, textStatus, jqXHR) {
        // togleAction(useridselect);
        var obj = JSON.parse(data);
        var newrec_recruitreqid = '';
        var newrec_persa = '';
        var newrec_area = '';
        var newrec_skilllayanan = '';
        var newrec_payrollarea = '';
        var newrec_jabatan = '';
        var newrec_level = '';

        if (obj.recruitreqid) {
          var newrec_recruitreqid = obj.recruitreqid;
        }
        if (obj.persa) {
          var newrec_persa = obj.persa;
        }
        if (obj.area) {
          var newrec_area = obj.area;
        }
        if (obj.skilllayanan) {
          var newrec_skilllayanan = obj.skilllayanan;
        }
        if (obj.payrollarea) {
          var newrec_payrollarea = obj.payrollarea;
        }
        if (obj.jabatan) {
          var newrec_jabatan = obj.jabatan;
        }
        if (obj.level) {
          var newrec_level = obj.level;
        }

        document.getElementById('newrec_recruitreqid').innerHTML = newrec_recruitreqid;
        document.getElementById('newrec_persa').innerHTML = newrec_persa;
        document.getElementById('newrec_area').innerHTML = newrec_area;
        document.getElementById('newrec_skilllayanan').innerHTML = newrec_skilllayanan;
        document.getElementById('newrec_payrollarea').innerHTML = newrec_payrollarea;
        document.getElementById('newrec_jabatan').innerHTML = newrec_jabatan;
        document.getElementById('newrec_level').innerHTML = newrec_level;

      },
    });
  }

  document.addEventListener("DOMContentLoaded", function() {
    getdataforchangereq();
  });

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
        var nojo = '';
        var name = '';
        var persa = '';
        var area = '';
        var skilllayanan = '';
        var payrollarea = '';
        var jabatan = '';
        var level = '';
        var hire = '';
        var hiringdate = '';
        var cpstart = '';
        var cpend = '';
        var checkperner = '';

        if (obj.perner) {
          var pernerres = obj.perner;
        }
        if (obj.nojo) {
          var nojo = obj.nojo;
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
        if (obj.hiringdate) {
          var hiringdate = obj.hiringdate;
        }
        if (obj.cpstart) {
          var cpstart = obj.cpstart;
        }
        if (obj.cpend) {
          var cpend = obj.cpend;
        }
        if (obj.checkperner) {
          var checkperner = obj.checkperner;
        }

        document.getElementById('pernerdisp').innerHTML = pernerres;
        document.getElementById('nojo').innerHTML = nojo;
        document.getElementById('name').innerHTML = name;
        document.getElementById('persa').innerHTML = persa;
        document.getElementById('area').innerHTML = area;
        document.getElementById('skilllayanan').innerHTML = skilllayanan;
        document.getElementById('payrollarea').innerHTML = payrollarea;
        document.getElementById('jabatan').innerHTML = jabatan;
        document.getElementById('level').innerHTML = level;
        document.getElementById('hire').innerHTML = hire;
        document.getElementById('hiringdate').innerHTML = hiringdate;
        document.getElementById('cpstart').innerHTML = cpstart;
        document.getElementById('cpend').innerHTML = cpend;
        $("#checkperner").val(checkperner);

      },
    });
  }

  document.addEventListener("DOMContentLoaded", function() {
    getdataforreplacechangereq();
  });

  function getdataforreplacechangereq() {
    var newuseridselect = $('#newuserid').val();
    $.ajax({
      type: 'POST',
      cache: false,
      data: {
        newuserid: newuseridselect,
        id: <?php echo $model->id; ?>,
      },
      url: '<?php echo Yii::$app->urlManager->createUrl(['changehiring/getnewuserabout']) ?>',
      success: function(data, textStatus, jqXHR) {
        // togleAction(useridselect);
        var obj = JSON.parse(data);
        var newpernerres = '';
        var newname = '';
        var newnojo = '';
        var newpersa = '';
        var newarea = '';
        var newskilllayanan = '';
        var newpayrollarea = '';
        var newjabatan = '';
        var newlevel = '';
        var newhire = '';
        var newcheckperner = '';

        if (obj.perner) {
          var newpernerres = obj.perner;
        }
        if (obj.name) {
          var newname = obj.name;
        }
        if (obj.nojo) {
          var newnojo = obj.nojo;
        }
        if (obj.persa) {
          var newpersa = obj.persa;
        }
        if (obj.area) {
          var newarea = obj.area;
        }
        if (obj.skilllayanan) {
          var newskilllayanan = obj.skilllayanan;
        }
        if (obj.payrollarea) {
          var newpayrollarea = obj.payrollarea;
        }
        if (obj.jabatan) {
          var newjabatan = obj.jabatan;
        }
        if (obj.level) {
          var newlevel = obj.level;
        }
        if (obj.hire) {
          var newhire = obj.hire;
        }
        if (obj.checkperner) {
          var newcheckperner = obj.checkperner;
        }

        document.getElementById('newpernerdisp').innerHTML = newpernerres;
        document.getElementById('newname').innerHTML = newname;
        document.getElementById('newnojo').innerHTML = newnojo;
        document.getElementById('newpersa').innerHTML = newpersa;
        document.getElementById('newarea').innerHTML = newarea;
        document.getElementById('newskilllayanan').innerHTML = newskilllayanan;
        document.getElementById('newpayrollarea').innerHTML = newpayrollarea;
        document.getElementById('newjabatan').innerHTML = newjabatan;
        document.getElementById('newlevel').innerHTML = newlevel;
        document.getElementById('newhire').innerHTML = newhire;
        $("#checkperner").val(checkperner);

      },
    });
  }

  function getstartcontract() {
    var newstartcontract = $('awalkontrak').val();
    $.ajax({
      type: 'POST',
      cache: false,
      data: {
        awalkontrak: newstartcontract,
        id: <?php echo $model->id; ?>,
      },
      url: '<?php echo Yii::$app->urlManager->createUrl(['changehiring/getscp']) ?>',
      success: function(data, textStatus, jqXHR) {
        var obj = JSO.parse(data);
        var awalkontrak = '';

        if (obj.awalkontrak) {
          var awalkontrakres = obj.awalkontrak;
        }
        document.getElementById('cpstartreplacemmet').innerHTML = awalkontrakres;
      },
    });
  }

  function getendcontract() {
    var newendcontract = $('akhirkontrak').val();
    $.ajax({
      type: 'POST',
      cache: false,
      data: {
        akhirkontrak: newendcontract,
        id: <?php echo $model->id; ?>,
      },
      url: '<?php echo Yii::$app->urlManager->createUrl(['changehiring/getecp']) ?>',
      success: function(data, textStatus, jqXHR) {
        var obj = JSO.parse(data);
        var akhirkontrak = '';

        if (obj.akhirkontrak) {
          var akhirkontrakres = obj.akhirkontrak;
        }
        document.getElementById('cpendreplacemmet').innerHTML = akhirkontrakres;
      },
    });
  }
</script>