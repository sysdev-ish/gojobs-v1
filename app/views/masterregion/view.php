<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Masterregion */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Masterregions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="masterregion-view">

    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'regionname',
                'createtime',
                'updatetime',
                // 'createdby',
                // 'updatedby',
            ],
        ]) ?>
    </div>
</div>
