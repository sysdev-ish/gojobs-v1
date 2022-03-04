<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Mappingregionarea */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mappingregionareas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mappingregionarea-view">
    
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                [
                  'attribute' => 'areaishid',
                  'format' => 'html',
                  'value'=>function ($data) {
                    return ($data->masterareaish)?$data->masterareaish->area:'';
                }

                ],
                [
                  'attribute' => 'regionid',
                  'format' => 'html',
                  'value'=>function ($data) {
                    return ($data->masterregion)?$data->masterregion->regionname:'';
                  }

                ],
                [
                  'attribute' => 'areaid',
                  'format' => 'html',
                  'value'=>function ($data) {
                    return ($data->masterarea)?$data->masterarea->value2:'';
                  }

                ],
                'createtime',
                'updatetime',
                // 'createdby',
                // 'updatedby',
            ],
        ]) ?>
    </div>
</div>
