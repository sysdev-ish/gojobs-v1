<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Masterindustry */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Masterindustries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="masterindustry-view box box-solid">

    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'industry_type',
                [
                    'attribute' => 'status',
                    'format' => 'html',
                    'value' => function($data) {
                        return ($data->typeinterview == 1) ? 'Published' : 'Unpublished';
                    }
                ],
                'createtime',
                'updatetime',
            ],
        ]) ?>
    </div>
</div>