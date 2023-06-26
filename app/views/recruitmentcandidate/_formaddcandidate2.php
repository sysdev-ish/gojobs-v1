<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use app\models\Recruitmentcandidate;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Recruitmentcandidate */
/* @var $form yii\widgets\ActiveForm */
?>
<?php Pjax::begin([
  'id' => 'addcandidate',
  'timeout' => false,
  'enablePushState' => false,
]) ?>
<div id="cobaajax"></div>
<div class="recruitmentcandidate-form">
  <blockquote>
    <p>Add Candidate for Recruitment request by No Jo <?php echo $modelrecreq->nojo; ?>.</p>
    <small>Job detail for <cite title="Source Title"><?php echo (is_numeric($modelrecreq->jabatan)) ? $modelrecreq->jobfunc->jobcat->name_job_function_category . ' - ' . $modelrecreq->jobfunc->name_job_function : $modelrecreq->jabatan; ?></cite></small>
    <small>Project <cite title="Source Title"><?php echo ($modelrecreq->transjo->n_project == '' || $modelrecreq->transjo->n_project == 'Pilih') ? $modelrecreq->transjo->project : $modelrecreq->transjo->n_project; ?></cite></small>
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

        // 'birthdate',
        // 'lasteducation',
        'address:ntext',
        [
          'attribute' => 'cityname',
          'value' => 'city.kota',
          'contentOptions' => ['style' => 'width: 150px;']

        ],

        [
          'class' => 'yii\grid\ActionColumn',
          'contentOptions' => ['style' => 'min-width: 100px;'],
          'template' => '<div id = "actionpjax" class="btn-group pull-right">{addcandidate}</div>',
          'buttons' => [
            'addcandidate' => function ($url, $model) use ($transrincianid) {

              $cekcandidate = Recruitmentcandidate::find()->where(['userid' => $model->userid, 'recruitreqid' => $transrincianid])->one();
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
                  'title' => 'Ad to Candidate',
                  'style' => $display,
                  'onclick' => "
                               if (confirm('Are you sure you want to add to candidate?') == true) {
                                   $.ajax({
                                       type: 'POST',
                                       cache: false,
                                       url: '" . Yii::$app->urlManager->createUrl(['recruitmentcandidate/addtocandidate', 'id' => $transrincianid, 'userid' => $model->userid]) . "',
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