<?php
use yii\widgets\ListView;
/* @var $this yii\web\View */

$this->title = 'Search Job';
?>
<div class="col-md-4">
  <div class="box box-solid">
    <div class="box-header with-border">
      <i class="fa fa-search"></i>

      <h3 class="box-title">Advance Search</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    </div>
    <!-- /.box-body -->
  </div>
</div>
<div class="col-md-8">

  <?php
echo  ListView::widget([
  'dataProvider' => $dataProvider,
  'itemView' => '_item',
    'pager' => [
        'firstPageLabel' => 'first',
        'lastPageLabel' => 'last',
        'prevPageLabel' => '<',
        'nextPageLabel' => '>',
        'maxButtonCount' => 3,


    ],
])
?>
</div>
