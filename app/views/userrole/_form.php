<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Userrole */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="userrole-form box box-default">
  <?php $form = ActiveForm::begin(); ?>
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <div class="col-md-12">
          <?= $form->field($model, 'role')->textInput(['maxlength' => true]) ?>
          <?= $form->field($model, 'countcheck')->hiddenInput(['maxlength' => true, 'id' => 'countcheck'])->label(false) ?>
        </div>
      </div>

      <div class="col-md-12">
        <div class="col-md-4">
          <div class="box-footer box-comments" style="margin-bottom:5px; margin-top:20px;background-color:#89a0c6">

            <span class="username">
              Recruitment Request
            </span><!-- /.username -->
            <!-- /.comment-text -->

          </div>
          <div class="col-md-12">
            <?= $form->field($model, 'm1')->checkbox(); ?>
            <?= $form->field($model, 'm62')->checkbox(); ?>
            <?= $form->field($model, 'm63')->checkbox(); ?>
          </div>
        </div>
        <div class="col-md-4">
          <div class="box-footer box-comments" style="margin-bottom:5px; margin-top:20px;background-color:#89a0c6">

            <span class="username">
              Recruitment Candidate
            </span><!-- /.username -->
            <!-- /.comment-text -->

          </div>
          <div class="col-md-12">
            <?= $form->field($model, 'm2')->checkbox(); ?>
            <?= $form->field($model, 'm3')->checkbox(); ?>
            <?= $form->field($model, 'm46')->checkbox(); ?>
            <?= $form->field($model, 'm47')->checkbox(); ?>
          </div>
        </div>

        <div class="col-md-4">
          <div class="box-footer box-comments" style="margin-bottom:5px; margin-top:20px;background-color:#89a0c6">

            <span class="username">
              Hiring
            </span><!-- /.username -->
            <!-- /.comment-text -->

          </div>
          <div class="col-md-12">
            <?= $form->field($model, 'm35')->checkbox(); ?>
            <?= $form->field($model, 'm36')->checkbox(); ?>
            <?= $form->field($model, 'm37')->checkbox(); ?>
          </div>
        </div>
        <div class="col-md-12">
          <div class="box-footer box-comments" style="margin-bottom:5px; margin-top:20px; background-color:#89a0c6;">

            <span class="username">
              Recruitment Process
            </span><!-- /.username -->
            <!-- /.comment-text -->

          </div>
          <div class="col-md-4">
            <div class="box-footer box-comments" style="margin-bottom:5px;">

              <span class="username">
                Interview
              </span><!-- /.username -->
              <!-- /.comment-text -->

            </div>
            <div class="col-md-12">
              <?= $form->field($model, 'm4')->checkbox(); ?>
              <?= $form->field($model, 'm5')->checkbox(); ?>
              <?= $form->field($model, 'm6')->checkbox(); ?>
            </div>
          </div>
          <div class="col-md-4">
            <div class="box-footer box-comments" style="margin-bottom:5px;">

              <span class="username">
                Psikotest
              </span><!-- /.username -->
              <!-- /.comment-text -->

            </div>
            <div class="col-md-12">
              <?= $form->field($model, 'm7')->checkbox(); ?>
              <?= $form->field($model, 'm8')->checkbox(); ?>
              <?= $form->field($model, 'm9')->checkbox(); ?>
            </div>
          </div>
          <div class="col-md-4">
            <div class="box-footer box-comments" style="margin-bottom:5px;">

              <span class="username">
                User Interview
              </span><!-- /.username -->
              <!-- /.comment-text -->

            </div>
            <div class="col-md-12">
              <?= $form->field($model, 'm10')->checkbox(); ?>
              <?= $form->field($model, 'm11')->checkbox(); ?>
              <?= $form->field($model, 'm12')->checkbox(); ?>
            </div>
          </div>
          <div class="col-md-3">
            <div class="box-footer box-comments" style="margin-bottom:5px;">

              <span class="username">
                Training Soft Skill
              </span><!-- /.username -->
              <!-- /.comment-text -->

            </div>
            <div class="col-md-12">
              <?= $form->field($model, 'm38')->checkbox(); ?>
              <?= $form->field($model, 'm39')->checkbox(); ?>
            </div>
          </div>
          <div class="col-md-3">
            <div class="box-footer box-comments" style="margin-bottom:5px;">

              <span class="username">
                Training Hard skill
              </span><!-- /.username -->
              <!-- /.comment-text -->

            </div>
            <div class="col-md-12">
              <?= $form->field($model, 'm40')->checkbox(); ?>
              <?= $form->field($model, 'm41')->checkbox(); ?>
            </div>
          </div>
          <div class="col-md-3">
            <div class="box-footer box-comments" style="margin-bottom:5px;">

              <span class="username">
                Tendem Pasif
              </span><!-- /.username -->
              <!-- /.comment-text -->

            </div>
            <div class="col-md-12">
              <?= $form->field($model, 'm42')->checkbox(); ?>
              <?= $form->field($model, 'm43')->checkbox(); ?>
            </div>
          </div>
          <div class="col-md-3">
            <div class="box-footer box-comments" style="margin-bottom:5px;">

              <span class="username">
                Tendem Aktif
              </span><!-- /.username -->
              <!-- /.comment-text -->

            </div>
            <div class="col-md-12">
              <?= $form->field($model, 'm44')->checkbox(); ?>
              <?= $form->field($model, 'm45')->checkbox(); ?>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="box-footer box-comments" style="margin-bottom:5px; margin-top:20px; background-color:#89a0c6;">

            <span class="username">
              Master Data
            </span><!-- /.username -->
            <!-- /.comment-text -->

          </div>
          <div class="col-md-2">
            <div class="box-footer box-comments" style="margin-bottom:5px;">

              <span class="username">
                Applicant Master
              </span><!-- /.username -->
              <!-- /.comment-text -->

            </div>
            <div class="col-md-12">
              <?= $form->field($model, 'm13')->checkbox(); ?>
              <?= $form->field($model, 'm14')->checkbox(); ?>
              <?= $form->field($model, 'm49')->checkbox(); ?>
            </div>
          </div>
          <div class="col-md-2 ">
            <div class="box-footer box-comments" style="margin-bottom:5px;">

              <span class="username">
                User Login
              </span><!-- /.username -->
              <!-- /.comment-text -->

            </div>
            <div class="col-md-12">
              <?= $form->field($model, 'm15')->checkbox(); ?>
              <?= $form->field($model, 'm16')->checkbox(); ?>
              <?= $form->field($model, 'm17')->checkbox(); ?>
              <?= $form->field($model, 'm18')->checkbox(); ?>
            </div>
          </div>
          <div class="col-md-2 ">
            <div class="box-footer box-comments" style="margin-bottom:5px;">

              <span class="username">
                User Role
              </span><!-- /.username -->
              <!-- /.comment-text -->

            </div>
            <div class="col-md-12">
              <?= $form->field($model, 'm19')->checkbox(); ?>
              <?= $form->field($model, 'm20')->checkbox(); ?>
              <?= $form->field($model, 'm21')->checkbox(); ?>
              <?= $form->field($model, 'm22')->checkbox(); ?>
            </div>
          </div>
          <div class="col-md-2">
            <div class="box-footer box-comments" style="margin-bottom:5px;">

              <span class="username">
                Master Office
              </span><!-- /.username -->
              <!-- /.comment-text -->

            </div>
            <div class="col-md-12">
              <?= $form->field($model, 'm23')->checkbox(); ?>
              <?= $form->field($model, 'm24')->checkbox(); ?>
              <?= $form->field($model, 'm25')->checkbox(); ?>
              <?= $form->field($model, 'm26')->checkbox(); ?>
            </div>
          </div>
          <div class="col-md-2">
            <div class="box-footer box-comments" style="margin-bottom:5px;">

              <span class="username">
                Master Room
              </span><!-- /.username -->
              <!-- /.comment-text -->

            </div>
            <div class="col-md-12">
              <?= $form->field($model, 'm27')->checkbox(); ?>
              <?= $form->field($model, 'm28')->checkbox(); ?>
              <?= $form->field($model, 'm29')->checkbox(); ?>
              <?= $form->field($model, 'm30')->checkbox(); ?>
            </div>
          </div>
          <div class="col-md-2">
            <div class="box-footer box-comments" style="margin-bottom:5px;">
              <span class="username">
                Master PIC
              </span><!-- /.username -->
              <!-- /.comment-text -->
            </div>
            <div class="col-md-12">
              <?= $form->field($model, 'm31')->checkbox(); ?>
              <?= $form->field($model, 'm32')->checkbox(); ?>
              <?= $form->field($model, 'm33')->checkbox(); ?>
              <?= $form->field($model, 'm34')->checkbox(); ?>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="col-md-2">
            <div class="box-footer box-comments" style="margin-bottom:5px;">

              <span class="username">
                Applicant login
              </span><!-- /.username -->
              <!-- /.comment-text -->

            </div>
            <div class="col-md-12">
              <?= $form->field($model, 'm51')->checkbox(); ?>
            </div>
          </div>
          <div class="col-md-2">
            <div class="box-footer box-comments" style="margin-bottom:5px;">
              <span class="username">
                Master Industry
              </span><!-- /.username -->
              <!-- /.comment-text -->
            </div>

            <div class="col-md-12">
              <?= $form->field($model, 'm72')->checkbox(); ?>
              <?= $form->field($model, 'm73')->checkbox(); ?>
              <?= $form->field($model, 'm74')->checkbox(); ?>
              <?= $form->field($model, 'm75')->checkbox(); ?>
            </div>
          </div>
          <div class="col-md-2">
            <div class="box-footer box-comments" style="margin-bottom:5px;">
              <span class="username">
                Master Job Family
              </span><!-- /.username -->
              <!-- /.comment-text -->
            </div>

            <div class="col-md-12">
              <?= $form->field($model, 'm76')->checkbox(); ?>
              <?= $form->field($model, 'm77')->checkbox(); ?>
              <?= $form->field($model, 'm78')->checkbox(); ?>
              <?= $form->field($model, 'm79')->checkbox(); ?>
            </div>
          </div>
          <div class="col-md-2">
            <div class="box-footer box-comments" style="margin-bottom:5px;">
              <span class="username">
                Master Sub Job Family
              </span><!-- /.username -->
              <!-- /.comment-text -->
            </div>

            <div class="col-md-12">
              <?= $form->field($model, 'm80')->checkbox(); ?>
              <?= $form->field($model, 'm81')->checkbox(); ?>
              <?= $form->field($model, 'm82')->checkbox(); ?>
              <?= $form->field($model, 'm83')->checkbox(); ?>
            </div>
          </div>
          <div class="col-md-2">
            <div class="box-footer box-comments" style="margin-bottom:5px;">
              <span class="username">
                Mapping Job Position
              </span><!-- /.username -->
              <!-- /.comment-text -->
            </div>

            <div class="col-md-12">
              <?= $form->field($model, 'm84')->checkbox(); ?>
              <?= $form->field($model, 'm85')->checkbox(); ?>
              <?= $form->field($model, 'm86')->checkbox(); ?>
              <?= $form->field($model, 'm87')->checkbox(); ?>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="box-footer box-comments" style="margin-bottom:5px; margin-top:20px; background-color:#89a0c6;">

            <span class="username">
              Report
            </span><!-- /.username -->
            <!-- /.comment-text -->

          </div>
          <div class="col-md-2 ">
            <div class="box-footer box-comments" style="margin-bottom:5px;">

              <span class="username">
                Hiring
              </span><!-- /.username -->
              <!-- /.comment-text -->

            </div>
            <div class="col-md-12">
              <?= $form->field($model, 'm48')->checkbox(); ?>
            </div>
          </div>
          <div class="col-md-2 ">
            <div class="box-footer box-comments" style="margin-bottom:5px;">

              <span class="username">
                Applicant data
              </span><!-- /.username -->
              <!-- /.comment-text -->

            </div>
            <div class="col-md-12">
              <?= $form->field($model, 'm50')->checkbox(); ?>
            </div>
          </div>
          <div class="col-md-2 ">
            <div class="box-footer box-comments" style="margin-bottom:5px;">

              <span class="username">
                Job Order
              </span><!-- /.username -->
              <!-- /.comment-text -->

            </div>
            <div class="col-md-12">
              <?= $form->field($model, 'm66')->checkbox(); ?>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="box-footer box-comments" style="margin-bottom:5px; margin-top:20px; background-color:#89a0c6;">

            <span class="username">
              Change Request
            </span><!-- /.username -->
            <!-- /.comment-text -->

          </div>
          <div class="col-md-2 ">
            <div class="box-footer box-comments" style="margin-bottom:5px;">

              <span class="username">
                Personal Data
              </span><!-- /.username -->
              <!-- /.comment-text -->

            </div>
            <div class="col-md-12">
              <?= $form->field($model, 'm52')->checkbox(); ?>
              <?= $form->field($model, 'm53')->checkbox(); ?>
              <?= $form->field($model, 'm54')->checkbox(); ?>
              <?= $form->field($model, 'm55')->checkbox(); ?>
              <?= $form->field($model, 'm56')->checkbox(); ?>
            </div>
          </div>
          <div class="col-md-2 ">
            <div class="box-footer box-comments" style="margin-bottom:5px;">

              <span class="username">
                Bank Account
              </span><!-- /.username -->
              <!-- /.comment-text -->

            </div>
            <div class="col-md-12">
              <?= $form->field($model, 'm57')->checkbox(); ?>
              <?= $form->field($model, 'm58')->checkbox(); ?>
              <?= $form->field($model, 'm59')->checkbox(); ?>
              <?= $form->field($model, 'm60')->checkbox(); ?>
              <?= $form->field($model, 'm61')->checkbox(); ?>
            </div>
          </div>
          <div class="col-md-2 ">
            <div class="box-footer box-comments" style="margin-bottom:5px;">

              <span class="username">
                Stop Job Order
              </span><!-- /.username -->
              <!-- /.comment-text -->

            </div>
            <div class="col-md-12">
              <?= $form->field($model, 'm64')->checkbox(); ?>
              <?= $form->field($model, 'm65')->checkbox(); ?>
            </div>

          </div>
          <div class="col-md-2 ">
            <div class="box-footer box-comments" style="margin-bottom:5px;">

              <span class="username">
                Resign
              </span><!-- /.username -->
              <!-- /.comment-text -->

            </div>
            <div class="col-md-12">
              <?= $form->field($model, 'm67')->checkbox(); ?>
              <?= $form->field($model, 'm68')->checkbox(); ?>
              <?= $form->field($model, 'm69')->checkbox(); ?>
              <?= $form->field($model, 'm70')->checkbox(); ?>
              <?= $form->field($model, 'm71')->checkbox(); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="box-footer">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
  </div>
  <?php ActiveForm::end(); ?>
</div>