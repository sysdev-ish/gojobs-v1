<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use app\models\Transrincianrekrut;
use app\models\Mastersubjobfamily;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\mappingjobpositionsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mapping Job Position';
$this->params['breadcrumbs'][] = $this->title;

Modal::begin([
    'header' => '<h4 class="modal-title">View Job Position</h4>',
    'id' => 'viewmappingjobposition-modal',
    'size' => 'modal-md'
]);

echo "<div id='mappingjobpositionview'></div>";


Modal::end();
Modal::begin([
    'header' => '<h4 class="modal-title">Update Mapping Job Position</h4>',
    'id' => 'updatemappingjobposition-modal',
    'size' => 'modal-md'
]);

echo "<div id='updatemappingjobposition'></div>";


Modal::end();
Modal::begin([
    'header' => '<h4 class="modal-title">Create New Job Position</h4>',
    'id' => 'createmappingjobposition-modal',
    'size' => 'modal-md'
]);

echo "<div id='createmappingjobposition'></div>";


Modal::end();


if (Yii::$app->user->isGuest) {
    $role = null;
} else {
    // $userid = Yii::$app->user->identity->id;
    $role = Yii::$app->user->identity->role;
}
if (Yii::$app->utils->permission($role, 'm25') && Yii::$app->utils->permission($role, 'm26')) {
    $action = '{view}{update}{delete}';
} elseif (Yii::$app->utils->permission($role, 'm25')) {
    $action = '{view}{update}';
} elseif (Yii::$app->utils->permission($role, 'm26')) {
    $action = '{view}{delete}';
} else {
    $action = '{view}';
}
?>
<div class="mappingjobposition-index box box-default">
    <div class="box-header with-border">
        <?php echo Html::button('Create', [
            'value' => Yii::$app->urlManager->createUrl('mappingjobposition/create'), //<---- here is where you define the action that handles the ajax request
            'class' => 'btn btn-md btn-success createmappingjobposition-modal-click',
            'data-toggle' => 'tooltip',
            'data-placement' => 'bottom',
            'title' => 'Create New Job Position'
        ]); ?>
    </div>
    <div class="box-body table-responsive">
        <?php // echo $this->render('_search', ['model' => $searchModel]); 
        ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'contentOptions' => ['style' => 'width: 50px;'],
                ],

                // 'id',
                [
                    'attribute' => 'subjobfamilyid',
                    'format' => 'html',
                    'contentOptions' => ['style' => 'min-width: 100px;'],
                    'filter' => \kartik\select2\Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'subjobfamilyid',
                        'data' => ArrayHelper::map(Mastersubjobfamily::find()->asArray()->all(), 'id', 'subjobfamily'),
                        'options' => ['placeholder' => 'Sub Job Family'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 1,
                            'min-width' => '100px',
                        ],
                    ]),
                    'value' => function ($data) {
                        return ($data->mastersubjobfamily) ? $data->mastersubjobfamily->subjobfamily : '';
                    }

                ],
                [
                    'attribute' => 'jabatansap',
                    'format' => 'html',
                    'contentOptions' => ['style' => 'min-width: 100px;'],
                    'filter' => \kartik\select2\Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'jabatansap',
                        'data' => ArrayHelper::map(Transrincianrekrut::find()->asArray()->all(), 'id', 'jabatan_sap'),
                        'options' => ['placeholder' => '2xxxxxxx'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 5,
                        ],
                    ]),
                    'value' => function ($data) {
                        return ($data->masterjabatansap) ? $data->masterjabatansap->jabatan_sap : '';
                    }

                ],
                [
                    'attribute' => 'kodeposisi',
                    'format' => 'html',
                    'contentOptions' => ['style' => 'min-width: 100px;'],
                    'filter' => \kartik\select2\Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'kodeposisi',
                        'data' => ArrayHelper::map(Transrincianrekrut::find()->asArray()->all(), 'id', 'hire_jabatan_sap'),
                        'options' => ['placeholder' => '2xxxxxxx'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 5,
                        ],
                    ]),
                    'value' => function ($data) {
                        return ($data->masterkodeposisi) ? $data->masterkodeposisi->hire_jabatan_sap : '';
                    }

                ],
                [
                    'attribute' => 'kodejabatan',
                    'format' => 'html',
                    'contentOptions' => ['style' => 'min-width: 100px;'],
                ],
                // 'createtime',
                // 'updatetime',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['style' => 'max-width: 100px;'],
                    'template' => '<div class="btn-group pull-right">' . $action . '</div>',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            $btn = Html::button('<i class="fa fa-eye" style="font-size:12pt;"></i>', [
                                'value' => Yii::$app->urlManager->createUrl('mappingjobposition/view?id=' . $model->id), //<---- here is where you define the action that handles the ajax request
                                'class' => 'btn btn-sm btn-info viewmappingjobposition-modal-click',
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'bottom',
                                'title' => 'Views Detail'
                            ]);
                            return $btn;
                        },
                        'update' => function ($url, $model, $key) {
                            $btn = Html::button('<i class="fa fa-pencil" style="font-size:12pt;"></i>', [
                                'value' => Yii::$app->urlManager->createUrl('mappingjobposition/update?id=' . $model->id), //<---- here is where you define the action that handles the ajax request
                                'class' => 'btn btn-sm btn-default updatemappingjobposition-modal-click',
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'bottom',
                                'title' => 'Update'
                            ]);
                            return $btn;
                        },
                        'delete' => function ($url, $model) {
                            return Html::a('<i class="fa fa-trash" style="font-size:12pt;"></i>', ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-sm btn-danger',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                                'data-toggle' => 'tooltip',
                                'title' => 'delete'
                            ]);
                        }
                    ]
                ],
            ],
        ]); ?>
    </div>
</div>
