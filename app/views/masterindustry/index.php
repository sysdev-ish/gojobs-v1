<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use app\models\Masterindustry;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MasterindustrySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Industry';
$this->params['breadcrumbs'][] = $this->title;
Modal::begin([
    'header' => '<h4 class="modal-title">View Industry Type</h4>',
    'id' => 'viewmasterindustry-modal',
    'size' => 'modal-md'
]);

echo "<div id='masterindustryview'></div>";
Modal::end();

Modal::begin([
    'header' => '<h4 class="modal-title">Update Industry Type</h4>',
    'id' => 'updatemasterindustry-modal',
    'size' => 'modal-md'
]);

echo "<div id='updatemasterindustry'></div>";
Modal::end();

Modal::begin([
    'header' => '<h4 class="modal-title">Create New Industry Type</h4>',
    'id' => 'createmasterindustry-modal',
    'size' => 'modal-md'
]);

echo "<div id='createmasterindustry'></div>";
Modal::end();

if (Yii::$app->user->isGuest) {
    $role = null;
} else {
    // $userid = Yii::$app->user->identity->id;
    $role = Yii::$app->user->identity->role;
}
if (Yii::$app->utils->permission($role, 'm74') && Yii::$app->utils->permission($role, 'm75')) {
    $action = '{view}{update}{delete}';
} elseif (Yii::$app->utils->permission($role, 'm74')) {
    $action = '{view}{update}';
} elseif (Yii::$app->utils->permission($role, 'm75')) {
    $action = '{view}{delete}';
} else {
    $action = '{view}';
}

?>
<div class="masterindustry-index box box-default">
    <?php if (Yii::$app->utils->permission($role, 'm73')) : ?>
        <div class="box-header with-border">
            <?php echo Html::button('Create', [
                'value' => Yii::$app->urlManager->createUrl('masterindustry/create'), //<---- here is where you define the action that handles the ajax request
                'class' => 'btn btn-md btn-success createmasterindustry-modal-click',
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'title' => 'Create New Industry'
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
                ['class' => 'yii\grid\SerialColumn'],

                // 'id',
                // 'createtime',
                // 'updatetime'
                'industry_type',
                [
                    'attribute' => 'status',
                    'contentOptions' => ['style' => 'min-width: 200px;'],
                    'format' => 'html',
                    'filter' => \kartik\select2\Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'status',
                        'data' => ['0' => 'Unpublished', '1' => 'Publish'],
                        'options' => ['placeholder' => '--'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'min-width' => '200px',
                        ],
                    ]),
                    'value' => function ($data) {
                        // if ($data->status == 1) {
                        //     return 'Publish';
                        // } elseif ($data->status == 0) {
                        //     return 'Unpublished';
                        // }
                        return ($data->status == 1) ? 'Published' : 'Unpublished';
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['style' => 'width: 130px;'],
                    'template' => '<div class="btn-group pull-right">' . $action . '</div>',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            $btn = Html::button('<i class="fa fa-eye" style="font-size:12pt;"></i>', [
                                'value' => Yii::$app->urlManager->createUrl('masterindustry/view?id=' . $model->id), //<---- here is where you define the action that handles the ajax request
                                'class' => 'btn btn-sm btn-info viewmasterindustry-modal-click',
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'bottom',
                                'title' => 'Views Detail'
                            ]);
                            return $btn;
                        },
                        'update' => function ($url, $model, $key) {
                            $btn = Html::button('<i class="fa fa-pencil" style="font-size:12pt;"></i>', [
                                'value' => Yii::$app->urlManager->createUrl('masterindustry/update?id=' . $model->id), //<---- here is where you define the action that handles the ajax request
                                'class' => 'btn btn-sm btn-default updatemasterindustry-modal-click',
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