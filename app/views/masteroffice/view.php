<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Masteroffice */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Masteroffices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="masteroffice-view box box-solid">

    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'officename',
                'address',
                [
                  'label' => 'Map Location',
                  'format' => 'raw',
                  'value'=>function ($data) {

                    return Html::a('Link location', 'https://maps.google.com/?q='.$data->lat.','.$data->long, ['target' => '_blank']);
                }

                ],

                'createtime',
                'updatetime',
            ],
        ]) ?>
    </div>
</div>
