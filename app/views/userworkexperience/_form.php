<?php

use app\models\Masterindustry;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use app\models\Mastersubjobfamily;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Userworkexperience */
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

    <h3 class="box-title"><?= Yii::t('app', 'Work Experience') ?></h3>
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

    <!-- show edit menu if user as superadmin -->
    <?php if (Yii::$app->utils->permission($role, 'm49')) : ?>
      <div class="box box-solid">
        <div class="box-body">

          <?php $form = ActiveForm::begin([
            'options' => [
              'enctype' => 'multipart/form-data',
              'id' => 'workexperience-form'
            ]
          ]); ?>
          <i>*) scroll right and clik new button for add Work Experience</i>
          <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper',
            'widgetBody' => '.form-options-body',
            'widgetItem' => '.form-options-item',
            'min' => 1,
            'limit' => 10,
            'insertButton' => '.add-item',
            'deleteButton' => '.delete-item',
            'model' => $modelwexp[0],
            'formId' => 'workexperience-form',
            'formFields' => [
              'id',

            ],
          ]); ?>
          <div class="form-options-body">
            <?php foreach ($modelwexp as $index => $modelwexp) : ?>
              <?php
              $modelwexp->startdate = substr($modelwexp->startdate, 0, 7);
              $modelwexp->enddate = substr($modelwexp->enddate, 0, 7);
              ?>
              <div class="form-options-item">
                <?php
                if (!$modelwexp->isNewRecord) {
                  echo Html::activeHiddenInput($modelwexp, "[{$index}]id");
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
                    <?= $form->field($modelwexp, "[{$index}]companyname")->textInput(["maxlength" => true]) ?>
                  </div>
                  <div class="col-md-6">
                    <?php $subjobfamily = ArrayHelper::map(Mastersubjobfamily::find()->asArray()->all(), 'subjobfamily', 'subjobfamily');
                    echo   $form->field($modelwexp, "[{$index}]lastposition")->widget(Select2::classname(), [
                      'data' => $subjobfamily,
                      // 'initValueText' => $recruitreqs, // set the initial display text
                      'options' => ['placeholder' => 'Pilih Jabatan Terakhir'],
                      'pluginOptions' => [
                        'allowClear' => true,
                      ],
                    ]);
                    ?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <?= $form->field($modelwexp, "[{$index}]startdate")->widget(
                      DatePicker::className(),
                      [
                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                        'options' => ['class' => 'dob', 'placeholder' => 'Date'],
                        'removeButton' => false,
                        'pluginOptions' => [
                          'autoclose' => true,
                          'startView' => 'year',
                          'minViewMode' => 'months',
                          'format' => 'yyyy-mm',
                          'todayHighlight' => true
                        ]
                      ]
                    );
                    ?>
                  </div>
                  <div class="col-md-6">
                    <?= $form->field($modelwexp, "[{$index}]enddate")->widget(
                      DatePicker::className(),
                      [
                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                        'options' => ['class' => 'dob', 'placeholder' => 'Date'],
                        'removeButton' => false,
                        'pluginOptions' => [
                          'autoclose' => true,
                          'startView' => 'year',
                          'minViewMode' => 'months',
                          'format' => 'yyyy-mm',
                          'todayHighlight' => true
                        ]
                      ]
                    );
                    ?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <?php $industry = ArrayHelper::map(Masterindustry::find()->asArray()->all(), 'industry_type', 'industry_type');
                    echo   $form->field($modelwexp, "[{$index}]industry")->widget(Select2::classname(), [
                      'data' => $industry,
                      // 'initValueText' => $recruitreqs, // set the initial display text
                      'options' => ['placeholder' => 'Pilih Industri'],
                      'pluginOptions' => [
                        'allowClear' => true,
                      ],
                    ]);
                    ?>
                  </div>
                  <div class="col-md-6">
                    <?= $form->field($modelwexp, "[{$index}]salary")->textInput(["maxlength" => true]) ?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <?= $form->field($modelwexp, "[{$index}]companyaddress")->textArea(["maxlength" => true, 'rows' => '3']) ?>
                  </div>
                  <div class="col-md-6">
                    <?= $form->field($modelwexp, "[{$index}]jobdesc")->textArea(["maxlength" => true, 'rows' => '3']) ?>
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
                <?= Html::a('Back', ['/userskill/cwizard'], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Skip', ['/organizationactivity/cwizard'], ['class' => 'btn btn-default']) ?>
              <?php } ?>
              <?= Html::submitButton((Yii::$app->controller->action->id == 'cwizard' or Yii::$app->controller->action->id == 'uwizard') ? 'Save & Next' : 'Save', ['class' => 'btn btn-success btn']) ?>
            </div>
          </div>
          <?php ActiveForm::end(); ?>
        </div>
      </div>
    <?php endif; ?>
    <!-- end of show edit menu if user as superadmin -->

    <!-- show edit menu if user not hiring yet -->
  <?php else : ?>
    <div class="box box-solid">
      <div class="box-body">

        <?php $form = ActiveForm::begin([
          'options' => [
            'enctype' => 'multipart/form-data',
            'id' => 'workexperience-form'
          ]
        ]); ?>
        <i>*) scroll right and clik new button for add Work Experience</i>
        <?php DynamicFormWidget::begin([
          'widgetContainer' => 'dynamicform_wrapper',
          'widgetBody' => '.form-options-body',
          'widgetItem' => '.form-options-item',
          'min' => 1,
          'limit' => 10,
          'insertButton' => '.add-item',
          'deleteButton' => '.delete-item',
          'model' => $modelwexp[0],
          'formId' => 'workexperience-form',
          'formFields' => [
            'id',

          ],
        ]); ?>
        <div class="form-options-body">
          <?php foreach ($modelwexp as $index => $modelwexp) : ?>
            <?php
            $modelwexp->startdate = substr($modelwexp->startdate, 0, 7);
            $modelwexp->enddate = substr($modelwexp->enddate, 0, 7);
            ?>
            <div class="form-options-item">
              <?php
              if (!$modelwexp->isNewRecord) {
                echo Html::activeHiddenInput($modelwexp, "[{$index}]id");
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
                  <?= $form->field($modelwexp, "[{$index}]companyname")->textInput(["maxlength" => true]) ?>
                </div>
                <div class="col-md-6">
                  <?php $subjobfamily = ArrayHelper::map(Mastersubjobfamily::find()->asArray()->all(), 'subjobfamily', 'subjobfamily');
                  echo   $form->field($modelwexp, "[{$index}]lastposition")->widget(Select2::classname(), [
                    'data' => $subjobfamily,
                    // 'initValueText' => $recruitreqs, // set the initial display text
                    'options' => ['placeholder' => 'Pilih Jabatan Terakhir'],
                    'pluginOptions' => [
                      'allowClear' => true,
                    ],
                  ]);
                  ?>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <?= $form->field($modelwexp, "[{$index}]startdate")->widget(
                    DatePicker::className(),
                    [
                      'type' => DatePicker::TYPE_COMPONENT_APPEND,
                      'options' => ['class' => 'dob', 'placeholder' => 'Date'],
                      'removeButton' => false,
                      'pluginOptions' => [
                        'autoclose' => true,
                        'startView' => 'year',
                        'minViewMode' => 'months',
                        'format' => 'yyyy-mm',
                        'todayHighlight' => true
                      ]
                    ]
                  );
                  ?>
                </div>
                <div class="col-md-6">
                  <?= $form->field($modelwexp, "[{$index}]enddate")->widget(
                    DatePicker::className(),
                    [
                      'type' => DatePicker::TYPE_COMPONENT_APPEND,
                      'options' => ['class' => 'dob', 'placeholder' => 'Date'],
                      'removeButton' => false,
                      'pluginOptions' => [
                        'autoclose' => true,
                        'startView' => 'year',
                        'minViewMode' => 'months',
                        'format' => 'yyyy-mm',
                        'todayHighlight' => true
                      ]
                    ]
                  );
                  ?>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <?php $industry = ArrayHelper::map(Masterindustry::find()->asArray()->all(), 'industry_type', 'industry_type');
                  echo   $form->field($modelwexp, "[{$index}]industry")->widget(Select2::classname(), [
                    'data' => $industry,
                    // 'initValueText' => $recruitreqs, // set the initial display text
                    'options' => ['placeholder' => 'Pilih Industri'],
                    'pluginOptions' => [
                      'allowClear' => true,
                    ],
                  ]);
                  ?>
                </div>
                <div class="col-md-6">
                  <?= $form->field($modelwexp, "[{$index}]salary")->textInput(["maxlength" => true]) ?>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <?= $form->field($modelwexp, "[{$index}]companyaddress")->textArea(["maxlength" => true, 'rows' => '3']) ?>
                </div>
                <div class="col-md-6">
                  <?= $form->field($modelwexp, "[{$index}]jobdesc")->textArea(["maxlength" => true, 'rows' => '3']) ?>
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
              <?= Html::a('Back', ['/userskill/cwizard'], ['class' => 'btn btn-primary']) ?>
              <?= Html::a('Skip', ['/organizationactivity/cwizard'], ['class' => 'btn btn-default']) ?>
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