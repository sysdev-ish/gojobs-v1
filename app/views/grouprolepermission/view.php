<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Grouprolepermission */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Grouprolepermissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grouprolepermission-view box box-solid">

    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'createtime',
                'updatetime',
                'grouprolepermission',
            ],
        ]) ?>
        <br><br>
        <table class="table no-border">
                <tbody><tr>
                  <th style="width: 10px">#</th>
                  <th>Role Permission</th>
                </tr>
                <?php foreach ($rolepermission as $key => $value) { ?>
                  <tr>
                    <td><?php echo $key + 1; ?></td>
                    <td><?php echo $value->rolename->role; ?></td>
                  </tr>
                <?php } ?>


              </tbody></table>
    </div>
</div>
