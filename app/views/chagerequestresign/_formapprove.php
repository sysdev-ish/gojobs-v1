<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use kartik\select2\Select2;
use linslin\yii2\curl;

/* @var $this yii\web\View */
/* @var $model app\models\Chagerequestjo */
/* @var $form yii\widgets\ActiveForm */
?>

<style>
  .table-cus {
    margin: 2px;
  }

  .th-cus {
    font-size: .7em;
    padding: 2px 3px;
    border-collapse: separate;
    border: 1px solid #000;
  }

  .td-cus {
    font-size: .7em;
    border: 1px solid #DDD;
  }
</style>

<div class="row">
  <div class="col-sm-12">
    <blockquote>
      <p>Approval Resign for <b>
          <!-- <? //php echo $model->fullname; 
                ?></b>. -->
          <table class="table table-striped table-bordered table-cus">
            <thead>
              <tr>
                <th class="th-cus">Name</th>
                <th class="th-cus">Reason Resign</th>
                <th class="th-cus">Join Date</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  // echo '<span class="badge">' . $up->fullname . '</span> ';
                  echo "<tr>";
                  echo "<td class='td-cus'>";
                  echo "$model->fullname";
                  echo "</td>";

                  echo "<td class='td-cus'>";
                  echo $model->resignreason['reason'];
                  echo "</td>";

                  echo "<td class='td-cus'>";
                  echo $model->hiring['tglinput'];
                  echo "</td>";
                  echo "</tr>";
              ?>
            </tbody>
          </table>
      </p>
    </blockquote>
  </div>
  <div class="col-md-12">
    <div class="chagerequestjo-form">
      <?php $form = ActiveForm::begin([
        'options' => [
          'enctype' => 'multipart/form-data',
          'id' => 'stopjo-form'
        ]
      ]); ?>
      <div class="box-body table-responsive">

        <?php
        $data = [8 => 'Approve', 5 => 'Reject', 6 => 'Revise'];
        echo   $form->field($model, 'status')->widget(Select2::classname(), [
          'data' => $data,
          'options' => ['placeholder' => '- select -'],
          'pluginOptions' => [
            'allowClear' => false,
            'initialize' => true,
          ],
        ])->label('Select Confirmation');
        ?>
        <?= $form->field($model, 'remarks')->textArea(['maxlength' => true]) ?>
      </div>
      <br>
      <div class="box-footer">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success btn-flat pull-right']) ?>
      </div>
      <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>