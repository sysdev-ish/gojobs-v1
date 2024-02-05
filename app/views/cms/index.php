<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'CMS';
$this->params['breadcrumbs'][] = $this->title;
Modal::begin([
    'header' => '<h4 class="modal-title">View CMS</h4>',
    'id' => 'viewcms-modal',
    'size' => 'modal-lg'
]);

echo "<div id='cmsview'></div>";
Modal::end();

Modal::begin([
    'header' => '<h4 class="modal-title">Update CMS</h4>',
    'id' => 'updatecms-modal',
    'size' => 'modal-lg'
]);

echo "<div id='updatecms'></div>";
Modal::end();

Modal::begin([
    'header' => '<h4 class="modal-title">Create New CMS</h4>',
    'id' => 'createcms-modal',
    'size' => 'modal-lg'
]);

echo "<div id='createcms'></div>";
Modal::end();

if (Yii::$app->user->isGuest) {
    $role = null;
} else {
    // $userid = Yii::$app->user->identity->id;
    $role = Yii::$app->user->identity->role;
}
if (Yii::$app->utils->permission($role, 'm133') && Yii::$app->utils->permission($role, 'm134')) {
    $action = '{view}{update}{delete}';
} elseif (Yii::$app->utils->permission($role, 'm133')) {
    $action = '{view}{update}';
} elseif (Yii::$app->utils->permission($role, 'm134')) {
    $action = '{view}{delete}';
} else {
    $action = '{view}';
}

?>
<div class="cms-index box box-default">
    <?php if (Yii::$app->utils->permission($role, 'm133')) : ?>
        <div class="box-header with-border">
            <?php echo Html::button('Create', [
                'value' => Yii::$app->urlManager->createUrl('cms/create'), //<---- here is where you define the action that handles the ajax request
                'class' => 'btn btn-md btn-success createcms-modal-click',
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'title' => 'Create New CMS'
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
                'title',
                // 'content',
                [
                    'label' => 'Content',
                    'attribute' => 'content',
                    'format' => 'html',
                    'value' => function ($data) {
                        return $data->content;
                    }
                ],
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
                [
                    'label' => 'Type',
                    'attribute' => 'type_content',
                    'format' => 'html',
                    'value' => function ($data) {
                        if ($data->type_content == 1) {
                            $type_content = "Banner";
                        } else if ($data->type_content == 2) {
                            $type_content = "Privacy & Policy";
                        } else if ($data->type_content == 2) {
                            $type_content = "Terms & Condition";
                        } else {
                            $type_content = "About & Contact";
                        }
                        return $type_content;
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['style' => 'min-width: 150px;'],
                    'template' => '<div class="btn-group pull-right">' . $action . '</div>',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            $btn = Html::button('<i class="fa fa-eye" style="font-size:12pt;"></i>', [
                                'value' => Yii::$app->urlManager->createUrl('cms/view?id=' . $model->id), //<---- here is where you define the action that handles the ajax request
                                'class' => 'btn btn-sm btn-info viewcms-modal-click',
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'bottom',
                                'title' => 'Views Detail'
                            ]);
                            return $btn;
                        },
                        'update' => function ($url, $model, $key) {
                            $btn = Html::button('<i class="fa fa-pencil" style="font-size:12pt;"></i>', [
                                'value' => Yii::$app->urlManager->createUrl('cms/update?id=' . $model->id), //<---- here is where you define the action that handles the ajax request
                                'class' => 'btn btn-sm btn-default updatecms-modal-click',
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