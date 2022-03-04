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
                  'attribute'=>'recruitreqid',
                  'format' => 'html',
                  'value' => function($data){

                    return ($data->jo)?$data->jo->nojo:'';
                  }

                ],
                [
                  'attribute'=>'createdby',
                  'format' => 'html',
                  'value' => function($data){

                    return ($data->createdbyu)?$data->createdbyu->name:'';
                  }

                ],
                'createtime',
                [
                  'attribute'=>'updatedby',
                  'format' => 'html',
                  'value' => function($data){

                    return ($data->updatedbyu)?$data->updatedbyu->name:'';
                  }

                ],
                'updatetime',
                [
                  'label'=>'Approval I',
                  'format' => 'raw',
                  'value' => function($data){
                    return "PM";
                  }

                ],
                [
                  'label'=>'Approved I At',
                  'format' => 'html',
                  'value' => function($data){

                    return ($data->approvedtime)?$data->approvedtime:'';
                  }

                ],
                [
                  'label'=>'Approval II',
                  'format' => 'raw',
                  'value' => function($data){
                    return ($data->approvedby2)?((Yii::$app->utils->getnamebynik($data->approvedby2))?Yii::$app->utils->getnamebynik($data->approvedby2):'-'):'No Approval';
                  }

                ],
                [
                  'label'=>'Approved II At',
                  'format' => 'html',
                  'value' => function($data){

                    return ($data->approvedby2)?(($data->approvedtime2)?$data->approvedtime2:''):'No Approval';
                  }

                ],
                [
                  'attribute'=>'status',
                  'format' => 'html',
                  'value' => function($data){
                    switch ($data->status) {
                      case '1':
                        $status = '<span class="label label-warning">Waiting Approval I</span>';
                        break;
                      case '2':
                        $status = '<span class="label label-warning">Waiting Approval II</span>';
                        break;
                      case '3':
                        $status = '<span class="label label-success">Approved</span>';
                        break;
                      case '4':
                        $status = '<span class="label label-danger">Rejected</span>';
                        break;

                      default:
                        $status = '';
                        break;
                    }
                    return $status;
                  }

                ],
                [
                  'attribute'=>'reason',
                  'format' => 'html',
                  'value' => function($data){
                    switch ($data->reason) {
                      case '1':
                        $reason = 'Permintaan User / Client';
                        break;
                      case '2':
                        $reason = 'Project Batal';
                        break;

                      default:
                        $reason = '';
                        break;
                    }
                    return $reason;
                  }

                ],
                'remarks',
                'oldjumlah',
                'jumlahstop',
                'jumlah',
                // 'documentevidence',
                [
                  'label'=>'Document',
                  'format' => 'raw',
                  'value' => function($data){
                    return ($data->documentevidence)?Html::a('<i class="fa fa-download"></i> Download' , ['/app/assets/upload/documentevidence/'.$data->documentevidence],['target'=>'_blank', 'class' => 'btn btn-sm btn-default text-muted']):'-';
                  }

                ],
            ],
        ]) ?>
    </div>
</div>
