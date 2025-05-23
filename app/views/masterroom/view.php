<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Masterroom */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Masterrooms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="masterroom-view">

    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'masteroffice.officename',
                'room',
                'floor',
                'createtime',
                'updatetime',
            ],
        ]) ?>
    </div>
</div>
