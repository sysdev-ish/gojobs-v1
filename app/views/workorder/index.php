<?php

use app\models\MappingCity;
use app\models\Mappingjob;
use app\models\Mastercity;
use app\models\Sapjob;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use floor12\summernote\Summernote;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MasterjobfamilySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Work Order';
$this->params['breadcrumbs'][] = $this->title;
Modal::begin([
    'header' => '<h4 class="modal-title">View Work Order</h4>',
    'id' => 'viewworkorder-modal',
    'size' => 'modal-xl'
]);
echo "<div id='viewworkorder'></div>";
Modal::end();

Modal::begin([
    'header' => '<h4 class="modal-title">Update Work Order</h4>',
    'id' => 'updateworkorder-modal',
    'size' => 'modal-xl'
]);
echo "<div id='updateworkorder'></div>";
Modal::end();

Modal::begin([
    'header' => '<h4 class="modal-title">Create New Work Order</h4>',
    'id' => 'createworkorder-modal',
    'size' => 'modal-xl'
]);
echo "<div id='createworkorder'></div>";
Modal::end();

Modal::begin([
    'header' => '<h4 class="modal-title">Add Candidate</h4>',
    'id' => 'addcandidate2workorder-modal',
    'size' => 'modal-xl',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    // 'pjaxContainer' => '#addcandidate',
]);
echo "<div id='addcandidateform2'></div>";
Modal::end();

if (Yii::$app->user->isGuest) {
    $role = null;
} else {
    // $userid = Yii::$app->user->identity->id;
    $role = Yii::$app->user->identity->role;
}
if (Yii::$app->utils->permission($role, 'm78') && Yii::$app->utils->permission($role, 'm79')) {
    $action = '{view}{addcandidate}{update}{setting}{delete}';
} elseif (Yii::$app->utils->permission($role, 'm78')) {
    $action = '{view}{update}';
} elseif (Yii::$app->utils->permission($role, 'm79')) {
    $action = '{view}{delete}';
} else {
    $action = '{view}';
}

?>
<div class="workorder-index box box-default">
    <?php if (Yii::$app->utils->permission($role, 'm77')) : ?>
        <div class="box-header with-border">
            <?php echo Html::button('Create', [
                'value' => Yii::$app->urlManager->createUrl('workorder/create'), //<---- here is where you define the action that handles the ajax request
                'class' => 'btn btn-md btn-success createworkorder-modal-click',
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'title' => 'Create New Work Order'
            ]); ?>
            <?php echo Html::a('<i class="fa fa-tasks" style="font-size:12pt;"></i>', ['manage'], [
                'class' => 'btn btn-sm btn-default pull-right',
                'data-toggle' => 'tooltip',
                'title' => 'Change Layout'
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
                // 'created_time',
                // 'updated_time'
                [
                    'attribute' => 'wo_number',
                    'contentOptions' => ['style' => 'width: 250px;']
                ],

                [
                    'label' => 'Jabatan',
                    'format' => 'html',
                    'filter' => \kartik\select2\Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'job_code',
                        'data' => ArrayHelper::map(Mappingjob::find()->asArray()->all(), 'kodejabatan', 'jabatansap'),
                        'options' => ['placeholder' => '--'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            // 'width' => '120px',
                        ],
                    ]),
                    'value' => function ($data) {
                        if ($data->job_code) {
                            return $data->jobsap->jabatansap;
                        } else {
                            return "-";
                        }
                    }
                ],

                [
                    'label' => 'City',
                    // 'attribute' => 'city',
                    'contentOptions' => ['style' => 'width: 100px;'],
                    'format' => 'html',
                    'filter' => \kartik\select2\Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'location',
                        'data' => ArrayHelper::map(MappingCity::find()->asArray()->all(), 'city_id', 'city_name'),
                        'options' => ['placeholder' => '--'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            // 'width' => '120px',
                        ],
                    ]),
                    'value' => function ($data) {
                        return ($data->city) ? $data->city->city_name : '';
                    }
                ],

                [
                    'label' => 'Project',
                    'attribute' => 'project_name',
                    'format' => 'html',
                    'value' => function ($data) {
                        return $data->project_name;
                    }
                ],
                [
                    'label' => 'Total Job',
                    'contentOptions' => ['style' => 'width: 100px'],
                    'attribute' => 'total_job',
                    'format' => 'html',
                    'value' => function ($data) {
                        return $data->total_job;
                    }
                    
                ],
                [
                    'label' => 'Total Applied',
                    'contentOptions' => ['style' => 'width: 100px'],
                    'format' => 'html',
                    'value' => function ($data) {
                        return Yii::$app->check->wo_applied($data->id);
                    }
                ],

                [
                    'label' => 'Candidated',
                    'contentOptions' => ['style' => 'width: 100px'],
                    'format' => 'html',
                    'value' => function ($data) {
                        return Yii::$app->check->wo_candidate($data->id);
                    }
                ],

                [
                    'label' => 'Hired',
                    'contentOptions' => ['style' => 'width: 100px'],
                    'format' => 'html',
                    'value' => function ($data) {
                        return Yii::$app->check->wo_hired($data->id, 1);
                    }
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['style' => 'min-width: 80px;'],
                    'template' => '<div class="btn-group pull-right">' . $action . '</div>',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            $btn = Html::button('<i class="fa fa-eye" style="font-size:12pt;"></i>', [
                                'value' => Yii::$app->urlManager->createUrl('workorder/view?id=' . $model->id), //<---- here is where you define the action that handles the ajax request
                                'class' => 'btn btn-sm btn-info viewworkorder-modal-click',
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'bottom',
                                'title' => 'Views Detail'
                            ]);
                            return $btn;
                        },
                        'addcandidate' => function ($url, $model, $key) {
                            ($model->status == 2 || $model->status == 4) ? $disabled = true : $disabled = false;
                            return Html::button('<i class="fa fa-user-plus" style="font-size:12pt;"></i>', [
                                'value' => Yii::$app->urlManager->createUrl('wocandidate/addcandidate2?id=' . $model->id), //<---- here is where you define the action that handles the ajax request
                                'class' => 'btn btn-sm btn-default addcandidate2workorder-modal-click',
                                'disabled' => $disabled,
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'bottom',
                                'title' => 'Add Candidate',
                            ]);
                        },
                        'update' => function ($url, $model, $key) {
                            $btn = Html::button('<i class="fa fa-pencil" style="font-size:12pt;"></i>', [
                                'value' => Yii::$app->urlManager->createUrl('workorder/update?id=' . $model->id), //<---- here is where you define the action that handles the ajax request
                                'class' => 'btn btn-sm btn-primary updateworkorder-modal-click',
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'bottom',
                                'title' => 'Update'
                            ]);
                            return $btn;
                        },
                        'setting' => function ($url, $model, $key) {
                            $btn = Html::button('<i class="fa fa-cog" style="font-size:12pt;"></i>', [
                                'value' => Yii::$app->urlManager->createUrl('workorder/setting?id=' . $model->id), //<---- here is where you define the action that handles the ajax request
                                'class' => 'btn btn-sm btn-warning',
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