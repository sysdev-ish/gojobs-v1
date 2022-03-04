<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Masterpic */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Masterpics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="masterpic-view">

    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'masteroffice.officename',
                'userlogin.name',
                'createtime',
                'updatetime',
            ],
        ]) ?>
    </div>
</div>
