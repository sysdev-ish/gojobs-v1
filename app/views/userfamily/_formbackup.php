<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Userfamily */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="userfamily-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'userid')->textInput() ?>

        <?= $form->field($model, 'createtime')->textInput() ?>

        <?= $form->field($model, 'updatetime')->textInput() ?>

        <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'gender')->dropDownList([ 'male' => 'Male', 'female' => 'Female', ], ['prompt' => '']) ?>

        <?= $form->field($model, 'birthdate')->textInput() ?>

        <?= $form->field($model, 'birthplace')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'lasteducation')->dropDownList([ 'elementary_school' => 'Elementary school', 'junior_high_school' => 'Junior high school', 'senior_high_school' => 'Senior high school', 'associate_degree' => 'Associate degree', 'bachelor_degree' => 'Bachelor degree', 'master_degree' => 'Master degree', 'doctoral_degree' => 'Doctoral degree', ], ['prompt' => '']) ?>

        <?= $form->field($model, 'jobtitle')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'companyname')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'relationship')->dropDownList([ 'father' => 'Father', 'mother' => 'Mother', 'siblings' => 'Siblings', 'husband' => 'Husband', 'wife' => 'Wife', 'child' => 'Child', ], ['prompt' => '']) ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
