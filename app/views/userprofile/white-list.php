<?php

use yii\helpers\Html;
use kartik\editors\Summernote;
use kartik\form\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Update User: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="User-update">
  <?php $form = ActiveForm::begin([
    'options' => []
  ]); ?>
  <blockquote>
    <p>User ID: <?php echo $model->id; ?></p>
    <p>Fullname: <?php echo $model->name; ?></p>
    <p>Email: <?php echo $model->email; ?></p>
    <p>Phone Number: <?php echo $model->mobile; ?></p>
  </blockquote>
  <div class="box-body">

    <!-- <?//php
    // echo   $form->field($model, 'status')->widget(Select2::classname(), [
    //   'data' => [0 => 'Inactive', 10 => 'Active'],
    //   'options' => ['placeholder' => '- select -'],
    //   'pluginOptions' => [
    //     'allowClear' => true,
    //   ],
    // ])->label('is User Active?');
    ?> -->

    <?php
    echo   $form->field($model, 'is_whitelist')->widget(Select2::classname(), [
      'data' => ['whitelist' => 'Whitelist', 'blacklist' => 'Blacklist'],
      'options' => ['placeholder' => '- select -'],
      'pluginOptions' => [
        'allowClear' => true,
      ],
    ])->label('is User Whitelist?');
    ?>

  </div>
  <div class="box-footer">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat pull-right']) ?>
  </div>
  <?php ActiveForm::end(); ?>

</div>