<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\modules\dashboard\models\Permission;
use kartik\file\FileInput;

$this->title = 'Create Bulk CR Resign';
$this->params['breadcrumbs'][] = ['label' => 'CR Resign', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$baseUrl = Yii::$app->request->baseUrl;

?>

<script type="text/javascript">
    var uploadData = null;
    var uploadDataCount = 0;
    var uploadDataFirstRow = '<?php echo $uploadDataFirstRow; ?>';
</script>


<?php $form = ActiveForm::begin([
    'id' => 'cr-form',
    'enableClientScript' => false,
    'enableClientValidation' => false,
    'options' => array(
        'enctype' => 'multipart/form-data',
    ),
]); ?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-body">
                <div class="row hidden-xs">
                    <div id="upload-input" class="col-md-12">
                        <input type="hidden" id="store-identifier" class="form-control" name="identifier" value="<?php echo $uploadIdentifier; ?>">
                        <?php $type = substr($model->file_upload, strpos($model->file_upload, '.') + 1);
                        $file = '';
                        $assetUrl = Yii::$app->request->baseUrl;
                        ?>
                        <?= $form->field($model, 'file_upload')->widget(FileInput::className(), [
                            'options' => ['accept' => ''],
                            'pluginOptions' => [
                                'showRemove' => true,
                                // 'theme' => 'explorer-fa',
                                'showUpload' => false,
                                'showCancel' => true,
                                'showPreview' => true,
                                'overwriteInitial' => true,
                                'previewFileType' => 'any',
                                // 'initialPreviewAsData' => $asdata,
                                'initialPreview' => $file,
                                'initialPreviewConfig' => [
                                    ['type' => $type, 'caption' => $model->file_upload, 'deleteUrl' => false],
                                ],
                                'uploadAsync' => true,
                                'allowedExtensions' => ['csv', 'xls', 'xlsx'],
                            ]
                        ]) ?>
                        <script type="text/javascript">
                            var uploadIdentifier = '<?php echo $uploadIdentifier; ?>';
                        </script>
                        <div class="hint-block">
                            Allowed file types are: <strong>.txt, .csv, .xls and .xlsx</strong><br>
                            Templates:
                            <ul style="padding-left:25px;">
                                <?php
                                $sampleFile = Yii::getAlias('@web') . '/assets/data/example/store.csv';
                                $sampleFileXls = Yii::getAlias('@web') . '/assets/data/example/store.xls';
                                $sampleFileXlsx = Yii::getAlias('@web') . '/assets/data/example/store.xlsx';
                                ?>
                                <li><a href="<?php echo $sampleFile; ?>">Comma Separated Values (.csv/.txt)</a></li>
                                <li><a href="<?php echo $sampleFileXls; ?>">Microsoft Excel (.xls)</a></li>
                                <li><a href="<?php echo $sampleFileXlsx; ?>">Microsoft Excel 2007 (.xlsx)</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="box-footer">
                        <a href="<?php echo $baseUrl; ?>/chagerequestresign/index" class="btn btn-default btn-flat"><span class="fa fa-chevron-left"></span> Cancel</a>

                        <div class="pull-right">
                            <?= Html::submitButton('Submit File', ['class' => 'btn btn-success btn']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>