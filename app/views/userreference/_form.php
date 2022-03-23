<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Userreference */
/* @var $form yii\widgets\ActiveForm */
?>
<?php if(Yii::$app->utils->getlayout() == 'main'): ?>
<div class="box box-header with-border">

  <h3 class="box-title">Reference</h3>
</div>
<?php endif; ?>

<!-- validation rule -->
  <?php if(Yii::$app->user->isGuest){
    $role = null;
  }else{
    $role = Yii::$app->user->identity->role;
  } ?>
<!-- end validation rule -->

<!-- show no data if user was hiring -->
  <?php if($model) :?>
    <?php if (Yii::$app->utils->aplhired($userid)) :?>
      <div class="box box-header with-border">
        <center><h3 class="box-title">No Data</h3></center>
      </div>
<!-- end of show no data if user was hiring -->

      <!-- show edit menu if user as superadmin -->
        <?php if (Yii::$app->utils->permission($role,'m49')):?>
          <div class="box box-solid">
            <div class="box-body">

              <?php $form = ActiveForm::begin([
                'options'=>[
                  'enctype'=>'multipart/form-data',
                  'id'=>'reference-form'
                ]
              ]); ?>

              <div class="row">

                <div class="col-md-12">
                  <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper',
                    'widgetBody' => '.form-options-body',
                    'widgetItem' => '.form-options-item',
                    'min' => 1,
                    'limit' => 10,
                    'insertButton' => '.add-item',
                    'deleteButton' => '.delete-item',
                    'model' => $modelureff[0],
                    'formId' => 'reference-form',
                    'formFields' => [
                      'id',

                    ],
                  ]); ?>
                  <div style="width:100%; overflow-x:scroll;">
                    <div class="container-items"><!-- widgetBody -->
                      <i>*) scroll right and clik new button for add formal education</i>
                      <table class="table  table-striped" style="min-width:1124px;">
                        <tr>
							<th style="width:150px; text-align: center"><?= Yii::t('app', 'Full name') ?></th>
							<th style="width:150px; text-align: center"><?= Yii::t('app', 'Address') ?></th>
							<th style="width:150px; text-align: center"><?= Yii::t('app', 'Phone') ?></th>
							<th style="width:150px; text-align: center"><?= Yii::t('app', 'Job Title') ?></th>
							<th style="width:150px; text-align: center"><?= Yii::t('app', 'Relationship') ?></th>
							<th style="width:50px; text-align: center"><?= Yii::t('app', 'Action') ?></th>
                        </tr>
                        <tbody class="form-options-body">
                          <?php foreach ($modelureff as $index => $modelureff): ?>

                            <tr class="form-options-item">
                              <?php
                              if (! $modelureff->isNewRecord) {
                                echo Html::activeHiddenInput($modelureff, "[{$index}]id");
                              }?>
                              <td class="vcenter">
                                <?= $form->field($modelureff, "[{$index}]fullname")->label(false)->textInput(['maxlength' => true]) ?>
                              </td>
                              <td class="vcenter">
                                <?= $form->field($modelureff, "[{$index}]address")->label(false)->textInput(['maxlength' => true]) ?>
                              </td>
                              <td class="vcenter">
                                <?= $form->field($modelureff, "[{$index}]phone")->label(false)->textInput(['maxlength' => true]) ?>
                              </td>
                              <td class="vcenter">
                                <?= $form->field($modelureff, "[{$index}]jobtitle")->label(false)->textInput(['maxlength' => true]) ?>
                              </td>
                              <td class="vcenter">
                                <?php
                                echo   $form->field($modelureff, "[{$index}]relationship")->label(false)->widget(Select2::classname(), [
                                  'data' => [ 'father' => 'Father', 'mother' => 'Mother', 'siblings' => 'Siblings', 'husband' => 'Husband', 'wife' => 'Wife', 'child' => 'Child'],
                                  'options' => ['placeholder' => '- select -'],
                                  'pluginOptions' => [
                                    'allowClear' => true
                                  ],
                                ]);
                                ?>
                              </td>
                              <td class="text-center vcenter">
                                <button type="button" class="delete-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                              </td>

                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="5"></td>
                            <td style="text-align: center"><button type="button" class="add-item btn btn-success btn-sm"><span class="fa fa-plus"></span> New</button></td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                  <?php DynamicFormWidget::end(); ?>
                </div>
              </div>
                <div class="box-footer" style="margin-top:20px;">
                  <div class="pull-right">
                    <?php if (Yii::$app->controller->action->id == 'cwizard' or Yii::$app->controller->action->id == 'uwizard'){?>
                    <?= Html::a('Back', ['/useremergencycontact/cwizard'], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Skip', ['/useraddinfo/cwizard'], ['class' => 'btn btn-default']) ?>
                    <?php } ?>
                    <?= Html::submitButton((Yii::$app->controller->action->id == 'cwizard' or Yii::$app->controller->action->id == 'uwizard') ? 'Save & Next':'Save', ['class' => 'btn btn-success btn']) ?>
                  </div>
                </div>
                <?php ActiveForm::end(); ?>
              </div>
            </div>
        <?php endif; ?>
      <!-- end of show edit menu if user as superadmin -->

<!-- show edit menu if user not hiring yet -->
  <?php else :?>
    <div class="box box-solid">
      <div class="box-body">

        <?php $form = ActiveForm::begin([
          'options'=>[
            'enctype'=>'multipart/form-data',
            'id'=>'reference-form'
          ]
        ]); ?>

        <div class="row">

          <div class="col-md-12">
            <?php DynamicFormWidget::begin([
              'widgetContainer' => 'dynamicform_wrapper',
              'widgetBody' => '.form-options-body',
              'widgetItem' => '.form-options-item',
              'min' => 1,
              'limit' => 10,
              'insertButton' => '.add-item',
              'deleteButton' => '.delete-item',
              'model' => $modelureff[0],
              'formId' => 'reference-form',
              'formFields' => [
                'id',

              ],
            ]); ?>
            <div style="width:100%; overflow-x:scroll;">
              <div class="container-items"><!-- widgetBody -->
                <i>*) scroll right and clik new button for add formal education</i>
                <table class="table  table-striped" style="min-width:1124px;">
                  <tr>
					<th style="width:150px; text-align: center"><?= Yii::t('app', 'Full name') ?></th>
					<th style="width:150px; text-align: center"><?= Yii::t('app', 'Address') ?></th>
					<th style="width:150px; text-align: center"><?= Yii::t('app', 'Phone') ?></th>
					<th style="width:150px; text-align: center"><?= Yii::t('app', 'Job Title') ?></th>
					<th style="width:150px; text-align: center"><?= Yii::t('app', 'Relationship') ?></th>
					<th style="width:50px; text-align: center"><?= Yii::t('app', 'Action') ?></th>
                  </tr>
                  <tbody class="form-options-body">
                    <?php foreach ($modelureff as $index => $modelureff): ?>

                      <tr class="form-options-item">
                        <?php
                        if (! $modelureff->isNewRecord) {
                          echo Html::activeHiddenInput($modelureff, "[{$index}]id");
                        }?>
                        <td class="vcenter">
                          <?= $form->field($modelureff, "[{$index}]fullname")->label(false)->textInput(['maxlength' => true]) ?>
                        </td>
                        <td class="vcenter">
                          <?= $form->field($modelureff, "[{$index}]address")->label(false)->textInput(['maxlength' => true]) ?>
                        </td>
                        <td class="vcenter">
                          <?= $form->field($modelureff, "[{$index}]phone")->label(false)->textInput(['maxlength' => true]) ?>
                        </td>
                        <td class="vcenter">
                          <?= $form->field($modelureff, "[{$index}]jobtitle")->label(false)->textInput(['maxlength' => true]) ?>
                        </td>
                        <td class="vcenter">
                          <?php
                          echo   $form->field($modelureff, "[{$index}]relationship")->label(false)->widget(Select2::classname(), [
                            'data' => [ 'father' => 'Father', 'mother' => 'Mother', 'siblings' => 'Siblings', 'husband' => 'Husband', 'wife' => 'Wife', 'child' => 'Child'],
                            'options' => ['placeholder' => '- select -'],
                            'pluginOptions' => [
                              'allowClear' => true
                            ],
                          ]);
                          ?>
                        </td>
                        <td class="text-center vcenter">
                          <button type="button" class="delete-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="5"></td>
                      <td style="text-align: center"><button type="button" class="add-item btn btn-success btn-sm"><span class="fa fa-plus"></span> New</button></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
            <?php DynamicFormWidget::end(); ?>
          </div>
        </div>
          <div class="box-footer" style="margin-top:20px;">
            <div class="pull-right">
              <?php if (Yii::$app->controller->action->id == 'cwizard' or Yii::$app->controller->action->id == 'uwizard'){?>
              <?= Html::a('Back', ['/useremergencycontact/cwizard'], ['class' => 'btn btn-primary']) ?>
              <?= Html::a('Skip', ['/useraddinfo/cwizard'], ['class' => 'btn btn-default']) ?>
              <?php } ?>
              <?= Html::submitButton((Yii::$app->controller->action->id == 'cwizard' or Yii::$app->controller->action->id == 'uwizard') ? 'Save & Next':'Save', ['class' => 'btn btn-success btn']) ?>
            </div>
          </div>
          <?php ActiveForm::end(); ?>
        </div>
      </div>
<!-- end of show edit menu if user not hiring yet -->

    <?php endif; ?>
  <?php endif; ?>
