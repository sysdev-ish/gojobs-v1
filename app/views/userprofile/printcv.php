<?php
$assetUrl = Yii::$app->request->baseUrl . '/app/assets/upload/';
$assetUrlavatar = Yii::$app->request->baseUrl . '/assets';
?>

<link href="<?php echo Yii::$app->request->baseUrl; ?>/css/print.css" rel="stylesheet" type="text/css" />

<section class="doc portrait">
  <div class="row doc-info">
    <div class="col-sm-12 col-print-12">
      <div class="row line-info" style="text-align:center;margin-bottom:20px;">
        <div class="col-sm-12 col-print-12">
          <h1 style="margin-bottom:-15px;">Curiculum Vitae</h1><br>
        </div>
      </div>
    </div>

    <div class="col-sm-12 col-print-12">
      <h4>Personal Information</h4>
      <div class="col-sm-9 col-print-9">
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Full Name</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo $userprofile->fullname; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Nick Name</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo $userprofile->nickname; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Phone</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo $userprofile->userlogin->mobile; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Email</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo $userprofile->userlogin->email; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Place & Birth Date</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo $userprofile->birthplace . ', ' . date_format(date_create($userprofile->birthdate), 'd M Y'); ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Domicile Address</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo $userprofile->address . ', ' . $userprofile->city->kota . ' - ' . $userprofile->province->provinsi . ' (' . $userprofile->postalcode . ')'; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Domicile Status</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo $userprofile->domicilestatus; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Address by ID</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo $userprofile->addressktp; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Natinality</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo $userprofile->nationality; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Religion</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo $userprofile->religion; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Marital Status</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo $userprofile->maritalstatus; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Blood type</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo $userprofile->bloodtype; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Identity Number</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo $userprofile->identitynumber; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Jamsostek Number</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo $userprofile->jamsosteknumber; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>BPJS Kesehatan Number</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo $userprofile->bpjsnumber; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>NPWP Number</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo $userprofile->npwpnumber; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Driving License Car Number</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo $userprofile->drivinglicencecarnumber; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Driving License Motorcycle Number</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo $userprofile->drivinglicencemotorcyclenumber; ?>
          </div>
        </div>

      </div>
      <div class="col-sm-3 col-print-3 text-center">
        <?php if ($userprofile->photo != null) { ?>
          <img class="profile-user-img-print img-responsive " src="<?php echo $assetUrl; ?>/photo/<?php echo $userprofile->photo; ?>" alt="User profile picture">
        <?php } else { ?>
          <img class="profile-user-img-print img-responsive " src="<?php echo $assetUrlavatar; ?>/img/user-avatar.png" alt="User profile picture">
        <?php } ?>
        <br>

      </div>
    </div>

    <div class="col-sm-12 col-print-12" style="margin-top : 35px;">
      <h4>Family Information</h4>
      <div class="col-sm-12 col-print-12">
        <div class="row line-info">
          <table class="table table-striped">
            <thead>
              <tr>
                <td style="vertical-align :middle; text-align:center;">No</td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Relationship</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Full Name</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Gender</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Last Education</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Birth Place & Birth Date</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Job Title</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Company Name</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Description</strong>
                </td>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($userfamily as $key => $value) { ?>
                <tr>
                  <td><?php echo $key + 1; ?></td>
                  <td><?php echo $value->relationship; ?></td>
                  <td><?php echo $value->fullname; ?></td>
                  <td><?php echo $value->gender; ?></td>
                  <td><?php echo $value->lasteducation0->education; ?></td>
                  <td><?php echo $value->birthplace . ', ' . $value->birthdate; ?></td>
                  <td><?php echo $value->jobtitle; ?></td>
                  <td><?php echo $value->companyname; ?></td>
                  <td><?php echo $value->description; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-print-12">
      <h4>Formal Education</h4>
      <div class="col-sm-12 col-print-12">
        <div class="row line-info">
          <table class="table table-striped">
            <thead>
              <tr>
                <td style="vertical-align :middle; text-align:center;"><strong>No</strong></td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Education Level</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Institutions</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>City</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Majoring</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Start Date</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>End Date</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Status</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>GPA</strong>
                </td>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($userfedu as $key => $value) { ?>
                <tr>
                  <td><?php echo $key + 1; ?></td>
                  <td><?php echo $value->educationallevel0->education; ?></td>
                  <td><?php echo $value->institutions; ?></td>
                  <td><?php echo $value->city; ?></td>
                  <td><?php echo $value->majoring; ?></td>
                  <td><?php echo $value->startdate; ?></td>
                  <td><?php echo $value->enddate; ?></td>
                  <td><?php echo $value->status; ?></td>
                  <td><?php echo $value->gpa; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="page-break-avoid"></div>
    <div class="col-sm-12 col-print-12">
      <h4>Non Formal Education</h4>
      <div class="col-sm-12 col-print-12">
        <div class="row line-info">
          <table class="table table-striped">
            <thead>
              <tr>
                <td style="vertical-align :middle; text-align:center;"><strong>No</strong></td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Education Level</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Institutions</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Start Date</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>End Date</strong>
                </td>

              </tr>
            </thead>
            <tbody>
              <?php foreach ($usernfedu as $key => $value) { ?>
                <tr>
                  <td><?php echo $key + 1; ?></td>
                  <td><?php echo $value->type; ?></td>
                  <td><?php echo $value->institutions; ?></td>
                  <td><?php echo $value->startdate; ?></td>
                  <td><?php echo $value->enddate; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-print-12">
      <h4>User foreign Language</h4>
      <div class="col-sm-12 col-print-12">
        <div class="row line-info">
          <table class="table table-striped">
            <thead>
              <tr>
                <td style="vertical-align :middle; text-align:center;"><strong>No</strong></td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Language</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Speaking</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Writing</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Reading</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Understanding</strong>
                </td>

              </tr>
            </thead>
            <tbody>
              <?php foreach ($usernflang as $key => $value) { ?>
                <tr>
                  <td><?php echo $key + 1; ?></td>
                  <td><?php echo $value->language; ?></td>
                  <td><?php echo ($value->speaking == 1) ? "<span class='label label-success'>Active</span>" : "<span class='label label-danger'>Passive</span>"; ?></td>
                  <td><?php echo ($value->writing == 1) ? "<span class='label label-success'>Active</span>" : "<span class='label label-danger'>Passive</span>"; ?></td>
                  <td><?php echo ($value->reading == 1) ? "<span class='label label-success'>Active</span>" : "<span class='label label-danger'>Passive</span>"; ?></td>
                  <td><?php echo ($value->understanding == 1) ? "<span class='label label-success'>Active</span>" : "<span class='label label-danger'>Passive</span>"; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-print-12">
      <h4>English Language Skill</h4>
      <div class="col-sm-12 col-print-12">
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Do you take the TOEFL Exam?</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo ($usereskill) ? (($usereskill->havetoefl == 1) ? "<span class='label label-success'>Yes</span>" : "<span class='label label-danger'>No</span>") : '-'; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Exam Date</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo ($usereskill) ? $usereskill->testtoefldate : '-'; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Institutions</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo ($usereskill) ? $usereskill->institutions : '-'; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>TOEFL Score</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo ($usereskill) ? $usereskill->toeflscore : '-'; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-print-12">
      <h4>Computer Skill</h4>
      <div class="col-sm-12 col-print-12">
        <div class="row line-info">
          <div class="col-sm-3 col-print-3">
            <strong>Ms Word</strong>
            <?php echo ($usercskill) ? (($usercskill->msword == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>") : '-'; ?>
          </div>
          <div class="col-sm-3 col-print-3">
            <strong>Ms Excel</strong>
            <?php echo ($usercskill) ? (($usercskill->msexcel == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>") : '-'; ?>
          </div>
          <div class="col-sm-3 col-print-3">
            <strong>Ms Power Point</strong>
            <?php echo ($usercskill) ? (($usercskill->mspowerpoint == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>") : '-'; ?>
          </div>
          <div class="col-sm-3 col-print-3">
            <strong>Sql</strong>
            <?php echo ($usercskill) ? (($usercskill->sql == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>") : '-'; ?>
          </div>
          <div class="col-sm-3 col-print-3">
            <strong>LAN</strong>
            <?php echo ($usercskill) ? (($usercskill->lan == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>") : '-'; ?>
          </div>
          <div class="col-sm-3 col-print-3">
            <strong>WAN</strong>
            <?php echo ($usercskill) ? (($usercskill->wan == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>") : '-'; ?>
          </div>
          <div class="col-sm-3 col-print-3">
            <strong>Pascal</strong>
            <?php echo ($usercskill) ? (($usercskill->pascal == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>") : '-'; ?>
          </div>
          <div class="col-sm-3 col-print-3">
            <strong>C Language</strong>
            <?php echo ($usercskill) ? (($usercskill->clanguage == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>") : '-'; ?>
          </div>
          <div class="col-sm-3 col-print-3">
            <strong>Android</strong>
            <?php echo ($usercskill) ? (($usercskill->android == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>") : '-'; ?>
          </div>
          <div class="col-sm-3 col-print-3">
            <strong>php</strong>
            <?php echo ($usercskill) ? (($usercskill->php == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>") : '-'; ?>
          </div>
          <div class="col-sm-3 col-print-3">
            <strong>java</strong>
            <?php echo ($usercskill) ? (($usercskill->java == 1) ? "<i class='fa fa-check-square-o'></i>'" : "<i class='fa fa-close (alias)'></i>") : '-'; ?>
          </div>

          <div class="col-sm-12 col-print-12">
            <strong>Others</strong>
            <?php echo ($usercskill) ? (($usercskill->others) ? $usercskill->others : '-') : '-'; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-print-12">
      <h4>Internet Skill</h4>
      <div class="col-sm-12 col-print-12">
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Internet knowledge</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo ($usercskill) ? (($usercskill->internetknowledge == 3) ? "<span class='label label-success'>Good</span>" : (($usercskill->internetknowledge == 2) ? "<span class='label label-warning'>Moderate</span>" : "<span class='label label-danger'>less</span>")) : '-'; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Purpose of using the internet</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo ($usercskill) ? ($usercskill->usinginternetpurpose) : '-'; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Frequency Using the Internet (State how many times in a certain period of time)</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo ($usercskill) ? ($usercskill->usinginternetfrequency) : '-'; ?>
          </div>
        </div>

      </div>
    </div>
    <div class="col-sm-12 col-print-12" style="margin-top : 35px;">
      <h4>Work Experience</h4>
      <div class="col-sm-12 col-print-12">
        <div class="row line-info">
          <table class="table table-striped">
            <thead>
              <tr>
                <td style="vertical-align :middle; text-align:center;">No</td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Company Name</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Address</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Start Date</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>End Date</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Last Position</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Salary</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Job Desc</strong>
                </td>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($userwexp as $key => $value) { ?>
                <tr>
                  <td><?php echo $key + 1; ?></td>
                  <td><?php echo $value->companyname; ?></td>
                  <td><?php echo $value->companyaddress; ?></td>
                  <td><?php echo $value->startdate; ?></td>
                  <td><?php echo $value->enddate; ?></td>
                  <td><?php echo $value->lastposition; ?></td>
                  <td><?php echo $value->salary; ?></td>
                  <td><?php echo $value->jobdesc; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-print-12" style="margin-top : 35px;">
      <h4>Organization Activity</h4>
      <div class="col-sm-12 col-print-12">
        <div class="row line-info">
          <table class="table table-striped">
            <thead>
              <tr>
                <td style="vertical-align :middle; text-align:center;">No</td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Organization Name</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Place</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Organization Skill</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Duration</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Position</strong>
                </td>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($userorgac as $key => $value) { ?>
                <tr>
                  <td><?php echo $key + 1; ?></td>
                  <td><?php echo $value->organizationname; ?></td>
                  <td><?php echo $value->organizationplace; ?></td>
                  <td><?php echo $value->organizationskill; ?></td>
                  <td><?php echo $value->duration; ?></td>
                  <td><?php echo $value->position; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-print-12" style="margin-top : 35px;">
      <h4>Emergency Contact</h4>
      <div class="col-sm-12 col-print-12">
        <div class="row line-info">
          <table class="table table-striped">
            <thead>
              <tr>
                <td style="vertical-align :middle; text-align:center;">No</td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Full Name</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Address</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Phone</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Relationship</strong>
                </td>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($userecontact as $key => $value) { ?>
                <tr>
                  <td><?php echo $key + 1; ?></td>
                  <td><?php echo $value->fullname; ?></td>
                  <td><?php echo $value->address; ?></td>
                  <td><?php echo $value->phone; ?></td>
                  <td><?php echo $value->relationship; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-print-12" style="margin-top : 35px;">
      <h4>Reference</h4>
      <div class="col-sm-12 col-print-12">
        <div class="row line-info">
          <table class="table table-striped">
            <thead>
              <tr>
                <td style="vertical-align :middle; text-align:center;">No</td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Full Name</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Address</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Phone</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Job title</strong>
                </td>
                <td style="vertical-align :middle; text-align:center;">
                  <strong>Relationship</strong>
                </td>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($userreff as $key => $value) { ?>
                <tr>
                  <td><?php echo $key + 1; ?></td>
                  <td><?php echo $value->fullname; ?></td>
                  <td><?php echo $value->address; ?></td>
                  <td><?php echo $value->phone; ?></td>
                  <td><?php echo $value->jobtitle; ?></td>
                  <td><?php echo $value->relationship; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-print-12">
      <h4>Medical History</h4>
      <div class="col-sm-12 col-print-12">
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Have you ever experienced seriously ill?</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo ($userhealth) ? (($userhealth->sick == 1) ? "<span class='label label-success'>Yes</span>" : "<span class='label label-danger'>No</span>") : '-'; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>If yes, When?</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo ($userhealth) ? $userhealth->when : '-'; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>what are the consequences until now </strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo ($userhealth) ? $userhealth->effect : '-'; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Illness Description </strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo ($userhealth) ? $userhealth->illnessdesc : '-'; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>have you ever had an accident?</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo ($userhealth) ? (($userhealth->accident == 1) ? "<span class='label label-success'>Yes</span>" : "<span class='label label-danger'>No</span>") : '-'; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>If yes, When? </strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo ($userhealth) ? $userhealth->whenaccident : '-'; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>what are the consequences until now </strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo ($userhealth) ? $userhealth->efffectaccident : '-'; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Accident Description</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo ($userhealth) ? $userhealth->accidentdesc : '-'; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-print-12">
      <h4>About you</h4>
      <div class="col-sm-12 col-print-12">
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Strengths</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo ($userabout) ? $userabout->strengths : '-'; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Weakness</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo ($userabout) ? $userabout->weakness : '-'; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Ambition and hopefullness</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo ($userabout) ? $userabout->ambitionandhopefullness : '-'; ?>
          </div>
        </div>

      </div>
    </div>
    <div class="col-sm-12 col-print-12">
      <h4>Other people's opinions about you</h4>
      <div class="col-sm-12 col-print-12">
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Strengths</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo ($userabout) ? $userabout->strengthsopinion : '-'; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Weakness</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo ($userabout) ? $userabout->weaknessopinion : '-'; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-print-12">
      <h4>Other Information</h4>
      <div class="col-sm-12 col-print-12">
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Ready for work shift? </strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo ($userabout) ? (($userabout->readyshift == 1) ? "<span class='label label-success'>Yes</span>" : "<span class='label label-danger'>No</span>") : '-'; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Ready for work overtime?</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo ($userabout) ? (($userabout->readyovertime == 1) ? "<span class='label label-success'>Yes</span>" : "<span class='label label-danger'>No</span>") : '-'; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Ready for task to out of town?</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo ($userabout) ? (($userabout->readyoverstay == 1) ? "<span class='label label-success'>Yes</span>" : "<span class='label label-danger'>No</span>") : '-'; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Ready for placed to out of town </strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo ($userabout) ? (($userabout->readyoutcity == 1) ? "<span class='label label-success'>Yes</span>" : "<span class='label label-danger'>No</span>") : '-'; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Job that you like?</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo ($userabout) ? $userabout->joblikeskill : '-'; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Job that you do not like?</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo ($userabout) ? $userabout->jobunlikeskill : '-'; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Have you ever done a psychological test?</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo ($userabout) ? (($userabout->havepsikotest == 1) ? "<span class='label label-success'>Yes</span>" : "<span class='label label-danger'>No</span>") : '-'; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Expectation Salary</strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo ($userabout) ? number_format($userabout->expectsalary) : '-'; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>When you ready for start work </strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo ($userabout) ? $userabout->readyforwork : '-'; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Bank Name </strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo ($userabout) ? (($userabout->bankid == null) ? '' : $userabout->bankname->bank) : '-'; ?>
          </div>
        </div>
        <div class="row line-info">
          <div class="col-sm-4 col-print-4">
            <strong>Bank Account Number </strong><br>
          </div>
          <div class="col-sm-8 col-print-8">
            : <?php echo ($userabout) ? $userabout->bankaccountnumber : '-'; ?>
          </div>
        </div>
      </div>
    </div>



  </div>
  </div>
</section>