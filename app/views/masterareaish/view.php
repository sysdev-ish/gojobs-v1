<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Masterareaish */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Masterareaishes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="masterareaish-view">
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'area',
                'createtime',
                'updatetime',
                // 'createdby',
                // 'updatedby',
            ],
        ]) ?>
    </div>
</div>
