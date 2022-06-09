<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use app\models\Mastersubjobfamily;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\mappingjobsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mapping Job Position';
$this->params['breadcrumbs'][] = $this->title;

Modal::begin([
    'header' => '<h4 class="modal-title">View Job Position</h4>',
    'id' => 'viewmappingjob-modal',
    'size' => 'modal-md'
]);

echo "<div id='mappingjobview'></div>";


Modal::end();
Modal::begin([
    'header' => '<h4 class="modal-title">Update Mapping Job Position</h4>',
    'id' => 'updatemappingjob-modal',
    'size' => 'modal-md'
]);

echo "<div id='updatemappingjob'></div>";


Modal::end();
Modal::begin([
    'header' => '<h4 class="modal-title">Create New Job Position</h4>',
    'id' => 'createmappingjob-modal',
    'size' => 'modal-md'
]);

echo "<div id='createmappingjob'></div>";


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
<div class="mappingjob-index box box-default">
    <?php if (Yii::$app->utils->permission($role, 'm85')) : ?>
        <div class="box-header with-border">
            <?php echo Html::button('Create', [
                'value' => Yii::$app->urlManager->createUrl('mappingjob/create'), //<---- here is where you define the action that handles the ajax request
                'class' => 'btn btn-md btn-success createmappingjob-modal-click',
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'title' => 'Create New Job Position'
            ]); ?>
        </div>
    <?php endif; ?>
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
                        'options' => ['placeholder' => '--'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            // 'minimumInputLength' => 1,
                            'min-width' => '100px',
                        ],
                    ]),
                    'value' => 'subjobfam.subjobfamily'

                ],
                'kodejabatan',
                'jabatansap',
                [
                    'attribute' => 'status',
                    'contentOptions' => ['style' => 'min-width: 200px;'],
                    'format' => 'html',
                    'filter' => \kartik\select2\Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'status',
                        'data' => ['1' => 'Publish', '0' => 'Unpublished'],
                        'options' => ['placeholder' => '--'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'min-width' => '200px',
                        ],
                    ]),
                    'value' => function ($data) {
                        return ($data->status == 1) ? 'Published' : 'Unpublished';
                    }

                ],

                // 'createtime',
                // 'updatetime',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['style' => 'max-width: 150px;'],
                    'template' => '<div class="btn-group pull-right">' . $action . '</div>',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            $btn = Html::button('<i class="fa fa-eye" style="font-size:12pt;"></i>', [
                                'value' => Yii::$app->urlManager->createUrl('mappingjob/view?id=' . $model->id), //<---- here is where you define the action that handles the ajax request
                                'class' => 'btn btn-sm btn-info viewmappingjob-modal-click',
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'bottom',
                                'title' => 'Views Detail'
                            ]);
                            return $btn;
                        },
                        'update' => function ($url, $model, $key) {
                            $btn = Html::button('<i class="fa fa-pencil" style="font-size:12pt;"></i>', [
                                'value' => Yii::$app->urlManager->createUrl('mappingjob/update?id=' . $model->id), //<---- here is where you define the action that handles the ajax request
                                'class' => 'btn btn-sm btn-default updatemappingjob-modal-click',
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