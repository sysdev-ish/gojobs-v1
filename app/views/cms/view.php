<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Cms */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'CMS', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="masterjobfamily-view box box-solid">

    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'title',
                // 'content',
                [
                    'label' => 'Content',
                    'attribute' => 'content',
                    'format' => 'html',
                    'value' => function ($data) {
                        return $data->content;
                    }
                ],
                [
                    'label' => 'Status',
                    'attribute' => 'status',
                    'format' => 'html',
                    'value' => function ($data) {
                        return ($data->status == 1) ? "Published" : "Unpublished";
                    }
                ],
                [
                    'label' => 'Type',
                    'attribute' => 'type_content',
                    'format' => 'html',
                    'value' => function ($data) {
                        if ($data->type_content == 1) {
                            $type_content = "Banner";
                        } else if ($data->type_content == 2) {
                            $type_content = "Privacy & Policy";
                        } else if ($data->type_content == 2) {
                            $type_content = "Terms & Condition";
                        } else {
                            $type_content = "About & Contact";
                        }
                        return $type_content;
                    }
                ],
                'created_time',
                'updated_time',
            ],
        ]) ?>
    </div>
</div>