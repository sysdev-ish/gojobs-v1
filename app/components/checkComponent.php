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
use app\models\Transperner;
use app\models\Transrincianori;
use app\models\Recruitmentcandidate;
use app\models\Chagerequestjo;
use app\models\Hiring;
use app\models\Transjo;
use app\models\User;
use app\models\WoHiring;
use app\models\WoRecruitmentCandidate;
use app\models\Workorder;

class checkComponent extends Component
{


  public function datacompleted($userid)
  {
    $ret = null;
    $userprofile = $this->cuserprofile($userid);
    // $userfamily = $this->cuserfamily($userid);
    // $userfedu = $this->cuserfeducation($userid);
    // $usernfedu = $this->cusernfeducation($userid);
    // $usernflang = $this->cuserflang($userid);
    // $userwexp = $this->cuserwexperience($userid);
    // $userorgac = $this->cuserorgac($userid);
    // $userecontact = $this->cuserecontact($userid);
    // $userreff = $this->cuserreff($userid);
    // $userhealth = $this->cuserhealth($userid);


    // if($userprofile && $userfamily && $userfedu  && $usernflang && $userecontact  && $userhealth){
    if ($userprofile) {
      $ret = 1;
    } else {
      $ret = 0;
    }

    return $ret;
  }
  public function datacompletedhiring($userid)
  {
    $ret = null;
    $userprofile = $this->cuserprofile($userid);
    $userfamily = $this->cuserfamily($userid);
    $userfedu = $this->cuserfeducation($userid);
    $usernfedu = $this->cusernfeducation($userid);
    // $usernflang = $this->cuserflang($userid);
    $userwexp = $this->cuserwexperience($userid);
    $userorgac = $this->cuserorgac($userid);
    $userecontact = $this->cuserecontact($userid);
    $userreff = $this->cuserreff($userid);
    $userhealth = $this->cuserhealth($userid);


    if ($userprofile && $userfamily && $userfedu && $userecontact && $userhealth) {
      $ret = 1;
    } else {
      $ret = 0;
    }

    return $ret;
  }
  public function datanotcompleted($userid)
  {
    $ret = null;
    $userprofile = $this->cuserprofile($userid);
    $userfamily = $this->cuserfamily($userid);
    $userfedu = $this->cuserfeducation($userid);
    $usernfedu = $this->cusernfeducation($userid);
    $usernflang = $this->cuserflang($userid);
    $userwexp = $this->cuserwexperience($userid);
    $userorgac = $this->cuserorgac($userid);
    $userecontact = $this->cuserecontact($userid);
    $userreff = $this->cuserreff($userid);
    $userhealth = $this->cuserhealth($userid);

    $data = [
      'profile' => $userprofile,
      'family ' => $userfamily,
      'formal_education' => $userfedu,
      'nonformal_education' => $usernfedu,
      'foreign_language' => $usernflang,
      'work experience' => $userwexp,
      'organization' => $userorgac,
      'emergencycontact' => $userecontact,
      'reference' => $userreff,
      'skill' => $userhealth
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

  public function datanothiring($userid)
  {
    $ret = null;
    $userprofile = $this->cuserprofile($userid);
    $userfamily = $this->cuserfamily($userid);
    $userfedu = $this->cuserfeducation($userid);
    $userecontact = $this->cuserecontact($userid);
    $userinfo = $this->cuserinfo($userid);

    $data = [
      'profile' => $userprofile,
      'family' => $userfamily,
      'formal_education' => $userfedu,
      'emergency_contact' => $userecontact,
      'info(bank account)' => $userinfo
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
  public function cuserprofile($userid)
  {
    $ret = null;
    $userprofile = Userprofile::find()->where(['userid' => $userid])->one();


    if ($userprofile) {
      $ret = 1;
    } else {
      $ret = 0;
    }

    return $ret;
  }
  public function cuserfamily($userid)
  {
    $ret = null;
    $userfamily = Userfamily::find()->where(['userid' => $userid])->one();


    if ($userfamily) {
      $ret = 1;
    } else {
      $ret = 0;
    }

    return $ret;
  }
  public function cuserfeducation($userid)
  {
    $ret = null;
    $userfedu = Userformaleducation::find()->where(['userid' => $userid])->one();


    if ($userfedu) {
      $ret = 1;
    } else {
      $ret = 0;
    }

    return $ret;
  }
  public function cusernfeducation($userid)
  {
    $ret = null;
    $usernfedu = Usernonformaleducation::find()->where(['userid' => $userid])->one();


    if ($usernfedu) {
      $ret = 1;
    } else {
      $ret = 0;
    }

    return $ret;
  }
  public function cuserflang($userid)
  {
    $ret = null;
    $usernflang = Userforeignlanguage::find()->where(['userid' => $userid])->one();


    if ($usernflang) {
      $ret = 1;
    } else {
      $ret = 0;
    }

    return $ret;
  }
  public function cuserwexperience($userid)
  {
    $ret = null;
    $userwexp = Userworkexperience::find()->where(['userid' => $userid])->one();


    if ($userwexp) {
      $ret = 1;
    } else {
      $ret = 0;
    }

    return $ret;
  }
  public function cuserorgac($userid)
  {
    $ret = null;
    $userorgac = Organizationactivity::find()->where(['userid' => $userid])->one();


    if ($userorgac) {
      $ret = 1;
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
      $ret = 1;
    } else {
      $ret = 0;
    }

    return $ret;
  }
  public function cuserreff($userid)
  {
    $ret = null;
    $userreff = Userreference::find()->where(['userid' => $userid])->one();

    if ($userreff) {
      $ret = 1;
    } else {
      $ret = 0;
    }

    return $ret;
  }
  public function cuserhealth($userid)
  {
    $ret = null;
    $userhealth = Userhealth::find()->where(['userid' => $userid])->one();
    $userabout = Userabout::find()->where(['userid' => $userid])->one();

    if ($userhealth && $userabout) {
      $ret = 1;
    } else {
      $ret = 0;
    }

    return $ret;
  }
  public function cuserainfo($userid)
  {
    $ret = null;
    $userhealth = Userhealth::find()->where(['userid' => $userid])->one();
    $userabout = Userabout::find()->where(['userid' => $userid])->one();

    if ($userhealth or $userabout) {
      $ret = 1;
    } else {
      $ret = 0;
    }

    return $ret;
  }

  public function cuserinfo($userid)
  {
    $ret = null;
    // $userhealth = Userhealth::find()->where(['userid' => $userid])->one();
    $userabout = Userabout::find()->where(['userid' => $userid])->one();

    if ($userabout) {
      $ret = 1;
    } else {
      $ret = 0;
    }

    return $ret;
  }
  public function cuploaddoc($userid)
  {
    $ret = null;
    $uploaddoc = Uploadocument::find()->where(['userid' => $userid])->one();

    if ($uploaddoc) {
      $ret = 1;
    } else {
      $ret = 0;
    }

    return $ret;
  }
  public function checkcandidate($id)
  {
    $ret = null;
    $tr = Transrincian::find()->where(['id' => $id])->one();
    $trori = Transrincianori::find()->where(['id' => $tr->idpktable])->one();
    $tp = Transperner::find()->where(['id' => $tr->idpktable])->one();
    $transjo = Transjo::find()->where(['nojo' => $tr->nojo])->one();
    $candidate = Recruitmentcandidate::find()
      ->where(['recruitreqid' => $id])
      ->andWhere([
        'or',
        ['status' => 4],
        ['status' => 26]
      ])
      ->all();

    if ($candidate) {
      $ret = count($candidate);
    } else {
      $ret = 0;
    }
    if ($tr->typejo == 1) {
      if ($transjo->flag_peralihan == 1) {
        // if($trori->type_rekrut == 1 OR $trori->type_rekrut == 3){
        if ($tr->type_rekrut == 1 or $tr->type_rekrut == 3) {
          $ret = $tr->jumlah;
        }
      } else {
        if ($tr->type_rekrut == 3) {
          $ret = $tr->jumlah;
        }
      }
    } else {
      if ($transjo->flag_peralihan == 1) {
        if ($tp->type_rep == 1 or $tp->type_rep == 3) {
          $ret = $tr->jumlah;
        }
      } else {

        if (!is_null($tp) && $tp->type_rep == 3) {
          $ret = $tr->jumlah;
        }
      }
    }




    return $ret;
  }
  public function checkapplied($id)
  {
    $ret = null;
    $tr = Transrincian::find()->where(['id' => $id])->one();
    $trori = Transrincianori::find()->where(['id' => $tr->idpktable])->one();
    $tp = Transperner::find()->where(['id' => $tr->idpktable])->one();
    $transjo = Transjo::find()->where(['nojo' => $tr->nojo])->one();
    $candidate = Recruitmentcandidate::find()
      ->where(['recruitreqid' => $id])
      ->all();

    if ($candidate) {
      $ret = count($candidate);
    } else {
      $ret = 0;
    }
    if ($tr->typejo == 1) {
      if ($transjo->flag_peralihan == 1) {
        // if($trori->type_rekrut == 1 OR $trori->type_rekrut == 3){
        if ($tr->type_rekrut == 1 or $tr->type_rekrut == 3) {
          $ret = $tr->jumlah;
        }
      } else {
        if ($tr->type_rekrut == 3) {
          $ret = $tr->jumlah;
        }
      }
    } else {
      if ($transjo->flag_peralihan == 1) {
        if ($tp->type_rep == 1 or $tp->type_rep == 3) {
          $ret = $tr->jumlah;
        }
      } else {

        if (!is_null($tp) && $tp->type_rep == 3) {
          $ret = $tr->jumlah;
        }
      }
    }




    return $ret;
  }
  public function checkJohired($id, $condition)
  {
    $ret = null;
    $tr = Transrincian::find()->where(['id' => $id])->one();
    $trori = Transrincianori::find()->where(['id' => $tr->idpktable])->one();
    $tp = Transperner::find()->where(['id' => $tr->idpktable])->one();
    $transjo = Transjo::find()->where(['nojo' => $tr->nojo])->one();

    if ($condition == 1) {
      $candidate = Hiring::find()
        ->where(['recruitreqid' => $id])
        ->andWhere([
          'or',
          ['statushiring' => 4],
          ['statushiring' => 7],
          ['statushiring' => 8]
        ])
        ->all();
    } else {
      $candidate = Hiring::find()
        ->where(['recruitreqid' => $id])
        ->andWhere([
          'or',
          ['statushiring' => 4],
          ['statushiring' => 7],
          ['statushiring' => 8],
          ['statushiring' => 1]
        ])
        ->all();
    }

    if ($candidate) {
      $ret = count($candidate);
    } else {
      $ret = 0;
    }

    if ($tr->typejo == 1) {
      if ($transjo->flag_peralihan == 1) {
        // if($trori->type_rekrut == 1 OR $trori->type_rekrut == 3){
        if ($tr->type_rekrut == 1 or $tr->type_rekrut == 3) {
          $ret = $tr->jumlah;
        }
      } else {
        if ($tr->type_rekrut == 3) {
          $ret = $tr->jumlah;
        }
      }
    } else {
      if ($transjo->flag_peralihan == 1) {
        if ($tp->type_rep == 1 or $tp->type_rep == 3) {
          $ret = $tr->jumlah;
        }
      } else {
        if (!is_null($tp) && $tp->type_rep == 3) {

          $ret = $tr->jumlah;
        }
      }
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
  public function checkstatuscr($id)
  {
    $ret = null;
    $crjo = Chagerequestjo::find()->where(['recruitreqid' => $id, 'status' => 1])->one();

    if ($crjo) {
      $ret = 1;
    } else {
      $ret = 0;
    }

    return $ret;
  }
  public function checkstatusjoHired($id, $newjumlah)
  {
    $ret = null;
    // $hired = Hiring::find()->where(['recruitreqid' => $id, 'statushiring' => 4])->all();
    $hired = Hiring::find()->where(['recruitreqid' => $id])
          ->andWhere(['statushiring' => [4, 7]]) // Use IN condition for status_rekrut
          ->all();

    if ($newjumlah == count($hired)) {
      $ret = 1;
    } else {
      $ret = 0;
    }

    return $ret;
  }

  // check component for appplied, candidate, or hired in workorder
  public function wo_candidate($id)
  {
    $ret = null;
    $tr = Workorder::find()->where(['id' => $id])->one();
    $candidate = WoRecruitmentCandidate::find()
      ->where(['wo_id' => $id])
      ->andWhere([
        'or',
        ['status' => 4],
        ['status' => 26]
      ])
      ->all();

    if ($candidate) {
      $ret = count($candidate);
    } else {
      $ret = 0;
    }
    if ($tr) {
        $ret = $tr->total_job;
    }
    return $ret;
  }
  // 
  public function wo_applied($id)
  {
    $ret = null;
    $workorder = Workorder::find()->where(['id' => $id])->one();
    $candidate = WoRecruitmentCandidate::find()->where(['wo_id' => $id])->all();

    if ($candidate) {
      $ret = count($candidate);
    } else {
      $ret = 0;
    }
    // 
    if ($workorder) {
        $ret = $workorder->total_applied;
    }
    return $ret;
  }
  // 
  public function wo_hired($id, $condition)
  {
    $ret = null;
    $tr = Workorder::find()->where(['id' => $id])->one();

    if ($condition == 1) {
      $candidate = WoHiring::find()
        ->where(['wo_id' => $id])
        ->andWhere([
          'or',
          ['hiring_status' => 4],
          ['hiring_status' => 7],
          ['hiring_status' => 8]
        ])
        ->all();
    } else {
      $candidate = WoHiring::find()
        ->where(['wo_id' => $id])
        ->andWhere([
          'or',
          ['hiring_status' => 4],
          ['hiring_status' => 7],
          ['hiring_status' => 8],
          ['hiring_status' => 1]
        ])
        ->all();
    }

    if ($candidate) {
      $ret = count($candidate);
    } else {
      $ret = 0;
    }

    if ($tr) {
      $ret = $tr->total_job;
    }

    return $ret;
  }


  // check user from blacklist or block
  public function checkBlacklist($mobile, $email, $name)
  {
    // 
    $ret = null;

    $check_data = User::find()->where([
      'or',
      ['mobile' => $mobile], ['email' => $email], ['name' => $name]
    ])->andWhere(['is_whitelist' => 'whitelist'])->one();

    if ($check_data) {
      $ret = 1;
    } else {
      $ret = 0;
    }

    return $ret;
  }

  public function checkBlacklistLogin($username)
  {
    // 
    $ret = null;

    // $check_data = User::find()->where(['username' => $username])->one();
    $check_data = User::find()->where(['username' => $username, 'is_whitelist' => 'whitelist'])->one();
    // var_dump($check_data);die();

    if ($check_data) {
      $ret = 1;
    } else {
      $ret = 0;
    }
    // var_dump($ret);die();
    return $ret;
  }
}
