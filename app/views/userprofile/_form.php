<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use kartik\date\DatePicker;
use kartik\file\FileInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Userprofile */
/* @var $form yii\widgets\ActiveForm */
?>
<!-- <div id="containerwizard"> -->



<!-- </div> -->
<?php if (Yii::$app->utils->getlayout() == 'main') : ?>
  <div class="box box-header with-border">

    <h3 class="box-title">User Profile</h3>
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
              'enctype' => 'multipart/form-data'
            ]
          ]); ?>
          <div class="row">
            <div class="col-md-12">
              <div class="col-md-6">
                <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>
              </div>
              <div class="col-md-6">
                <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="col-md-3">
                <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
              </div>
              <div class="col-md-3">
                <?php
                echo   $form->field($model, 'gender')->widget(Select2::classname(), [
                  'data' => ['male' => 'Male', 'female' => 'Female'],
                  'options' => ['placeholder' => '- select -', 'id' => 'gender'],
                  'pluginOptions' => [
                    'allowClear' => true
                  ],
                ]);
                ?>
              </div>
              <div class="col-md-3">
                <?= $form->field($model, 'birthdate')->widget(
                  DatePicker::className(),
                  [
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                    'options' => ['placeholder' => 'Date', 'autocomplete' => 'off'],
                    'readonly' => true,
                    'removeButton' => false,
                    'pluginOptions' => [
                      'autoclose' => true,
                      'startDate' => '-70y',
                      'endDate' => '-15y',
                      'format' => 'yyyy-mm-dd',
                      'todayHighlight' => true
                    ]
                  ]
                );
                ?>
              </div>
              <div class="col-md-3">
                <?= $form->field($model, 'birthplace')->textInput(['maxlength' => true]) ?>
              </div>
            </div>


            <div class="col-md-12">
              <div class="col-md-12">
                <?= $form->field($model, 'address')->textarea(['rows' => 2]) ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="col-md-6">
                <?php
                echo   $form->field($model, 'provinceid')->widget(Select2::classname(), [
                  'data' => $province,
                  'options' => ['placeholder' => '- select -', 'id' => 'provinceid'],
                  'pluginOptions' => [
                    'allowClear' => true
                  ],
                ]);
                ?>
              </div>
              <div class="col-md-6">
                <?= Html::hiddenInput('model_id2', $model->cityid, ['id' => 'model_id2']) ?>
                <?= $form->field($model, 'cityid')->widget(DepDrop::classname(), [
                  'data' => $kota,
                  'type' => DepDrop::TYPE_SELECT2,
                  'options' => ['id' => 'cityid'],
                  'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                  'pluginOptions' => [
                    'depends' => ['provinceid'],
                    'placeholder' => 'Select City',
                    'url' => Url::to(['/mastercity/getcity']),
                    'loadingText' => 'Loading ...',
                    'params' => ['model_id2'],
                    'initialize' => true,
                  ],


                ]); ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="col-md-6">
                <?= $form->field($model, 'postalcode')->textInput(['maxlength' => true]) ?>
              </div>
              <div class="col-md-6">
                <?php
                echo   $form->field($model, 'domicilestatus')->widget(Select2::classname(), [
                  'data' => ['one_own' => 'One own', 'owned_parents' => 'Owned parents', 'rent' => 'Rent', 'contract' => 'Contract', 'boarding_house' => 'Boarding house', 'others' => 'Others'],
                  'options' => ['placeholder' => '- select -', 'id' => 'domicilestatus'],
                  'pluginOptions' => [
                    'allowClear' => true
                  ],
                ]);
                ?>
              </div>

            </div>
            <div class="col-md-12">

              <div class="col-md-6">
                <!-- <?= $form->field($model, 'domicilestatusdescription')->textarea(['rows' => 6]) ?> -->
              </div>
            </div>
            <div class="col-md-12">
              <div class="col-md-12">
                <?= $form->field($model, 'addressktp')->textarea(['rows' => 2]) ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="col-md-6">
                <?php
                echo   $form->field($model, 'provinceidktp')->widget(Select2::classname(), [
                  'data' => $provincektp,
                  'options' => ['placeholder' => '- select -', 'id' => 'provinceidktp'],
                  'pluginOptions' => [
                    'allowClear' => true
                  ],
                ]);
                ?>
              </div>
              <div class="col-md-6">
                <?= Html::hiddenInput('model_id3', $model->cityidktp, ['id' => 'model_id3']) ?>
                <?= $form->field($model, 'cityidktp')->widget(DepDrop::classname(), [
                  'data' => $kotaktp,
                  'type' => DepDrop::TYPE_SELECT2,
                  'options' => ['id' => 'cityidktp'],
                  'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                  'pluginOptions' => [
                    'depends' => ['provinceidktp'],
                    'placeholder' => 'Select City',
                    'url' => Url::to(['/mastercity/getcity']),
                    'loadingText' => 'Loading ...',
                    'params' => ['model_id3'],
                    'initialize' => true,
                  ],


                ]); ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="col-md-12">
                <?= $form->field($model, 'postalcodektp')->textInput(['maxlength' => true]) ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="col-md-3">
                <?= $form->field($model, 'nationality')->textInput(['maxlength' => true]) ?>
              </div>
              <div class="col-md-3">
                <?php
                echo   $form->field($model, 'religion')->widget(Select2::classname(), [
                  'data' => ['islam' => 'Islam', 'christian' => 'Christian', 'catholic' => 'Catholic', 'protestant' => 'Protestant', 'hindu' => 'Hindu', 'buddha' => 'Buddha'],
                  'options' => ['placeholder' => '- select -', 'id' => 'religion'],
                  'pluginOptions' => [
                    'allowClear' => true
                  ],
                ]);
                ?>
              </div>
              <div class="col-md-3">
                <?php
                echo   $form->field($model, 'maritalstatus')->widget(Select2::classname(), [
                  'data' => ['married' => 'Married', 'single' => 'Single'],
                  'options' => ['placeholder' => '- select -', 'id' => 'maritalstatus'],
                  'pluginOptions' => [
                    'allowClear' => true
                  ],
                ]);
                ?>
              </div>
              <div class="col-md-3">
                <?= $form->field($model, 'weddingdate')->widget(
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
            </div>

            <div class="col-md-12">
              <div class="col-md-2">
                <?php
                echo   $form->field($model, 'bloodtype')->widget(Select2::classname(), [
                  'data' => ['A' => 'A', 'B' => 'B', 'AB' => 'Ab', 'O' => 'O'],
                  'options' => ['placeholder' => '- select -', 'id' => 'bloodtype'],
                  'pluginOptions' => [
                    'allowClear' => true
                  ],
                ]);
                ?>
              </div>
              <div class="col-md-5">
                <?= $form->field($model, 'identitynumber')->textInput(['maxlength' => true]) ?>
              </div>
              <div class="col-md-5">
                <?= $form->field($model, 'kknumber')->textInput(['maxlength' => true]) ?>
              </div>

            </div>
            <div class="col-md-12">
              <div class="col-md-4">
                <?= $form->field($model, 'havejamsostek')->checkbox()->label('You have JAMSOSTEK ? '); ?>
                <?= $form->field($model, 'jamsosteknumber')->textInput(['maxlength' => true]) ?>
              </div>
              <div class="col-md-4">
                <?= $form->field($model, 'havebpjs')->checkbox()->label('You have BPJS ? '); ?>
                <?= $form->field($model, 'bpjsnumber')->textInput(['maxlength' => true]) ?>
              </div>
              <div class="col-md-4">
                <?= $form->field($model, 'havenpwp')->checkbox()->label('You have NPWP ? '); ?>
                <?= $form->field($model, 'npwpnumber')->textInput(['maxlength' => true]) ?>
              </div>
            </div>

            <div class="col-md-12">
              <div class="col-md-6">
                <?= $form->field($model, 'drivinglicencecarnumber')->textInput(['maxlength' => true]) ?>
              </div>
              <div class="col-md-6">
                <?= $form->field($model, 'drivinglicencemotorcyclenumber')->textInput(['maxlength' => true]) ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="col-md-6">
                <?= $form->field($model, 'tinggibadan')->textInput(['maxlength' => true]) ?>
              </div>
              <div class="col-md-6">
                <?= $form->field($model, 'beratbadan')->textInput(['maxlength' => true]) ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="col-md-6">
                <?= $form->field($model, 'nokitas')->textInput(['maxlength' => true]) ?>
              </div>
              <div class="col-md-6">
                <?= $form->field($model, 'lokasikerja')->textInput(['maxlength' => true]) ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="col-md-6">
                <?php
                echo   $form->field($model, 'jobfamilyid')->widget(Select2::classname(), [
                  'data' => $jobfamily,
                  'options' => ['placeholder' => '- select -', 'id' => 'jobfamilyid'],
                  'pluginOptions' => [
                    'allowClear' => true
                  ],
                ]);
                ?>
              </div>
              <div class="col-md-6">
                <?php
                echo   $form->field($model, 'subjobfamilyid')->widget(Select2::classname(), [
                  'data' => $subjobfamily,
                  'options' => ['placeholder' => '- select -', 'id' => 'subjobfamilyid'],
                  'pluginOptions' => [
                    'allowClear' => true
                  ],
                ]);
                ?>
              </div>
            </div>

            <div class="col-md-12">
              <div class="col-md-12">
                <?= $form->field($model, 'jenispekerjaan')->textInput(['maxlength' => true]) ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="col-md-12">
                <?php if (!$model->isNewRecord) : ?>
                  <?php
                  $img = '';
                  $json = [];
                  $assetUrl = Yii::$app->request->baseUrl;
                  if (!empty($model->photo)) {

                    $img = Html::img($assetUrl . '/app/assets/upload/photo/' . $model->photo, ['width' => '150']);

                    $json[] = [
                      'caption' => $model->photo, Url::to(['/userprofile/deletefile']),
                      'key' => $model->id,
                    ];
                  }
                  ?>

                  <?= $form->field($model, 'photo')->widget(FileInput::className(), [
                    'options' => ['accept' => ''],
                    'pluginOptions' => [
                      'showRemove' => false,
                      'showUpload' => false,
                      'showCancel' => false,
                      'overwriteInitial' => true,
                      'initialPreviewConfig' => $json,
                      'previewFileType' => 'any',
                      'initialPreview' => $img,
                      'uploadAsync' => true,
                      // 'maxFileSize' => 3*1024*1024,
                      'deleteUrl' => Url::to(['/userprofile/deletefile']),
                      'allowedExtensions' => ['jpg', 'png', 'jpeg', 'pdf'],
                    ]
                  ]) ?>
                <?php else : ?>
                  <?= $form->field($model, 'photo')->widget(FileInput::classname(), [
                    'options' => ['accept' => ''],
                    'pluginOptions' => [
                      'showUpload' => false,
                    ]
                  ]); ?>
                <?php endif; ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="col-md-12">
                <?php if (!$model->isNewRecord) : ?>
                  <?php
                  $img = '';
                  $json = [];
                  $assetUrl = Yii::$app->request->baseUrl;
                  if (!empty($model->cvupload)) {

                    $img = Html::img($assetUrl . '/app/assets/upload/cvupload/' . $model->cvupload, ['width' => '150']);
                    $json[] = [
                      'caption' => $model->photo, Url::to(['/userprofile/deletefile']),
                      'key' => $model->id,
                    ];
                  }
                  ?>

                  <?= $form->field($model, 'cvupload')->widget(FileInput::className(), [
                    'options' => ['accept' => ''],
                    'pluginOptions' => [
                      'showRemove' => false,
                      'showUpload' => false,
                      'showCancel' => false,
                      'overwriteInitial' => true,
                      'initialPreviewConfig' => $json,
                      'previewFileType' => 'any',
                      'initialPreview' => $img,
                      'uploadAsync' => true,
                      // 'maxFileSize' => 3*1024*1024,
                      'deleteUrl' => Url::to(['/userprofile/deletefile']),
                      'allowedExtensions' => ['jpg', 'png', 'jpeg', 'pdf'],
                    ]
                  ]) ?>
                <?php else : ?>
                  <?= $form->field($model, 'cvupload')->widget(FileInput::classname(), [
                    'options' => ['accept' => ''],
                    'pluginOptions' => [
                      'showUpload' => false,
                    ]
                  ]); ?>
                <?php endif; ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="col-md-12">
                <?php
                echo   $form->field($modelvaksin, 'statusvaksin')->widget(Select2::classname(), [
                  'data' => ['1' => 'Belum Vaksin', '2' => 'Vaksin 1', '3' => 'Vaksin 2'],
                  'options' => [
                    'placeholder' => '- select -', 'id' => 'statusvaksin',
                    'onChange' => "
                          if ($(this).val() == 1) {
                            $('#alasanvaksinrow').show();

                            $('#tanggallokasisert1').hide();
                            $('#tanggalvaksin1').val('');
                            $('#lokasivaksin1').val('');
                            $('.fileinput-remove-button').click();

                            $('#tanggallokasisert2').hide();
                            $('#tanggalvaksin2').val('');
                            $('#lokasivaksin2').val('');
                          }else if($(this).val() == 2){
                            $('#alasanvaksinrow').hide();
                            $('#alasanvaksin').val('').trigger('change') ;

                            $('#tanggallokasisert1').show();
                            $('#tanggallokasisert2').hide();
                            $('#tanggalvaksin2').val('');
                            $('#lokasivaksin2').val('');
                            $('.fileinput-remove-button').click();


                          }else if ($(this).val() == 3) {
                            $('#alasanvaksinrow').hide();
                            $('#alasanvaksin').val('').trigger('change') ;

                            $('#tanggallokasisert1').show();

                            $('#tanggallokasisert2').show();
                          }
                          ;
                          ",
                  ],

                  'pluginOptions' => [
                    'allowClear' => true
                  ],
                ]);
                ?>
              </div>
            </div>
            <?php
            // if ($model->isNewRecord){
            switch ($modelvaksin->statusvaksin) {
              case '1':
                $displayalasanvaksin = "";
                $displaytanggalloksert1 = "display:none;";
                $displaytanggalloksert2 = "display:none;";
                break;
              case '2':
                $displayalasanvaksin = "display:none;";
                $displaytanggalloksert1 = "";
                $displaytanggalloksert2 = "display:none;";
                break;
              case '3':
                $displayalasanvaksin = "display:none;";
                $displaytanggalloksert1 = "";
                $displaytanggalloksert2 = "";
                break;

              default:
                $displayalasanvaksin = "display:none;";
                $displaytanggalloksert1 = "display:none;";
                $displaytanggalloksert2 = "display:none;";
                break;
            }

            // }

            ?>
            <div class="col-md-12" id="alasanvaksinrow" style="<?php echo $displayalasanvaksin; ?>">
              <div class="col-md-12">
                <?php
                echo   $form->field($modelvaksin, 'alasan')->widget(Select2::classname(), [
                  'data' => $alasanvaksin,
                  'options' => ['placeholder' => '- select -', 'id' => 'alasanvaksin'],
                  'pluginOptions' => [
                    'allowClear' => true
                  ],
                ]);
                ?>
              </div>
            </div>
            <div id="tanggallokasisert1" style="<?php echo $displaytanggalloksert1; ?>">
              <div class="col-md-12">
                <div class="col-md-6">
                  <?= $form->field($modelvaksin, 'tanggalvaksin1')->widget(
                    DatePicker::className(),
                    [
                      'type' => DatePicker::TYPE_COMPONENT_APPEND,
                      'options' => ['placeholder' => 'Date', 'autocomplete' => 'off', 'id' => 'tanggalvaksin1'],
                      'readonly' => true,
                      'removeButton' => false,
                      'pluginOptions' => [
                        'autoclose' => true,
                        'startDate' => '-1y',
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true
                      ]
                    ]
                  );
                  ?>
                </div>
                <div class="col-md-6">
                  <?= $form->field($modelvaksin, 'lokasivaksin1')->textInput(['maxlength' => true, 'id' => 'lokasivaksin1']) ?>
                </div>
              </div>
              <div class="col-md-12">
                <div class="col-md-12">
                  <?php if (!$modelvaksin->isNewRecord) : ?>
                    <?php
                    $img = '';
                    $json = [];
                    $assetUrl = Yii::$app->request->baseUrl;
                    if (!empty($modelvaksin->sertvaksin1)) {

                      $img = Html::img($assetUrl . '/app/assets/upload/sertifikatvaksin/' . $modelvaksin->sertvaksin1, ['width' => '150']);
                      $json[] = [
                        'caption' => $modelvaksin->sertvaksin1, Url::to(['/userprofile/deletefile']),
                        'key' => $modelvaksin->id,
                      ];
                    }
                    ?>

                    <?= $form->field($modelvaksin, 'sertvaksin1')->widget(FileInput::className(), [
                      'options' => ['accept' => ''],
                      'pluginOptions' => [
                        'showRemove' => false,
                        'showUpload' => false,
                        'showCancel' => false,
                        'overwriteInitial' => true,
                        'initialPreviewConfig' => $json,
                        'previewFileType' => 'any',
                        'initialPreview' => $img,
                        'uploadAsync' => true,
                        // 'maxFileSize' => 3*1024*1024,
                        'deleteUrl' => Url::to(['/userprofile/deletefile']),
                        'allowedExtensions' => ['jpg', 'png', 'jpeg', 'pdf'],
                      ]
                    ]) ?>
                  <?php else : ?>
                    <?= $form->field($modelvaksin, 'sertvaksin1')->widget(FileInput::classname(), [
                      'options' => ['accept' => ''],
                      'pluginOptions' => [
                        'showUpload' => false,
                      ]
                    ]); ?>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            <div id="tanggallokasisert2" style="<?php echo $displaytanggalloksert2; ?>">

              <div class="col-md-12">
                <div class="col-md-6">
                  <?= $form->field($modelvaksin, 'tanggalvaksin2')->widget(
                    DatePicker::className(),
                    [
                      'type' => DatePicker::TYPE_COMPONENT_APPEND,
                      'options' => ['placeholder' => 'Date', 'autocomplete' => 'off', 'id' => 'tanggalvaksin2'],
                      'readonly' => true,
                      'removeButton' => false,
                      'pluginOptions' => [
                        'autoclose' => true,
                        'startDate' => '-1y',
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true
                      ]
                    ]
                  );
                  ?>
                </div>
                <div class="col-md-6">
                  <?= $form->field($modelvaksin, 'lokasivaksin2')->textInput(['maxlength' => true, 'id' => 'lokasivaksin2']) ?>
                </div>
              </div>
              <div class="col-md-12">
                <div class="col-md-12">
                  <?php if (!$modelvaksin->isNewRecord) : ?>
                    <?php
                    $img = '';
                    $json = [];
                    $assetUrl = Yii::$app->request->baseUrl;
                    if (!empty($modelvaksin->sertvaksin2)) {

                      $img = Html::img($assetUrl . '/app/assets/upload/sertifikatvaksin/' . $modelvaksin->sertvaksin2, ['width' => '150']);
                      $json[] = [
                        'caption' => $modelvaksin->sertvaksin2, Url::to(['/userprofile/deletefile']),
                        'key' => $modelvaksin->id,
                      ];
                    }
                    ?>

                    <?= $form->field($modelvaksin, 'sertvaksin2')->widget(FileInput::className(), [
                      'options' => ['accept' => ''],
                      'pluginOptions' => [
                        'showRemove' => false,
                        'showUpload' => false,
                        'showCancel' => false,
                        'overwriteInitial' => true,
                        'initialPreviewConfig' => $json,
                        'previewFileType' => 'any',
                        'initialPreview' => $img,
                        'uploadAsync' => true,
                        // 'maxFileSize' => 3*1024*1024,
                        'deleteUrl' => Url::to(['/userprofile/deletefile']),
                        'allowedExtensions' => ['jpg', 'png', 'jpeg', 'pdf'],
                      ]
                    ]) ?>
                  <?php else : ?>
                    <?= $form->field($modelvaksin, 'sertvaksin2')->widget(FileInput::classname(), [
                      'options' => ['accept' => ''],
                      'pluginOptions' => [
                        'showUpload' => false,
                      ]
                    ]); ?>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer">
            <div class="pull-right">
              <?= Html::submitButton((Yii::$app->controller->action->id == 'cwizard' or Yii::$app->controller->action->id == 'uwizard') ? 'Save' : 'Save', ['class' => 'btn btn-success btn']) ?>
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
            'enctype' => 'multipart/form-data'
          ]
        ]); ?>
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-6">
              <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
              <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-3">
              <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-3">
              <?php
              echo   $form->field($model, 'gender')->widget(Select2::classname(), [
                'data' => ['male' => 'Male', 'female' => 'Female'],
                'options' => ['placeholder' => '- select -', 'id' => 'gender'],
                'pluginOptions' => [
                  'allowClear' => true
                ],
              ]);
              ?>
            </div>
            <div class="col-md-3">
              <?= $form->field($model, 'birthdate')->widget(
                DatePicker::className(),
                [
                  'type' => DatePicker::TYPE_COMPONENT_APPEND,
                  'options' => ['placeholder' => 'Date', 'autocomplete' => 'off'],
                  'readonly' => true,
                  'removeButton' => false,
                  'pluginOptions' => [
                    'autoclose' => true,
                    'startDate' => '-70y',
                    'endDate' => '-15y',
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true
                  ]
                ]
              );
              ?>
            </div>
            <div class="col-md-3">
              <?= $form->field($model, 'birthplace')->textInput(['maxlength' => true]) ?>
            </div>
          </div>


          <div class="col-md-12">
            <div class="col-md-12">
              <?= $form->field($model, 'address')->textarea(['rows' => 2]) ?>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-6">
              <?php
              echo   $form->field($model, 'provinceid')->widget(Select2::classname(), [
                'data' => $province,
                'options' => ['placeholder' => '- select -', 'id' => 'provinceid'],
                'pluginOptions' => [
                  'allowClear' => true
                ],
              ]);
              ?>
            </div>
            <div class="col-md-6">
              <?= Html::hiddenInput('model_id2', $model->cityid, ['id' => 'model_id2']) ?>
              <?= $form->field($model, 'cityid')->widget(DepDrop::classname(), [
                'data' => $kota,
                'type' => DepDrop::TYPE_SELECT2,
                'options' => ['id' => 'cityid'],
                'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                'pluginOptions' => [
                  'depends' => ['provinceid'],
                  'placeholder' => 'Select City',
                  'url' => Url::to(['/mastercity/getcity']),
                  'loadingText' => 'Loading ...',
                  'params' => ['model_id2'],
                  'initialize' => true,
                ],


              ]); ?>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-6">
              <?= $form->field($model, 'postalcode')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
              <?php
              echo   $form->field($model, 'domicilestatus')->widget(Select2::classname(), [
                'data' => ['one_own' => 'One own', 'owned_parents' => 'Owned parents', 'rent' => 'Rent', 'contract' => 'Contract', 'boarding_house' => 'Boarding house', 'others' => 'Others'],
                'options' => ['placeholder' => '- select -', 'id' => 'domicilestatus'],
                'pluginOptions' => [
                  'allowClear' => true
                ],
              ]);
              ?>
            </div>

          </div>
          <div class="col-md-12">

            <div class="col-md-6">
              <!-- <?= $form->field($model, 'domicilestatusdescription')->textarea(['rows' => 6]) ?> -->
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-12">
              <?= $form->field($model, 'addressktp')->textarea(['rows' => 2]) ?>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-6">
              <?php
              echo   $form->field($model, 'provinceidktp')->widget(Select2::classname(), [
                'data' => $provincektp,
                'options' => ['placeholder' => '- select -', 'id' => 'provinceidktp'],
                'pluginOptions' => [
                  'allowClear' => true
                ],
              ]);
              ?>
            </div>
            <div class="col-md-6">
              <?= Html::hiddenInput('model_id3', $model->cityidktp, ['id' => 'model_id3']) ?>
              <?= $form->field($model, 'cityidktp')->widget(DepDrop::classname(), [
                'data' => $kotaktp,
                'type' => DepDrop::TYPE_SELECT2,
                'options' => ['id' => 'cityidktp'],
                'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                'pluginOptions' => [
                  'depends' => ['provinceidktp'],
                  'placeholder' => 'Select City',
                  'url' => Url::to(['/mastercity/getcity']),
                  'loadingText' => 'Loading ...',
                  'params' => ['model_id3'],
                  'initialize' => true,
                ],


              ]); ?>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-12">
              <?= $form->field($model, 'postalcodektp')->textInput(['maxlength' => true]) ?>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-3">
              <?= $form->field($model, 'nationality')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-3">
              <?php
              echo   $form->field($model, 'religion')->widget(Select2::classname(), [
                'data' => ['islam' => 'Islam', 'christian' => 'Christian', 'catholic' => 'Catholic', 'protestant' => 'Protestant', 'hindu' => 'Hindu', 'buddha' => 'Buddha'],
                'options' => ['placeholder' => '- select -', 'id' => 'religion'],
                'pluginOptions' => [
                  'allowClear' => true
                ],
              ]);
              ?>
            </div>
            <div class="col-md-3">
              <?php
              echo   $form->field($model, 'maritalstatus')->widget(Select2::classname(), [
                'data' => ['married' => 'Married', 'single' => 'Single'],
                'options' => ['placeholder' => '- select -', 'id' => 'maritalstatus'],
                'pluginOptions' => [
                  'allowClear' => true
                ],
              ]);
              ?>
            </div>
            <div class="col-md-3">
              <?= $form->field($model, 'weddingdate')->widget(
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
          </div>

          <div class="col-md-12">
            <div class="col-md-2">
              <?php
              echo   $form->field($model, 'bloodtype')->widget(Select2::classname(), [
                'data' => ['A' => 'A', 'B' => 'B', 'AB' => 'Ab', 'O' => 'O'],
                'options' => ['placeholder' => '- select -', 'id' => 'bloodtype'],
                'pluginOptions' => [
                  'allowClear' => true
                ],
              ]);
              ?>
            </div>
            <div class="col-md-5">
              <?= $form->field($model, 'identitynumber')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-5">
              <?= $form->field($model, 'kknumber')->textInput(['maxlength' => true]) ?>
            </div>

          </div>
          <div class="col-md-12">
            <div class="col-md-4">
              <?= $form->field($model, 'havejamsostek')->checkbox()->label('You have JAMSOSTEK ? '); ?>
              <?= $form->field($model, 'jamsosteknumber')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
              <?= $form->field($model, 'havebpjs')->checkbox()->label('You have BPJS ? '); ?>
              <?= $form->field($model, 'bpjsnumber')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
              <?= $form->field($model, 'havenpwp')->checkbox()->label('You have NPWP ? '); ?>
              <?= $form->field($model, 'npwpnumber')->textInput(['maxlength' => true]) ?>
            </div>
          </div>

          <div class="col-md-12">
            <div class="col-md-6">
              <?= $form->field($model, 'drivinglicencecarnumber')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
              <?= $form->field($model, 'drivinglicencemotorcyclenumber')->textInput(['maxlength' => true]) ?>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-6">
              <?= $form->field($model, 'tinggibadan')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
              <?= $form->field($model, 'beratbadan')->textInput(['maxlength' => true]) ?>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-6">
              <?= $form->field($model, 'nokitas')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
              <?= $form->field($model, 'lokasikerja')->textInput(['maxlength' => true]) ?>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-12">
              <?= $form->field($model, 'jenispekerjaan')->textInput(['maxlength' => true]) ?>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-12">
              <?php if (!$model->isNewRecord) : ?>
                <?php
                $img = '';
                $json = [];
                $assetUrl = Yii::$app->request->baseUrl;
                if (!empty($model->photo)) {

                  $img = Html::img($assetUrl . '/app/assets/upload/photo/' . $model->photo, ['width' => '150']);

                  $json[] = [
                    'caption' => $model->photo, Url::to(['/userprofile/deletefile']),
                    'key' => $model->id,
                  ];
                }
                ?>

                <?= $form->field($model, 'photo')->widget(FileInput::className(), [
                  'options' => ['accept' => ''],
                  'pluginOptions' => [
                    'showRemove' => false,
                    'showUpload' => false,
                    'showCancel' => false,
                    'overwriteInitial' => true,
                    'initialPreviewConfig' => $json,
                    'previewFileType' => 'any',
                    'initialPreview' => $img,
                    'uploadAsync' => true,
                    // 'maxFileSize' => 3*1024*1024,
                    'deleteUrl' => Url::to(['/userprofile/deletefile']),
                    'allowedExtensions' => ['jpg', 'png', 'jpeg', 'pdf'],
                  ]
                ]) ?>
              <?php else : ?>
                <?= $form->field($model, 'photo')->widget(FileInput::classname(), [
                  'options' => ['accept' => ''],
                  'pluginOptions' => [
                    'showUpload' => false,
                  ]
                ]); ?>
              <?php endif; ?>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-12">
              <?php if (!$model->isNewRecord) : ?>
                <?php
                $img = '';
                $json = [];
                $assetUrl = Yii::$app->request->baseUrl;
                if (!empty($model->cvupload)) {

                  $img = Html::img($assetUrl . '/app/assets/upload/cvupload/' . $model->cvupload, ['width' => '150']);
                  $json[] = [
                    'caption' => $model->photo, Url::to(['/userprofile/deletefile']),
                    'key' => $model->id,
                  ];
                }
                ?>

                <?= $form->field($model, 'cvupload')->widget(FileInput::className(), [
                  'options' => ['accept' => ''],
                  'pluginOptions' => [
                    'showRemove' => false,
                    'showUpload' => false,
                    'showCancel' => false,
                    'overwriteInitial' => true,
                    'initialPreviewConfig' => $json,
                    'previewFileType' => 'any',
                    'initialPreview' => $img,
                    'uploadAsync' => true,
                    // 'maxFileSize' => 3*1024*1024,
                    'deleteUrl' => Url::to(['/userprofile/deletefile']),
                    'allowedExtensions' => ['jpg', 'png', 'jpeg', 'pdf'],
                  ]
                ]) ?>
              <?php else : ?>
                <?= $form->field($model, 'cvupload')->widget(FileInput::classname(), [
                  'options' => ['accept' => ''],
                  'pluginOptions' => [
                    'showUpload' => false,
                  ]
                ]); ?>
              <?php endif; ?>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-12">
              <?php
              echo   $form->field($modelvaksin, 'statusvaksin')->widget(Select2::classname(), [
                'data' => ['1' => 'Belum Vaksin', '2' => 'Vaksin 1', '3' => 'Vaksin 2'],
                'options' => [
                  'placeholder' => '- select -', 'id' => 'statusvaksin',
                  'onChange' => "
                                      if ($(this).val() == 1) {
                                        $('#alasanvaksinrow').show();

                                        $('#tanggallokasisert1').hide();
                                        $('#tanggalvaksin1').val('');
                                        $('#lokasivaksin1').val('');
                                        $('.fileinput-remove-button').click();

                                        $('#tanggallokasisert2').hide();
                                        $('#tanggalvaksin2').val('');
                                        $('#lokasivaksin2').val('');
                                      }else if($(this).val() == 2){
                                        $('#alasanvaksinrow').hide();
                                        $('#alasanvaksin').val('').trigger('change') ;

                                        $('#tanggallokasisert1').show();
                                        $('#tanggallokasisert2').hide();
                                        $('#tanggalvaksin2').val('');
                                        $('#lokasivaksin2').val('');
                                        $('.fileinput-remove-button').click();


                                      }else if ($(this).val() == 3) {
                                        $('#alasanvaksinrow').hide();
                                        $('#alasanvaksin').val('').trigger('change') ;

                                        $('#tanggallokasisert1').show();

                                        $('#tanggallokasisert2').show();
                                      }
                                      ;
                                      ",
                ],

                'pluginOptions' => [
                  'allowClear' => true
                ],
              ]);
              ?>
            </div>
          </div>
          <?php
          // if ($model->isNewRecord){
          switch ($modelvaksin->statusvaksin) {
            case '1':
              $displayalasanvaksin = "";
              $displaytanggalloksert1 = "display:none;";
              $displaytanggalloksert2 = "display:none;";
              break;
            case '2':
              $displayalasanvaksin = "display:none;";
              $displaytanggalloksert1 = "";
              $displaytanggalloksert2 = "display:none;";
              break;
            case '3':
              $displayalasanvaksin = "display:none;";
              $displaytanggalloksert1 = "";
              $displaytanggalloksert2 = "";
              break;

            default:
              $displayalasanvaksin = "display:none;";
              $displaytanggalloksert1 = "display:none;";
              $displaytanggalloksert2 = "display:none;";
              break;
          }

          // }

          ?>
          <div class="col-md-12" id="alasanvaksinrow" style="<?php echo $displayalasanvaksin; ?>">
            <div class="col-md-12">
              <?php
              echo   $form->field($modelvaksin, 'alasan')->widget(Select2::classname(), [
                'data' => $alasanvaksin,
                'options' => ['placeholder' => '- select -', 'id' => 'alasanvaksin'],
                'pluginOptions' => [
                  'allowClear' => true
                ],
              ]);
              ?>
            </div>
          </div>
          <div id="tanggallokasisert1" style="<?php echo $displaytanggalloksert1; ?>">
            <div class="col-md-12">
              <div class="col-md-6">
                <?= $form->field($modelvaksin, 'tanggalvaksin1')->widget(
                  DatePicker::className(),
                  [
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                    'options' => ['placeholder' => 'Date', 'autocomplete' => 'off', 'id' => 'tanggalvaksin1'],
                    'readonly' => true,
                    'removeButton' => false,
                    'pluginOptions' => [
                      'autoclose' => true,
                      'startDate' => '-1y',
                      'format' => 'yyyy-mm-dd',
                      'todayHighlight' => true
                    ]
                  ]
                );
                ?>
              </div>
              <div class="col-md-6">
                <?= $form->field($modelvaksin, 'lokasivaksin1')->textInput(['maxlength' => true, 'id' => 'lokasivaksin1']) ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="col-md-12">
                <?php if (!$modelvaksin->isNewRecord) : ?>
                  <?php
                  $img = '';
                  $json = [];
                  $assetUrl = Yii::$app->request->baseUrl;
                  if (!empty($modelvaksin->sertvaksin1)) {

                    $img = Html::img($assetUrl . '/app/assets/upload/sertifikatvaksin/' . $modelvaksin->sertvaksin1, ['width' => '150']);
                    $json[] = [
                      'caption' => $modelvaksin->sertvaksin1, Url::to(['/userprofile/deletefile']),
                      'key' => $modelvaksin->id,
                    ];
                  }
                  ?>

                  <?= $form->field($modelvaksin, 'sertvaksin1')->widget(FileInput::className(), [
                    'options' => ['accept' => ''],
                    'pluginOptions' => [
                      'showRemove' => false,
                      'showUpload' => false,
                      'showCancel' => false,
                      'overwriteInitial' => true,
                      'initialPreviewConfig' => $json,
                      'previewFileType' => 'any',
                      'initialPreview' => $img,
                      'uploadAsync' => true,
                      // 'maxFileSize' => 3*1024*1024,
                      'deleteUrl' => Url::to(['/userprofile/deletefile']),
                      'allowedExtensions' => ['jpg', 'png', 'jpeg', 'pdf'],
                    ]
                  ]) ?>
                <?php else : ?>
                  <?= $form->field($modelvaksin, 'sertvaksin1')->widget(FileInput::classname(), [
                    'options' => ['accept' => ''],
                    'pluginOptions' => [
                      'showUpload' => false,
                    ]
                  ]); ?>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <div id="tanggallokasisert2" style="<?php echo $displaytanggalloksert2; ?>">

            <div class="col-md-12">
              <div class="col-md-6">
                <?= $form->field($modelvaksin, 'tanggalvaksin2')->widget(
                  DatePicker::className(),
                  [
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                    'options' => ['placeholder' => 'Date', 'autocomplete' => 'off', 'id' => 'tanggalvaksin2'],
                    'readonly' => true,
                    'removeButton' => false,
                    'pluginOptions' => [
                      'autoclose' => true,
                      'startDate' => '-1y',
                      'format' => 'yyyy-mm-dd',
                      'todayHighlight' => true
                    ]
                  ]
                );
                ?>
              </div>
              <div class="col-md-6">
                <?= $form->field($modelvaksin, 'lokasivaksin2')->textInput(['maxlength' => true, 'id' => 'lokasivaksin2']) ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="col-md-12">
                <?php if (!$modelvaksin->isNewRecord) : ?>
                  <?php
                  $img = '';
                  $json = [];
                  $assetUrl = Yii::$app->request->baseUrl;
                  if (!empty($modelvaksin->sertvaksin2)) {

                    $img = Html::img($assetUrl . '/app/assets/upload/sertifikatvaksin/' . $modelvaksin->sertvaksin2, ['width' => '150']);
                    $json[] = [
                      'caption' => $modelvaksin->sertvaksin2, Url::to(['/userprofile/deletefile']),
                      'key' => $modelvaksin->id,
                    ];
                  }
                  ?>

                  <?= $form->field($modelvaksin, 'sertvaksin2')->widget(FileInput::className(), [
                    'options' => ['accept' => ''],
                    'pluginOptions' => [
                      'showRemove' => false,
                      'showUpload' => false,
                      'showCancel' => false,
                      'overwriteInitial' => true,
                      'initialPreviewConfig' => $json,
                      'previewFileType' => 'any',
                      'initialPreview' => $img,
                      'uploadAsync' => true,
                      // 'maxFileSize' => 3*1024*1024,
                      'deleteUrl' => Url::to(['/userprofile/deletefile']),
                      'allowedExtensions' => ['jpg', 'png', 'jpeg', 'pdf'],
                    ]
                  ]) ?>
                <?php else : ?>
                  <?= $form->field($modelvaksin, 'sertvaksin2')->widget(FileInput::classname(), [
                    'options' => ['accept' => ''],
                    'pluginOptions' => [
                      'showUpload' => false,
                    ]
                  ]); ?>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="box-footer">
          <div class="pull-right">
            <?= Html::submitButton((Yii::$app->controller->action->id == 'cwizard' or Yii::$app->controller->action->id == 'uwizard') ? 'Save' : 'Save', ['class' => 'btn btn-success btn']) ?>
          </div>
        </div>

        <?php ActiveForm::end(); ?>
      </div>
    </div>
    <!-- end of show edit menu if user not hiring yet -->

  <?php endif; ?>
<?php endif; ?>
