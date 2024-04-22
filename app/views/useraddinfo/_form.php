<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use kartik\file\FileInput;


/* @var $this yii\web\View */
/* @var $model app\models\Userhealth */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box box-header with-border">

  <h3 class="box-title"><?= Yii::t('app', 'Additional Info') ?></h3>
</div>

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
              'id' => 'useraddinfo-form'
            ]
          ]); ?>
          <div class="box-footer box-comments" style="margin-bottom:5px;">

            <span class="username">
              <?= Yii::t('app', 'Medical History') ?>

            </span><!-- /.username -->

          </div>
          <div class="row">

            <div class="col-md-12">
              <div class="col-md-6">
                <?= $form->field($model, 'sick')->radioList([1 => 'Yes', 2 => 'No']); ?>
              </div>
              <div class="col-md-6">
                <?= $form->field($model, 'when')->textInput(['maxlength' => true]) ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="col-md-6">
                <?= $form->field($model, 'effect')->textInput(['maxlength' => true]) ?>
              </div>
              <div class="col-md-6">
                <?= $form->field($model, 'illnessdesc')->textArea(['maxlength' => true, 'rows' => '3']) ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="col-md-6">
                <?= $form->field($model, 'accident')->radioList([1 => 'Yes', 2 => 'No']); ?>
              </div>
              <div class="col-md-6">
                <?= $form->field($model, 'whenaccident')->textInput(['maxlength' => true]) ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="col-md-6">
                <?= $form->field($model, 'efffectaccident')->textInput(['maxlength' => true]) ?>
              </div>
              <div class="col-md-6">
                <?= $form->field($model, 'accidentdesc')->textArea(['maxlength' => true, 'rows' => '3']) ?>
              </div>
            </div>

          </div>
          <div class="box-footer box-comments" style="margin-bottom:5px;">

            <span class="username">
              About You

            </span><!-- /.username -->

          </div>
          <div class="row">

            <div class="col-md-12">
              <div class="col-md-6">
                <?= $form->field($modelabout, 'strengths')->textArea(['maxlength' => true, 'rows' => '3']) ?>
              </div>
              <div class="col-md-6">
                <?= $form->field($modelabout, 'weakness')->textArea(['maxlength' => true, 'rows' => '3']) ?>
              </div>
              <div class="col-md-12">
                <?= $form->field($modelabout, 'ambitionandhopefullness')->textArea(['maxlength' => true, 'rows' => '3']) ?>
              </div>
            </div>
          </div>
          <div class="box-footer box-comments" style="margin-bottom:5px;">

            <span class="username">
              Other people's opinions about you

            </span><!-- /.username -->

          </div>
          <div class="row">

            <div class="col-md-12">
              <div class="col-md-6">
                <?= $form->field($modelabout, 'strengthsopinion')->textArea(['maxlength' => true, 'rows' => '3']) ?>
              </div>
              <div class="col-md-6">
                <?= $form->field($modelabout, 'weaknessopinion')->textArea(['maxlength' => true, 'rows' => '3']) ?>
              </div>
            </div>
          </div>
          <div class="box-footer box-comments" style="margin-bottom:5px;">

            <span class="username">
              Other Information

            </span><!-- /.username -->

          </div>
          <div class="row">

            <div class="col-md-12">
              <div class="col-md-6">
                <?= $form->field($modelabout, 'specialskills')->textArea(['maxlength' => true, 'rows' => '3']) ?>
              </div>
              <div class="col-md-6">
                <?= $form->field($modelabout, 'yourgoals')->textArea(['maxlength' => true, 'rows' => '3']) ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="col-md-6">
                <?= $form->field($modelabout, 'activityinsparetime')->textArea(['maxlength' => true, 'rows' => '3']) ?>
              </div>
              <div class="col-md-6">
                <?= $form->field($modelabout, 'hobby')->textArea(['maxlength' => true, 'rows' => '3']) ?>
              </div>
            </div>
          </div>
          <div class="box-footer box-comments" style="margin-bottom:5px;">

            <span class="username">
              About Job

            </span><!-- /.username -->

          </div>
          <div class="row">

            <div class="col-md-12">
              <div class="col-md-6">
                <?= $form->field($modelabout, 'readyshift')->radioList([1 => 'Yes', 2 => 'No']); ?>
              </div>
              <div class="col-md-6">
                <?= $form->field($modelabout, 'readyovertime')->radioList([1 => 'Yes', 2 => 'No']); ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="col-md-6">
                <?= $form->field($modelabout, 'readyoverstay')->radioList([1 => 'Yes', 2 => 'No']); ?>
              </div>
              <div class="col-md-6">
                <?= $form->field($modelabout, 'readyoutcity')->radioList([1 => 'Yes', 2 => 'No']); ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="col-md-6">
                <?= $form->field($modelabout, 'joblikeskill')->textArea(['maxlength' => true, 'rows' => '3']) ?>
              </div>
              <div class="col-md-6">
                <?= $form->field($modelabout, 'jobunlikeskill')->textArea(['maxlength' => true, 'rows' => '3']) ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="col-md-3">
                <?php
                echo   $form->field($modelabout, "havepsikotest")->widget(Select2::classname(), [
                  'data' => [
                    1 => 'Yes',
                    2 => 'No'
                  ],
                  'options' => ['placeholder' => '- select -'],
                  'pluginOptions' => [
                    'allowClear' => true
                  ],
                ]);
                ?>
              </div>
              <div class="col-md-3">
                <?= $form->field($modelabout, 'whenpsikotest')->widget(
                  DatePicker::className(),
                  [
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                    'options' => ['placeholder' => 'Date'],
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
                <?= $form->field($modelabout, 'purposepsikotest')->textInput(['maxlength' => true]) ?>
              </div>

            </div>
            <div class="col-md-12">
              <div class="col-md-6">
                <?= $form->field($modelabout, 'expectsalary')->textInput(['maxlength' => true]) ?>
              </div>
              <div class="col-md-6">
                <?php
                echo   $form->field($modelabout, "readyforwork")->widget(Select2::classname(), [
                  'data' => [
                    'Immediately' => 'Immediately',
                    '1 Weeks from Now' => '1 Week from Now',
                    '2 Weeks from Now' => '2 Week from Now',
                    '1 Month from Now' => '1 Month from Now',
                  ],
                  'options' => ['placeholder' => '- select -'],
                  'pluginOptions' => [
                    'allowClear' => true
                  ],
                ]);
                ?>
              </div>
            </div>

            <div class="col-md-12">
              <div class="col-md-6">
                <?php
                echo   $form->field($modelabout, "bankid")->widget(Select2::classname(), [
                  'data' => $bank,
                  'options' => ['placeholder' => '- select -'],
                  'pluginOptions' => [
                    'allowClear' => true
                  ],
                ]);
                ?>
              </div>
              <div class="col-md-6">
                <?= $form->field($modelabout, 'bankaccountnumber')->textInput(['maxlength' => false]) ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="col-md-12">
                <?php if (!$modelabout->isNewRecord) : ?>
                  <?php

                  $type = '';
                  $file = '';
                  $asdata = false;
                  $assetUrl = Yii::$app->request->baseUrl;
                  if (!empty($modelabout->passbook)) {
                    $type = substr($modelabout->passbook, strrpos($modelabout->passbook, '.') + 1);
                    if ($type == 'pdf') {
                      $asdata = true;
                      $file = $assetUrl . '/app/assets/upload/bankaccount/' . $modelabout->passbook;
                    } else {
                      $asdata = false;
                      $file = Html::img($assetUrl . '/app/assets/upload/bankaccount/' . $modelabout->passbook, ['width' => '150']);
                    }
                  }
                  ?>

                  <?= $form->field($modelabout, 'passbook')->widget(FileInput::className(), [
                    'options' => ['accept' => ''],
                    'pluginOptions' => [
                      'showRemove' => false,
                      // 'theme' => 'explorer-fa',
                      'showUpload' => false,
                      'showCancel' => false,
                      'showPreview' => true,
                      'overwriteInitial' => true,
                      'previewFileType' => 'any',
                      'initialPreviewAsData' => $asdata,
                      'initialPreview' => $file,
                      'initialPreviewConfig' => [
                        ['type' => $type, 'caption' => $modelabout->passbook, 'deleteUrl' => false],
                      ],
                      'uploadAsync' => true,
                      // 'maxFileSize' => 10*1024*1024,
                      'allowedExtensions' => ['jpg', 'png', 'jpeg', 'pdf'],
                    ]
                  ]) ?>
                <?php else : ?>
                  <?= $form->field($modelabout, 'passbook')->widget(FileInput::classname(), [
                    'options' => ['accept' => ''],
                    'pluginOptions' => [
                      'showUpload' => false,
                      'showCaption' => true,
                      'showRemove' => true,
                    ]
                  ]); ?>
                <?php endif; ?>
              </div>
            </div>

            <div class="col-md-12">
              <div class="col-md-12">
                <?php
                echo   $form->field($modelabout, "infoofrecruitmentid")->widget(Select2::classname(), [
                  'data' => $infoofrecruitment,
                  'options' => ['placeholder' => '- select -'],
                  'pluginOptions' => [
                    'allowClear' => true
                  ],
                ]);
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="box-footer">
          <div class="pull-right">
            <?php if (Yii::$app->controller->action->id == 'cwizard' or Yii::$app->controller->action->id == 'uwizard') { ?>
              <?= Html::a('Back', ['/userworkexperience/cwizard'], ['class' => 'btn btn-primary']) ?>
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
            'id' => 'useraddinfo-form'
          ]
        ]); ?>
        <div class="box-footer box-comments" style="margin-bottom:5px;">

          <span class="username">
            Medical History

          </span><!-- /.username -->

        </div>
        <div class="row">

          <div class="col-md-12">
            <div class="col-md-6">
              <?= $form->field($model, 'sick')->radioList([1 => 'Yes', 2 => 'No']); ?>
            </div>
            <div class="col-md-6">
              <?= $form->field($model, 'when')->textInput(['maxlength' => true]) ?>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-6">
              <?= $form->field($model, 'effect')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
              <?= $form->field($model, 'illnessdesc')->textArea(['maxlength' => true, 'rows' => '3']) ?>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-6">
              <?= $form->field($model, 'accident')->radioList([1 => 'Yes', 2 => 'No']); ?>
            </div>
            <div class="col-md-6">
              <?= $form->field($model, 'whenaccident')->textInput(['maxlength' => true]) ?>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-6">
              <?= $form->field($model, 'efffectaccident')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
              <?= $form->field($model, 'accidentdesc')->textArea(['maxlength' => true, 'rows' => '3']) ?>
            </div>
          </div>

        </div>
        <div class="box-footer box-comments" style="margin-bottom:5px;">

          <span class="username">
            About You

          </span><!-- /.username -->

        </div>
        <div class="row">

          <div class="col-md-12">
            <div class="col-md-6">
              <?= $form->field($modelabout, 'strengths')->textArea(['maxlength' => true, 'rows' => '3']) ?>
            </div>
            <div class="col-md-6">
              <?= $form->field($modelabout, 'weakness')->textArea(['maxlength' => true, 'rows' => '3']) ?>
            </div>
            <div class="col-md-12">
              <?= $form->field($modelabout, 'ambitionandhopefullness')->textArea(['maxlength' => true, 'rows' => '3']) ?>
            </div>


          </div>
        </div>
        <div class="box-footer box-comments" style="margin-bottom:5px;">

          <span class="username">
            Other people's opinions about you

          </span><!-- /.username -->

        </div>
        <div class="row">

          <div class="col-md-12">
            <div class="col-md-6">
              <?= $form->field($modelabout, 'strengthsopinion')->textArea(['maxlength' => true, 'rows' => '3']) ?>
            </div>
            <div class="col-md-6">
              <?= $form->field($modelabout, 'weaknessopinion')->textArea(['maxlength' => true, 'rows' => '3']) ?>
            </div>
          </div>
        </div>
        <div class="box-footer box-comments" style="margin-bottom:5px;">

          <span class="username">
            Other Information

          </span><!-- /.username -->

        </div>
        <div class="row">

          <div class="col-md-12">
            <div class="col-md-6">
              <?= $form->field($modelabout, 'specialskills')->textArea(['maxlength' => true, 'rows' => '3']) ?>
            </div>
            <div class="col-md-6">
              <?= $form->field($modelabout, 'yourgoals')->textArea(['maxlength' => true, 'rows' => '3']) ?>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-6">
              <?= $form->field($modelabout, 'activityinsparetime')->textArea(['maxlength' => true, 'rows' => '3']) ?>
            </div>
            <div class="col-md-6">
              <?= $form->field($modelabout, 'hobby')->textArea(['maxlength' => true, 'rows' => '3']) ?>
            </div>
          </div>
        </div>
        <div class="box-footer box-comments" style="margin-bottom:5px;">

          <span class="username">
            About Job

          </span><!-- /.username -->

        </div>
        <div class="row">

          <div class="col-md-12">
            <div class="col-md-6">
              <?= $form->field($modelabout, 'readyshift')->radioList([1 => 'Yes', 2 => 'No']); ?>
            </div>
            <div class="col-md-6">
              <?= $form->field($modelabout, 'readyovertime')->radioList([1 => 'Yes', 2 => 'No']); ?>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-6">
              <?= $form->field($modelabout, 'readyoverstay')->radioList([1 => 'Yes', 2 => 'No']); ?>
            </div>
            <div class="col-md-6">
              <?= $form->field($modelabout, 'readyoutcity')->radioList([1 => 'Yes', 2 => 'No']); ?>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-6">
              <?= $form->field($modelabout, 'joblikeskill')->textArea(['maxlength' => true, 'rows' => '3']) ?>
            </div>
            <div class="col-md-6">
              <?= $form->field($modelabout, 'jobunlikeskill')->textArea(['maxlength' => true, 'rows' => '3']) ?>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-3">
              <?php
              echo   $form->field($modelabout, "havepsikotest")->widget(Select2::classname(), [
                'data' => [
                  1 => 'Yes',
                  2 => 'No'
                ],
                'options' => ['placeholder' => '- select -'],
                'pluginOptions' => [
                  'allowClear' => true
                ],
              ]);
              ?>
            </div>
            <div class="col-md-3">
              <?= $form->field($modelabout, 'whenpsikotest')->widget(
                DatePicker::className(),
                [
                  'type' => DatePicker::TYPE_COMPONENT_APPEND,
                  'options' => ['placeholder' => 'Date'],
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
              <?= $form->field($modelabout, 'purposepsikotest')->textInput(['maxlength' => true]) ?>
            </div>

          </div>
          <div class="col-md-12">
            <div class="col-md-6">
              <?= $form->field($modelabout, 'expectsalary')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
              <?php
              echo   $form->field($modelabout, "readyforwork")->widget(Select2::classname(), [
                'data' => [
                  'Immediately' => 'Immediately',
                  '1 Weeks from Now' => '1 Week from Now',
                  '2 Weeks from Now' => '2 Week from Now',
                  '1 Month from Now' => '1 Month from Now',
                ],
                'options' => ['placeholder' => '- select -'],
                'pluginOptions' => [
                  'allowClear' => true
                ],
              ]);
              ?>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-6">
              <?php
              echo   $form->field($modelabout, "bankid")->widget(Select2::classname(), [
                'data' => $bank,
                'options' => ['placeholder' => '- select -'],
                'pluginOptions' => [
                  'allowClear' => true
                ],
              ]);
              ?>
            </div>
            <div class="col-md-6">
              <?= $form->field($modelabout, 'bankaccountnumber')->textInput(['maxlength' => false]) ?>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-12">
              <?php if (!$modelabout->isNewRecord) : ?>
                <?php

                $type = '';
                $file = '';
                $asdata = false;
                $assetUrl = Yii::$app->request->baseUrl;
                if (!empty($modelabout->passbook)) {
                  $type = substr($modelabout->passbook, strrpos($modelabout->passbook, '.') + 1);
                  if ($type == 'pdf') {
                    $asdata = true;
                    $file = $assetUrl . '/app/assets/upload/bankaccount/' . $modelabout->passbook;
                  } else {
                    $asdata = false;
                    $file = Html::img($assetUrl . '/app/assets/upload/bankaccount/' . $modelabout->passbook, ['width' => '150']);
                  }
                }
                ?>

                <?= $form->field($modelabout, 'passbook')->widget(FileInput::className(), [
                  'options' => ['accept' => ''],
                  'pluginOptions' => [
                    'showRemove' => false,
                    // 'theme' => 'explorer-fa',
                    'showUpload' => false,
                    'showCancel' => false,
                    'showPreview' => true,
                    'overwriteInitial' => true,
                    'previewFileType' => 'any',
                    'initialPreviewAsData' => $asdata,
                    'initialPreview' => $file,
                    'initialPreviewConfig' => [
                      ['type' => $type, 'caption' => $modelabout->passbook, 'deleteUrl' => false],
                    ],
                    'uploadAsync' => true,
                    // 'maxFileSize' => 10*1024*1024,
                    'allowedExtensions' => ['jpg', 'png', 'jpeg', 'pdf'],
                  ]
                ]) ?>
              <?php else : ?>
                <?= $form->field($modelabout, 'passbook')->widget(FileInput::classname(), [
                  'options' => ['accept' => ''],
                  'pluginOptions' => [
                    'showUpload' => false,
                    'showCaption' => true,
                    'showRemove' => true,
                  ]
                ]); ?>
              <?php endif; ?>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-12">
              <?php
              echo   $form->field($modelabout, "infoofrecruitmentid")->widget(Select2::classname(), [
                'data' => $infoofrecruitment,
                'options' => ['placeholder' => '- select -'],
                'pluginOptions' => [
                  'allowClear' => true
                ],
              ]);
              ?>
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <div class="pull-right">
          <?php if (Yii::$app->controller->action->id == 'cwizard' or Yii::$app->controller->action->id == 'uwizard') { ?>
            <?= Html::a('Back', ['/userworkexperience/cwizard'], ['class' => 'btn btn-primary']) ?>
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