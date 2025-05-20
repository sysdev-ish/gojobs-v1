<?php

namespace app\components;

use Yii;
use yii\base\Component;

use app\models\Userprofile;
use app\models\Userfamily;
use app\models\Userformaleducation;
use app\models\Usernonformaleducation;
use app\models\Userforeignlanguage;
use app\models\Userworkexperience;
use app\models\Organizationactivity;
use app\models\Useremergencycontact;
use app\models\Userreference;
use app\models\Userhealth;
use app\models\Userabout;
use app\models\Uploadocument;
use app\models\Transrincian;
use app\models\Recruitmentcandidate;


class checkDataforhiring extends Component
{


  public function datacompleted($userid)
  {
    $ret = null;
    $userprofile = $this->cuserprofile($userid);
    $userfamily = $this->cuserfamily($userid);
    $userfedu = $this->cuserfeducation($userid);
    $usernfedu = $this->cusernfeducation($userid);
    $userecontact = $this->cuserecontact($userid);
    $userabout = $this->cuserabout($userid);
    // $document = $this->cuserdoc($userid);

    if ($userprofile && $userfamily && $userfedu && $userecontact  && $userabout) {
    // if ($userprofile && $userfamily && $userfedu && $userecontact  && $userabout && $document) {
      $ret = 1;
    } else {
      $ret = 0;
    }
    // var_dump($userprofile.$userfamily.$userfedu.$userecontact.$userabout);die;
    return $ret;
  }
  public function datanotcompleted($userid)
  {
    $ret = null;
    $userprofile = $this->cuserprofile($userid);
    $userfamily = $this->cuserfamily($userid);
    $userfedu = $this->cuserfeducation($userid);
    $userecontact = $this->cuserecontact($userid);
    $userabout = $this->cuserabout($userid);
    // $document = $this->cuserdoc($userid);

    $data = [
      'profile' => $userprofile,
      'family' => $userfamily,
      'formal education' => $userfedu,
      // 'user nonformal education'=>$usernfedu,
      'emergency contact' => $userecontact,
      // 'document' => $document,
      'additional info' => $userabout
    ];
    $dataarray = null;
    foreach ($data as $key => $value) {
      if ($value == 0) {
        $dataarray[] = $key;
      }
    }

    $ret = $dataarray;

    return $ret;
  }
  // public function cjo($recruitreqid){
  //     $ret = null;
  //     $cjo = Transrincian::find()->where(['id'=>$recruitreqid])->one();
  //
  //
  //     if($cjo){
  //       if(
  //         $cjo->persa_sap &&
  //         $cjo->skill_sap &&
  //         $cjo->area_sap &&
  //         $cjo->abkrs_sap &&
  //         $cjo->hire_jabatan_sap &&
  //       ){
  //         $ret = 1;
  //       }else{
  //         $ret = 0;
  //       }
  //     }else{
  //       $ret = 0;
  //     }
  //
  //     return $ret;
  // }
  public function cuserprofile($userid)
  {
    $ret = null;
    $userprofile = Userprofile::find()->where(['userid' => $userid])->one();

    if ($userprofile) {
      if (
        $userprofile->gender &&
        $userprofile->maritalstatus &&
        $userprofile->religion &&
        $userprofile->birthdate &&
        $userprofile->fullname &&
        $userprofile->birthplace &&
        $userprofile->bloodtype &&
        $userprofile->identitynumber &&
        $userprofile->identitynumber <> '2147483647' &&
        $userprofile->kknumber &&
        $userprofile->npwpnumber &&
        $userprofile->jamsosteknumber &&
        $userprofile->bpjsnumber &&
        $userprofile->address &&
        $userprofile->addressktp &&
        $userprofile->domicilestatus &&
        $userprofile->cityktp &&
        $userprofile->city &&
        $userprofile->province &&
        $userprofile->provincektp &&
        $userprofile->postalcode &&
        $userprofile->postalcodektp &&
        $userprofile->phone
      ) {
        $ret = 1;
      } else {
        $ret = 0;
      }
    } else {
      $ret = 0;
    }

    return $ret;
  }
  public function cuserfamily($userid)
  {
    $ret = null;
    $userfamily = Userfamily::find()->where(['userid' => $userid])->all();
    if ($userfamily) {
      foreach ($userfamily as $key => $userfamily) {
        if (
          $userfamily->gender &&
          $userfamily->relationship &&
          $userfamily->jobtitle &&
          $userfamily->birthdate &&
          $userfamily->fullname &&
          $userfamily->birthplace &&
          $userfamily->lasteducation
        ) {
          $ret = 1;
        } else {
          $ret = 0;
          break;
        }
      }
    } else {
      $ret = 0;
    }


    return $ret;
  }
  public function cuserfeducation($userid)
  {
    $ret = null;
    $userfedu = Userformaleducation::find()->where(['userid' => $userid])->all();
    if ($userfedu) {
      foreach ($userfedu as $key => $userfedu) {
        if (
          $userfedu->enddate &&
          $userfedu->status &&
          $userfedu->educationallevel &&
          $userfedu->institutions &&
          $userfedu->gpa
        ) {
          $ret = 1;
        } else {
          $ret = 0;
          break;
        }
      }
    } else {
      $ret = 0;
    }


    return $ret;
  }
  public function cusernfeducation($userid)
  {
    $ret = null;
    $usernfedu = Usernonformaleducation::find()->where(['userid' => $userid])->all();


    if ($usernfedu) {
      foreach ($usernfedu as $key => $usernfedu) {
        if (
          $usernfedu->type &&
          $usernfedu->iscertificate &&
          $usernfedu->enddate &&
          $usernfedu->institutions
        ) {
          $ret = 1;
        } else {
          $ret = 0;
          break;
        }
      }
    } else {
      $ret = 0;
    }

    return $ret;
  }

  public function cuserecontact($userid)
  {
    $ret = null;
    $userecontact = Useremergencycontact::find()->where(['userid' => $userid])->one();


    if ($userecontact) {
      if (
        $userecontact->address &&
        $userecontact->fullname &&
        $userecontact->city &&
        $userecontact->province &&
        $userecontact->postalcode &&
        $userecontact->phone
      ) {
        $ret = 1;
      } else {
        $ret = 0;
      }
    } else {
      $ret = 0;
    }

    return $ret;
  }

  public function cuserabout($userid)
  {
    $ret = null;
    $userabout = Userabout::find()->where(['userid' => $userid])->one();

    if ($userabout) {
      if (
        $userabout->bankid &&
        $userabout->bankaccountnumber
        // $userabout->passbook
      ) {
        $ret = 1;
      } else {
        $ret = 0;
      }
    } else {
      $ret = 0;
    }

    return $ret;
  }
  public function cuserdoc($userid)
  {
    $ret = null;
    $document = Uploadocument::find()->where(['userid' => $userid])->one();

    if ($document) {
      $ret = 1;
    } else {
      $ret = 0;
    }

    return $ret;
  }

  public function checkstatusjo($id)
  {
    $ret = null;
    $transrincian = Transrincian::find()->where(['id' => $id])->one();
    $candidate = Recruitmentcandidate::find()->where(['recruitreqid' => $id, 'status' => 4])->all();

    if ($transrincian->jumlah == count($candidate)) {
      $ret = 'Done';
    } else {
      $ret = 'On Progress';
    }

    return $ret;
  }
}
