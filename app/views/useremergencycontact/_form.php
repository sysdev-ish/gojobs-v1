<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Useremergencycontact */
/* @var $form yii\widgets\ActiveForm */
?>
<?php if (Yii::$app->utils->getlayout() == 'main') : ?>
  <div class="box box-header with-border">

    <h3 class="box-title">Emergency Contact</h3>
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
              'id' => 'emergencycontact-form'
            ]
          ]); ?>

          <i>*) scroll right and clik new button for add emergency contact</i>
          <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper',
            'widgetBody' => '.form-options-body',
            'widgetItem' => '.form-options-item',
            'min' => 1,
            'limit' => 10,
            'insertButton' => '.add-item',
            'deleteButton' => '.delete-item',
            'model' => $modeluecontact[0],
            'formId' => 'emergencycontact-form',
            'formFields' => [
              'id',

            ],
          ]); ?>
          <div class="form-options-body">
            <?php foreach ($modeluecontact as $index => $modeluecontact) : ?>

              <div class="form-options-item">
                <?php
                if (!$modeluecontact->isNewRecord) {
                  echo Html::activeHiddenInput($modeluecontact, "[{$index}]id");
                } ?>
                <div class="row">
                  <div class="col-md-12">
                    <div class="text-center pull-right">
                      <button type="button" class="delete-item btn btn-danger btn-sm"><i class="fa fa-minus"></i></button>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <?= $form->field($modeluecontact, "[{$index}]fullname")->textInput(['maxlength' => true]) ?>
                  </div>
                  <div class="col-md-4">
                    <?= $form->field($modeluecontact, "[{$index}]phone")->textInput(['maxlength' => true]) ?>
                  </div>
                  <div class="col-md-4">
                    <?php
                    echo   $form->field($modeluecontact, "[{$index}]relationship")->widget(Select2::classname(), [
                      'data' => ['father' => 'Father', 'mother' => 'Mother', 'siblings' => 'Siblings', 'husband' => 'Husband', 'wife' => 'Wife', 'child' => 'Child'],
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
                    <?php
                    echo   $form->field($modeluecontact, "[{$index}]provinceid")->widget(Select2::classname(), [
                      'data' => $province,
                      'options' => ['placeholder' => '- select -'],
                      'pluginOptions' => [
                        'allowClear' => true
                      ],
                    ]);
                    ?>
                  </div>
                  <div class="col-md-6">
                    <?php
                    echo Html::activeHiddenInput($modeluecontact, "[{$index}]model_id2", ['value' => $modeluecontact->cityid]);

                    $param = 'useremergencycontact-' . $index . '-model_id2';
                    $depends = 'useremergencycontact-' . $index . '-provinceid';
                    // var_dump($param);die;
                    ?>
                    <?= $form->field($modeluecontact, "[{$index}]cityid")->widget(DepDrop::classname(), [
                      'data' => $kota,
                      'type' => DepDrop::TYPE_SELECT2,
                      // 'options' => ['id'=>'cityid'],
                      'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                      'pluginOptions' => [
                        'depends' => [$depends],
                        'placeholder' => 'Select City',
                        'url' => Url::to(['/mastercity/getcity']),
                        'loadingText' => 'Loading ...',
                        'params' => [$param],
                        'initialize' => true,
                      ],
                    ]); ?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <?= $form->field($modeluecontact, "[{$index}]address")->textInput(['maxlength' => true]) ?>
                  </div>
                  <div class="col-md-6">
                    <?= $form->field($modeluecontact, "[{$index}]postalcode")->textInput(['maxlength' => true]) ?>
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
                <?= Html::a('Back', ['/organizationactivity/cwizard'], ['class' => 'btn btn-primary']) ?>
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
            'id' => 'emergencycontact-form'
          ]
        ]); ?>
        <i>*) scroll right and clik new button for add emergency contact</i>
        <?php DynamicFormWidget::begin([
          'widgetContainer' => 'dynamicform_wrapper',
          'widgetBody' => '.form-options-body',
          'widgetItem' => '.form-options-item',
          'min' => 1,
          'limit' => 10,
          'insertButton' => '.add-item',
          'deleteButton' => '.delete-item',
          'model' => $modeluecontact[0],
          'formId' => 'emergencycontact-form',
          'formFields' => [
            'id',

          ],
        ]); ?>
        <div class="form-options-body">
          <?php foreach ($modeluecontact as $index => $modeluecontact) : ?>

            <div class="form-options-item">
              <?php
              if (!$modeluecontact->isNewRecord) {
                echo Html::activeHiddenInput($modeluecontact, "[{$index}]id");
              } ?>
              <div class="row">
                <div class="col-md-12">
                  <div class="text-center pull-right">
                    <button type="button" class="delete-item btn btn-danger btn-sm"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <?= $form->field($modeluecontact, "[{$index}]fullname")->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                  <?= $form->field($modeluecontact, "[{$index}]phone")->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                  <?php
                  echo   $form->field($modeluecontact, "[{$index}]relationship")->widget(Select2::classname(), [
                    'data' => ['father' => 'Father', 'mother' => 'Mother', 'siblings' => 'Siblings', 'husband' => 'Husband', 'wife' => 'Wife', 'child' => 'Child'],
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
                  <?php
                  echo   $form->field($modeluecontact, "[{$index}]provinceid")->widget(Select2::classname(), [
                    'data' => $province,
                    'options' => ['placeholder' => '- select -'],
                    'pluginOptions' => [
                      'allowClear' => true
                    ],
                  ]);
                  ?>
                </div>
                <div class="col-md-6">
                  <?php
                  echo Html::activeHiddenInput($modeluecontact, "[{$index}]model_id2", ['value' => $modeluecontact->cityid]);

                  $param = 'useremergencycontact-' . $index . '-model_id2';
                  $depends = 'useremergencycontact-' . $index . '-provinceid';
                  // var_dump($param);die;
                  ?>
                  <?= $form->field($modeluecontact, "[{$index}]cityid")->widget(DepDrop::classname(), [
                    'data' => $kota,
                    'type' => DepDrop::TYPE_SELECT2,
                    // 'options' => ['id'=>'cityid'],
                    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                    'pluginOptions' => [
                      'depends' => [$depends],
                      'placeholder' => 'Select City',
                      'url' => Url::to(['/mastercity/getcity']),
                      'loadingText' => 'Loading ...',
                      'params' => [$param],
                      'initialize' => true,
                    ],
                  ]); ?>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <?= $form->field($modeluecontact, "[{$index}]address")->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                  <?= $form->field($modeluecontact, "[{$index}]postalcode")->textInput(['maxlength' => true]) ?>
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
              <?= Html::a('Back', ['/organizationactivity/cwizard'], ['class' => 'btn btn-primary']) ?>
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