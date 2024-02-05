<?php

use yii\helpers\Html;
use app\models\Mastercity;
use app\models\Mastersubjobfamily;
use kartik\select2\Select2;
use app\models\Recruitmentcandidate;
use app\models\WoRecruitmentCandidate;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $model app\models\Recruitmentcandidate */

?>
<div class="recruitmentcandidate-create">

    <?php Pjax::begin([
        'id' => 'addcandidate',
        'timeout' => false,
        'enablePushState' => false,
    ]) ?>
    <div class="recruitmentcandidate-form">
        <blockquote>
            <p>Add Candidate for Recruitment request by No Jo <?php echo $modelrecreq->wo_number; ?>.</p>
            <small>Job detail for <cite title="Source Title"><?php echo (is_numeric($modelrecreq->job_code)) ? $modelrecreq->jobsap->jabatansap : $modelrecreq->job; ?></cite></small>
            <small>Project <cite title="Source Title"><?php echo $modelrecreq->project_name; ?></cite></small>
            <small>Job Requirement: <cite title="Source Title"><?php echo $modelrecreq->job_description ? $modelrecreq->job_description : "-"; ?></cite></small>
            <small>Job Description: <cite title="Source Title"><?php echo $modelrecreq->job_requirement ? $modelrecreq->job_requirement : "-"; ?></cite></small>
        </blockquote>
        <div class="box-body table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProviderprofile,
                'filterModel' => $searchModelprofile,
                // 'filterModel' => true,
                // 'pjax' => true,
                'layout' => "{items}\n{summary}\n{pager}",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'fullname',
                    [
                        'attribute' => 'gender',
                        'filter' => \kartik\select2\Select2::widget([
                            'model' => $searchModelprofile,
                            'attribute' => 'gender',
                            'data' => ['male' => 'male', 'female' => 'female'],
                            'options' => ['placeholder' => '--'],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'width' => '100px',
                            ],
                        ]),
                        'contentOptions' => ['style' => 'max-width: 100px;']
                    ],
                    'address:ntext',
                    [
                        'attribute' => 'phone',
                        'value' => 'phone',
                        'contentOptions' => ['style' => 'width: 150px;']
                    ],

                    [
                        'attribute' => 'identitynumber',
                        'value' => 'identitynumber',
                        'contentOptions' => ['style' => 'width: 150px;']
                    ],

                    [
                        'attribute' => 'cityname',
                        'value' => 'city.kota',
                        'contentOptions' => ['style' => 'width: 150px;']
                    ],

                    [
                        'attribute' => 'lastposition',
                        'contentOptions' => ['style' => 'width: 150px;'],
                        'format' => 'raw',
                        'filter' => \kartik\select2\Select2::widget([
                            'model' => $searchModelprofile,
                            'attribute' => 'lastposition',
                            'data' => ArrayHelper::map(Mastersubjobfamily::find()->asArray()->all(), 'id', 'subjobfamily'),
                            'options' => ['placeholder' => ' -- '],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'width' => '150px',
                            ],
                        ]),
                        'value' => 'userworkexperience.lastposition'
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => ['style' => 'min-width: 100px;'],
                        'template' => '<div id = "actionpjax" class="btn-group pull-right">{download}{addcandidate}</div>',
                        'buttons' => [
                            'download' => function ($url, $model) {
                                if ($model->userid) {
                                    $disabled = false;
                                } else {
                                    $disabled = true;
                                }
                                return
                                    Html::a('<i class=" fa fa-print margin-r-5"></i>', ['userprofile/printcv', 'userid' => $model->userid], ['target' => '_blank', 'data-pjax' => "0", 'class' => 'btn btn-sm btn-primary']);
                            },

                            'addcandidate' => function ($url, $model) use ($transrincianid) {
                                $cekcandidate = WoRecruitmentCandidate::find()->where(['user_id' => $model->userid, 'wo_id' => $transrincianid])->one();
                                if ($cekcandidate) {
                                    $icon = '<i class="fa fa-check  text-green" style="font-size:12pt;"></i>';
                                    $disabled = true;
                                    $display = 'display:none';
                                    $displaycheck = '';
                                } else {
                                    $icon = '<i class="fa fa-user-plus" style="font-size:12pt;"></i>';
                                    $display = '';
                                    $displaycheck = 'display:none';
                                }

                                return  '<a id="btncheck' . $model->id . '" class=" btn btn-sm btn-default" disabled style ="' . $displaycheck . '"><i class="fa fa-check text-green" style="font-size:12pt;"></i></a>' . ' '
                                    . Html::a($icon, '#', [
                                        'id' => 'btnaddcandidate' . $model->id,
                                        'class' => 'btn btn-sm btn-default',
                                        'title' => 'Add to Candidate',
                                        'style' => $display,
                                        'onclick' => "
                               if (confirm('Are you sure you want to add to candidate?') == true) {
                                   $.ajax({
                                       type: 'POST',
                                       cache: false,
                                       url: '" . Yii::$app->urlManager->createUrl(['wocandidate/addtocandidate', 'id' => $transrincianid, 'userid' => $model->userid]) . "',
                                       success: function (data, textStatus, jqXHR) {
                                          alert(data);
                                           $('#addcandidate2-modal').find('#btnaddcandidate" . $model->id . "').hide();
                                           $('#addcandidate2-modal').find('#btncheck" . $model->id . "').show();
                                       },
                                   });
                               }

                               return false;
                           "
                                    ]);
                            }
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
    <?php Pjax::end() ?>

</div>