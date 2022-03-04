<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\datetime\DateTimePicker;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use app\models\Transrincian;
use app\models\Mastersubgrouppenilaian;
use app\models\Interviewform;

/* @var $this yii\web\View */
/* @var $model app\models\Interview */
/* @var $form yii\widgets\ActiveForm */
$url = \yii\helpers\Url::to(['transrincian/recreqlist']);
?>

<div class="interview-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="box-body table-responsive">
      <blockquote>
                  <p>Interview Process for Recruitment request by No Jo <?php echo $modelrecreq->nojo; ?>.</p>
                  <small>Job detail for <cite title="Source Title"><?php
                  echo   (is_numeric($modelrecreq->jabatan)) ? $modelrecreq->jobfunc->jobcat->name_job_function_category.' - '.$modelrecreq->jobfunc->name_job_function : $modelrecreq->jabatan;?></cite></small>
      </blockquote>

        <?= $form->field($model, 'userid')->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'recruitmentcandidateid')->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'fullname')->textInput(['disabled' => true]) ?>
        <?php
        // var_dump();
        echo   $form->field($modelreccan, 'recruitreqid')->widget(Select2::classname(), [
          // 'data' => $recruitreq,
          // 'model' => $modelrecreq,
          // 'value' => $modelrecreq->id,
          'initValueText' => empty($modelreccan->recruitreqid) ? '' : Transrincian::findOne($modelreccan->recruitreqid)->nojo.' | '.Transrincian::findOne($modelreccan->recruitreqid)->n_project, // set the initial display text  // 'initValueText' => ' ', // set the initial display text
          'options' => ['placeholder' => '- select -', 'id'=>'recruitreqid'],
          'pluginOptions' => [
              'dropdownParent' => new yii\web\JsExpression('$("#intproc-modal")'),
              'allowClear' => true,
              'minimumInputLength' => 3,
              'language' => [
                  'errorLoading' => new \yii\web\JsExpression("function () { return 'No results...'; }"),
              ],
              'ajax' => [
                  'url' => $url,
                  'dataType' => 'json',
                  'data' => new \yii\web\JsExpression('function(params) { return {q:params.term}; }')
              ],
              'escapeMarkup' => new \yii\web\JsExpression('function (markup) { return markup; }'),
              'templateResult' => new \yii\web\JsExpression('function(a) {
                if(a.name_job_function){var jabatans = a.name_job_function}else{var jabatans =  a.jabatan}
                if(a.nojo == null){return "No Data";}else{return a.nojo+" <br> "+ jabatans + " - " + a.city_name;}; }'),
              // 'templateSelection' => new \yii\web\JsExpression('function (a) {
              //   if(a.name_job_function){var jabatans = a.name_job_function}else{var jabatans =  a.jabatan}
              //   if(a.nojo == null){return "- select -";}else{ return a.nojo + " | " + jabatans + " | " + a.city_name;}; }'),
          ],
        ])->label('Posisi yang disarankan');
        ?>


              <table class="table table-striped">
                <tbody><tr>
                  <th style="width: 10px">#</th>
                  <th>Aspek - Aspek Penilaian</th>
                  <th style="width: 150px">Nilai</th>
                  <th>Deskripsi</th>
                </tr>
                <?php
                $subgroupprev = null;
                $i=1;
                foreach ($masterpenilaian as $index => $m):
                  $dataInsert = new Interviewform();
                  $subgroup = Mastersubgrouppenilaian::find()->where(['id'=>$m->subgrouppenilaian])->one();

                  if($m->subgrouppenilaian != $subgroupprev){
                    echo '<tr><th colspan="4">'.$subgroup->subgroup.'</th></tr>';
                    $subgroupprev = $subgroup->id;
                    $i=1;
                  }
                ?>
                <tr>
                  <td><?php echo $i++; ?></td>
                  <td><?php echo $m->aspekpenilaian;?></td>
                  <?php echo $form->field($dataInsert, "[$index]aspekpenilaianid")->hiddenInput(['value' => $m->id])->label(false); ?>
                  <td><?php echo $form->field($dataInsert, "[$index]nilai")->radioList(array('K'=>'K','C'=>'C','B'=>'B',"T"=>"T"))->label(false); ?></td>
                  <td><?php echo $form->field($dataInsert, "[$index]desc")->label(false); ?></td>
                </tr>

              <?php  endforeach; ?>


              </tbody></table>
              <br>
              <p> <b> SKALA RATING :   </b>       K (Kurang);    C (Cukup);     B (Baik);    T (Tinggi) </p>
          <?= $form->field($model, 'desc')->textArea(['placeholder' => 'Ringkasan hasil wawancara disertai alasan-alasan spesifik berdasarkan pendidikan dan pengalaman pelamar yang dapat menunjang karirnya.']) ?>
          <?= $form->field($model, 'addinfo')->textArea() ?>

        <?php

        echo   $form->field($model, 'status')->widget(Select2::classname(), [
          'data' => ['2'=>'Pass','3'=>'Fail'],
          // 'initValueText' => $recruitreqs, // set the initial display text
          'options' => ['placeholder' => '- select -'],
          'pluginOptions' => [
              // 'dropdownParent' => new yii\web\JsExpression('$("#invite-modal")'),
              'allowClear' => true,
          ],
        ])->label('Interview result');
        ?>


    </div>
    <div class="box-footer">
        <?= Html::submitButton('Confirm', ['class' => 'btn btn-success btn-flat pull-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
