<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Userfamily */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs('

$(function () {
  $(".dynamicform_wrapper").on("afterDelete", function(e, item) {
    $( ".dob" ).each(function() {
      $( this ).removeClass("hasDatepicker").datepicker({
        dateFormat : "dd/mm/yy",
        yearRange : "1925:+0",
        maxDate : "-1D",
        changeMonth: true,
        changeYear: true
      });
    });
  });
});
');
?>
<?php if (Yii::$app->utils->getlayout() == 'main') : ?>
  <div class="box box-header with-border">

    <h3 class="box-title">User Family</h3>
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
              'id' => 'userfamily-form'
            ]
          ]); ?>
          <i>*) scroll right and clik new button for add family</i>
          <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper',
            'widgetBody' => '.form-options-body',
            'widgetItem' => '.form-options-item',
            // 'widgetBody' => '.form-options-body',
            // 'widgetItem' => '.form-options-item',
            'min' => 1,
            'limit' => 10,
            'insertButton' => '.add-item',
            'deleteButton' => '.delete-item',
            'model' => $modelfamily[0],
            'formId' => 'userfamily-form',
            'formFields' => [
              'id',
            ],
          ]); ?>
          <div class="form-options-body">
            <?php foreach ($modelfamily as $index => $modelfamily) : ?>
              <div class="form-options-item">
                <?php
                if (!$modelfamily->isNewRecord) {
                  echo Html::activeHiddenInput($modelfamily, "[{$index}]id");
                } ?>
                <div class="row">
                  <div class="col-md-12">
                    <div class="text-center pull-right">
                      <button type="button" class="delete-item btn btn-danger btn-sm"><i class="fa fa-minus"></i></button>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <?php
                    echo   $form->field($modelfamily, "[{$index}]relationship")->widget(Select2::classname(), [
                      'data' => ['father' => 'Father', 'mother' => 'Mother', 'siblings' => 'Siblings', 'husband' => 'Husband', 'wife' => 'Wife', 'child' => 'Child'],
                      'options' => ['placeholder' => '- select -', 'style' => 'width:100px;'],
                      'pluginOptions' => [
                        'allowClear' => true
                      ],
                    ]);
                    ?>
                  </div>
                  <div class="col-md-6">
                    <?php
                    echo   $form->field($modelfamily, "[{$index}]gender")->widget(Select2::classname(), [
                      'data' => ['male' => 'Male', 'female' => 'Female',],
                      'options' => ['placeholder' => '- select -'],
                      'pluginOptions' => [
                        'allowClear' => true
                      ],
                    ]);
                    ?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <?= $form->field($modelfamily, "[{$index}]fullname")->textInput(["maxlength" => true]) ?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <?= $form->field($modelfamily, "[{$index}]birthplace")->textInput(["maxlength" => true]) ?>
                  </div>
                  <div class="col-md-4">
                    <?= $form->field($modelfamily, "[{$index}]birthdate")->widget(
                      DatePicker::className(),
                      [
                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                        'options' => ['placeholder' => 'Date', 'autocomplete' => 'off'],
                        'readonly' => true,
                        'removeButton' => false,
                        'pluginOptions' => [
                          'autoclose' => true,
                          'startDate' => '-100y',
                          'endDate' => '-0y',
                          'format' => 'yyyy-mm-dd',
                          'todayHighlight' => true,
                          'width' => '200px',
                        ]
                      ]
                    );
                    ?>
                  </div>
                  <div class="col-md-4">
                    <?php
                    echo   $form->field($modelfamily, "[{$index}]lasteducation")->widget(Select2::classname(), [
                      'data' => $education,
                      'options' => ['placeholder' => '- select -', 'style' => 'width:100px;'],
                      'pluginOptions' => [
                        'allowClear' => true
                      ],
                    ]);
                    ?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <?= $form->field($modelfamily, "[{$index}]jobtitle")->textInput(["maxlength" => true]) ?>
                  </div>
                  <div class="col-md-6">
                    <?= $form->field($modelfamily, "[{$index}]companyname")->textInput(["maxlength" => true]) ?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <?= $form->field($modelfamily, "[{$index}]description")->textInput(["maxlength" => true]) ?>
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
            'id' => 'userfamily-form'
          ]
        ]); ?>
        <i>*) scroll right and clik new button for add family</i>
        <?php DynamicFormWidget::begin([
          'widgetContainer' => 'dynamicform_wrapper',
          'widgetBody' => '.form-options-body',
          'widgetItem' => '.form-options-item',
          // 'widgetBody' => '.form-options-body',
          // 'widgetItem' => '.form-options-item',
          'min' => 1,
          'limit' => 10,
          'insertButton' => '.add-item',
          'deleteButton' => '.delete-item',
          'model' => $modelfamily[0],
          'formId' => 'userfamily-form',
          'formFields' => [
            'id',
          ],
        ]); ?>
        <div class="form-options-body">
          <?php foreach ($modelfamily as $index => $modelfamily) : ?>
            <div class="form-options-item">
              <?php
              if (!$modelfamily->isNewRecord) {
                echo Html::activeHiddenInput($modelfamily, "[{$index}]id");
              } ?>
              <div class="row">
                <div class="col-md-12">
                  <div class="text-center pull-right">
                    <button type="button" class="delete-item btn btn-danger btn-sm"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <?php
                  echo   $form->field($modelfamily, "[{$index}]relationship")->widget(Select2::classname(), [
                    'data' => ['father' => 'Father', 'mother' => 'Mother', 'siblings' => 'Siblings', 'husband' => 'Husband', 'wife' => 'Wife', 'child' => 'Child'],
                    'options' => ['placeholder' => '- select -', 'style' => 'width:100px;'],
                    'pluginOptions' => [
                      'allowClear' => true
                    ],
                  ]);
                  ?>
                </div>
                <div class="col-md-6">
                  <?php
                  echo   $form->field($modelfamily, "[{$index}]gender")->widget(Select2::classname(), [
                    'data' => ['male' => 'Male', 'female' => 'Female',],
                    'options' => ['placeholder' => '- select -'],
                    'pluginOptions' => [
                      'allowClear' => true
                    ],
                  ]);
                  ?>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <?= $form->field($modelfamily, "[{$index}]fullname")->textInput(["maxlength" => true]) ?>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <?= $form->field($modelfamily, "[{$index}]birthplace")->textInput(["maxlength" => true]) ?>
                </div>
                <div class="col-md-4">
                  <?= $form->field($modelfamily, "[{$index}]birthdate")->widget(
                    DatePicker::className(),
                    [
                      'type' => DatePicker::TYPE_COMPONENT_APPEND,
                      'options' => ['placeholder' => 'Date', 'autocomplete' => 'off'],
                      'readonly' => true,
                      'removeButton' => false,
                      'pluginOptions' => [
                        'autoclose' => true,
                        'startDate' => '-100y',
                        'endDate' => '-0y',
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                        'width' => '200px',
                      ]
                    ]
                  );
                  ?>
                </div>
                <div class="col-md-4">
                  <?php
                  echo   $form->field($modelfamily, "[{$index}]lasteducation")->widget(Select2::classname(), [
                    'data' => $education,
                    'options' => ['placeholder' => '- select -', 'style' => 'width:100px;'],
                    'pluginOptions' => [
                      'allowClear' => true
                    ],
                  ]);
                  ?>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <?= $form->field($modelfamily, "[{$index}]jobtitle")->textInput(["maxlength" => true]) ?>
                </div>
                <div class="col-md-6">
                  <?= $form->field($modelfamily, "[{$index}]companyname")->textInput(["maxlength" => true]) ?>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <?= $form->field($modelfamily, "[{$index}]description")->textInput(["maxlength" => true]) ?>
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