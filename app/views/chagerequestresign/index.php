<?php

use yii\helpers\Html;
use yii\grid\GridView;
// use kartik\grid\GridView;
use kartik\grid\CheckboxColumn;
use kartik\grid\SerialColumn;
use kartik\select2\Select2;
use app\models\Masterstatuscr;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;

// use yii\grid\CheckboxColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Chagerequestresignsearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Resign';
$this->params['breadcrumbs'][] = $this->title;
Modal::begin([
  'header' => '<h4 class="modal-title">View Change Request Resign</h4>',
  'id' => 'viewcresign-modal',
  'size' => 'modal-lg'
]);
echo "<div id='viewcresign-view'></div>";
Modal::end();

Modal::begin([
  'header' => '<h4 class="modal-title">Approve Change Request Resign</h4>',
  'id' => 'approvecrresign-modal',
  'size' => 'modal-lg'
]);
echo "<div id='approvecrresign-view'></div>";
Modal::end();

Modal::begin([
  'header' => '<h4 class="modal-title">Bulk Approve Change Request Resign</h4>',
  'id' => 'approvebulkcrresign-modal',
  'size' => 'modal-lg'
]);
echo "<div id='approvebulkcrresign-view'></div>";
Modal::end();

if (Yii::$app->user->isGuest) {
  $role = null;
} else {
  // $userid = Yii::$app->user->identity->id;
  $role = Yii::$app->user->identity->role;
}
$actionview = '';
$actionupdate = '';
$actiondelete = '';
$actionapprove = '';
if (Yii::$app->utils->permission($role, 'm67')) {
  $actionview = '{view}';
}
if (Yii::$app->utils->permission($role, 'm69')) {
  $actionupdate = '{update}';
}
if (Yii::$app->utils->permission($role, 'm70')) {
  $actiondelete = '{delete}';
}
if (Yii::$app->utils->permission($role, 'm71')) {
  $actionapprove = '{approve}';
}
$action = $actionview . $actionupdate . $actiondelete . $actionapprove;
?>


<div class="chagerequestresign-index box box-default">
  <?php if (Yii::$app->utils->permission($role, 'm68')) : ?>
    <div class="box-header with-border">
      <?= Html::a('Create', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
      <?= Html::a('Upload Data', ['upload'], ['class' => 'btn btn-warning btn-flat']) ?>


      <!-- <div id="massApprove" class="btn btn-info pull-right approvebulkcrresign" title="" data-toggle="tooltip" data-placement="bottom" onclick="getRows()" data-original-title="Mass Approve">Mass Approval
      </div> -->


      <?= Html::button('Mass Approval', [
        /*'value' => Yii::$app->urlManager->createUrl('chagerequestresign/bulkapprove'),
        'class' => 'btn btn-info pull-right approvebulkcrresign-modal-click',*/
        'class' => 'btn btn-info pull-right',
        'data-load-url' => Yii::$app->request->baseUrl . '/chagerequestresign/bulkapprove',
        'data-target' => '#approvebulkcrresign-modal',
        'data-toggle' => 'tooltip',
        'data-placement' => 'bottom',
        'title' => 'Mass Approve',
        'id' => 'massApprove',
        //'onclick' => "getRows()",
      ]) ?>


    </div>
  <?php endif; ?>

  <div class="box-body table-responsive">
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <?= GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'layout' => "{items}\n{summary}\n{pager}",
      'id' => "grid",
      'columns' => [
        [
          'class' => 'yii\grid\CheckboxColumn'
        ],
        //   [
        //     'class' => 'yii\grid\CheckboxColumn', 'checkboxOptions' => function($model) {
        //           return ['value' => $model->Your_unique_id];
        //       },
        // ],
        // ['class' => 'yii\grid\CheckboxColumn','name' => 'checked'],

        ['class' => 'yii\grid\SerialColumn'],
        // 'id',
        [
          'label' => 'Name',
          'attribute' => 'fullname',
          'format' => 'html',
          'value' => function ($data) {
            return $data->fullname;
          }
        ],
        [
          'label' => 'Perner',
          'attribute' => 'perner',
          'format' => 'html',
          'value' => function ($data) {
            return $data->perner;
          }
        ],
        [
          'attribute' => 'resigndate',
          'contentOptions' => ['style' => 'min-width: 100px;'],
          'format' => 'html',
          'value' => function ($data) {
            return $data->resigndate;
          }

        ],
        [
          'label' => 'Created By',
          'attribute' => 'createduser',
          'format' => 'html',
          'value' => function ($data) {

            return ($data->createduser) ? $data->createduser->name : "";
          }

        ],
        [

          'label' => 'Approver',
          'attribute' => 'approveduser',
          'format' => 'html',
          'value' => function ($data) {

            return ($data->approveduser) ? $data->approveduser->name : "";
          }

        ],
        [
          'attribute' => 'status',
          'contentOptions' => ['style' => 'width: 100px;'],
          'format' => 'html',
          'filter' => \kartik\select2\Select2::widget([
            'model' => $searchModel,
            'attribute' => 'status',
            'data' => ArrayHelper::map(Masterstatuscr::find()->asArray()->all(), 'id', 'statusname'),
            'options' => ['placeholder' => '--'],
            'pluginOptions' => [
              'allowClear' => true,
              'width' => '120px',
            ],
          ]),
          'value' => function ($data) {
            // return $data->status;
            if ($data->status == 1) {
              $label = 'label-danger';
            } elseif ($data->status == 2 or $data->status == 3) {
              $label = 'label-warning';
            } elseif ($data->status == 4) {
              $label = 'label-success';
            } elseif ($data->status == 8) {
              $label = 'label-info';
            } else {
              $label = 'label-danger';
            }
            return '<span class="label ' . $label . '">' . $data->statusprocess->statusname . '</span>';
          }

        ],
        [

          'label' => 'Remarks',
          'attribute' => 'remarks',
          'format' => 'html',
          'value' => function ($data) {

            return "<b><i>" . $data->remarks . "</i></b><br>" . $data->userremarks;
          }

        ],
        [
          'class' => 'yii\grid\ActionColumn',
          'contentOptions' => ['style' => 'min-width: 180px;'],
          'template' => '<div class="btn-group pull-right">' . $action . '</div>',
          'buttons' => [
            'view' => function ($url, $model, $key) {
              $btn = Html::button('<i class="fa fa-eye" style="font-size:12pt;"></i>', [
                'value' => Yii::$app->urlManager->createUrl('chagerequestresign/view?id=' . $model->id),
                'class' => 'btn btn-sm btn-default viewcresign-modal-click',
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'title' => 'Views Detail'
              ]);
              return $btn;
            },
            'approve' => function ($url, $model, $key) {
              if ($model->status ==  2) {
                $disabled = false;
              } else {
                $disabled = true;
              }
              $btn = Html::button('<i class="fa fa-gavel" style="font-size:12pt;"></i>', [
                'value' => Yii::$app->urlManager->createUrl('chagerequestresign/approve?id=' . $model->id . '&userid=' . $model->userid), //<---- here is where you define the action that handles the ajax request
                'class' => 'btn btn-sm btn-info approvecrresign-modal-click',
                'disabled' => $disabled,
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'title' => 'Approve'
              ]);
              return $btn;
            },
            'update' => function ($url, $model) {
              if ($model->status < 2 or $model->status == 5 or $model->status == 6) {
                $disabled = false;
                $link = 'update';
              } else {
                $disabled = true;
                $link = '#';
              }
              return Html::a('<i class="fa fa-pencil" style="font-size:12pt;"></i>', [$link, 'id' => $model->id], [
                'class' => 'btn btn-sm btn-default',
                'disabled' => $disabled,
                'data-toggle' => 'tooltip',
                'title' => 'Update'
              ]);
            },
            'delete' => function ($url, $model) {
              ($model->status < 2) ? $disabled = false : $disabled = true;
              if ($model->status < 2) {
                return Html::a('<i class="fa fa-trash" style="font-size:12pt;"></i>', ['delete', 'id' => $model->id], [
                  'class' => 'btn btn-sm btn-danger', 'data-toggle' => 'tooltip', 'title' => 'delete', 'disabled' => $disabled,
                  'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                  ],
                ]);
              } else {
                return Html::a('<i class="fa fa-trash" style="font-size:12pt;"></i>', ['#', 'id' => $model->id], [
                  'class' => 'btn btn-sm btn-danger', 'data-toggle' => 'tooltip', 'title' => 'delete', 'disabled' => $disabled,

                ]);
              }
            }
          ]
        ],
      ],
    ]); ?>
  </div>
</div>

<!--<script>
  // $('.approvebulkcrresign-modal-click').click(function() {
  //   var loading = new Loading({
  //     direction: 'hor',
  //     discription: 'Loading...',
  //     defaultApply: true,
  //   });

  //   console.log('hai');
  //   event.preventDefault();
  //   this.blur();
  //   $.get($(this).attr('value'), function(html) {
  //     loading.out()
  //     $('#approvebulkcrresign-modal')
  //       .modal('show')
  //       .find('#approvebulkcrresign-view')
  //       .empty()
  //       .append(html);
  //   });
  // });


  function getRows() {
    //var id as row_id from the gridview column
    // var list = [] is an array for storing the values selected from the gridview 
    // so as to post to the controller.
    var id = $('#grid').yiiGridView('getSelectedRows');
    // console.log(id);

    if ($('#massApprove').legth > 0) {
      alert('div is exist');
    }

    $("#userSelected").append(id.toString());

    console.log(id)

    $.ajax({
      type: 'POST',
      cache: false,
      data: {
        id: id
      },
      url: '<?//php echo Yii::$app->urlManager->createUrl(["chagerequestresign/bulkapprove"]) ?>',
      dataType: "json",
      success: function(data, textStatus, jqXHR) {
      }
    });
  }
</script>-->