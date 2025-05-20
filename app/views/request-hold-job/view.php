<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Chagerequestjo */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Chagerequestjos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chagerequestjo-view box box-solid">

  <div class="box-body table-responsive no-padding">
    <?= DetailView::widget([
      'model' => $model,
      'attributes' => [
        'id',
        [
          'attribute' => 'recruitreqid',
          'format' => 'html',
          'value' => function ($data) {
            return ($data->jo) ? $data->jo->nojo : '';
          }
        ],
        [
          'label' => 'Area',
          'format' => 'raw',
          'value' => function ($data) {
            return ($data->jo) ? $data->jo->areasap->value2 : '';
          }
        ],
        [
          'label' => 'Job',
          'format' => 'raw',
          'value' => function ($data) {
            return ($data->jo) ? $data->jo->jabatansap->value2 : '';
          }
        ],
        [
          'attribute' => 'created_by',
          'format' => 'html',
          'value' => function ($data) {
            return ($data->creator) ? $data->creator->name : '';
          }

        ],
        'created_at',
        [
          'attribute' => 'updatedby',
          'format' => 'html',
          'value' => function ($data) {
            return ($data->updater) ? $data->updater->name : '';
          }
        ],
        'updated_at',
        [
          'label' => 'Approval',
          'format' => 'raw',
          'value' => function ($data) {
            return ($data->approved_by) ? ((Yii::$app->utils->getnamebynik($data->approved_by)) ? Yii::$app->utils->getnamebynik($data->approved_by) : '-') : 'No Approval';
          }

        ],
        [
          'label' => 'Approved At',
          'format' => 'html',
          'value' => function ($data) {

            return ($data->approved_by) ? (($data->approved_at) ? $data->approved_at : '') : 'No Approval';
          }
        ],
        'approved_note',
        [
          'label' => 'Restored At',
          'format' => 'html',
          'value' => function ($data) {
            return $data->restored_at ?? '';
          }
        ],
        [
          'attribute' => 'status',
          'format' => 'html',
          'value' => function ($data) {
            switch ($data->status) {
              case '1':
                $status = '<span class="label label-warning">Waiting Approval</span>';
                break;
              case '2':
                $status = '<span class="label label-danger">Rejected</span>';
                break;
              case '3':
                $status = '<span class="label label-success">Approved</span>';
                break;
              case '4':
                $status = '<span class="label label-success">Re Opened</span>';
                break;

              default:
                $status = '';
                break;
            }
            return $status;
          }

        ],
        [
          'attribute' => 'reason',
          'format' => 'html',
          'value' => function ($data) {
            $reasons = [
              1 => 'Permintaan User/ Client',
              2 => 'Proyek Terkait Ditunda',
              3 => 'Kebutuhan Sumber Daya Manusia Ditinjau Ulang',
              4 => 'Prioritas Rekrutmen Berubah'
            ];
            $stopReason = $reasons[$data->reason] ?? 'Alasan tidak diketahui';

            return $stopReason;
          }

        ],
        'remarks',
        'scheme_date_old',
        'scheme_date_start',
        'scheme_date_end',
        [
          'label' => 'Evidence',
          'format' => 'raw',
          'value' => function ($data) {
            return ($data->evidence) ? Html::a('<i class="fa fa-download"></i> Download', ['/app/assets/upload/holdjob/' . $data->evidence], ['target' => '_blank', 'class' => 'btn btn-sm btn-default text-muted']) : '-';
          }

        ],
      ],
    ]) ?>
  </div>
</div>