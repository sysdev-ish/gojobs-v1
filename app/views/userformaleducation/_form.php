<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Userformaleducation */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs('
$(function () {
    $(".dynamicform_wrapper").on("afterDelete", function(e, item) {
        $( ".dob" ).each(function() {
           $( this ).removeClass("hasDatepicker").datepicker({
              dateFormat : "yyyy-mm-dd",
              yearRange : "1925:+0",
              maxDate : "-1D",
              changeMonth: true,
              changeYear: true
           });
      });
    });
});
');
if ($model->startdate == '0000-00-00') {
  $model->startdate = null;
}
if ($model->enddate == '0000-00-00') {
  $model->enddate = null;
}
// var_dump($model->startdate);die;

?>
<?php if (Yii::$app->utils->getlayout() == 'main') : ?>
  <div class="box box-header with-border">

    <h3 class="box-title">Formal Education</h3>
  </div>
<?php endif; ?>

<!-- validation rule -->
<?php if (Yii::$app->user->isGuest) {
  $role = null;
} else {
  $role = Yii::$app->user->identity->role;
} ?>
<!-- end validation rule -->

<!-- show no data if user was hiring -->
<?php if ($model) : ?>
  <?php if (Yii::$app->utils->aplhired($userid)) : ?>
    <div class="box box-header with-border">
      <center>
        <h3 class="box-title">No Data</h3>
      </center>
    </div>
    <!-- end of show no data if user was hiring -->

    <!-- show edit menu if user as admin -->
    <?php if (Yii::$app->utils->permission($role, 'm49')) : ?>
      <div class="box box-solid">
        <div class="box-body">

          <?php $form = ActiveForm::begin([
            'options' => [
              'enctype' => 'multipart/form-data',
              'id' => 'userformaleducation-form'
            ]
          ]); ?>
          <i>*) scroll right and clik new button for add Formal Education</i>
          <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper',
            'widgetBody' => '.form-options-body',
            'widgetItem' => '.form-options-item',
            'min' => 1,
            'limit' => 10,
            'insertButton' => '.add-item',
            'deleteButton' => '.delete-item',
            'model' => $modelfedu[0],
            'formId' => 'userformaleducation-form',
            'formFields' => [
              'id',
            ],
          ]); ?>
          <div class="form-options-body">
            <?php foreach ($modelfedu as $index => $modelfedu) : ?>
              <div class="form-options-item">
                <?php
                if (!$modelfedu->isNewRecord) {
                  echo Html::activeHiddenInput($modelfedu, "[{$index}]id");
                } ?>
                <div class="row">
                  <div class="col-md-12">
                    <div class="text-center pull-right">
                      <button type="button" class="delete-item btn btn-danger btn-sm"><i class="fa fa-minus"></i></button>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <?= $form->field($modelfedu, "[{$index}]institutions")->textInput(["maxlength" => true]) ?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <?= $form->field($modelfedu, "[{$index}]city")->textInput(["maxlength" => true]) ?>
                  </div>
                  <div class="col-md-4">
                    <?= $form->field($modelfedu, "[{$index}]majoring")->textInput(["maxlength" => true]) ?>
                  </div>
                  <div class="col-md-4">
                    <?php
                    echo   $form->field($modelfedu, "[{$index}]educationallevel")->widget(Select2::classname(), [
                      'data' => $education,
                      'options' => ['placeholder' => '- select -'],
                      'pluginOptions' => [
                        'allowClear' => true
                      ],
                    ]);
                    ?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <?= $form->field($modelfedu, "[{$index}]startdate")->widget(
                      DatePicker::className(),
                      [
                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                        'options' => ['class' => 'dob', 'placeholder' => 'Date'],
                        'readonly' => true,
                        'removeButton' => false,
                        'pluginOptions' => [
                          'autoclose' => true,
                          'format' => 'yyyy-mm-dd',
                          'todayHighlight' => true
                        ]
                      ]
                    );
                    ?>
                  </div>
                  <div class="col-md-6">
                    <?= $form->field($modelfedu, "[{$index}]enddate")->widget(
                      DatePicker::className(),
                      [
                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                        'options' => ['class' => 'dob', 'placeholder' => 'Date'],
                        'readonly' => true,
                        'removeButton' => false,
                        'pluginOptions' => [
                          'autoclose' => true,
                          'format' => 'yyyy-mm-dd',
                          'todayHighlight' => true
                        ]
                      ]
                    );
                    ?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <?php
                    echo   $form->field($modelfedu, "[{$index}]status")->widget(Select2::classname(), [
                      'data' => ['finished' => 'Finished', 'unfinished' => 'Unfinished',],
                      'options' => ['placeholder' => '- select -'],
                      'pluginOptions' => [
                        'allowClear' => true
                      ],
                    ]);
                    ?>
                  </div>
                  <div class="col-md-6">
                    <?= $form->field($modelfedu, "[{$index}]gpa")->textInput(["maxlength" => true]) ?>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="text-center pull-right">
                <button type="button" class="add-item btn btn-success btn-sm"><span class="fa fa-plus"></span> New</button>
              </div>
            </div>
          </div>
          <?php DynamicFormWidget::end(); ?>
          <div class="box-footer" style="margin-top:20px;">
            <div class="pull-right">
              <?php if (Yii::$app->controller->action->id == 'cwizard' or Yii::$app->controller->action->id == 'uwizard') { ?>
                <?= Html::a('Back', ['/userprofile/cwizard'], ['class' => 'btn btn-primary']) ?>
              <?php } ?>
              <?= Html::submitButton((Yii::$app->controller->action->id == 'cwizard' or Yii::$app->controller->action->id == 'uwizard') ? 'Save & Next' : 'Save', ['class' => 'btn btn-success btn']) ?>
            </div>
          </div>

          <?php ActiveForm::end(); ?>
        </div>
      </div>
    <?php endif; ?>
    <!-- end of show edit menu if user as admin -->

    <!-- show edit menu if user not hiring yet -->
  <?php else : ?>
    <div class="box box-solid">
      <div class="box-body">
        <?php $form = ActiveForm::begin([
          'options' => [
            'enctype' => 'multipart/form-data',
            'id' => 'userformaleducation-form'
          ]
        ]); ?>
        <i>*) scroll right and clik new button for add Formal Education</i>
        <?php DynamicFormWidget::begin([
          'widgetContainer' => 'dynamicform_wrapper',
          'widgetBody' => '.form-options-body',
          'widgetItem' => '.form-options-item',
          'min' => 1,
          'limit' => 10,
          'insertButton' => '.add-item',
          'deleteButton' => '.delete-item',
          'model' => $modelfedu[0],
          'formId' => 'userformaleducation-form',
          'formFields' => [
            'id',
          ],
        ]); ?>
        <div class="form-options-body">
          <?php foreach ($modelfedu as $index => $modelfedu) : ?>
            <div class="form-options-item">
              <?php
              if (!$modelfedu->isNewRecord) {
                echo Html::activeHiddenInput($modelfedu, "[{$index}]id");
              } ?>
              <div class="row">
                <div class="col-md-12">
                  <div class="text-center pull-right">
                    <button type="button" class="delete-item btn btn-danger btn-sm"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <?= $form->field($modelfedu, "[{$index}]institutions")->textInput(["maxlength" => true]) ?>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <?= $form->field($modelfedu, "[{$index}]city")->textInput(["maxlength" => true]) ?>
                </div>
                <div class="col-md-4">
                  <?= $form->field($modelfedu, "[{$index}]majoring")->textInput(["maxlength" => true]) ?>
                </div>
                <div class="col-md-4">
                  <?php
                  echo   $form->field($modelfedu, "[{$index}]educationallevel")->widget(Select2::classname(), [
                    'data' => $education,
                    'options' => ['placeholder' => '- select -'],
                    'pluginOptions' => [
                      'allowClear' => true
                    ],
                  ]);
                  ?>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <?= $form->field($modelfedu, "[{$index}]startdate")->widget(
                    DatePicker::className(),
                    [
                      'type' => DatePicker::TYPE_COMPONENT_APPEND,
                      'options' => ['class' => 'dob', 'placeholder' => 'Date'],
                      'readonly' => true,
                      'removeButton' => false,
                      'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true
                      ]
                    ]
                  );
                  ?>
                </div>
                <div class="col-md-6">
                  <?= $form->field($modelfedu, "[{$index}]enddate")->widget(
                    DatePicker::className(),
                    [
                      'type' => DatePicker::TYPE_COMPONENT_APPEND,
                      'options' => ['class' => 'dob', 'placeholder' => 'Date'],
                      'readonly' => true,
                      'removeButton' => false,
                      'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true
                      ]
                    ]
                  );
                  ?>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <?php
                  echo   $form->field($modelfedu, "[{$index}]status")->widget(Select2::classname(), [
                    'data' => ['finished' => 'Finished', 'unfinished' => 'Unfinished',],
                    'options' => ['placeholder' => '- select -'],
                    'pluginOptions' => [
                      'allowClear' => true
                    ],
                  ]);
                  ?>
                </div>
                <div class="col-md-6">
                  <?= $form->field($modelfedu, "[{$index}]gpa")->textInput(["maxlength" => true]) ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="text-center pull-right">
              <button type="button" class="add-item btn btn-success btn-sm"><span class="fa fa-plus"></span> New</button>
            </div>
          </div>
        </div>
        <?php DynamicFormWidget::end(); ?>
        <div class="box-footer" style="margin-top:20px;">
          <div class="pull-right">
            <?php if (Yii::$app->controller->action->id == 'cwizard' or Yii::$app->controller->action->id == 'uwizard') { ?>
              <?= Html::a('Back', ['/userprofile/cwizard'], ['class' => 'btn btn-primary']) ?>
            <?php } ?>
            <?= Html::submitButton((Yii::$app->controller->action->id == 'cwizard' or Yii::$app->controller->action->id == 'uwizard') ? 'Save & Next' : 'Save', ['class' => 'btn btn-success btn']) ?>
          </div>
        </div>
        <?php ActiveForm::end(); ?>
      </div>
    </div>
    <!-- end of show edit menu if user not hiring yet -->

  <?php endif; ?>
<?php endif; ?>