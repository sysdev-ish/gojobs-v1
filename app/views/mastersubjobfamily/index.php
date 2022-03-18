<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MastersubjobfamilySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Sub Job Family';
$this->params['breadcrumbs'][] = $this->title;
Modal::begin([
    'header' => '<h4 class="modal-title">View Sub Job Family</h4>',
    'id' => 'viewmastersubjobfamily-modal',
    'size' => 'modal-md'
]);

echo "<div id='mastersubjobfamilyview'></div>";
Modal::end();

Modal::begin([
    'header' => '<h4 class="modal-title">Update Sub Job Family</h4>',
    'id' => 'updatemastersubjobfamily-modal',
    'size' => 'modal-md'
]);

echo "<div id='updatemastersubjobfamily'></div>";
Modal::end();

Modal::begin([
    'header' => '<h4 class="modal-title">Create New Sub Job Family</h4>',
    'id' => 'createmastersubjobfamily-modal',
    'size' => 'modal-md'
]);

echo "<div id='createmastersubjobfamily'></div>";
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
<div class="mastersubjobfamily-index box box-default">

    <div class="box-header with-border">
        <?php echo Html::button('Create', [
            'value' => Yii::$app->urlManager->createUrl('mastersubjobfamily/create'), //<---- here is where you define the action that handles the ajax request
            'class' => 'btn btn-md btn-success createmastersubjobfamily-modal-click',
            'data-toggle' => 'tooltip',
            'data-placement' => 'bottom',
            'title' => 'Create New Sub Job Family'
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
                ['class' => 'yii\grid\SerialColumn'],

                // 'id',
                'jobfamily_id',
                // [
                //     'label' => 'Job Family',
                //     'attribute' => 'jobfamily',
                //     'format' => 'html',
                //     'value' => function ($data) {
                //         return $data->masterjobfamily->jobfamily_id;
                //     }
                // ],
                // 'createtime',
                // 'updatetime'
                'subjobfamily',
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
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['style' => 'min-width: 150px;'],
                    'template' => '<div class="btn-group pull-right">' . $action . '</div>',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            $btn = Html::button('<i class="fa fa-eye" style="font-size:12pt;"></i>', [
                                'value' => Yii::$app->urlManager->createUrl('mastersubjobfamily/view?id=' . $model->id), //<---- here is where you define the action that handles the ajax request
                                'class' => 'btn btn-sm btn-info viewmastersubjobfamily-modal-click',
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'bottom',
                                'title' => 'Views Detail'
                            ]);
                            return $btn;
                        },
                        'update' => function ($url, $model, $key) {
                            $btn = Html::button('<i class="fa fa-pencil" style="font-size:12pt;"></i>', [
                                'value' => Yii::$app->urlManager->createUrl('mastersubjobfamily/update?id=' . $model->id), //<---- here is where you define the action that handles the ajax request
                                'class' => 'btn btn-sm btn-default updatemastersubjobfamily-modal-click',
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