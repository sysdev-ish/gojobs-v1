<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Userrole */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="userrole-form">
  <div class="container">
    <div class="card card-custom gutter-b">
      <?php $form = ActiveForm::begin(); ?>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-12">
              <?= $form->field($model, 'role')->textInput(['maxlength' => true]) ?>
              <?= $form->field($model, 'countcheck')->hiddenInput(['maxlength' => true, 'id' => 'countcheck'])->label(false) ?>
            </div>
          </div>
          <div class="col-md-12">
            <div class="col-md-3 form-group row">
              <label class="col-5 col-form-label">Recruitment Request</label>
              <div class="col-7 col-form-label">
                <?= $form->field($model, 'm1')->checkbox(['class' => 'my-0']); ?>
                <?= $form->field($model, 'm62')->checkbox(['class' => 'my-0']); ?>
                <?= $form->field($model, 'm63')->checkbox(['class' => 'my-0']); ?>
              </div>
            </div>
            <div class="col-md-3 form-group row">
              <label class="col-5 col-form-label">Recruitment Candidate</label>
              <div class="col-7 col-form-label">
                <?= $form->field($model, 'm2')->checkbox(['class' => 'my-0']); ?>
                <?= $form->field($model, 'm3')->checkbox(['class' => 'my-0']); ?>
                <?= $form->field($model, 'm46')->checkbox(['class' => 'my-0']); ?>
                <?= $form->field($model, 'm47')->checkbox(['class' => 'my-0']); ?>
              </div>
            </div>

            <div class="col-md-3 form-group row">
              <label class="col-5 col-form-label">Hiring</label>
              <div class="col-7 col-form-label">
                <?= $form->field($model, 'm35')->checkbox(['class' => 'my-0']); ?>
                <?= $form->field($model, 'm36')->checkbox(['class' => 'my-0']); ?>
                <?= $form->field($model, 'm37')->checkbox(['class' => 'my-0']); ?>
              </div>
            </div>

            <div class="col-md-12">
              <div class="col-form-label" style="padding: 5px; margin-bottom:5px; margin-top:10px; border-radius: 4px;  background-color:#89a0c6;">
                <span class="col-form-label">
                  Recruitment Process
                </span><!-- /.username -->
              </div>
              <div class="col-md-4 form-group row">
                <div class="col-5 col-form-label">
                  Interview
                </div>
                <div class="col-7 col-form-label">
                  <?= $form->field($model, 'm4')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm5')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm6')->checkbox(['class' => 'my-0']); ?>
                </div>
              </div>
              <div class="col-md-4 form-group row">
                <div class="col-5 col-form-label">
                  Psikotest
                </div>
                <div class="col-7 col-form-label">
                  <?= $form->field($model, 'm7')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm8')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm9')->checkbox(['class' => 'my-0']); ?>
                </div>
              </div>
              <div class="col-md-3 form-group row">
                <div class="col-5 col-form-label">
                  User Interview
                </div>
                <div class="col-7 col-form-label">
                  <?= $form->field($model, 'm10')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm11')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm12')->checkbox(['class' => 'my-0']); ?>
                </div>
              </div>
              <div class="col-md-3 form-group row">
                <div class="col-5 col-form-label">
                  Training Soft Skill
                </div>
                <div class="col-7 col-form-label">
                  <?= $form->field($model, 'm38')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm39')->checkbox(['class' => 'my-0']); ?>
                </div>
              </div>
              <div class="col-md-3 form-group row">
                <div class="col-5 col-form-label">
                  Training Hard skill
                </div>
                <div class="col-7 col-form-label">
                  <?= $form->field($model, 'm40')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm41')->checkbox(['class' => 'my-0']); ?>
                </div>
              </div>
              <div class="col-md-3 form-group row">
                <div class="col-5 col-form-label">
                  Tendem Pasif
                </div>
                <div class="col-7 col-form-label">
                  <?= $form->field($model, 'm42')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm43')->checkbox(['class' => 'my-0']); ?>
                </div>
              </div>
              <div class="col-md-3 form-group row">
                <div class="col-5 col-form-label">
                  Tendem Aktif
                </div>
                <div class="col-7 col-form-label">
                  <?= $form->field($model, 'm44')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm45')->checkbox(['class' => 'my-0']); ?>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="col-form-label" style="padding: 5px; margin-bottom:5px; margin-top:10px; border-radius: 4px;  background-color:#89a0c6;">
                <span class="col-form-label">
                  Master Data
                </span><!-- /.username -->
              </div>
              <div class="col-md-3 form-group row">
                <div class="col-5 col-form-label">
                  Applicant Master
                </div>
                <div class="col-7 col-form-label">
                  <?= $form->field($model, 'm13')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm14')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm49')->checkbox(['class' => 'my-0']); ?>
                </div>
              </div>
              <div class="col-md-3 form-group row ">
                <div class="col-5 col-form-label">
                  User Login
                </div>
                <div class="col-7 col-form-label">
                  <?= $form->field($model, 'm15')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm16')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm17')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm18')->checkbox(['class' => 'my-0']); ?>
                </div>
              </div>
              <div class="col-md-3 form-group row ">
                <div class="col-5 col-form-label">
                  User Role
                </div>
                <div class="col-7 col-form-label">
                  <?= $form->field($model, 'm19')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm20')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm21')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm22')->checkbox(['class' => 'my-0']); ?>
                </div>
              </div>
              <div class="col-md-3 form-group row">
                <div class="col-5 col-form-label">
                  Master Office
                </div>
                <div class="col-7 col-form-label">
                  <?= $form->field($model, 'm23')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm24')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm25')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm26')->checkbox(['class' => 'my-0']); ?>
                </div>
              </div>
              <div class="col-md-3 form-group row">
                <div class="col-5 col-form-label">
                  Master Room
                </div>
                <div class="col-7 col-form-label">
                  <?= $form->field($model, 'm27')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm28')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm29')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm30')->checkbox(['class' => 'my-0']); ?>
                </div>
              </div>
              <div class="col-md-3 form-group row">
                <div class="col-5 col-form-label">
                  <span class="username">
                    Master PIC
                  </span>
                </div>
                <div class="col-7 col-form-label">
                  <?= $form->field($model, 'm31')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm32')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm33')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm34')->checkbox(['class' => 'my-0']); ?>
                </div>
              </div>
              <div class="col-md-3 form-group row">
                <div class="col-5 col-form-label">
                  Applicant login
                </div>
                <div class="col-7 col-form-label">
                  <?= $form->field($model, 'm51')->checkbox(['class' => 'my-0']); ?>
                </div>
              </div>
              <div class="col-md-3 form-group row">
                <div class="col-5 col-form-label">
                  <span class="username">
                    Master Industry
                </div>

                <div class="col-7 col-form-label">
                  <?= $form->field($model, 'm72')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm73')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm74')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm75')->checkbox(['class' => 'my-0']); ?>
                </div>
              </div>
              <div class="col-md-3 form-group row">
                <div class="col-5 col-form-label">
                  <span class="username">
                    Master Job Family
                </div>

                <div class="col-7 col-form-label">
                  <?= $form->field($model, 'm76')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm77')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm78')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm79')->checkbox(['class' => 'my-0']); ?>
                </div>
              </div>
              <div class="col-md-3 form-group row">
                <div class="col-5 col-form-label">
                  <span class="username">
                    Master Sub Job Family
                </div>

                <div class="col-7 col-form-label">
                  <?= $form->field($model, 'm80')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm81')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm82')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm83')->checkbox(['class' => 'my-0']); ?>
                </div>
              </div>
              <div class="col-md-3 form-group row">
                <div class="col-5 col-form-label">
                  <span class="username">
                    Mapping Job Position
                </div>

                <div class="col-7 col-form-label">
                  <?= $form->field($model, 'm84')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm85')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm86')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm87')->checkbox(['class' => 'my-0']); ?>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="col-form-label" style="padding: 5px; margin-bottom:5px; margin-top:10px; border-radius: 4px;  background-color:#89a0c6;">
                <span class="col-form-label">
                  Report
                </span><!-- /.username -->
              </div>
              <div class="col-md-3 form-group row ">
                <div class="col-5 col-form-label">
                  Hiring
                </div>
                <div class="col-7 col-form-label">
                  <?= $form->field($model, 'm48')->checkbox(['class' => 'my-0']); ?>
                </div>
              </div>
              <div class="col-md-3 form-group row ">
                <div class="col-5 col-form-label">
                  Applicant data
                </div>
                <div class="col-7 col-form-label">
                  <?= $form->field($model, 'm50')->checkbox(['class' => 'my-0']); ?>
                </div>
              </div>
              <div class="col-md-3 form-group row ">
                <div class="col-5 col-form-label">
                  Job Order
                </div>
                <div class="col-7 col-form-label">
                  <?= $form->field($model, 'm66')->checkbox(['class' => 'my-0']); ?>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="col-form-label" style="padding: 5px; margin-bottom:5px; margin-top:10px; border-radius: 4px;  background-color:#89a0c6;">
                <span class="col-form-label">
                  Change Request
                </span><!-- /.username -->
              </div>
              <div class="col-md-3 form-group row ">
                <div class="col-5 col-form-label">
                  Personal Data
                </div>
                <div class="col-7 col-form-label">
                  <?= $form->field($model, 'm52')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm53')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm54')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm55')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm56')->checkbox(['class' => 'my-0']); ?>
                </div>
              </div>
              <div class="col-md-3 form-group row ">
                <div class="col-5 col-form-label">
                  Bank Account
                </div>
                <div class="col-7 col-form-label">
                  <?= $form->field($model, 'm57')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm58')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm59')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm60')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm61')->checkbox(['class' => 'my-0']); ?>
                </div>
              </div>
              <div class="col-md-3 form-group row ">
                <div class="col-5 col-form-label">
                  Stop Job Order
                </div>
                <div class="col-7 col-form-label">
                  <?= $form->field($model, 'm64')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm65')->checkbox(['class' => 'my-0']); ?>
                </div>
              </div>
              <div class="col-md-3 form-group row ">
                <div class="col-5 col-form-label">
                  Resign
                </div>
                <div class="col-7 col-form-label">
                  <?= $form->field($model, 'm67')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm68')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm69')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm70')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm71')->checkbox(['class' => 'my-0']); ?>
                </div>
              </div>
              <div class="col-md-3 form-group row ">
                <div class="col-5 col-form-label">
                  Change Cancel Join
                </div>
                <div class="col-7 col-form-label">
                  <?= $form->field($model, 'm88')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm89')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm90')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm91')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm92')->checkbox(['class' => 'my-0']); ?>
                </div>
              </div>
              <div class="col-md-3 form-group row ">
                <div class="col-5 col-form-label">
                  Change Hiring
                </div>
                <div class="col-7 col-form-label">
                  <?= $form->field($model, 'm93')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm94')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm95')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm96')->checkbox(['class' => 'my-0']); ?>
                  <?= $form->field($model, 'm97')->checkbox(['class' => 'my-0']); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12 text-right">
          <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary font-weight-bolder btn-flat']) ?>
          </div>
        </div>
      </div>
      <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>