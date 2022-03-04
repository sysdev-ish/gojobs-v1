<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $model app\models\Userworkexperienceposition */
/* @var $form yii\widgets\ActiveForm */
?>

<?php DynamicFormWidget::begin([
  'widgetContainer' => 'dynamicform_inner',
  'widgetBody' => '.form-options-body_inner',
  'widgetItem' => '.form-options-item_inner',
  'min' => 1,
  'limit' => 10,
  'insertButton' => '.add-item_inner',
  'deleteButton' => '.delete-item_inner',
  'model' => $modelwexpp[0],
  'formId' => 'workexperience-form',
  'formFields' => [
    'id',

  ],
]); ?>
<div style="width:100%;">
  <div class="container-items"><!-- widgetBody -->
    <table class="table  table-border" style="width:100%;">

      <tbody class="form-options-body_inner">
        <?php foreach ($modelwexpp as $indexwexpp => $modelwexpp): ?>

          <tr class="form-options-item_inner">
            <?php
            if (! $modelwexpp->isNewRecord) {
              echo Html::activeHiddenInput($modelwexpp, "[{$index}][{$indexwexpp}]id");
            }?>
            <td class="vcenter">
              <?= $form->field($modelwexpp, "[{$index}][{$indexwexpp}]position")->label(false)->textInput(["maxlength" => true]) ?>
            </td>
            <td class="vcenter">
              <?= $form->field($modelwexpp, "[{$index}][{$indexwexpp}]salary")->label(false)->textInput(["maxlength" => true]) ?>
            </td>
            <td class="vcenter">
              <?= $form->field($modelwexpp, "[{$index}][{$indexwexpp}]jobdesc")->label(false)->textArea(["maxlength" => true,"rows"=>"2"]) ?>
            </td>
            <td class="text-center vcenter">
              <button type="button" class="delete-item_inner btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
            </td>

          </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3"></td>
          <td style="text-align: center"><button type="button" class="add-item_inner btn btn-success btn-sm"><span class="fa fa-plus"></span> Add Position</button></td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
<?php DynamicFormWidget::end(); ?>
