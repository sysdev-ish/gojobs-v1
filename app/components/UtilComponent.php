<?php
namespace app\components;

use Yii;
use yii\base\Component;
use linslin\yii2\curl;

use app\models\Userprofile;
use app\models\Userlogin;
use app\models\Rolepermission;
use app\models\Mappinggrouprolepermission;

use app\models\Hiring;
use app\models\Mailcounter;
use app\models\Logactivity;

use app\modules\dashboard\models\Whatsapp;
use app\modules\dashboard\models\Sms;

use DateTime;
use DatePeriod;
use DateInterval;


class UtilComponent extends Component {

  public function logger($type = 'info', $message = null){
    $ret = null;

    if($message){

      switch ($type) {
        case 'error':
        $log_msg = date('Y-m-d H:i:s') . ' ERROR ' . $message;
        break;

        case 'warning':
        $log_msg = date('Y-m-d H:i:s') . ' WARNING ' . $message;
        break;

        default:
        $log_msg = date('Y-m-d H:i:s') . ' INFO ' . $message;
        break;
      }

      $log_filename = 'haier-app-' . date('Y-m-d') . '.log';
      $logFile = Yii::$app->getRuntimePath() . '/logs/' . $log_filename;
      file_put_contents($logFile, $log_msg . "\n", FILE_APPEND);

    }

    return $ret;
  }
  public function todate($date){

    $time=strtotime($date);

    return $time;
  }
  public function getlayout(){

    if(Yii::$app->user->isGuest){
      $role = 2;
    }else{
      // $userid = Yii::$app->user->identity->id;
      $role = Yii::$app->user->identity->role;
    }
    if($role==2){
      $layout = 'main-applicant';
    }else{
      $layout = 'main';
    }

    return $layout;
  }
  public function getprofileuser($userid){

    $ret = null;
    $userprofile = Userprofile::find()->where(['userid'=>$userid])->one();


    if($userprofile){
      $ret = $userprofile;
    }else{
      $ret = null;
    }

    return $ret;
  }
  public function permission($roleid,$modulecode){

    $ret = false;
    if(!Yii::$app->user->isGuest){
      if($modulecode == "B01" && $roleid == 2){
          $ret = false;
      }else {
        $getgrouprole = Yii::$app->user->identity->grouprolepermissionid;
        $rolepermission = null;
        if($getgrouprole){
          $getroleid = $this->getroleid($getgrouprole);

          // var_dump($getgrouprole);die;
          if($getroleid){
            $getroleid = implode(',', $getroleid);
            $rolepermission = Rolepermission::find()->where('roleid IN (' . $getroleid . ') and modulecode = "'.$modulecode.'"')->one();
          }
        }else{
          $rolepermission = Rolepermission::find()->where(['roleid'=>$roleid,'modulecode'=>$modulecode])->one();
        }



        if($rolepermission){
          $ret = true;
        }else{
          if($modulecode == "B01"){
            $ret = true;
          }else {
            $ret = false;
          }
        }
      }
      }


    return $ret;
  }
  protected function getroleid($grouprolepermissionid){
    $ret = null;
    if($grouprolepermissionid){
      $getrole = Mappinggrouprolepermission::find()->where(['grouprolepermissionid'=>$grouprolepermissionid,'active'=>1])->all();
      $roleids = null;
      if($getrole){
        $roleids = array();
        foreach($getrole as $tr){
          $roleids[] = $tr->roleid;
        }
      }
      $ret = $roleids;
    }

    return $ret;
  }
  public function getusername($username){
    $ret = null;
    if($username){
      // $ret = null;
      // var_dump($username);die;
      $getname = Userlogin::find()->where(['username'=>$username])->one();
      if($getname){
        $ret = $getname->name;
      }else{
        $ret = null;
        $getnamebyothersid = Userlogin::find()->where(['othersid'=>$username])->one();
        if($getnamebyothersid){
          $ret = $getnamebyothersid->name;
        }
      }
      }
      return $ret;
    }


  // public function getvstatus(){
  //
  //   if(Yii::$app->user->isGuest){
  //     $vstatus = 1;
  //     $role = 2;
  //   }else{
  //     // $userid = Yii::$app->user->identity->id;
  //     $role = Yii::$app->user->identity->role;
  //     $vstatus = Yii::$app->user->identity->verify_status
  //   }
  //   if($role==1 && $vstatus==2){
  //     $layout = 'main-applicant';
  //   }else{
  //     $layout = 'main';
  //   }
  //
  //   return $layout;
  // }

  public function sendmail($to,$subject,$body,$identifier){
    $curl = new curl\Curl();
    $verification = $curl->setPostParams([
      // 'from' => 'gojobs@ish.co.id',
      'to[]' => $to,
      'subject' => $subject,
      'body' => $body,
      'token' => 'ish@gojobs',
    ])
    ->post('http://192.168.88.27/mailgatewaygojobs/send');
    $response = $verification[8];
    $now = date('Y-m-d');
    $updatetoday = Mailcounter::find()->where(['date'=>$now, 'klasifikasi'=>$identifier])->one();
    if($updatetoday){
      $addcounter = $updatetoday->count + 1;
      $updatetoday->count = $addcounter;
      $updatetoday->save(false);
    }else{
      $newtoday = new Mailcounter();
      $newtoday->date = date('Y-m-d');
      $newtoday->count = 1;
      $newtoday->klasifikasi = $identifier;
      $newtoday->save(false);
    }
    return $response;
  }

  public function sendmailinternal($to,$subject,$body,$identifier){
    $curl = new curl\Curl();
    $verification = $curl->setPostParams([
      // 'from' => 'gojobs@ish.co.id',
      'to' => $to,
      'subject' => $subject,
      'body' => $body,
      'token' => 'ish@!notif',
      'appsenderid' => 1,
    ])
    ->post('http://192.168.88.70/notification/web/api/sendmail');
    $response = $verification;
    $now = date('Y-m-d');
    $updatetoday = Mailcounter::find()->where(['date'=>$now, 'klasifikasi'=>$identifier])->one();
    if($updatetoday){
      $addcounter = $updatetoday->count + 1;
      $updatetoday->count = $addcounter;
      $updatetoday->save(false);
    }else{
      $newtoday = new Mailcounter();
      $newtoday->date = date('Y-m-d');
      $newtoday->count = 1;
      $newtoday->klasifikasi = $identifier;
      $newtoday->save(false);
    }
    return $response;
  }

  //start connect hris
  public function getaccesstoken($code){
    $curl = new curl\Curl();
    $getaccesstoken = $curl->setPostParams([
      'grant_type' => 'authorization_code',
      'code' => $code,
      'redirect_uri' => 'https://gojobs.id/rekrut/site/oauthhris',
      'client_id' => 'goj0bsid',
      'client_secret' => 'e95h0gf8x8mwlek9bqgy',
    ])
    ->post('passport.ish.co.id/core/api/sso/token');
    // var_dump($getaccesstoken);die;
    $response = $getaccesstoken;
    return $response;
  }
  public function getuserdata($token){
    $curl = new curl\Curl();
    $getuserdata = $curl->setPostParams([
      'access_token' => $token,
    ])
    ->post('passport.ish.co.id/core/api/sso/info');
    // var_dump($getaccesstoken);die;
    $response = $getuserdata;
    return $response;
  }
  public function logout($token){
    $curl = new curl\Curl();
    $logout = $curl->setPostParams([
      'access_token' => $token,
    ])
    ->post('passport.ish.co.id/core/api/sso/logout');
    // var_dump($getaccesstoken);die;
    $response = $logout;
    return $response;
  }
  //end connect hris
  public function terbilang($bilangan){
    $angka = array('0','0','0','0','0','0','0','0','0','0',
    '0','0','0','0','0','0');
    $kata = array('','satu','dua','tiga','empat','lima',
    'enam','tujuh','delapan','sembilan');
    $tingkat = array('','ribu','juta','milyar','triliun');

    $panjang_bilangan = strlen($bilangan);

    /* pengujian panjang bilangan */
    if ($panjang_bilangan > 15) {
      $kalimat = "Diluar Batas";
      return $kalimat;
    }

    /* mengambil angka-angka yang ada dalam bilangan,
    dimasukkan ke dalam array */
    for ($i = 1; $i <= $panjang_bilangan; $i++) {
      $angka[$i] = substr($bilangan,-($i),1);
    }

    $i = 1;
    $j = 0;
    $kalimat = "";


    /* mulai proses iterasi terhadap array angka */
    while ($i <= $panjang_bilangan) {

      $subkalimat = "";
      $kata1 = "";
      $kata2 = "";
      $kata3 = "";

      /* untuk ratusan */
      if ($angka[$i+2] != "0") {
        if ($angka[$i+2] == "1") {
          $kata1 = "seratus";
        } else {
          $kata1 = $kata[$angka[$i+2]] . " ratus";
        }
      }

      /* untuk puluhan atau belasan */
      if ($angka[$i+1] != "0") {
        if ($angka[$i+1] == "1") {
          if ($angka[$i] == "0") {
            $kata2 = "sepuluh";
          } elseif ($angka[$i] == "1") {
            $kata2 = "sebelas";
          } else {
            $kata2 = $kata[$angka[$i]] . " belas";
          }
        } else {
          $kata2 = $kata[$angka[$i+1]] . " puluh";
        }
      }

      /* untuk satuan */
      if ($angka[$i] != "0") {
        if ($angka[$i+1] != "1") {
          $kata3 = $kata[$angka[$i]];
        }
      }

      /* pengujian angka apakah tidak nol semua,
      lalu ditambahkan tingkat */
      if (($angka[$i] != "0") OR ($angka[$i+1] != "0") OR
      ($angka[$i+2] != "0")) {
        $subkalimat = "$kata1 $kata2 $kata3 " . $tingkat[$j] . " ";
      }

      /* gabungkan variabe sub kalimat (untuk satu blok 3 angka)
      ke variabel kalimat */
      $kalimat = $subkalimat . $kalimat;
      $i = $i + 3;
      $j = $j + 1;

    }

    /* mengganti satu ribu jadi seribu jika diperlukan */
    if (($angka[5] == "0") AND ($angka[6] == "0")) {
      $kalimat = str_replace("satu ribu","seribu",$kalimat);
    }

    return trim($kalimat);

  }
  public function indodate($date){
    $days = date("D", strtotime($date));
    $dates = date("Y-m-d", strtotime($date));
    switch($days){
      case 'Sun':
      $day = "Minggu";
      break;

      case 'Mon':
      $day = "Senin";
      break;

      case 'Tue':
      $day = "Selasa";
      break;

      case 'Wed':
      $day = "Rabu";
      break;

      case 'Thu':
      $day = "Kamis";
      break;

      case 'Fri':
      $day = "Jumat";
      break;

      case 'Sat':
      $day = "Sabtu";
      break;

      default:
      $day = "Tidak di ketahui";
      break;
    };

    $bulan = array (
      1 =>   'Januari',
      2 => 'Februari',
      3 => 'Maret',
      4 => 'April',
      5 => 'Mei',
      6 => 'Juni',
      7 => 'Juli',
      8 => 'Agustus',
      9 => 'September',
      10 => 'Oktober',
      11 => 'November',
      12 => 'Desember'
    );
    $pecahkan = explode('-', $dates);

    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun

    return $day.', '.$pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];


  }
  public function getpersonalarea($persaid){

    $ret = null;
    if($persaid){
      $curl = new curl\Curl();
      $getpersonalarea = $curl->setPostParams([
        'persaid' => $persaid,
        'token' => 'ish**2019',
      ])
      ->post('http://192.168.88.5/service/index.php/sap_masterdata/getpersonalarea');
      $personalarea  = json_decode($getpersonalarea);

      if($personalarea){
        $ret = $personalarea->value2;
      }else{
        $ret = null;
      }
    }


    return $ret;
  }
  public function getarea($areaid){

    $ret = null;
    if($areaid){
      $curl = new curl\Curl();
      $getarea = $curl->setPostParams([
        'areaid' => $areaid,
        'token' => 'ish**2019',
      ])
      ->post('http://192.168.88.5/service/index.php/sap_masterdata/getarea');
      $area  = json_decode($getarea);

      if($area){
        $ret = $area->value2;
      }else{
        $ret = null;
      }
    }


    return $ret;
  }
  public function getskilllayanan($skilllayananid){

    $ret = null;
    if($skilllayananid){
      $curl = new curl\Curl();
      $getskillayanan = $curl->setPostParams([
        'skilllayananid' => $skilllayananid,
        'token' => 'ish**2019',
      ])
      ->post('http://192.168.88.5/service/index.php/sap_masterdata/getskilllayanan');
      $skilllayanan  = json_decode($getskillayanan);

      if($skilllayanan){
        $ret = $skilllayanan->value2;
      }else{
        $ret = null;
      }
    }


    return $ret;
  }
  public function getpayrollarea($payrollareaid){

    $ret = null;
    if($payrollareaid){
      $curl = new curl\Curl();
      $getpayrollarea = $curl->setPostParams([
        'payrollareaid' => $payrollareaid,
        'token' => 'ish**2019',
      ])
      ->post('http://192.168.88.5/service/index.php/sap_masterdata/getpayrollarea');
      $payrollarea  = json_decode($getpayrollarea);

      if($payrollarea){
        $ret = $payrollarea->value2;
      }else{
        $ret = null;
      }
    }


    return $ret;
  }
  public function getjabatan($jabatanid){

    $ret = null;
    if($jabatanid){
      $curl = new curl\Curl();
      $getjabatan = $curl->setPostParams([
        'jabatanid' => $jabatanid,
        'token' => 'ish**2019',
      ])
      ->post('http://192.168.88.5/service/index.php/sap_masterdata/getjabatan');
      $jabatan  = json_decode($getjabatan);
      // var_dump($jabatan);die;
      if($jabatan){
        $ret = $jabatan->value2;
      }else{
        $ret = null;
      }
    }


    return $ret;
  }
  public function getjabatanid($jabatan){

    $ret = null;
    if($jabatan){
      $curl = new curl\Curl();
      $getjabatan = $curl->setPostParams([
        'jabatan' => $jabatan,
        'token' => 'ish**2019',
      ])
      ->post('http://192.168.88.5/service/index.php/sap_masterdata/getjabatanid');
      $jabatan  = json_decode($getjabatan);
      // var_dump($jabatan);die;
      if($jabatan){
        $ret = $jabatan->value1;
      }else{
        $ret = null;
      }
    }


    return $ret;
  }
  public function getnamebynik($nik){

    $ret = null;
    if($nik){
      $curl = new curl\Curl();
      $getname = $curl->setPostParams([
        'auth_token' => 'ish@cipete2018!',
        'perner' => $nik,
        // 'perner' => '8508100',
        // 'perner' => '80937',
      ])
      ->post('https://hris.ish.co.id/core/api/employee/detail');
      $name  = json_decode($getname);
      // var_dump($name);die;

      if($name){
        if($name->code){
          $ret = $name->data->name;
        }else{
          $ret = null;
        }
      }

    }


    return $ret;
  }
  public function ordinal($num)
  {
    $last=substr($num,-1);
    if( $last>3  or
    $last==0 or
    ( $num >= 11 and $num <= 19 ) )
    {
      $ext='th';
    }
    else if( $last==3 )
    {
      $ext='rd';
    }
    else if( $last==2 )
    {
      $ext='nd';
    }
    else
    {
      $ext='st';
    }
    return $num.$ext;
  }
  public function diffdate ($date1, $date2)
  {
    $begin = new DateTime( $date1 );
    $end = new DateTime( $date2 );
    $end = $end->modify( '+1 month' );

    $interval = DateInterval::createFromDateString('1 month');

    $period = new DatePeriod($begin, $interval, $end);
    $counter = 0;
    foreach($period as $dt) {
        $counter++;
    }

    return $counter;
  }

  public function aplhired($userid)
  {
    $ret = null;
    $userhired = Hiring::find()->where(['userid'=>$userid,'statushiring'=>4,'statusbiodata'=>4])->one();


    if($userhired){
      $ret = $userhired;
    }else{
      $ret = null;
    }

    return $ret;
  }
  function generateRandomString($length = 5) {
			$chars = "23456789ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz";
			$charArray = str_split($chars);
			$charCount = strlen($chars);
			$result = "";
			for($i=1;$i<=$length;$i++)
			{
				$randChar = rand(0,$charCount-1);
				$result .= $charArray[$randChar];
			}
			return $result;
		}
    public function insppjp($perner,$joindate){

      $ret = null;
      if($perner && $joindate){
        $curl = new curl\Curl();
        $insppjp = $curl->setPostParams([
          'perner' => $perner,
          'joindate' => $joindate,
        ])
        ->post('http://192.168.88.5/hrms/RFCIT9002.php');
        $returninsppjp  = json_decode($insppjp);

        if($returninsppjp){
          $ret = $returninsppjp->CODE;
        }else{
          $ret = null;
        }
      }


      return $ret;
    }
    public function create_login_log(){
      $ret = null;
      if(!Yii::$app->user->isGuest){
        $checklog = Logactivity::find()->where('userid ='.Yii::$app->user->identity->id.' AND date = CURDATE()')->one();
        if($checklog){
          $logmodel = $checklog;
          // var_dump($checklog);die;


          $logmodel->lastlogin = date('Y-m-d H-i-s');
          $logmodel->counter =  $checklog->counter + 1;
          $logmodel->save();

        }else{
          $nik = Yii::$app->user->identity->username;
          $newlogmodel = new Logactivity();

          $divisionid = null;
          $divisionname = 'division unregistered on hris';
          $curl = new curl\Curl();
          $getdata = $curl->setPostParams([
            'auth_token' => 'ish@cipete2018!',
            'perner' => $nik,
          ])
          ->post('https://hris.ish.co.id/core/api/employee/detail');
          $dataresult  = json_decode($getdata);

          if($dataresult){
            if($dataresult->code == 1){
              $divisionid = $dataresult->data->positions[0]->division_id;
              $divisionname = $dataresult->data->positions[0]->division_name;
            }
          }

          $newlogmodel->date = date('Y-m-d');
          $newlogmodel->userid = Yii::$app->user->identity->id;
          $newlogmodel->actiitytype = 1;
          $newlogmodel->roleid = Yii::$app->user->identity->role;
          $newlogmodel->divisionid = $divisionid;
          $newlogmodel->division = $divisionname;
          $newlogmodel->firstlogin = date('Y-m-d H-i-s');
          $newlogmodel->lastlogin = date('Y-m-d H-i-s');
          $newlogmodel->counter = 1;
          $newlogmodel->save(false);
        }

        // var_dump($name);die;



      }


      return $ret;
      // var_dump(Yii::$app->user->identity->id);die;
    }





}
