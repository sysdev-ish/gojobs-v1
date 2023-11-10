<?php

use yii\helpers\Html;

$assetUrl = Yii::$app->request->baseUrl . '/app/assets/upload/';
$assetUrlavatar = Yii::$app->request->baseUrl . '/assets';
$profile = Yii::$app->utils->getprofileuser($userid);
?>
<div class="careerfy-typo-wrap">
  <div class="careerfy-employer-dashboard-nav">
    <figure>
      <!-- <a href="#" class="employer-dashboard-thumb"> -->

      <div class="crop-profile">
        <?php if ($profile) { ?>

          <?php if ($profile->photo != null) { ?>
            <img class="profile-user-img img-responsive " src="<?php echo $assetUrl; ?>/photo/<?php echo $profile->photo; ?>" alt="User profile picture">
          <?php } else { ?>
            <img class="profile-user-img img-responsive " src="<?php echo $assetUrlavatar; ?>/img/user-avatar.png" alt="User profile picture">
          <?php }
        } else { ?>
          <img class="profile-user-img img-responsive " src="<?php echo $assetUrlavatar; ?>/img/user-avatar.png" alt="User profile picture">
        <?php } ?>
      </div>
      <!-- </a> -->
      <figcaption style="margin-top:20px;">
        <div class="careerfy-fileUpload">
          <!-- <span><i class="careerfy-icon careerfy-add"></i> Print CV</span> -->
          <?php echo  Html::a('<i class=" fa fa-print margin-r-5"></i><b> Print Resume</b>', ['userprofile/printcv', 'userid' => $userid], ['target' => '_blank', 'class' => 'careerfy-employer-list-btn', 'style' => 'border-radius: 8px;']); ?>

          <!-- <input type="file" class="careerfy-upload"> -->
        </div>
        <?php if ($profile) { ?>

          <h2><?php echo $profile->fullname; ?></h2>
          <span class="careerfy-dashboard-subtitle"><?= Yii::t('app', $profile->gender) ?></span>
        <?php } ?>

      </figcaption>
    </figure>
    <ul>
      <li class="<?php echo (Yii::$app->controller->id == 'userprofile') ? 'active ' : ' '; ?> "><?php echo Html::a('<i class="careerfy-icon careerfy-user"></i> ' . Yii::t('app', 'My Profile') .  ((Yii::$app->check->cuserprofile($userid)) ?  '<span class="pull-right text-green"><i class="fa fa-check-square-o"></i></span>' : '<span class="pull-right text-red"><i class="fa fa-close (alias)"></i></span>'), ['/userprofile/views', 'userid' => $userid]) ?></li>
      <li class="<?php echo (Yii::$app->controller->id == 'userfamily') ? 'active ' : ' '; ?> "><?= Html::a('<i class="careerfy-icon careerfy-group"></i> ' . Yii::t('app', 'My Family') .  ((Yii::$app->check->cuserfamily($userid)) ?  '<span class="pull-right text-green"><i class="fa fa-check-square-o"></i></span>' : '<span class="pull-right text-red"><i class="fa fa-close (alias)"></i></span>'), ['/userfamily/views', 'userid' => $userid]) ?></li>
      <li class="<?php echo (Yii::$app->controller->id == 'userformaleducation') ? 'active ' : ' '; ?> "><?= Html::a('<i class="careerfy-icon careerfy-mortarboard"></i> ' . Yii::t('app', 'Formal Education') . ((Yii::$app->check->cuserfeducation($userid)) ?  '<span class="pull-right text-green"><i class="fa fa-check-square-o"></i></span>' : '<span class="pull-right text-red"><i class="fa fa-close (alias)"></i></span>'), ['/userformaleducation/views', 'userid' => $userid]) ?></li>
      <li class="<?php echo (Yii::$app->controller->id == 'usernonformaleducation') ? 'active ' : ' '; ?> "><?= Html::a('<i class="careerfy-icon careerfy-mortarboard"></i> ' . Yii::t('app', 'Non Formal Education') . ((Yii::$app->check->cusernfeducation($userid)) ?  '<span class="pull-right text-green"><i class="fa fa-check-square-o"></i></span>' : '<span class="pull-right text-red"><i class="fa fa-close (alias)"></i></span>'), ['/usernonformaleducation/views', 'userid' => $userid]) ?></li>
      <li class="<?php echo (Yii::$app->controller->id == 'userskill') ? 'active ' : ' '; ?> "><?= Html::a('<i class="careerfy-icon careerfy-design-skills"></i> ' . Yii::t('app', 'Skill') . ((Yii::$app->check->cuserflang($userid)) ?  '<span class="pull-right text-green"><i class="fa fa-check-square-o"></i></span>' : '<span class="pull-right text-red"><i class="fa fa-close (alias)"></i></span>'), ['/userskill/views', 'userid' => $userid]) ?></li>
      <li class="<?php echo (Yii::$app->controller->id == 'userworkexperience') ? 'active ' : ' '; ?> "><?= Html::a('<i class="careerfy-icon careerfy-social-media"></i> ' . Yii::t('app', 'Experience') . ((Yii::$app->check->cuserwexperience($userid)) ?  '<span class="pull-right text-green"><i class="fa fa-check-square-o"></i></span>' : '<span class="pull-right text-red"><i class="fa fa-close (alias)"></i></span>'), ['/userworkexperience/views', 'userid' => $userid]) ?></li>
      <li class="<?php echo (Yii::$app->controller->id == 'organizationactivity') ? 'active ' : ' '; ?> "><?= Html::a('<i class="careerfy-icon careerfy-fax"></i> ' . Yii::t('app', 'Organization Activity') . ((Yii::$app->check->cuserorgac($userid)) ?  '<span class="pull-right text-green"><i class="fa fa-check-square-o"></i></span>' : '<span class="pull-right text-red"><i class="fa fa-close (alias)"></i></span>'), ['/organizationactivity/views', 'userid' => $userid]) ?></li>
      <li class="<?php echo (Yii::$app->controller->id == 'useremergencycontact') ? 'active ' : ' '; ?> "><?= Html::a('<i class="careerfy-icon careerfy-technology"></i> ' . Yii::t('app', 'Emergency Contact') . ((Yii::$app->check->cuserecontact($userid)) ?  '<span class="pull-right text-green"><i class="fa fa-check-square-o"></i></span>' : '<span class="pull-right text-red"><i class="fa fa-close (alias)"></i></span>'), ['/useremergencycontact/views', 'userid' => $userid]) ?></li>
      <li class="<?php echo (Yii::$app->controller->id == 'userreference') ? 'active ' : ' '; ?> "><?= Html::a('<i class="careerfy-icon careerfy-curriculum"></i> ' . Yii::t('app', 'Reference') . ((Yii::$app->check->cuserreff($userid)) ?  '<span class="pull-right text-green"><i class="fa fa-check-square-o"></i></span>' : '<span class="pull-right text-red"><i class="fa fa-close (alias)"></i></span>'), ['/userreference/views', 'userid' => $userid]) ?></li>
      <li class="<?php echo (Yii::$app->controller->id == 'useraddinfo') ? 'active ' : ' '; ?> "><?= Html::a('<i class="careerfy-icon careerfy-id-card"></i> ' . Yii::t('app', 'Additional Info') . ((Yii::$app->check->cuserhealth($userid)) ?  '<span class="pull-right text-green"><i class="fa fa-check-square-o"></i></span>' : '<span class="pull-right text-red"><i class="fa fa-close (alias)"></i></span>'), ['/useraddinfo/views', 'userid' => $userid]) ?></li>
      <li class="<?php echo (Yii::$app->controller->id == 'uploadocument') ? 'active ' : ' '; ?> "><?= Html::a('<i class="careerfy-icon careerfy-briefcase"></i> ' . Yii::t('app', 'Documents') . ((Yii::$app->check->cuploaddoc($userid)) ?  '<span class="pull-right text-green"><i class="fa fa-check-square-o"></i></span>' : '<span class="pull-right text-red"><i class="fa fa-close (alias)"></i></span>'), ['/uploadocument/views', 'userid' => $userid]) ?></li>


      <!-- <li><a href="index.html"><i class="careerfy-icon careerfy-logout"></i> Logout</a></li> -->
      <li><?= Html::a('<i class="careerfy-icon careerfy-logout"></i>'.' Logout', ['/site/logout'], ['data-method' => 'post']) ?></li>
      <li class="<?php echo (Yii::$app->controller->action->id == 'myappliaction') ? 'active ' : ' '; ?> "><?= Html::a('<i class="careerfy-icon careerfy-briefcase-1"></i> ' . Yii::t('app', 'Applied Jobs'), ['/recruitmentcandidate/myapplication', 'userid' => $userid]) ?></li>

    </ul>
  </div>
</div>