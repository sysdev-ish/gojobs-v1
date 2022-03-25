<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MappingJobPosition */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mapping Job Positions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mappingjobposition-view box box-primary">
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                [
                    'attribute' => 'Kode Jabatan',
                    'format' => 'html',
                    'value' => function ($data) {
                        return ($data->masterkodejabatan) ? $data->masterkodejabatan->value1 : '';
                    }
                ],
                // 'masterjabatansap.value2',
                [
                    'attribute' => 'Jabatan SAP',
                    'format' => 'html',
                    'value' => function ($data) {
                        return ($data->masterjabatansap) ? $data->masterjabatansap->value2 : '';
                    }
                ],
                [
                    'attribute' => 'status',
                    'format' => 'html',
                    'value' => function ($data) {
                        return ($data->status == 1) ? 'Publish' : 'Unpublished';
                    }
                    
                ],
                'mastersubjobfamily.subjobfamily',
            ],
        ]) ?>
    </div>
</div>
