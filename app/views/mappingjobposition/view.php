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
                'masterjabatansap.value2',
                [
                    'attribute' => 'status',
                    'format' => 'html',
                    'value' => function ($data) {
                        return ($data->status == 1) ? 'Publish' : 'Unpublished';
                    }

                ],
                // 'masterkodejabatan.hire_jabatan_sap',
                'masterkodejabatan.value3',
                'mastersubjobfamily.subjobfamily',
            ],
        ]) ?>
    </div>
</div>
