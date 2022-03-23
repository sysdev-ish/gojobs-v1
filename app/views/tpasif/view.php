<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tpasif */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tpasifs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tpasif-view box box-primary">
    <div class="box-header">
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'userid',
                'createtime',
                'updatetime',
                'scheduledate',
                'date',
                'status',
                'recruitmentcandidateid',
                'officeid',
                'roomid',
                'pic',
                'desc',
                'addinfo',
                'officepic',
            ],
        ]) ?>
    </div>
</div>
