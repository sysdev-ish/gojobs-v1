<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Mappinggrouprolepermission;

/* @var $this yii\web\View */
/* @var $model app\models\Grouprolepermission */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="grouprolepermission-form box box-default">
  <?php $form = ActiveForm::begin(); ?>
  <div class="box-body">

    <div class="row">
      <div class="col-md-12">
        <?= $form->field($model, 'grouprolepermission')->textInput(['maxlength' => true]) ?>
      </div>
      <div class="col-md-12">
        <?php foreach ($userrole as $index => $value): ?>

          <div class="col-md-3">
            <?php
            $data = Mappinggrouprolepermission::find()->where(['roleid' => $value->id,'grouprolepermissionid'=>$model->id])->one();
            if($data){
              $dataInsert = $data;
            }else{
              $dataInsert =  new Mappinggrouprolepermission();
            }
            if($dataInsert):
            ?>
            <?= $form->field($dataInsert, "[$index]roleid")->hiddenInput(['value'=> $value->id])->label(false) ?>
            <?= $form->field($dataInsert, "[$index]active")->checkbox(['label' => $value->role]); ?>
          <?php endif; ?>
          </div>

        <?php endforeach; ?>
      </div>
    </div>

  </div>
  <div class="box-footer">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
  </div>
  <?php ActiveForm::end(); ?>
</div>
