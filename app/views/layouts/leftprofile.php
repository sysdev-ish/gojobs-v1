<?php
use yii\helpers\Html;
$assetUrl = Yii::$app->request->baseUrl . '/app/assets/upload/';
$assetUrlavatar = Yii::$app->request->baseUrl . '/assets';
$profile = Yii::$app->utils->getprofileuser($userid);
?>
<div class="box box-solid">
  <div class="box-body box-profile">
    <div class="crop-profile">
      <?php if ($profile) { ?>
        <?php if ($profile->photo != null) { ?>
          <img class="profile-user-img img-responsive " src="<?php echo $assetUrl; ?>/photo/<?php echo $profile->photo;?>"  alt="User profile picture">
        <?php }else{ ?>
          <img class="profile-user-img img-responsive " src="<?php echo $assetUrlavatar; ?>/img/user-avatar.png"  alt="User profile picture">
        <?php }
      }else{ ?>
        <img class="profile-user-img img-responsive " src="<?php echo $assetUrlavatar; ?>/img/user-avatar.png"  alt="User profile picture">
      <?php } ?>
    </div>
    <?php if ($profile) { ?>

    <h3 class="profile-username text-center"><?php echo $profile->fullname; ?></h3>
  <?php } ?>

    <?php echo  Html::a('<i class=" fa fa-print margin-r-5"></i><b>Print CV</b>', ['userprofile/printcv', 'userid' => $userid], ['target'=>'_blank','class' => 'btn btn-primary btn-block']); ?>
  </div>

</div>
<?php if (Yii::$app->controller->action->id != 'viewshort' && Yii::$app->controller->action->id != 'viewshortwd') : ?>
  <div class="box box-solid">

    <div class="box-body no-padding">
      <ul class="nav nav-pills nav-stacked">
        <li class="<?php echo  (Yii::$app->controller->id == 'userprofile') ? 'active ' : ' '; ?> "><?php echo Html::a('<i class="fa fa-user"></i> User Profile'.  ((Yii::$app->check->cuserprofile($userid)) ?  '<span class="pull-right text-green"><i class="fa fa-check-square-o"></i></span>':'<span class="pull-right text-red"><i class="fa fa-close (alias)"></i></span>'), ['/userprofile/views','userid'=>$userid]) ?></li>
        <li class="<?php echo  (Yii::$app->controller->id == 'userfamily') ? 'active ' : ' '; ?> "><?= Html::a('<i class="fa fa-users"></i> User Family'.  ((Yii::$app->check->cuserfamily($userid)) ?  '<span class="pull-right text-green"><i class="fa fa-check-square-o"></i></span>':'<span class="pull-right text-red"><i class="fa fa-close (alias)"></i></span>'), ['/userfamily/views','userid'=>$userid]) ?></li>
        <li class="<?php echo  (Yii::$app->controller->id == 'userformaleducation') ? 'active ' : ' '; ?> "><?= Html::a('<i class="fa fa-mortar-board (alias)"></i> Formal Education'.((Yii::$app->check->cuserfeducation($userid)) ?  '<span class="pull-right text-green"><i class="fa fa-check-square-o"></i></span>':'<span class="pull-right text-red"><i class="fa fa-close (alias)"></i></span>'), ['/userformaleducation/views','userid'=>$userid]) ?></li>
        <li class="<?php echo  (Yii::$app->controller->id == 'usernonformaleducation') ? 'active ' : ' '; ?> "><?= Html::a('<i class="fa fa-mortar-board (alias)"></i> Non Formal Education'.((Yii::$app->check->cusernfeducation($userid)) ?  '<span class="pull-right text-green"><i class="fa fa-check-square-o"></i></span>':'<span class="pull-right text-red"><i class="fa fa-close (alias)"></i></span>'), ['/usernonformaleducation/views','userid'=>$userid]) ?></li>
        <li class="<?php echo  (Yii::$app->controller->id == 'userskill') ? 'active ' : ' '; ?> "><?= Html::a('<i class="fa fa-user-secret"></i> Skill'.((Yii::$app->check->cuserflang($userid)) ?  '<span class="pull-right text-green"><i class="fa fa-check-square-o"></i></span>':'<span class="pull-right text-red"><i class="fa fa-close (alias)"></i></span>'), ['/userskill/views','userid'=>$userid]) ?></li>
        <li class="<?php echo  (Yii::$app->controller->id == 'userworkexperience') ? 'active ' : ' '; ?> "><?= Html::a('<i class="fa fa-list-ul"></i> Experience'.((Yii::$app->check->cuserwexperience($userid)) ?  '<span class="pull-right text-green"><i class="fa fa-check-square-o"></i></span>':'<span class="pull-right text-red"><i class="fa fa-close (alias)"></i></span>'), ['/userworkexperience/views','userid'=>$userid]) ?></li>
        <li class="<?php echo  (Yii::$app->controller->id == 'organizationactivity') ? 'active ' : ' '; ?> "><?= Html::a('<i class="fa  fa-institution (alias)"></i> Organization Activity'.((Yii::$app->check->cuserorgac($userid)) ?  '<span class="pull-right text-green"><i class="fa fa-check-square-o"></i></span>':'<span class="pull-right text-red"><i class="fa fa-close (alias)"></i></span>'), ['/organizationactivity/views','userid'=>$userid]) ?></li>
        <li class="<?php echo  (Yii::$app->controller->id == 'useremergencycontact') ? 'active ' : ' '; ?> "><?= Html::a('<i class="fa fa-phone-square"></i> Emergency Contact'.((Yii::$app->check->cuserecontact($userid)) ?  '<span class="pull-right text-green"><i class="fa fa-check-square-o"></i></span>':'<span class="pull-right text-red"><i class="fa fa-close (alias)"></i></span>'), ['/useremergencycontact/views','userid'=>$userid]) ?></li>
        <li class="<?php echo  (Yii::$app->controller->id == 'userreference') ? 'active ' : ' '; ?> "><?= Html::a('<i class="fa fa-unlink (alias)"></i> Reference'.((Yii::$app->check->cuserreff($userid)) ?  '<span class="pull-right text-green"><i class="fa fa-check-square-o"></i></span>':'<span class="pull-right text-red"><i class="fa fa-close (alias)"></i></span>'), ['/userreference/views','userid'=>$userid]) ?></li>
        <li class="<?php echo  (Yii::$app->controller->id == 'useraddinfo') ? 'active ' : ' '; ?> "><?= Html::a('<i class="fa fa-info"></i> Additional Info'.((Yii::$app->check->cuserhealth($userid)) ?  '<span class="pull-right text-green"><i class="fa fa-check-square-o"></i></span>':'<span class="pull-right text-red"><i class="fa fa-close (alias)"></i></span>'), ['/useraddinfo/views','userid'=>$userid]) ?></li>
        <li class="<?php echo  (Yii::$app->controller->id == 'uploadocument') ? 'active ' : ' '; ?> "><?= Html::a('<i class="fa fa-files-o"></i> Documents'.((Yii::$app->check->cuploaddoc($userid)) ?  '<span class="pull-right text-green"><i class="fa fa-check-square-o"></i></span>':'<span class="pull-right text-red"><i class="fa fa-close (alias)"></i></span>'), ['/uploadocument/views','userid'=>$userid]) ?></li>
      </ul>
    </div>

    <!-- /.box-body -->
  </div>
  <div class="box box-solid">
    <div class="box-body no-padding">
      <ul class="nav nav-pills nav-stacked">
        <li class="<?php echo  (Yii::$app->controller->action->id == 'myappliaction') ? 'active ' : ' '; ?> "><?= Html::a('<i class="fa  fa-file"></i> My Applications', ['/recruitmentcandidate/myapplication','userid'=>$userid]) ?></li>
      </ul>
    </div>
  </div>
  <!-- /.box-body -->
<?php endif; ?>
