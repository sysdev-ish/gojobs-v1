<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Masterjobfamily */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Master Job Families', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mastersubjobfamily-view box box-solid">

    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'jobfam.jobfamily',
                'subjobfamily',
                [
                    'attribute' => 'status',
                    'format' => 'html',
                    'value' => function ($data) {
                        return ($data->status == 1) ? 'Publish' : 'Unpublished';
                    }

                ],
                'createtime',
                'updatetime',
            ],
        ]) ?>
    </div>
</div>