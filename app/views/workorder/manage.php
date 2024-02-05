<?php

use app\models\WoHiring;
use app\models\WoRecruitmentInterview;
use app\models\Mastercity;
use app\models\WoRecruitmentPsikotest;
use app\models\WoRecruitmentCandidate;
use app\models\Sapjob;
use app\models\WoRecruitmentUserInterview;
use app\models\WoRecruitmentWoRecruitmentInterview;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use floor12\summernote\Summernote;
use yii\widgets\LinkPager;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MasterjobfamilySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List Manage Job Order';

Modal::begin([
    'header' => '<h4 class="modal-title">View Work Order</h4>',
    'id' => 'viewworkorder-modal',
    'size' => 'modal-xl'
]);
echo "<div id='viewworkorder'></div>";
Modal::end();

Modal::begin([
    'header' => '<h4 class="modal-title">Update Work Order</h4>',
    'id' => 'updateworkorder-modal',
    'size' => 'modal-xl'
]);
echo "<div id='updateworkorder'></div>";
Modal::end();

Modal::begin([
    'header' => '<h4 class="modal-title">Create New Work Order</h4>',
    'id' => 'createworkorder-modal',
    'size' => 'modal-xl'
]);
echo "<div id='createworkorder'></div>";
Modal::end();

Modal::begin([
    'header' => '<h4 class="modal-title">Add Candidate</h4>',
    'id' => 'addcandidate2-workorder-modal',
    'size' => 'modal-xl',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    // 'pjaxContainer' => '#addcandidate',
]);
echo "<div id='addcandidateform2'></div>";
Modal::end();

if (Yii::$app->user->isGuest) {
  $role = null;
} else {
  // $userid = Yii::$app->user->identity->id;
  $role = Yii::$app->user->identity->role;
}
if (Yii::$app->utils->permission($role, 'm78') && Yii::$app->utils->permission($role, 'm79')) {
  $action = '{view}{update}{delete}';
} elseif (Yii::$app->utils->permission($role, 'm78')) {
  $action = '{view}{update}';
} elseif (Yii::$app->utils->permission($role, 'm79')) {
  $action = '{view}{delete}';
} else {
  $action = '{view}';
}

$baseUrl = Yii::$app->request->baseUrl;


?>
<!-- <div class="workorder-index box"> -->
<?php if (Yii::$app->utils->permission($role, 'm77')) : ?>
  <div class="box-header with-border">
    <form action="manage" method="get">
      <div class="row align-items-center">
        <div class="col-md-9">
          <div class="row align-items-center">
            <div class="col-md-2 col-sm-12">
              <div class="form-group">
                <input type="text" class="form-control" name="Filter[wo_number]" placeholder="No JO" <?php if ($filters['wo_number']) : ?>value="<?php echo $filters['wo_number']; ?>" <?php endif; ?>>
              </div>
            </div>
            <div class="col-md-2 col-sm-12">
              <div class="form-group">
                <input type="text" class="form-control" name="Filter[project_name]" placeholder="Project" <?php if ($filters['project_name']) : ?>value="<?php echo $filters['project_name']; ?>" <?php endif; ?>>
              </div>
            </div>
            <div class="col-md-2 col-sm-12">
              <div class="form-group">
                <input type="text" class="form-control" name="Filter[area]" placeholder="Area" <?php if ($filters['area']) : ?>value="<?php echo $filters['area']; ?>" <?php endif; ?>>
              </div>
            </div>
            <div class="col-md-2 col-sm-12">
              <div class="form-group">
                <input type="text" class="form-control" name="Filter[id]" placeholder="Jabatan SAP" <?php if ($filters['id']) : ?>value="<?php echo $filters['id']; ?>" <?php endif; ?>>
              </div>
            </div>
            <div class="col-md-2 col-sm-12">
              <div class="form-group">
                <select name="Filter[type_wo]" class="form-control selectpicker" data-live-search="true">
                  <option value=""> Type JO </option>
                  <?php if ($type) : ?>
                    <?php
                    foreach ($type as $key => $value) :
                      $selected = null;
                      if ($filters['type_wo'] == $key) $selected = 'selected="selected"';
                    ?>
                      <option value="<?php echo $key; ?>" <?php echo $selected; ?>>
                        <?php echo Html::encode($value); ?>
                      </option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </div>
            </div>
            <div class="col-md-2 col-sm-12">
              <div class="form-group">
                <select name="Filter[status]" class="form-control selectpicker" data-live-search="true">
                  <option value=""> Select status </option>
                  <?php if ($status) : ?>
                    <?php
                    foreach ($status as $key => $value) :
                      $selected = null;
                      if ($filters['status'] == $key) $selected = 'selected="selected"';
                    ?>
                      <option value="<?php echo $key; ?>" <?php echo $selected; ?>>
                        <?php echo Html::encode($value); ?>
                      </option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group text-right">
            <?= Html::a('Reset', ['/workorder/manage'], ['class' => 'btn btn-default font-weight-bold px-6', 'id' => 'workorder']) ?>
            <?= Html::submitButton('Search', ['class' => 'btn btn-light-primary px-6 font-weight-bold mr-5']) ?>
            <?php echo Html::a('<i class="fa fa-list-ul" style="font-size:12pt;"></i>', ['index'], [
              'class' => 'btn btn-sm btn-default pull-right',
              'data-toggle' => 'tooltip',
              'title' => 'Change Layout'
            ]); ?>
          </div>
        </div>
      </div>
    </form>
    <!-- <? //php echo Html::button('Create', [
          // 'value' => Yii::$app->urlManager->createUrl('workorder/create'),
          // 'class' => 'btn btn-md btn-success createworkorder-modal-click pull-right',
          // 'data-toggle' => 'tooltip',
          // 'data-placement' => 'bottom',
          // 'title' => 'Create New Work Order'
          //]); 
          ?> -->
  </div>
<?php endif; ?>
<div class="row">
  <?php foreach ($models as $data) : ?>
    <div class="col-lg-12">
      <div class="box box-default">
        <div class="row">
          <div class="col-lg-3">
            <blockquote class="ml-4">
              <h4> <?php echo Html::button((($data->wo_number) ? $data->wo_number : "-"), [
                      'value' => Yii::$app->urlManager->createUrl('workorder/viewshort?id=' . $data->id), //<---- here is where you define the action that handles the ajax request
                      'class' => 'btn btn-link recreq-modal-click',
                      'style' => 'padding:0px;',
                      'data-toggle' => 'tooltip',
                      'data-placement' => 'bottom',
                      'title' => 'View Recruitment Request Detail'
                    ]) ?></h4>
              <footer>Project Name: <cite><?php echo ($data->project_name) ? $data->project_name : ''; ?></cite></footer>
              <footer>Location: <cite><?php echo ($data->city) ? $data->city->city_name : ''; ?></cite></footer>
              <footer>Due Date JO: <cite>
                  <?php
                  $datenow = date('Y-m-d');
                  if ($data) {
                    $datenew = $data->created_time;
                    $datenewplus = date('Y-m-d', strtotime($datenew . ' + 14 days'));
                    $datediff = (strtotime($datenewplus) - strtotime($datenow)) / (60 * 60 * 24);
                    echo ($data) ?
                      (($datediff < 0 && $data->status == 1) ? '<span class="text-red">' . $datenewplus . "</span>" : $datenewplus)
                      : '-';
                  } else {
                    echo "-";
                  }
                  ?>
                </cite>
              </footer>
              <?php switch ($data->status) {
                case 1:
                  $status = "On Progress";
                  break;
                case 2:
                  $status = "Done";
                  break;
                case 3:
                  $status = "On Progress (Revised JO)";
                  break;
                case 4:
                  $status = "Done (Revised JO)";
                  break;

                default:
                  $status = '';
                  break;
              }

              echo '<span class="label label-defatul">' . $status . '</span>';
              ?>
            </blockquote>
          </div>
          <div class="col-lg-9">
            <!-- <div class="row"> -->
            <div class="col-xs-2 col-lg-2 mt-2">
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo WoRecruitmentCandidate::find()->where(['wo_id' => $data->id])->count();  ?></h3>
                  <p>Candidate</p>
                </div>
                <a href="<?php echo $baseUrl; ?>/wocandidate/index?WoRecruitmentCandidatesearch%5Bfullname%5D=&WoRecruitmentCandidatesearch%5Bwo_number%5D=<?php echo $data->wo_number; ?>&WoRecruitmentCandidatesearch%5Bjabatans%5D=&WoRecruitmentCandidatesearch%5Bcity%5D=&WoRecruitmentCandidatesearch%5Bstatus%5D=&WoRecruitmentCandidatesearch%5Btypeinterview%5D=&WoRecruitmentCandidatesearch%5Btypeinterview%5D=" class="small-box-footer">
                  More info <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <div class="col-xs-2 col-lg-2 mt-2">
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php
                      $candidate = WoRecruitmentCandidate::find()->where(['wo_id' => $data->id])->all();
                      $candidates = array();
                      foreach ($candidate as $val) {
                        $candidates[] = $val->id;
                      }
                      echo WoRecruitmentPsikotest::find()->where('candidate_id IN ("' . implode('","', $candidates) . '")', [])->count();
                      ?>
                  </h3>
                  <p>Psikotest</p>
                </div>
                <a href="<?php echo $baseUrl; ?>/psikotest/index?WoRecruitmentPsikotestsearch%5Bwo_number%5D=<?php echo $data->wo_number; ?>" class="small-box-footer">
                  More info <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <div class="col-xs-2 col-lg-2 mt-2">
              <div class="small-box bg-green">
                <div class="inner">
                  <h3>
                    <?php
                    $candidate = WoRecruitmentCandidate::find()->where(['wo_id' => $data->id])->all();
                    $candidates = array();
                    foreach ($candidate as $val) {
                      $candidates[] = $val->id;
                    }
                    echo WoRecruitmentInterview::find()->where('candidate_id IN ("' . implode('","', $candidates) . '")', [])->count();
                    ?>
                  </h3>
                  <p>Interview</p>
                </div>
                <a href="<?php echo $baseUrl; ?>/interview/index?WoRecruitmentInterviewsearch%5Bwo_number%5D=<?php echo $data->wo_number; ?>" class="small-box-footer">
                  More info <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <div class="col-xs-2 col-lg-2 mt-2">
              <div class="small-box bg-green">
                <div class="inner">
                  <h3>
                    <?php
                    $candidate = WoRecruitmentCandidate::find()->where(['wo_id' => $data->id])->all();
                    $candidates = array();
                    foreach ($candidate as $val) {
                      $candidates[] = $val->id;
                    }
                    echo WoRecruitmentUserInterview::find()->where('candidate_id IN ("' . implode('","', $candidates) . '")', [])->count();
                    ?>
                  </h3>
                  <p>User Interview</p>
                </div>
                <a href="<?php echo $baseUrl; ?>/wouserinterview/index?WoRecruitmentWoRecruitmentInterviewsearch%5Bwo_number%5D=<?php echo $data->wo_number; ?>" class="small-box-footer">
                  More info <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <div class="col-xs-2 col-lg-2 mt-2">
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo WoHiring::find()->where(['wo_id' => $data->id, 'hiring_status' => 4])->count(); ?></h3>
                  <p>Hiring</p>
                </div>
                <a class="small-box-footer" href="<?php echo $baseUrl; ?>/hiring?WoHiringsearch%5Bfullname%5D=&WoHiringsearch%5Bwo_number%5D=<?php echo $data->wo_number; ?>&WoHiringsearch%5Btype_worincian%5D=&WoHiringsearch%5Bareasap%5D=&WoHiringsearch%5Bjabatansap%5D=&WoHiringsearch%5Btype_wo%5D=&WoHiringsearch%5Bstatus%5D=&WoHiringsearch%5Buserpm%5D=&WoHiringsearch%5Btglinput%5D=">
                  More info <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <div class="col-xs-2 col-lg-2 mt-2 col-centered text-center">
              <!-- <div class="small-box bg-default"> -->
              <div class="inner">
                <div class="btn btn-group">
                  <?php echo Html::button('<i class="fa fa-eye" style="font-size:12pt;"></i>', [
                    'value' => Yii::$app->urlManager->createUrl('workorder/view?id=' . $data->id), //<---- here is where you define the action that handles the ajax request
                    'class' => 'btn btn-sm btn-info viewworkorder-modal-click',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'bottom',
                    'title' => 'Views Detail'
                  ]); ?>
                  <?php
                  ($data->status == 2 || $data->status == 4) ? $disabled = true : $disabled = false;
                  echo Html::button('<i class="fa fa-user-plus" style="font-size:12pt;"></i>', [
                    'value' => Yii::$app->urlManager->createUrl('wocandidate/addcandidate2?id=' . $data->id), //<---- here is where you define the action that handles the ajax request
                    'class' => 'btn btn-sm btn-default addcandidate2-modal-click',
                    'disabled' => $disabled,
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'bottom',
                    'title' => 'Add Candidate',
                  ]); ?>
                  <?php
                  echo  Html::button('<i class="fa fa-pencil" style="font-size:12pt;"></i>', [
                    'value' => Yii::$app->urlManager->createUrl('workorder/update?id=' . $data->id), //<---- here is where you define the action that handles the ajax request
                    'class' => 'btn btn-sm btn-primary updateworkorder-modal-click',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'bottom',
                    'title' => 'Update'
                  ]); ?>

                  <?php
                  echo Html::button('<i class="fa fa-cog" style="font-size:12pt;"></i>', [
                    'value' => Yii::$app->urlManager->createUrl('workorder/setting?id=' . $data->id), //<---- here is where you define the action that handles the ajax request
                    'class' => 'btn btn-sm btn-warning',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'bottom',
                    'title' => 'Update'
                  ]); ?>

                </div>
              </div>
              <!-- </div> -->
            </div>
            <!-- </div> -->
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<div class="row">
  <div class="col-lg-6">
    <?php
    $currentPage = $pages->page + 1;
    $firstData = $pages->offset + 1;
    $lastData = ($pages->page + 1 == $pages->pageCount) ? $pages->offset + ($pages->totalCount - $pages->offset) : $pages->offset + $pages->pageSize;
    if ($pages->totalCount == 0) {
      $firstData = 0;
      $lastData = 0;
      $currentPage = 0;
    }
    ?>
    <span class="label label-default mr-2">Data:
      #<?php echo $firstData; ?>-<?php echo $lastData; ?>/<?php echo $pages->totalCount; ?></span>
    <span class="label label-default">Page:
      #<?php echo $currentPage; ?>/<?php echo $pages->pageCount; ?></span>
  </div>
  <div class="col-lg-6 top-0 text-right">
    <?php
    echo LinkPager::widget([
      'pagination' => $pages,
    ]);
    ?>
  </div>
</div>
<!-- </div> -->
<!-- </div> -->