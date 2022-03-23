<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Recruitmentcandidate */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Recruitmentcandidates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recruitmentcandidate-view">

    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'userprofile.fullname',
                [
                  'label' => 'No JO',
                  'format' => 'html',
                  'value'=>function ($data) {
                    return $data->recrequest->nojo;
                }

                ],
                [
                  'attribute' => 'status',
                  'format' => 'html',
                  'value'=>function ($data) {
                    if($data->status == 0){$label='label-warning';}elseif($data->status == 4){$label='label-success';}elseif($data->status == 5){$label='label-danger';}else{$label='label-primary';}
                    return '<span class="label '.$label.'">'.$data->statuscandidate->statusname.'</span>';
                }

                ],
                [
                  'attribute' => 'typeinterview',
                  'format' => 'html',
                  'value'=>function ($data) {
                    return ($data->typeinterview == 1)?'Invite':'Walk in';
                }

                ],
                'createtime',
                'updatetime',
            ],
        ]) ?>
    </div>
</div>
