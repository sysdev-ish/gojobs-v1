<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Userforeignlanguage */
/* @var $form yii\widgets\ActiveForm */
?>
<?php if(Yii::$app->utils->getlayout() == 'main'): ?>
<div class="box box-header with-border">

  <h3 class="box-title">Skill</h3>
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
                  'id'=>'userskill-form'
                ]
              ]); ?>
              <div class="box-footer box-comments" style="margin-bottom:5px;">

                  <span class="username">
                    <?= Yii::t('app', 'Foreign language') ?>

                  </span><!-- /.username -->

              </div>
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
                    'model' => $modelflang[0],
                    'formId' => 'userskill-form',
                    'formFields' => [
                      'id',

                    ],
                  ]); ?>
                  <div style="overflow-x:scroll;">
                    <div class="container-items"><!-- widgetBody -->
                      <i>*) scroll right and clik new button for add formal education</i>
                      <table class="table  table-striped" style="width:1025px;">
                        <tr>
						  <th style="min-width:150px; text-align: center"><?= Yii::t('app', 'Language') ?></th>
						  <th style="min-width:150px; text-align: center"><?= Yii::t('app', 'Speaking') ?></th>
						  <th style="min-width:150px; text-align: center"><?= Yii::t('app', 'Writing') ?></th>
						  <th style="min-width:150px; text-align: center"><?= Yii::t('app', 'Reading') ?></th>
						  <th style="min-width:150px; text-align: center"><?= Yii::t('app', 'Understanding') ?></th>
						  <th style="min-width:50px; text-align: center"><?= Yii::t('app', 'Action') ?></th>	
                        </tr>
                        <tbody class="form-options-body">
                          <?php foreach ($modelflang as $index => $modelflang): ?>

                            <tr class="form-options-item">
                              <?php
                              if (! $modelflang->isNewRecord) {
                                echo Html::activeHiddenInput($modelflang, "[{$index}]id");
                              }?>
                              <td class="vcenter">
                                <?= $form->field($modelflang, "[{$index}]language")->label(false)->textInput(["maxlength" => true]) ?>
                              </td>
                              <td class="vcenter">
                                <?= $form->field($modelflang, "[{$index}]speaking")->radioList([1 => 'Active', 2 => 'Passive'])->label(false); ?>
                              </td>
                              <td class="vcenter">
                                <?= $form->field($modelflang, "[{$index}]writing")->radioList([1 => 'Active', 2 => 'Passive'])->label(false); ?>
                              </td>
                              <td class="vcenter">
                                <?= $form->field($modelflang, "[{$index}]reading")->radioList([1 => 'Active', 2 => 'Passive'])->label(false); ?>
                              </td>
                              <td class="vcenter">
                                <?= $form->field($modelflang, "[{$index}]understanding")->radioList([1 => 'Active', 2 => 'Passive'])->label(false); ?>
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
              <div class="box-footer box-comments" style="margin-bottom:5px; margin-top:20px;">

                  <span class="username">
                    <?= Yii::t('app', 'English Language Skill') ?>
                  </span><!-- /.username -->
                <!-- /.comment-text -->

              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-12">
                    <?= $form->field($modeleskill, "havetoefl")->radioList([1 => 'Yes', 2 => 'No'])->label(Yii::t('app', 'Do you take the TOEFL Exam?')); ?>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="col-md-4">
                    <?= $form->field($modeleskill, 'testtoefldate')->widget(
                      DatePicker::className(), [
                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                        'options' => ['placeholder' => 'Date'],
                        'pluginOptions' => [
                          'autoclose' => true,
                          'format' => 'yyyy-mm-dd',
                          'todayHighlight' => true
                        ]
                      ]);
                      ?>
                    </div>
                    <div class="col-md-4">
                      <?= $form->field($modeleskill, 'institutions')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-4">
                      <?= $form->field($modeleskill, 'toeflscore')->textInput() ?>
                    </div>
                  </div>
                </div>
                <div class="box-footer box-comments" style="margin-bottom:5px; margin-top:20px;">

                  <!-- <div class="comment-text"> -->
                    <span class="username">
                      <?= Yii::t('app', 'Computer Skill') ?>
                    </span><!-- /.username -->
                  <!-- </div> -->
                  <!-- /.comment-text -->

                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-2">
                      <?= $form->field($modelcskill, 'msword')->checkbox(); ?>
                    </div>
                    <div class="col-md-2">
                      <?= $form->field($modelcskill, 'msexcel')->checkbox(); ?>
                    </div>
                    <div class="col-md-2">
                      <?= $form->field($modelcskill, 'mspowerpoint')->checkbox(); ?>
                    </div>
                    <div class="col-md-2">
                      <?= $form->field($modelcskill, 'sql')->checkbox(); ?>
                    </div>
                    <div class="col-md-2">
                      <?= $form->field($modelcskill, 'lan')->checkbox(); ?>
                    </div>
                    <div class="col-md-2">
                      <?= $form->field($modelcskill, 'wan')->checkbox(); ?>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="col-md-2">
                      <?= $form->field($modelcskill, 'pascal')->checkbox(); ?>
                    </div>
                    <div class="col-md-2">
                      <?= $form->field($modelcskill, 'clanguage')->checkbox(); ?>
                    </div>
                    <div class="col-md-2">
                      <?= $form->field($modelcskill, 'android')->checkbox(); ?>
                    </div>
                    <div class="col-md-2">
                      <?= $form->field($modelcskill, 'php')->checkbox(); ?>
                    </div>
                    <div class="col-md-2">
                      <?= $form->field($modelcskill, 'java')->checkbox(); ?>
                    </div>
                    <div class="col-md-12">
                      <?= $form->field($modelcskill, 'others')->textInput(['maxlength' => true]) ?>
                    </div>

                  </div>
                  <div class="col-md-12">
                    <div class="col-md-12">
					  <?= $form->field($modelcskill, "internetknowledge")->radioList([1 => Yii::t('skill', 'Less'), 2 => Yii::t('skill', 'Moderate'), 3 =>  Yii::t('skill', 'Good') ]); ?>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="col-md-12">
                      <?= $form->field($modelcskill, 'usinginternetpurpose')->textInput(['maxlength' => true]) ?>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="col-md-12">
                      <?= $form->field($modelcskill, 'usinginternetfrequency')->textInput(['maxlength' => true]) ?>
                    </div>
                  </div>
                </div>
                <div class="box-footer">
                  <div class="pull-right">
                    <?php if (Yii::$app->controller->action->id == 'cwizard' or Yii::$app->controller->action->id == 'uwizard'){?>
                    <?= Html::a('Back', ['/usernonformaleducation/cwizard'], ['class' => 'btn btn-primary']) ?>
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
                  'id'=>'userskill-form'
                ]
              ]); ?>
              <div class="box-footer box-comments" style="margin-bottom:5px;">

                  <span class="username">
                    <?= Yii::t('app', 'Foreign language') ?>

                  </span><!-- /.username -->

              </div>
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
                    'model' => $modelflang[0],
                    'formId' => 'userskill-form',
                    'formFields' => [
                      'id',

                    ],
                  ]); ?>
                  <div style="overflow-x:scroll;">
                    <div class="container-items"><!-- widgetBody -->
                      <i>*) scroll right and clik new button for add formal education</i>
                      <table class="table  table-striped" style="width:1025px;">
                        <tr>
						  <th style="min-width:150px; text-align: center"><?= Yii::t('app', 'Language') ?></th>
                          <th style="min-width:150px; text-align: center"><?= Yii::t('app', 'Speaking') ?></th>
                          <th style="min-width:150px; text-align: center"><?= Yii::t('app', 'Writing') ?></th>
                          <th style="min-width:150px; text-align: center"><?= Yii::t('app', 'Reading') ?></th>
                          <th style="min-width:150px; text-align: center"><?= Yii::t('app', 'Understanding') ?></th>
                          <th style="min-width:50px; text-align: center"><?= Yii::t('app', 'Action') ?></th>
                        </tr>
                        <tbody class="form-options-body">
                          <?php foreach ($modelflang as $index => $modelflang): ?>

                            <tr class="form-options-item">
                              <?php
                              if (! $modelflang->isNewRecord) {
                                echo Html::activeHiddenInput($modelflang, "[{$index}]id");
                              }?>
                              <td class="vcenter">
                                <?= $form->field($modelflang, "[{$index}]language")->label(false)->textInput(["maxlength" => true]) ?>
                              </td>
                              <td class="vcenter">
                                <?= $form->field($modelflang, "[{$index}]speaking")->radioList([1 => 'Active', 2 => 'Passive'])->label(false); ?>
                              </td>
                              <td class="vcenter">
                                <?= $form->field($modelflang, "[{$index}]writing")->radioList([1 => 'Active', 2 => 'Passive'])->label(false); ?>
                              </td>
                              <td class="vcenter">
                                <?= $form->field($modelflang, "[{$index}]reading")->radioList([1 => 'Active', 2 => 'Passive'])->label(false); ?>
                              </td>
                              <td class="vcenter">
                                <?= $form->field($modelflang, "[{$index}]understanding")->radioList([1 => 'Active', 2 => 'Passive'])->label(false); ?>
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
              <div class="box-footer box-comments" style="margin-bottom:5px; margin-top:20px;">

                  <span class="username">
                    <?= Yii::t('app', 'English Language Skill') ?>
                  </span><!-- /.username -->
                <!-- /.comment-text -->

              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-12">
					<?= $form->field($modeleskill, "havetoefl")->radioList([1 => 'Yes', 2 => 'No'])->label(Yii::t('app', 'Do you take the TOEFL Exam?')); ?>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="col-md-4">
                    <?= $form->field($modeleskill, 'testtoefldate')->widget(
                      DatePicker::className(), [
                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                        'options' => ['placeholder' => 'Date'],
                        'pluginOptions' => [
                          'autoclose' => true,
                          'format' => 'yyyy-mm-dd',
                          'todayHighlight' => true
                        ]
                      ]);
                      ?>
                    </div>
                    <div class="col-md-4">
                      <?= $form->field($modeleskill, 'institutions')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-4">
                      <?= $form->field($modeleskill, 'toeflscore')->textInput() ?>
                    </div>
                  </div>
                </div>
                <div class="box-footer box-comments" style="margin-bottom:5px; margin-top:20px;">

                  <!-- <div class="comment-text"> -->
                    <span class="username">
                      <?= Yii::t('app', 'Computer Skill') ?>
                    </span><!-- /.username -->
                  <!-- </div> -->
                  <!-- /.comment-text -->

                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-2">
                      <?= $form->field($modelcskill, 'msword')->checkbox(); ?>
                    </div>
                    <div class="col-md-2">
                      <?= $form->field($modelcskill, 'msexcel')->checkbox(); ?>
                    </div>
                    <div class="col-md-2">
                      <?= $form->field($modelcskill, 'mspowerpoint')->checkbox(); ?>
                    </div>
                    <div class="col-md-2">
                      <?= $form->field($modelcskill, 'sql')->checkbox(); ?>
                    </div>
                    <div class="col-md-2">
                      <?= $form->field($modelcskill, 'lan')->checkbox(); ?>
                    </div>
                    <div class="col-md-2">
                      <?= $form->field($modelcskill, 'wan')->checkbox(); ?>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="col-md-2">
                      <?= $form->field($modelcskill, 'pascal')->checkbox(); ?>
                    </div>
                    <div class="col-md-2">
                      <?= $form->field($modelcskill, 'clanguage')->checkbox(); ?>
                    </div>
                    <div class="col-md-2">
                      <?= $form->field($modelcskill, 'android')->checkbox(); ?>
                    </div>
                    <div class="col-md-2">
                      <?= $form->field($modelcskill, 'php')->checkbox(); ?>
                    </div>
                    <div class="col-md-2">
                      <?= $form->field($modelcskill, 'java')->checkbox(); ?>
                    </div>
                    <div class="col-md-12">
                      <?= $form->field($modelcskill, 'others')->textInput(['maxlength' => true]) ?>
                    </div>

                  </div>
                  <div class="col-md-12">
                    <div class="col-md-12">
						<?= $form->field($modelcskill, "internetknowledge")->radioList([1 => Yii::t('skill', 'Less'), 2 => Yii::t('skill', 'Moderate'), 3 =>  Yii::t('skill', 'Good') ]); ?>	
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="col-md-12">
                      <?= $form->field($modelcskill, 'usinginternetpurpose')->textInput(['maxlength' => true]) ?>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="col-md-12">
                      <?= $form->field($modelcskill, 'usinginternetfrequency')->textInput(['maxlength' => true]) ?>
                    </div>
                  </div>
                </div>
                <div class="box-footer">
                  <div class="pull-right">
                    <?php if (Yii::$app->controller->action->id == 'cwizard' or Yii::$app->controller->action->id == 'uwizard'){?>
                    <?= Html::a('Back', ['/usernonformaleducation/cwizard'], ['class' => 'btn btn-primary']) ?>
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
