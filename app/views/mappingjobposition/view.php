<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MappingJobPosition */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mapping Job Positions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mappingjobposition-view box box-primary">
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'masterjabatansap.jabatan_sap',
                'kodejabatan',
                'masterkodeposisi.hire_jabatan_sap',
                'mastersubjobfamily.subjobfamily',
            ],
        ]) ?>
    </div>
</div>