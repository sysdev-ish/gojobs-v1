<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MappingJobPosition */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mapping Industries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mappingjob-view box box-primary">
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'company_name',
                'client_name',
                'category_segment',
                'categoryindustry.industry_type',
                'description',
                [
                    'attribute' => 'status',
                    'format' => 'html',
                    'value' => function ($data) {
                        return ($data->status == 1) ? 'Publish' : 'Unpublished';
                    }

                ],
            ],
        ]) ?>
    </div>
</div>