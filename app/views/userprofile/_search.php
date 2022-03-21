<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Userprofilesearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="userprofile-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'userid') ?>

    <?= $form->field($model, 'createtime') ?>

    <?= $form->field($model, 'updatetime') ?>

    <?= $form->field($model, 'fullname') ?>

    <?php // echo $form->field($model, 'nickname') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'birthdate') ?>

    <?php // echo $form->field($model, 'birthplace') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'postalcode') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'domicilestatus') ?>

    <?php // echo $form->field($model, 'domicilestatusdescription') ?>

    <?php // echo $form->field($model, 'addressktp') ?>

    <?php // echo $form->field($model, 'nationality') ?>

    <?php // echo $form->field($model, 'religion') ?>

    <?php // echo $form->field($model, 'maritalstatus') ?>

    <?php // echo $form->field($model, 'weddingdate') ?>

    <?php // echo $form->field($model, 'bloodtype') ?>

    <?php // echo $form->field($model, 'identitynumber') ?>

    <?php // echo $form->field($model, 'jamsosteknumber') ?>

    <?php // echo $form->field($model, 'npwpnumber') ?>

    <?php // echo $form->field($model, 'drivinglicencecarnumber') ?>

    <?php // echo $form->field($model, 'drivinglicencemotorcyclenumber') ?>
    
    <?php // echo $form->field($model, 'jobfamily') ?>
    
    <?php // echo $form->field($model, 'subjobfamily') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
