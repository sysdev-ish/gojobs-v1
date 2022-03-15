<aside class="main-sidebar">

  <section class="sidebar">

    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo $assetUrl; ?>/img/user-avatar.png" class="img-circle" alt="User Image" />

        <!-- <img src="../assets/img/user-avatar.png" class="img-circle" alt="User Image"/> -->
      </div>
      <div class="pull-left info">
        <p><?php echo Yii::$app->user->isGuest ? 'Guest' : Yii::$app->user->identity->username; ?></p>

        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>

    <?php
    if (Yii::$app->user->isGuest) {
      $role = null;
    } else {
      // $userid = Yii::$app->user->identity->id;
      $role = Yii::$app->user->identity->role;
    }
    // var_dump(Yii::$app->utils->getrolepermission($role,'m1'));die;
    ?>


    <?= dmstr\widgets\Menu::widget(
      [
        'options' => ['class' => 'sidebar-menu'],
        'items' => [
          ['label' => 'Menu', 'options' => ['class' => 'header']],
          [
            'label' => 'Dashboard', 'visible' => (Yii::$app->utils->permission($role, 'B01')), 'icon' => 'dashboard (alias)', 'url' => ['/site/dashboard'],
            'active' => Yii::$app->controller->id == 'dashboard'
          ],
          [
            'label' => 'Report',
            'icon' => 'file-text',
            'url' => '#',
            'visible' => (Yii::$app->utils->permission($role, 'm48')),
            'items' => [
              [
                'label' => 'Hiring', 'icon' => 'circle-o', 'url' => ['/report/reporthiring'],
                'visible' => (Yii::$app->utils->permission($role, 'm48')),
                'active' => Yii::$app->controller->action->id == 'reporthiring'
              ],
              [
                'label' => 'Applicant Data', 'icon' => 'circle-o', 'url' => ['/report/reportapplicant'],
                'visible' => (Yii::$app->utils->permission($role, 'm50')),
                'active' => Yii::$app->controller->action->id == 'reportapplicant'
              ],
              [
                'label' => 'Job Order', 'icon' => 'circle-o', 'url' => ['/report/reportjoborder'],
                'visible' => (Yii::$app->utils->permission($role, 'm66')),
                'active' => Yii::$app->controller->action->id == 'reportjoborder'
              ],


            ],
          ],
          [
            'label' => 'Change Request',
            'icon' => 'exchange',
            'url' => '#',
            'visible' => (Yii::$app->utils->permission($role, 'B01')),
            'items' => [
              [
                'label' => 'Personal Data', 'icon' => 'circle-o', 'url' => ['/chagerequestdata'],
                'visible' => (Yii::$app->utils->permission($role, 'm52')),
                'active' => Yii::$app->controller->id == 'chagerequestdata'
              ],
              [
                'label' => 'Bank Account', 'icon' => 'circle-o', 'url' => ['/chagerequestdatabank'],
                'visible' => (Yii::$app->utils->permission($role, 'm57')),
                'active' => Yii::$app->controller->id == 'chagerequestdatabank'
              ],
              [
                'label' => 'Stop Job Order', 'icon' => 'circle-o', 'url' => ['/chagerequestjo'],
                'visible' => (Yii::$app->utils->permission($role, 'm64')),
                'active' => Yii::$app->controller->id == 'chagerequestjo'
              ],
              [
                'label' => 'Resign', 'icon' => 'circle-o', 'url' => ['/chagerequestresign'],
                'visible' => (Yii::$app->utils->permission($role, 'm67')),
                'active' => Yii::$app->controller->id == 'chagerequestresign'
              ],


            ],
          ],
          [
            'label' => 'Recruitment Request', 'icon' => 'feed (alias)', 'url' => ['/transrincian/index'], 'visible' => (Yii::$app->utils->permission($role, 'm1')),
            'active' => Yii::$app->controller->id == 'transrincian'
          ],
          [
            'label' => 'Recruitment Candidate', 'icon' => 'user-plus', 'url' => ['/recruitmentcandidate/index'], 'visible' => (Yii::$app->utils->permission($role, 'm2')),
            'active' => Yii::$app->controller->id == 'recruitmentcandidate'
          ],

          [
            'label' => 'Recruitment Proccess',
            'icon' => 'spinner',
            'url' => '#',
            'visible' => (Yii::$app->utils->permission($role, 'm4') or Yii::$app->utils->permission($role, 'm7') or Yii::$app->utils->permission($role, 'm10') or Yii::$app->utils->permission($role, 'm38') or Yii::$app->utils->permission($role, 'm40') or Yii::$app->utils->permission($role, 'm42') or Yii::$app->utils->permission($role, 'm44')),
            'items' => [
              [
                'label' => 'Psikotest', 'icon' => 'circle-o', 'url' => ['/psikotest/index'], 'visible' => (Yii::$app->utils->permission($role, 'm7')),
                'active' => Yii::$app->controller->id == 'psikotest'
              ],
              [
                'label' => 'Interview', 'icon' => 'circle-o', 'url' => ['/interview/index'], 'visible' => (Yii::$app->utils->permission($role, 'm4')),
                'active' => Yii::$app->controller->id == 'interview'
              ],
              [
                'label' => 'User Interview', 'icon' => 'circle-o', 'url' => ['/userinterview/index'], 'visible' => (Yii::$app->utils->permission($role, 'm10')),
                'active' => Yii::$app->controller->id == 'userinterview'
              ],
              [
                'label' => 'Training Soft skill', 'icon' => 'circle-o', 'url' => ['/tsoftskill/index'], 'visible' => (Yii::$app->utils->permission($role, 'm38')),
                'active' => Yii::$app->controller->id == 'tsoftskill'
              ],
              [
                'label' => 'Training Hard Skill', 'icon' => 'circle-o', 'url' => ['/thardskill/index'], 'visible' => (Yii::$app->utils->permission($role, 'm40')),
                'active' => Yii::$app->controller->id == 'thardskill'
              ],
              [
                'label' => 'Tandem Pasif', 'icon' => 'circle-o', 'url' => ['/tpasif/index'], 'visible' => (Yii::$app->utils->permission($role, 'm42')),
                'active' => Yii::$app->controller->id == 'tpasif'
              ],
              [
                'label' => 'Tandem Aktif', 'icon' => 'circle-o', 'url' => ['/taktif/index'], 'visible' => (Yii::$app->utils->permission($role, 'm44')),
                'active' => Yii::$app->controller->id == 'taktif'
              ],

            ],
          ],
          [
            'label' => 'Hiring', 'icon' => 'circle-o', 'url' => ['/hiring'], 'visible' => (Yii::$app->utils->permission($role, 'm35')),
            'active' => Yii::$app->controller->id == 'hiring'
          ],
          [
            'label' => 'Master Data',
            'icon' => 'share',
            'url' => '#',
            'visible' => (Yii::$app->utils->permission($role, 'm13') or Yii::$app->utils->permission($role, 'm15') or Yii::$app->utils->permission($role, 'm19') or Yii::$app->utils->permission($role, 'm23') or Yii::$app->utils->permission($role, 'm27')),
            'items' => [
              [
                'label' => 'Applicant Master', 'icon' => 'circle-o', 'url' => ['/userprofile/index'], 'visible' => (Yii::$app->utils->permission($role, 'm13')),
                'active' => Yii::$app->controller->id == 'userprofile'
              ],
              [
                'label' => 'User Login', 'icon' => 'circle-o', 'url' => ['/userlogin/index'], 'visible' => (Yii::$app->utils->permission($role, 'm15')),
                'active' => Yii::$app->controller->id == 'userlogin'
              ],
              [
                'label' => 'Group User Role', 'icon' => 'circle-o', 'url' => ['/grouprolepermission/index'], 'visible' => (Yii::$app->utils->permission($role, 'm19')),
                'active' => Yii::$app->controller->id == 'grouprolepermission'
              ],
              [
                'label' => 'User Role', 'icon' => 'circle-o', 'url' => ['/userrole/index'], 'visible' => (Yii::$app->utils->permission($role, 'm19')),
                'active' => Yii::$app->controller->id == 'userrole'
              ],
              [
                'label' => 'Master Office', 'icon' => 'circle-o', 'url' => ['/masteroffice/index'], 'visible' => (Yii::$app->utils->permission($role, 'm23')),
                'active' => Yii::$app->controller->id == 'masteroffice'
              ],
              [
                'label' => 'Master Room', 'icon' => 'circle-o', 'url' => ['/masterroom/index'], 'visible' => (Yii::$app->utils->permission($role, 'm27')),
                'active' => Yii::$app->controller->id == 'masterroom'
              ],
              [
                'label' => 'Master PIC', 'icon' => 'circle-o', 'url' => ['/masterpic/index'], 'visible' => (Yii::$app->utils->permission($role, 'm31')),
                'active' => Yii::$app->controller->id == 'masterpic'
              ],
              [
                'label' => 'Applicant login', 'icon' => 'circle-o', 'url' => ['/applicantlogin/index'], 'visible' => (Yii::$app->utils->permission($role, 'm51')),
                'active' => Yii::$app->controller->id == 'applicantlogin'
              ],
              [
                'label' => 'Area ISH', 'icon' => 'circle-o', 'url' => ['/masterareaish/index'], 'visible' => (Yii::$app->utils->permission($role, 'm51')),
                'active' => Yii::$app->controller->id == 'masterareaish'
              ],
              [
                'label' => 'Region', 'icon' => 'circle-o', 'url' => ['/masterregion/index'], 'visible' => (Yii::$app->utils->permission($role, 'm51')),
                'active' => Yii::$app->controller->id == 'masterregion'
              ],
              [
                'label' => 'Mapping Area', 'icon' => 'circle-o', 'url' => ['/mappingregionarea/index'], 'visible' => (Yii::$app->utils->permission($role, 'm51')),
                'active' => Yii::$app->controller->id == 'mappingregionarea'
              ],
              [
                'label' => 'Industry Type', 'icon' => 'circle-o', 'url' => ['/masterindustry/index'], 'visible' => (Yii::$app->utils->permission($role, 'm51')),
                'active' => Yii::$app->controller->id == 'masterindustry'
              ],
              [
                'label' => 'Job Family', 'icon' => 'circle-o', 'url' => ['/masterjobfamily/index'], 'visible' => (Yii::$app->utils->permission($role, 'm51')),
                'active' => Yii::$app->controller->id == 'masterjobfamily'
              ],
              [
                'label' => 'Sub Job Family', 'icon' => 'circle-o', 'url' => ['/mastersubjobfamily/index'], 'visible' => (Yii::$app->utils->permission($role, 'm51')),
                'active' => Yii::$app->controller->id == 'mastersubjobfamily'
              ],
              [
                'label' => 'Job Position Mapping', 'icon' => 'circle-o', 'url' => ['/mappingjobposition/index'], 'visible' => (Yii::$app->utils->permission($role, 'm51')),
                'active' => Yii::$app->controller->id == 'mappingjobposition'
              ],
            ],
          ],

        ],
      ]
    ) ?>


  </section>

</aside>