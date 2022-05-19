<?php

namespace app\controllers;

use Yii;
use app\models\Hiring;
use app\models\Transrincian;
use app\models\Transjo;
use app\models\Userprofile;
use app\models\Useremergencycontact;
use app\models\Userfamily;
use app\models\Userformaleducation;
use app\models\Usernonformaleducation;
use app\models\Userabout;
use app\models\Hiringsearch;
use app\models\Chagerequestjo;
use app\models\Recruitmentcandidatefhsearch;
use app\models\Userlogin;
use app\models\User;
use app\models\Maillog;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use linslin\yii2\curl;
use yii\filters\AccessControl;

/**
 * HiringController implements the CRUD actions for Hiring model.
 */
class HiringController extends Controller
{
  /**
   * @inheritdoc
   */
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'only' => ['index', 'update', 'create', 'view', 'approve', 'reject', 'addhiring', 'delete'],
        'rules' => [
          [
            'actions' => ['index', 'update', 'create', 'view', 'approve', 'reject', 'addhiring', 'delete'],
            'allow' => true,
            'roles' => ['@'],
            'matchCallback' => function () {
              return (Yii::$app->utils->permission(Yii::$app->user->identity->role, 'm35'));
            }

          ],
          // [
          //     'actions' => ['index','update','create','view','approve','reject','addhiring','delete'],
          //     'allow' => true,
          //     'roles' => ['@'],
          // ],
        ],
      ],
      'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
          'delete' => ['POST'],
        ],
      ],
    ];
  }

  /**
   * Lists all Hiring models.
   * @return mixed
   */
  public function actionIndex()
  {
    $searchModel = new Hiringsearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Displays a single Hiring model.
   * @param integer $id
   * @return mixed
   */
  public function actionView($id)
  {
    return $this->render('view', [
      'model' => $this->findModel($id),
    ]);
  }

  /**
   * Creates a new Hiring model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionAddhiring()
  {
    $searchModelprofile = new Recruitmentcandidatefhsearch();
    $dataProviderprofile = $searchModelprofile->search(Yii::$app->request->queryParams);
    return $this->renderAjax('addhiring', [
      'searchModelprofile' => $searchModelprofile,
      'dataProviderprofile' => $dataProviderprofile,
    ]);
  }
  public function actionCreate($userid)
  {
    $recruitreqid = $_POST['recruitreqid'];
    if ($recruitreqid) {
      $model = new Hiring();
      $modelcountjo = Hiring::find()->where('recruitreqid = ' . $recruitreqid . ' AND statushiring <> 5 AND statushiring <> 6 AND statushiring <> 7')->count();
      $transrincian = Transrincian::find()->where(['id' => $recruitreqid])->one();
      $userprofile = Userprofile::find()->where(['userid' => $userid])->one();
      $chagerequestjo = Chagerequestjo::find()->where(['recruitreqid' => $recruitreqid])
        ->andWhere([
          'or',
          ['status' => 1],
          ['status' => 2]
        ])->one();
      if ($chagerequestjo) {
        $countnewjumlah = $chagerequestjo->jumlah;
      } else {
        $countnewjumlah = $transrincian->jumlah;
      }
      if ($transrincian->typejo == 3) {
        return 5;
      } else {
        if ($modelcountjo >= $transrincian->jumlah) {
          return 4;
        } else if ($modelcountjo >= $countnewjumlah) {
          return 6;
        } else if (Yii::$app->checkhiring->datacompleted($userid)) {
          $transjo = Transjo::find()->where(['nojo' => $transrincian->nojo])->one();
          // $typerekrut = Transrincian::find()->where(['type_rekrut'=>$transrincian->type_rekrut])->one();

          $awalkontrak = $transjo->tanggal;
          $lama = substr($transjo->lama, 0, 2);
          $akhirkontrak = date('Y-m-d', strtotime('+' . $lama . ' month', strtotime($awalkontrak)));

          if (Yii::$app->request->isAjax) {
            $model->userid = $userid;
            $model->recruitreqid = $recruitreqid;
            $model->createtime = date('Y-m-d H-i-s');
            $model->updatetime = date('Y-m-d H-i-s');
            $model->tglinput = date('Y-m-d');
            $model->awalkontrak = $awalkontrak;
            $model->akhirkontrak = $akhirkontrak;
            $model->statushiring = 1;
            $model->statusbiodata = 1;
            if ($transjo->flag_peralihan == 1) {
              $model->typejo = 2;
            }
            $model->createdby = Yii::$app->user->identity->id;
            $model->updateby = Yii::$app->user->identity->id;
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($transrincian->skema == 0) {
              return 0;
            } else {
              if ($model->save()) {
                if ($transrincian->transjo->n_project == "" || $transrincian->transjo->n_project == "Pilih") {
                  $layanan = $transrincian->transjo->project;
                } else {
                  $layanan = $transrincian->transjo->n_project;
                }
                if (Yii::$app->utils->getpersonalarea($transrincian->persa_sap)) {
                  $area = Yii::$app->utils->getpersonalarea($transrincian->persa_sap);
                } else {
                  $area = " ";
                }
                if (Yii::$app->utils->getskilllayanan($transrincian->skill_sap)) {
                  $skilllayanan = Yii::$app->utils->getskilllayanan($transrincian->skill_sap);
                } else {
                  $skilllayanan = '';
                }
                if (Yii::$app->utils->getpayrollarea($transrincian->abkrs_sap)) {
                  $payrollarea = Yii::$app->utils->getpayrollarea($transrincian->abkrs_sap);
                } else {
                  $payrollarea = '';
                }
                if (Yii::$app->utils->getjabatan($transrincian->hire_jabatan_sap)) {
                  $jabatan = Yii::$app->utils->getjabatan($transrincian->hire_jabatan_sap);
                } else {
                  $jabatan = '';
                }
                $curl = new curl\Curl();
                $getlevels = $curl->setPostParams([
                  'level' => $transrincian->level_sap,
                  'token' => 'ish**2019',
                ])->post('http://192.168.88.5/service/index.php/sap_profile/getlevel');
                $level  = json_decode($getlevels);
                if ($level) {
                  $level = $level;
                } else {
                  $level = '';
                }
                //notifikasi feedback email ke proman untuk approval hiring gojobs
                $to = 'proman@ish.co.id';
                $subject = 'Notifikasi Approval Hiring Gojobs';
                $body = 'Semangat Pagi,,
                <br>
                Anda mendapatkan permintaan Approval Hiring untuk :

                <br>
                <br>
                <table>
                <tr>
                <td valign="top">Nama</td>
                <td valign="top">:</td>
                <td valign="top">' . $userprofile->fullname . '</td>
                </tr>
                <tr>
                <td valign="top">No Jo</td>
                <td valign="top">:</td>
                <td valign="top">' . $transrincian->nojo . '</td>
                </tr>
                <tr>
                <td valign="top">Personal Area</td>
                <td valign="top">:</td>
                <td valign="top">' . $layanan . '</td>
                </tr>
                <tr>
                <td valign="top">Area</td>
                <td valign="top">:</td>
                <td valign="top">' . $area . '</td>
                </tr>
                <tr>
                <td valign="top">Skill layanan</td>
                <td valign="top">:</td>
                <td valign="top">' . $skilllayanan . '</td>
                </tr>
                <tr>
                <td valign="top">Payroll Area</td>
                <td valign="top">:</td>
                <td valign="top">' . $payrollarea . '</td>
                </tr>
                <tr>
                <td valign="top">Jabatan</td>
                <td valign="top">:</td>
                <td valign="top">' . $jabatan . '</td>
                </tr>
                <tr>
                <td valign="top">Level</td>
                <td valign="top">:</td>
                <td valign="top">' . $level . '</td>
                </tr>
                </table>
                <br>
                <br>
                Silakan masuk ke link gojobs.id untuk melakukan verifikasi lebih lanjut.
                <br><br>
                Have a great day !
                ';
                // var_dump($body);die;
                $verification = Yii::$app->utils->sendmailinternal($to, $subject, $body, 11);
                // var_dump($jobfamily->id);die;
                // var_dump('sampe');die;
                return 2;
              } else {
                return 1;
              }
            }
          }
        } else {
          return 3;
        }
      }
    } else {
      return 6;
    }
  }

  //testfunction
  public function actionHiringprocessdev($id)
  {
    // if ($id <> 23468) {
    $model = $this->findModel($id);
    $transrincian = Transrincian::find()->where(['id' => $model->recruitreqid])->one();
    $userprofile = Userprofile::find()->where(['userid' => $model->userid])->one();
    $hiring = Hiring::find()->where(['userid' => $model])->one();

    $tglinput = date_create($model->tglinput);
    // var_dump($transrincian->abkrs_sap);die;
    $curl = new curl\Curl();
    $cekpaycontroll =  $curl->setPostParams([
      'token' => 'ish@2019!',
      'ABKRS' => $transrincian->abkrs_sap,
    ])->post('http://192.168.88.5/service/index.php/Rfccekpayrollcontroll');
    $payrollcontrollresult  = json_decode($cekpaycontroll);
    if ($payrollcontrollresult->status == 1) {
      $cekposition =  $curl->setPostParams([
        'token' => 'ish@2019!',
        'STELL' => $transrincian->hire_jabatan_sap,
        'WERKS' => $transrincian->persa_sap,
        'PERSK' => $transrincian->skill_sap,
        'BTRTL' => $transrincian->area_sap,
        'ABKRS' => $transrincian->abkrs_sap,
      ])
        ->post('http://192.168.88.5/service/index.php/Rfccekposisi');
      $cekpositionresult  = json_decode($cekposition);
      if ($cekpositionresult) {
        if ($cekpositionresult->CODE == 'S') {
          if ($userprofile->gender == 'male') {
            $gender = '1';
          } else {
            $gender = '2';
          }
          if ($userprofile->maritalstatus == 'single') {
            $statuskawin = '0';
          } else {
            $statuskawin = '1';
          }
          if ($userprofile->religion == 'islam') {
            $agama = '01';
          } elseif ($userprofile->religion == 'christian') {
            $agama = '02';
          } elseif ($userprofile->religion == 'protestant') {
            $agama = '02';
          } elseif ($userprofile->religion == 'hindu') {
            $agama = '04';
          } elseif ($userprofile->religion == 'buddha') {
            $agama = '05';
          } elseif ($userprofile->religion == 'catholic') {
            $agama = '03';
          } else {
            $agama = '07';
          }
          if ($transrincian->kontrak == 'PKWT') {
            $kontrak = '01';
          } elseif ($transrincian->kontrak == 'PARTTIME' or $transrincian->kontrak == 'Part Time') {
            $kontrak = '03';
          } elseif ($transrincian->kontrak == 'MAGANG') {
            $kontrak = '05';
          } elseif ($transrincian->kontrak == 'KEMITRAAN') {
            $kontrak = '06';
          } elseif ($transrincian->kontrak == 'THL') {
            $kontrak = '07';
          } elseif ($transrincian->kontrak == 'PKWT-KEMITRAAN PB') {
            $kontrak = '01';
          }

          if ($transrincian->typejo == 1) {
            $massg = "01";
          } else {
            $massg = "03";
          }
          $birthdate = date_create($userprofile->birthdate);
          $url = "http://192.168.88.60:8080/ish-rest/hiring/insert";
          $request_data = [
            'begda' => date_format($tglinput, 'Y.m.d'),
            'endda' => '9999.12.31',
            'massn' => 'Z1',
            'massg' => $massg,
            'werks' => $transrincian->persa_sap,
            'persg' => '8',
            'persk' => $transrincian->skill_sap,
            'btrtl' => $transrincian->area_sap,
            'abkrs' => $transrincian->abkrs_sap,
            'ansvh' => $kontrak,
            'stell' => $transrincian->hire_jabatan_sap,
            'cname' => $userprofile->fullname,
            'anred' => $gender,
            'sprsl' => 'ID',
            'gbpas' => date_format($birthdate, 'Y.m.d'),
            'gbort' => $userprofile->birthplace,
            'natio' => 'ID',
            'gblnd' => 'ID',
            'famst' => $statuskawin,
            'konfe' => $agama,
          ];

          $json = json_encode($request_data);

          // print_r($json);
          // die;
          // echo '<br>';

          $headers  = [
            'Content-Type: application/json',
            'cache-control: no-cache"=',
          ];

          $ch = curl_init();

          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

          // var_dump('ok');die;
          $response = curl_exec($ch);

          curl_close($ch);
          $ret = json_decode($response);
          // [status] => NOK [message] => [pernr] =>
          if ($ret->status == 'OK') {
            $model->perner = $ret->pernr;
            $model->statushiring = 4;
            $model->message = $ret->message;
            $model->save();
          } else {
            $model->statushiring = 3;
            $model->message = $ret->message;
            $model->save();
          }
          print_r(json_encode($ret));
        } else {
          $model->statushiring = 3;
          $model->message = 'VACANT POSITION NOT FOUND';
          $model->save();
          $retpos = ['status' => "NOK", 'message' => 'VACANT POSITION NOT FOUND', 'pernr' => null];
          print_r(json_encode($retpos));
        }
      } else {
        $model->statushiring = 3;
        $model->message = 'You have already locked Position';
        $model->save();
        $retpos = ['status' => "NOK", 'message' => 'You have already locked Position', 'pernr' => null];
        print_r(json_encode($retpos));
      }
      // return $this->redirect(['index']);
    } else {
      $model->statushiring = 3;
      $model->message = 'You have already locked payroll controll';
      $model->save();
      $retlock = ['status' => "NOK", 'message' => 'lock', 'pernr' => null];
      print_r(json_encode($retlock));
    }

    $hiring = Hiring::find()->where(['userid' => $model])->one();
    $hiringstatus = Yii::$app->utils->aplhired($model);
    if ($hiringstatus) {
      $to = $hiring->mail->email;

      $subject = 'Pemberitahuan PT Infomedia Solusi Humanika';
      $body = Yii::$app->params['mailFeedback'];
      $verification = Yii::$app->utils->sendmail($to, $subject, $body, 11);
      if ($verification) {
        $to = 'khusnul.hisyam@ish.co.id';
        $subject = 'Informasi Approve Hiring';
        $body = Yii::$app->params['mailLog'];
        $body = str_replace('{fullname}', $model->userprofile->fullname, $body);
        $body = str_replace('{jabatan}', $transrincian->jabatan, $body);
        $body = str_replace('{area}', $transrincian->areasap->value2, $body);
        $sendmail = Yii::$app->utils->sendmailinternal($to, $subject, $body, 9);
      }
    }
    // } 

    // else {
    //   $retpos = ['status' => "NOK", 'message' => 'temp hold running', 'pernr' => null];
    //   print_r(json_encode($retpos));
    // }
  }

  //hiringprocess
  public function actionHiringprocess($id)
  {
    $model = $this->findModel($id);
    $transrincian = Transrincian::find()->where(['id' => $model->recruitreqid])->one();
    $userprofile = Userprofile::find()->where(['userid' => $model->userid])->one();

    $tglinput = date_create($model->tglinput);

    // $modelulogin = Userlogin::find()->where(['email' => $model])->one();
    $model->fullname = $userprofile->fullname;
    $model->userid = $userprofile->userid;
    // var_dump($transrincian->abkrs_sap);die;
    $curl = new curl\Curl();
    $cekposition =  $curl->setPostParams([
      'token' => 'ish@2019!',
      'STELL' => $transrincian->hire_jabatan_sap,
      'WERKS' => $transrincian->persa_sap,
      'PERSK' => $transrincian->skill_sap,
      'BTRTL' => $transrincian->area_sap,
      'ABKRS' => $transrincian->abkrs_sap,
    ])
      ->post('http://192.168.88.5/service/index.php/Rfccekposisi');
    $cekpositionresult  = json_decode($cekposition);

    if ($cekpositionresult) {
      if ($cekpositionresult->CODE == 'S') {

        $cekpaycontroll =  $curl->setPostParams([
          'token' => 'ish@2019!',
          'ABKRS' => $transrincian->abkrs_sap,
        ])->post('http://192.168.88.5/service/index.php/Rfccekpayrollcontroll');
        $payrollcontrollresult  = json_decode($cekpaycontroll);
        if ($payrollcontrollresult->status == 1) {
          if ($userprofile->gender == 'male') {
            $gender = '1';
          } else {
            $gender = '2';
          }
          if ($userprofile->maritalstatus == 'single') {
            $statuskawin = '0';
          } else {
            $statuskawin = '1';
          }
          if ($userprofile->religion == 'islam') {
            $agama = '01';
          } elseif ($userprofile->religion == 'christian') {
            $agama = '02';
          } elseif ($userprofile->religion == 'protestant') {
            $agama = '02';
          } elseif ($userprofile->religion == 'hindu') {
            $agama = '04';
          } elseif ($userprofile->religion == 'buddha') {
            $agama = '05';
          } elseif ($userprofile->religion == 'catholic') {
            $agama = '03';
          } else {
            $agama = '07';
          }
          if ($transrincian->kontrak == 'PKWT') {
            $kontrak = '01';
          } elseif ($transrincian->kontrak == 'PARTTIME' or $transrincian->kontrak == 'Part Time') {
            $kontrak = '03';
          } elseif ($transrincian->kontrak == 'MAGANG') {
            $kontrak = '05';
          } elseif ($transrincian->kontrak == 'KEMITRAAN' or $transrincian->kontrak == 'Kemitraan') {
            $kontrak = '06';
          } elseif ($transrincian->kontrak == 'THL') {
            $kontrak = '07';
          } elseif ($transrincian->kontrak == 'PKWT-KEMITRAAN PB') {
            $kontrak = '01';
          }

          if ($transrincian->typejo == 1) {
            $massg = "01";
          } else {
            $massg = "03";
          }
          $birthdate = date_create($userprofile->birthdate);
          $url = "http://192.168.88.60:8080/ish-rest/hiring/insert";
          $request_data = [
            'begda' => date_format($tglinput, 'Y.m.d'),
            'endda' => '9999.12.31',
            'massn' => 'Z1',
            'massg' => $massg,
            'werks' => $transrincian->persa_sap,
            'persg' => '8',
            'persk' => $transrincian->skill_sap,
            'btrtl' => $transrincian->area_sap,
            'abkrs' => $transrincian->abkrs_sap,
            'ansvh' => $kontrak,
            'stell' => $transrincian->hire_jabatan_sap,
            'cname' => $userprofile->fullname,
            'anred' => $gender,
            'sprsl' => 'ID',
            'gbpas' => date_format($birthdate, 'Y.m.d'),
            'gbort' => $userprofile->birthplace,
            'natio' => 'ID',
            'gblnd' => 'ID',
            'famst' => $statuskawin,
            'konfe' => $agama,
          ];

          $json = json_encode($request_data);

          // print_r($json);
          // die;
          // echo '<br>';

          $headers  = [
            'Content-Type: application/json',
            'cache-control: no-cache"=',
          ];

          $ch = curl_init();

          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

          // var_dump('ok');die;

          $response = curl_exec($ch);

          curl_close($ch);
          $ret = json_decode($response);
          // var_dump($ret);die;
          // [status] => NOK [message] => [pernr] =>
          if ($ret) {
            if ($ret->status == 'OK') {
              $model->perner = $ret->pernr;
              $model->statushiring = 4;
              $model->message = $ret->message;
              $model->save();
            } else {
              $model->statushiring = 3;
              $model->message = $ret->message;
              $model->save();
            }
            print_r(json_encode($ret));
          } else {
            $model->statushiring = 3;
            $model->message = "error response null";
            $model->save();
            $retlock = ['status' => "NOK", 'message' => 'error response null', 'pernr' => null];
            print_r(json_encode($retlock));
          }
        } else {
          $model->statushiring = 3;
          $model->message = 'You have already locked payroll controll';
          $model->save();
          $retlock = ['status' => "NOK", 'message' => 'lock', 'pernr' => null];
          print_r(json_encode($retlock));
        }
      } else {
        $model->statushiring = 3;
        $model->message = 'VACANT POSITION NOT FOUND';
        $model->save();
        $retpos = ['status' => "NOK", 'message' => 'VACANT POSITION NOT FOUND', 'pernr' => null];
        print_r(json_encode($retpos));
      }
    } else {
      $model->statushiring = 3;
      $model->message = 'You have already locked Position';
      $model->save();
      $retpos = ['status' => "NOK", 'message' => 'You have already locked Position', 'pernr' => null];
      print_r(json_encode($retpos));
    }

    $hiring = Hiring::find()->where(['userid' => $model])->one();

    $hiringstatus = Yii::$app->utils->aplhired($model);
    if ($hiringstatus) {
      $to = $hiring->mail->email;

      $subject = 'Pemberitahuan PT Infomedia Solusi Humanika';
      $body = Yii::$app->params['mailFeedback'];
      $verification = Yii::$app->utils->sendmail($to, $subject, $body, 11);
    }

    // $hiring = Hiring::find()->where(['userid' => $model])->one();
    // $hiringstatus = Yii::$app->utils->aplhired($model);
    // if ($hiringstatus) {
    //   $to = $hiring->mail->email;

    //   $subject = 'Pemberitahuan PT Infomedia Solusi Humanika';
    //   $body = Yii::$app->params['mailFeedback'];
    //   $verification = Yii::$app->utils->sendmail($to, $subject, $body, 11);
      // if ($verification) {
      //   echo 'successfully';
      // }
    // }
  }

  //testfunction
  public function actionTest($id)
  {
    $model = $this->findModel($id);
    $transrincian = Transrincian::find()->where(['id' => $model->recruitreqid])->one();
    $hiring = Hiring::find()->where(['userid' => $model])->one();
    $userid = $hiring->userid; 
    // $to = $model->mail->email;
    
    $hiringstatus = Yii::$app->utils->aplhired($model);
    if ($hiringstatus) {
      $curl = new curl\Curl();
      $getlevels = $curl->setPostParams([
        'level' => $transrincian->level_sap,
        'token' => 'ish**2019',
      ])->post('http://192.168.88.5/service/index.php/sap_profile/getlevel');
      // $to = 'khsyaam62@gmail.com';
      $to = 'khusnul.hisyam@ish.co.id';
      // $to = $hiring->mail->email;

      $subject = 'Pemberitahuan PT Infomedia Solusi Humanika Test';

      $body = Yii::$app->params['mailFeedback'];
      // $body = str_replace('{fullname}', $model->userprofile->fullname, $body);
      // $body = str_replace('{jabatan}', $transrincian->jabatan, $body);
      // $body = str_replace('{area}', $transrincian->areasap->value2, $body);

      // $sendmail = Yii::$app->utils->sendmail($to, $subject, $body, 3, $hiring);
      // var_dump($hiring);die;
      $sendmail = Yii::$app->utils->sendmailExternal($to, $subject, $body, 3, $userid);
      // $sendmail = Yii::$app->utils->sendmailinternal($to, $subject, $body, 9);
      if ($sendmail) {
        //for log feedback developer
        // $to = 'khsyaam62@gmail.com';
        // $subject = 'Informasi Approve Hiring';
        // $body = Yii::$app->params['mailLog'];
        // $body = str_replace('{fullname}', $model->userprofile->fullname, $body);
        // $body = str_replace('{jabatan}', $transrincian->jabatan, $body);
        // $body = str_replace('{area}', $transrincian->areasap->value2, $body);
        // $mail = Yii::$app->utils->sendmail($to, $subject, $body, 9);
        echo 'succesfully';
      }
      else {
        echo 'not succesfully';
      }
    }
  }

  //testfunctionmanual
  public function actionHiringprocessmanual($id)
  {
    $model = $this->findModel($id);
    $transrincian = Transrincian::find()->where(['id' => $model->recruitreqid])->one();
    $userprofile = Userprofile::find()->where(['userid' => $model->userid])->one();
    $tglinput = date_create($model->tglinput);
    // var_dump($transrincian->abkrs_sap);die;
    $curl = new curl\Curl();
    $cekpaycontroll =  $curl->setPostParams([
      'token' => 'ish@2019!',
      'ABKRS' => $transrincian->abkrs_sap,
    ])->post('http://192.168.88.5/service/index.php/Rfccekpayrollcontroll');
    $payrollcontrollresult  = json_decode($cekpaycontroll);
    // var_dump($cekpaycontroll);die;
    if ($payrollcontrollresult->status == 1) {

      if ($userprofile->gender == 'male') {
        $gender = '1';
      } else {
        $gender = '2';
      }
      if ($userprofile->maritalstatus == 'single') {
        $statuskawin = '0';
      } else {
        $statuskawin = '1';
      }
      if ($userprofile->religion == 'islam') {
        $agama = '01';
      } elseif ($userprofile->religion == 'christian') {
        $agama = '02';
      } elseif ($userprofile->religion == 'protestant') {
        $agama = '02';
      } elseif ($userprofile->religion == 'hindu') {
        $agama = '04';
      } elseif ($userprofile->religion == 'buddha') {
        $agama = '05';
      } elseif ($userprofile->religion == 'catholic') {
        $agama = '03';
      } else {
        $agama = '07';
      }
      if ($transrincian->kontrak == 'PKWT') {
        $kontrak = '01';
      } elseif ($transrincian->kontrak == 'PARTTIME' or $transrincian->kontrak == 'Part Time') {
        $kontrak = '03';
      } elseif ($transrincian->kontrak == 'MAGANG') {
        $kontrak = '05';
      } elseif ($transrincian->kontrak == 'KEMITRAAN') {
        $kontrak = '06';
      } elseif ($transrincian->kontrak == 'THL') {
        $kontrak = '07';
      } elseif ($transrincian->kontrak == 'PKWT-KEMITRAAN PB') {
        $kontrak = '01';
      }

      if ($transrincian->typejo == 1) {
        $massg = "01";
      } else {
        $massg = "03";
      }
      $birthdate = date_create($userprofile->birthdate);
      $url = "http://192.168.88.60:8080/ish-rest/hiring/insert";
      $request_data = [
        'begda' => date_format($tglinput, 'Y.m.d'),
        'endda' => '9999.12.31',
        'massn' => 'Z1',
        'massg' => $massg,
        'werks' => $transrincian->persa_sap,
        'persg' => '8',
        'persk' => $transrincian->skill_sap,
        'btrtl' => $transrincian->area_sap,
        'abkrs' => $transrincian->abkrs_sap,
        'ansvh' => $kontrak,
        'stell' => $transrincian->hire_jabatan_sap,
        'cname' => $userprofile->fullname,
        'anred' => $gender,
        'sprsl' => 'ID',
        'gbpas' => date_format($birthdate, 'Y.m.d'),
        'gbort' => $userprofile->birthplace,
        'natio' => 'ID',
        'gblnd' => 'ID',
        'famst' => $statuskawin,
        'konfe' => $agama,
      ];

      $json = json_encode($request_data);

      // print_r($json);
      // die;
      // echo '<br>';


      $headers  = [
        'Content-Type: application/json',
        'cache-control: no-cache"=',
      ];

      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

      // var_dump('ok');die;
      $response = curl_exec($ch);

      curl_close($ch);
      $ret = json_decode($response);
      // [status] => NOK [message] => [pernr] =>
      if ($ret->status == 'OK') {
        $model->perner = $ret->pernr;
        $model->statushiring = 4;
        $model->message = $ret->message;
        $model->save();
      } else {
        $model->statushiring = 3;
        $model->message = $ret->message;
        $model->save();
      }
      print_r(json_encode($ret));
      // return $this->redirect(['index']);
    } else {
      $retlock = ['status' => "NOK", 'message' => 'lock', 'pernr' => null];
      print_r(json_encode($retlock));
    }
  }

  //updateprocesshiringsap
  public function actionHiringupdateprocess($id)
  {
    $model = $this->findModel($id);
    $transrincian = Transrincian::find()->where(['id' => $model->recruitreqid])->one();
    $userprofile = Userprofile::find()->where(['userid' => $model->userid])->one();
    $userecontact = Useremergencycontact::find()->where(['userid' => $model->userid])->one();
    $userfamilys = Userfamily::find()->where(['userid' => $model->userid])->all();
    $userfedus = Userformaleducation::find()->where(['userid' => $model->userid])->all();
    $usernfedus = Usernonformaleducation::find()->where(['userid' => $model->userid])->all();
    $userabout = Userabout::find()->where(['userid' => $model->userid])->one();
    $curl = new curl\Curl();
    $cekpaycontroll =  $curl->setPostParams([
      'token' => 'ish@2019!',
      'ABKRS' => $transrincian->abkrs_sap,
    ])->post('http://192.168.88.5/service/index.php/Rfccekpayrollcontroll');
    $payrollcontrollresult  = json_decode($cekpaycontroll);
    if ($payrollcontrollresult->status == 1) {
      $birthdate = date_create($userprofile->birthdate);
      $tglinput = date_create($model->tglinput);
      $awalkontrak = date_create($model->awalkontrak);
      $akhirkontrak = date_create($model->akhirkontrak);
      $wedingdate = date_create($userprofile->weddingdate);
      $url = "http://192.168.88.60:8080/ish-rest/ZINFHRF_00025";
      //p0002 = untuk applicant yang sudah menikah (input tanggal pernikahan)
      if ($userprofile->gender == 'male') {
        $gender = '1';
        if ($userprofile->maritalstatus == 'married') {
          $spben = 'X';
        } else {
          $spben = '';
        }
      } else {
        $gender = '2';
        if ($userprofile->maritalstatus == 'married') {
          $spben = 'X';
        } else {
          $spben = '';
        }
      }
      if ($userprofile->religion == 'islam') {
        $agama = '01';
      } elseif ($userprofile->religion == 'christian') {
        $agama = '02';
      } elseif ($userprofile->religion == 'protestant') {
        $agama = '02';
      } elseif ($userprofile->religion == 'hindu') {
        $agama = '04';
      } elseif ($userprofile->religion == 'buddha') {
        $agama = '05';
      } elseif ($userprofile->religion == 'catholic') {
        $agama = '03';
      } else {
        $agama = '07';
      }
      if ($model->flaginfotype022 == 1 and $model->flaginfotype021 == 1) {
        if ($userprofile->maritalstatus == 'single') {
          $statuskawin = '0';
          $marrd = '';
          $marst = '';
          $infotype = ['0041', '0006', '0028', '0185', '0241', '0242', '0009', '0008', '0016', '0035', '0037'];
        } else {
          $statuskawin = '1';
          $marrd = 'X';
          $marst = 'X';
          $infotype = ['0002', '0041', '0006', '0028', '0185', '0241', '0242', '0009', '0008', '0016', '0035', '0037'];
        }
      } else if ($model->flaginfotype022 == 1) {
        if ($userprofile->maritalstatus == 'single') {
          $statuskawin = '0';
          $marrd = '';
          $marst = '';
          $infotype = ['0041', '0006', '0021', '0028', '0185', '0241', '0242', '0009', '0008', '0016', '0035', '0037'];
        } else {
          $statuskawin = '1';
          $marrd = 'X';
          $marst = 'X';
          $infotype = ['0002', '0041', '0006', '0021', '0028', '0185', '0241', '0242', '0009', '0008', '0016', '0035', '0037'];
        }
      } else if ($model->flaginfotype021 == 1) {
        if ($userprofile->maritalstatus == 'single') {
          $statuskawin = '0';
          $marrd = '';
          $marst = '';
          $infotype = ['0041', '0006', '0022', '0028', '0185', '0241', '0242', '0009', '0008', '0016', '0035', '0037'];
        } else {
          $statuskawin = '1';
          $marrd = 'X';
          $marst = 'X';
          $infotype = ['0002', '0041', '0006', '0022', '0028', '0185', '0241', '0242', '0009', '0008', '0016', '0035', '0037'];
        }
      } else {
        if ($userprofile->maritalstatus == 'single') {
          $statuskawin = '0';
          $marrd = '';
          $marst = '';
          $infotype = ['0041', '0006', '0021', '0022', '0028', '0185', '0241', '0242', '0009', '0008', '0016', '0035', '0037'];
        } else {
          $statuskawin = '1';
          $marrd = 'X';
          $marst = 'X';
          $infotype = ['0002', '0041', '0006', '0021', '0022', '0028', '0185', '0241', '0242', '0009', '0008', '0016', '0035', '0037'];
        }
      }

      if ($transrincian->kontrak == 'PKWT') {
        $cttyp = '02';
      } elseif ($transrincian->kontrak == 'PARTTIME' or $transrincian->kontrak == 'Part Time') {
        $cttyp = '09';
      } elseif ($transrincian->kontrak == 'MAGANG') {
        $cttyp = '10';
      } elseif ($transrincian->kontrak == 'KEMITRAAN') {
        $cttyp = '08';
      } elseif ($transrincian->kontrak == 'THL') {
        $cttyp = '07';
      } elseif ($transrincian->kontrak == 'PKWT-KEMITRAAN PB') {
        $cttyp = '11';
      }

      $addressdata = $this->findAddressdata($model, $userprofile, $userecontact);
      $userfamilydata = $this->findUserfamily($model, $userfamilys);
      $userfamilyJtdata = $this->findUserfamilyJt($model, $userfamilys);
      $usereducation = $this->findUsereducation($model, $userfedus, $usernfedus);

      // var_dump($usereducation);die;
      $request_data = [
        [
          'pernr' => "$model->perner",
          'inftypList' => $infotype,
          'p00002List' => [
            [
              'endda' => '31.12.9999',
              'begda' => date_format($tglinput, 'd.m.Y'),
              'operation' => 'mod',
              'pernr' => "$model->perner",
              'infty' => '0002',
              'nachn' => $userprofile->fullname,
              'cname' => $userprofile->fullname,
              'knznm' => '',
              'anred' => $gender,
              'gesch' => $gender,
              'gbdat' => date_format($birthdate, 'd.m.Y'),
              'gblnd' => 'ID',
              'gbort' => $userprofile->birthplace,
              'natio' => 'ID',
              'sprsl' => 'ID',
              'konfe' => $agama,
              'famst' => $statuskawin,
              'famdt' => date_format($wedingdate, 'd.m.Y'),
              'anzkd' => '',
              'gbpas' => date_format($birthdate, 'd.m.Y'),
              'gbjhr' => date_format($birthdate, 'y'),
              'gbmon' => date_format($birthdate, 'm'),
              'gbtag' => date_format($birthdate, 'd'),
              'nchmc' => $userprofile->fullname
            ]
          ],
          'p00041List' => [
            [
              'endda' => '',
              'begda' => '',
              'operation' => 'INS',
              'pernr' => "$model->perner",
              'infty' => '0041',
              'dar01' => '01',
              'dat01' => date_format($awalkontrak, 'd.m.Y'),
              'dar02' => '',
              'dat02' => ''
            ]
          ],

          // infty 1 = alamat ktp, 2 = alamat tinggal, 4 =  alamat emergencycontact, 5 = alamat anggota keluarga
          'p00006List' => $addressdata,
          // subty relationship, 1 = pasangan (suami/istri), 2 = anak, 11 = ayah, 12 = ibu, 91 = saudara kandung
          'p00021List' => $userfamilydata,

          //infotype 318 tidak usah
          'p00318List' => $userfamilyJtdata,
          // formal dan non formal menggunakan infotype yang sama yaitu 0022
          'p00022List' => $usereducation,
          'p00028List' => [
            [
              'endda' => '31.12.9999',
              'begda' => date_format($tglinput, 'd.m.Y'),
              'operation' => 'INS',
              'pernr' => "$model->perner",
              'infty' => '0028',
              'subty' => 'Z001',
              'exdat' => date_format($tglinput, 'd.m.Y'),
              'resul' => '01',
              'dianr' => '',
              'sbj01' => '01',
              'jnf01' => '',
              'nmf01' => '',
              'dtf01' => '',
              'wtf01' => $userprofile->bloodtype,
              'sbj02' => '',
              'jnf02' => '',
              'nmf02' => '',
              'dtf02' => '',
              'wtf02' => '',
              'sbj03' => '',
              'jnf03' => '',
              'nmf03' => '',
              'dtf03' => '',
              'wtf03' => '',
              'sbj04' => '',
              'jnf04' => '',
              'nmf04' => '',
              'dtf04' => '',
              'wtf04' => '',
              'sbj05' => '',
              'jnf05' => '',
              'nmf05' => '',
              'dtf05' => '',
              'wtf05' => '',
              'sbj06' => '',
              'jnf06' => '',
              'nmf06' => '',
              'dtf06' => '',
              'wtf06' => '',
              'sbj07' => '',
              'jnf07' => '',
              'nmf07' => '',
              'dtf07' => '',
              'wtf07' => '',
              'sbj08' => '',
              'jnf08' => '',
              'nmf08' => '',
              'dtf08' => '',
              'wtf08' => '',
              'sbj09' => '',
              'jnf09' => '',
              'nmf09' => '',
              'dtf09' => '',
              'wtf09' => ''
            ]
          ],
          //01  no ktp, 02  sim a, 03  sim b, 04  sim c, 05  nik, 06  agent id, 07  passport, 08  virtual bpjs, 09  kartu keluarga, 80  application id
          'p00185List' => [
            [
              'endda' => '31.12.9999',
              'begda' => date_format($tglinput, 'd.m.Y'),
              'operation' => 'INS',
              'pernr' => "$model->perner",
              'infty' => '0185',
              'subty' => '01',
              'ictyp' => '01', // haru sama dengan subty
              'icnum' => $userprofile->identitynumber,
              'fpdat' => '',
              'expid' => '',
              'isspl' => '',
              'iscot' => 'ID'
            ],
            [
              'endda' => '31.12.9999',
              'begda' => date_format($tglinput, 'd.m.Y'),
              'operation' => 'INS',
              'pernr' => "$model->perner",
              'infty' => '0185',
              'subty' => '09',
              'ictyp' => '09', // haru sama dengan subty
              'icnum' => $userprofile->kknumber,
              'fpdat' => '',
              'expid' => '',
              'isspl' => '',
              'iscot' => 'id'
            ]
          ],
          'p00241List' => [
            [
              'endda' => '31.12.9999',
              'begda' => date_format($tglinput, 'd.m.Y'),
              'operation' => 'INS',
              'pernr' => "$model->perner",
              'infty' => '0241',
              'taxid' => $userprofile->npwpnumber, //validasi max character 15
              'marrd' => $marrd,
              'spben' => $spben,
              'depnd' => 'f',
              'rdate' => ''
            ]
          ],
          'p00242List' => [
            [
              'endda' => '31.12.9999',
              'begda' => date_format($tglinput, 'd.m.Y'),
              'operation' => 'INS',
              'pernr' => "$model->perner",
              'infty' => '0242',
              // 'jamid'=> $userprofile->jamsosteknumber, //validasi max character 11
              'jamid' => "00000000000", //validasi max character 11
              'marst' => $marst
            ]
          ],

          'p00009List' => [
            [
              'endda' => '31.12.9999',
              // 'begda'=> "17.02.2019",
              'begda' => date_format($tglinput, 'd.m.Y'),
              'operation' => 'INS',
              'pernr' => "$model->perner",
              'infty' => '0009',
              'subty' => '0',
              'bnksa' => '0',
              'waers' => 'IDR',
              'zlsch' => 'T',
              'banks' => 'ID',
              'bankl' => $userabout->bankname->sapid, //nama bank, kode ambil dari master bank ditambahkan kode bank sap
              'bankn' => $userabout->bankaccountnumber
            ]
          ],
          'p00008List' => [
            [
              'endda' => '31.12.9999',
              'begda' => date_format($tglinput, 'd.m.Y'),
              'operation' => 'INS',
              'pernr' => "$model->perner",
              'infty' => '0008',
              'trfar' => $transrincian->level_sap,
              'trfgb' => 'Z1',
              'trfgr' => $transrincian->level_sap,
              'trfst' => '01',
              'waers' => 'IDR'
            ]
          ],
          'p00016List' => [
            [
              'endda' => '31.12.9999',
              'begda' => date_format($tglinput, 'd.m.Y'),
              'operation' => 'INS',
              'pernr' => "$model->perner",
              'infty' => '0016',
              'lfzfr' => '',
              'lfzzh' => '',
              'lfzso' => '',
              'kgzfr' => '',
              'kgzzh' => '',
              'prbzt' => '',
              'prbeh' => '',
              'kdgfr' => '',
              'kdgf2' => '',
              'arber' => date_format($akhirkontrak, 'd.m.Y'),
              'konsl' => '59',
              'cttyp' => $cttyp,
              'zwrkpl' => ''
            ]
          ],
          'p00035List' => [
            [
              'endda' => '31.12.9999',
              'begda' => date_format($tglinput, 'd.m.Y'),
              'operation' => 'INS',
              'pernr' => "$model->perner",
              'infty' => '0035',
              'subty' => 'Z1',
              'itxex' => 'X',
              'dat35' => date_format($awalkontrak, 'd.m.Y'),
            ]
          ],
          'p00037List' => [
            [
              'endda' => '31.12.9999',
              'begda' => date_format($tglinput, 'd.m.Y'),
              'operation' => 'INS',
              'pernr' => "$model->perner",
              'infty' => '0037',
              'subty' => "0016",
              'vsart' => "0016",
              'vsges' => "11",
              // 'vsnum'=> $userprofile->bpjsnumber, //validasi max character 11
              'vsnum' => "00000000000", //validasi max character 11
              'waers' => "IDR"
            ]
          ],

        ]
      ];

      //var_dump($request_data);

      $json = json_encode($request_data);

      $headers  = [
        'Content-Type: application/json',
        'cache-control: no-cache"=',
      ];

      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

      // var_dump('ok');die;
      $response = curl_exec($ch);

      curl_close($ch);
      $ret = json_decode($response);
      if ($model->flaginfotype022 != 1) {
        if (stripos(json_encode($ret), 'Success when operation infty. 0022') !== false) {
          $model->flaginfotype022 = 1;
          $model->save();
        }
      }
      if ($model->flaginfotype021 != 1) {
        if (stripos(json_encode($ret), 'Success when operation infty. 0021') !== false) {
          $model->flaginfotype021 = 1;
          $model->save();
        }
      }
      // var_dump($ret);die;
      // var_dump($ret[8]->success);die;
      $log = array();
      foreach ($ret as $key => $value) {
        if ($value->success != 1) {
          $log  = $value->message;
        }
      }

      if ($log) {
        $model->statusbiodata = 3;
        $model->message = $log;
        $model->save();
      } else {
        $joindatetglinput = date_format($tglinput, 'Ymd');
        $insppjp = Yii::$app->utils->insppjp($model->perner, $joindatetglinput);

        if ($insppjp == "S") {
          // var_dump($insppjp);die;
          $model->statusbiodata = 4;
          $model->message = 'successful';
          // notification email if jo completed (start)
          $modelcountjohiring = Hiring::find()->where('recruitreqid = ' . $model->recruitreqid . ' AND statushiring <> 5 AND statushiring <> 6 AND statushiring <> 7')->count();
          $modellisthiring = Hiring::find()->where('recruitreqid = ' . $model->recruitreqid . ' AND statushiring <> 5 AND statushiring <> 6 AND statushiring <> 7')->all();
          $transrincian = Transrincian::find()->where(['id' => $model->recruitreqid])->one();
          $personalarea = (Yii::$app->utils->getpersonalarea($transrincian->persa_sap)) ? Yii::$app->utils->getpersonalarea($transrincian->persa_sap) : "";
          $area =  (Yii::$app->utils->getarea($transrincian->area_sap)) ? Yii::$app->utils->getarea($transrincian->area_sap) : "";
          $skilllayanan = (Yii::$app->utils->getskilllayanan($transrincian->skill_sap)) ? Yii::$app->utils->getskilllayanan($transrincian->skill_sap) : "";
          $payrollarea = (Yii::$app->utils->getpayrollarea($transrincian->abkrs_sap)) ? Yii::$app->utils->getpayrollarea($transrincian->abkrs_sap) : "";
          $jabatan = (Yii::$app->utils->getjabatan($transrincian->hire_jabatan_sap)) ? Yii::$app->utils->getjabatan($transrincian->hire_jabatan_sap) : "";
          $curl = new curl\Curl();
          $getlevels = $curl->setPostParams([
            'level' => $transrincian->level_sap,
            'token' => 'ish**2019',
          ])->post('http://192.168.88.5/service/index.php/sap_profile/getlevel');
          $level  = json_decode($getlevels);
          $leveljabatan = ($level) ? $level : "";
          if ($modelcountjohiring == $transrincian->jumlah) {
            foreach ($modellisthiring as $key => $value) {
              $no = $key + 1;
              $listperner[] =  $no . '. ' . $value->perner;
            }

            $listpernerconv = implode('<br>', $listperner);
            // var_dump($listpernerconv);die;
            $to = 'proman@ish.co.id';
            $subject = 'Job Order Information - Done';
            $body = 'Selamat !!!
            <br>
            Permintaan Recruitment sudah terpenuhi untuk rincian sebagai berikut :

            <br>
            <br>
            <table>
            <tr>
            <td valign="top">No Job Order</td>
            <td valign="top">:</td>
            <td valign="top">' . $transrincian->nojo . '</td>
            </tr>
            <tr>
            <td valign="top">Personal Area</td>
            <td valign="top">:</td>
            <td valign="top">' . $personalarea . '</td>
            </tr>
            <tr>
            <td valign="top">Area</td>
            <td valign="top">:</td>
            <td valign="top">' . $area . '</td>
            </tr>
            <tr>
            <td valign="top">Skill Layanan</td>
            <td valign="top">:</td>
            <td valign="top">' . $skilllayanan . '</td>
            </tr>
            <tr>
            <td valign="top">Payroll Area</td>
            <td valign="top">:</td>
            <td valign="top">' . $payrollarea . '</td>
            </tr>
            <tr>
            <td valign="top">Jabatan</td>
            <td valign="top">:</td>
            <td valign="top">' . $jabatan . '</td>
            </tr>
            <tr>
            <td valign="top">Level</td>
            <td valign="top">:</td>
            <td valign="top">' . $leveljabatan . '</td>
            </tr>
            </table>
            <br>
            <br>
            Berikut daftar pekerjanya :
            <br><br>
            ' . $listpernerconv;
            // var_dump($body);die;
            $sendemail = Yii::$app->utils->sendmailinternal($to, $subject, $body, 12);
          }
        } else {
          $model->statusbiodata = 3;
          $model->message = 'ppjp error';
        }
        $model->save();
        // notification email if jo completed (end)
      }
      print_r(json_encode($ret));
    } else {
      $retlock = ['status' => "NOK", 'message' => 'lock', 'pernr' => null];
      print_r(json_encode($retlock));
    }

    // print_r($ret);
    //  ob_start();
    //  print_r($json);
    //  if ($json){
    //    echo $json;
    //  }else{
    //    echo json_last_error_msg();
    //  }
    // return ob_get_clean();
    // return $this->redirect(['index']);

  }
  public function actionHiringupdatetglkontrak($id)
  {
    $model = $this->findModel($id);
    $transrincian = Transrincian::find()->where(['id' => $model->recruitreqid])->one();
    $userprofile = Userprofile::find()->where(['userid' => $model->userid])->one();
    $userecontact = Useremergencycontact::find()->where(['userid' => $model->userid])->one();
    $userfamilys = Userfamily::find()->where(['userid' => $model->userid])->all();
    $userfedus = Userformaleducation::find()->where(['userid' => $model->userid])->all();
    $usernfedus = Usernonformaleducation::find()->where(['userid' => $model->userid])->all();
    $userabout = Userabout::find()->where(['userid' => $model->userid])->one();

    $birthdate = date_create($userprofile->birthdate);
    $tglinput = date_create($model->tglinput);
    $awalkontrak = date_create($model->awalkontrak);
    $akhirkontrak = date_create($model->akhirkontrak);
    $wedingdate = date_create($userprofile->weddingdate);
    $url = "http://192.168.88.60:8080/ish-rest/ZINFHRF_00025";
    //p0002 = untuk applicant yang sudah menikah (input tanggal pernikahan)


    if ($transrincian->kontrak == 'PKWT') {
      $cttyp = '02';
    } elseif ($transrincian->kontrak == 'PARTTIME' or $transrincian->kontrak == 'Part Time') {
      $cttyp = '09';
    } elseif ($transrincian->kontrak == 'MAGANG') {
      $cttyp = '10';
    } elseif ($transrincian->kontrak == 'KEMITRAAN') {
      $cttyp = '08';
    } elseif ($transrincian->kontrak == 'THL') {
      $cttyp = '07';
    } elseif ($transrincian->kontrak == 'PKWT-KEMITRAAN PB') {
      $cttyp = '11';
    }


    $infotype = ['0041', '0006', '0028', '0185', '0241', '0242', '0009', '0008', '0016', '0035', '0037'];

    // var_dump($usereducation);die;
    $request_data = [
      [
        'pernr' => "$model->perner",
        'inftypList' => $infotype,
        'p00016List' => [
          [
            'endda' => '31.12.9999',
            'begda' => date_format($tglinput, 'd.m.Y'),
            'operation' => 'INS',
            'pernr' => "$model->perner",
            'infty' => '0016',
            'lfzfr' => '',
            'lfzzh' => '',
            'lfzso' => '',
            'kgzfr' => '',
            'kgzzh' => '',
            'prbzt' => '',
            'prbeh' => '',
            'kdgfr' => '',
            'kdgf2' => '',
            'arber' => date_format($akhirkontrak, 'd.m.Y'),
            'konsl' => '59',
            'cttyp' => $cttyp,
            'zwrkpl' => ''
          ]
        ],
        'p00035List' => [
          [
            'endda' => '31.12.9999',
            'begda' => date_format($tglinput, 'd.m.Y'),
            'operation' => 'INS',
            'pernr' => "$model->perner",
            'infty' => '0035',
            'subty' => 'Z1',
            'itxex' => 'X',
            'dat35' => date_format($awalkontrak, 'd.m.Y'),
          ]
        ],

      ]
    ];

    //var_dump($request_data);

    $json = json_encode($request_data);



    $headers  = [
      'Content-Type: application/json',
      'cache-control: no-cache"=',
    ];


    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // var_dump('ok');die;


    $response = curl_exec($ch);

    curl_close($ch);
    $ret = json_decode($response);
    if ($model->flaginfotype022 != 1) {
      if (stripos(json_encode($ret), 'Success when operation infty. 0022') !== false) {
        $model->flaginfotype022 = 1;
        $model->save();
      }
    }
    if ($model->flaginfotype021 != 1) {
      if (stripos(json_encode($ret), 'Success when operation infty. 0021') !== false) {
        $model->flaginfotype021 = 1;
        $model->save();
      }
    }
    // var_dump($ret);die;
    // var_dump($ret[8]->success);die;
    $log = array();
    foreach ($ret as $key => $value) {
      if ($value->success != 1) {
        $log  = $value->message;
      }
    }
    if ($log) {
      $model->statusbiodata = 3;
      $model->message = $log;
      $model->save();
    } else {
      $model->statusbiodata = 4;
      $model->message = 'successful';
      $model->save();
    }

    // print_r($ret);
    //  ob_start();
    //  print_r($json);
    //  if ($json){
    //    echo $json;
    //  }else{
    //    echo json_last_error_msg();
    //  }
    // return ob_get_clean();
    // return $this->redirect(['index']);

  }

  public function actionHiringtest()
  {
    $insppjp = Yii::$app->utils->insppjp("134484", "20190802");
    var_dump($insppjp);
    die;
  }

  protected function findAddressdata($model, $userprofile, $userecontact)
  {
    $addresscount = strlen($userprofile->address);
    $tglinput = date_create($model->tglinput);
    $awalkontrak = date_create($model->awalkontrak);
    $akhirkontrak = date_create($model->akhirkontrak);
    if ($addresscount > 60) {
      $address = substr($userprofile->address, 0, 60);
      $addressl2 = substr($userprofile->address, 60);
    } else {
      $address = $userprofile->address;
      $addressl2 = '';
    };
    $addressktpcount = strlen($userprofile->addressktp);
    if ($addressktpcount > 60) {
      $addressktp = substr($userprofile->addressktp, 0, 60);
      $addressktpl2 = substr($userprofile->addressktp, 60);
    } else {
      $addressktp = $userprofile->addressktp;
      $addressktpl2 = '';
    };
    $addressapplicant = [
      [
        'endda' => '31.12.9999',
        'begda' => date_format($tglinput, 'd.m.Y'),
        'operation' => 'INS',
        'pernr' => "$model->perner",
        'infty' => '0006',
        'subty' => '1',
        'anssa' => '1',
        'name2' => $userprofile->domicilestatus,
        'stras' => $addressktp, //max 60 character, apabila tidak cukup pindahkan ke field locat
        'ort01' => $userprofile->cityktp->kota, //kota ditambahkan pada modul userprofile
        'ort02' => '',
        'pstlz' => $userprofile->postalcodektp, //kodepos pada modul userprofile ditambahkan
        'land1' => 'ID',
        'telnr' => $userprofile->phone,
        'entkm' => '',
        'locat' => $addressktpl2,
        'adr03' => '',
        'adr04' => '',
        'state' => $userprofile->provincektp->sapid, //provinsi tambahkan id sap pada database
        'entk2' => '',
        'com01' => '',
        'num01' => '',
        'com02' => '',
        'num02' => '',
        'com03' => '',
        'num03' => '',
        'railw' => ''
      ],
      [
        'endda' => '31.12.9999',
        'begda' => date_format($tglinput, 'd.m.Y'),
        'operation' => 'INS',
        'pernr' => "$model->perner",
        'infty' => '0006',
        'subty' => '2',
        'anssa' => '2',
        'name2' => $userprofile->domicilestatus,
        'stras' => $address, //max 60 character, apabila tidak cukup pindahkan ke field locat
        'ort01' => $userprofile->city->kota, //kota ditambahkan pada modul userprofile
        'ort02' => '',
        'pstlz' => $userprofile->postalcode, //kodepos pada modul userprofile ditambahkan
        'land1' => 'ID',
        'telnr' => $userprofile->phone,
        'entkm' => '',
        'locat' => $addressl2,
        'adr03' => '',
        'adr04' => '',
        'state' => $userprofile->province->sapid, //provinsi tambahkan id sap pada database
        'entk2' => '',
        'com01' => '',
        'num01' => '',
        'com02' => '',
        'num02' => '',
        'com03' => '',
        'num03' => '',
        'railw' => ''
      ],
    ];

    $addressuccount = strlen($userecontact->address);
    if ($addressuccount > 60) {
      $addressuc = substr($userecontact->address, 0, 60);
      $addressucl2 = substr($userecontact->address, 60);
    } else {
      $addressuc = $userecontact->address;
      $addressucl2 = '';
    };
    $useremergencycontact[] = [
      'endda' => '31.12.9999',
      'begda' => date_format($tglinput, 'd.m.Y'),
      'operation' => 'INS',
      'pernr' => "$model->perner",
      'infty' => '0006',
      'subty' => '4',
      'anssa' => '4',
      'name2' => $userecontact->fullname,
      'stras' => $addressuc, //max 60 character, apabila tidak cukup pindahkan ke field locat
      'ort01' => $userecontact->city->kota, //kota ditambahkan pada modul userprofile
      'ort02' => '',
      'pstlz' => $userecontact->postalcode, //kodepos pada modul userprofile ditambahkan
      'land1' => 'ID',
      'telnr' => $userprofile->phone,
      'entkm' => '',
      'locat' => $addressucl2,
      'adr03' => '',
      'adr04' => '',
      'state' => $userprofile->province->sapid, //provinsi tambahkan id sap pada database
      'entk2' => '',
      'com01' => '',
      'num01' => '',
      'com02' => '',
      'num02' => '',
      'com03' => '',
      'num03' => '',
      'railw' => ''
    ];

    $addressdata = array_merge($addressapplicant, $useremergencycontact);

    return $addressdata;
  }

  protected function findUserfamily($model, $userfamilys)
  {
    $objpssib = 1;
    $objpschild = 1;
    $tglinput = date_create($model->tglinput);
    $awalkontrak = date_create($model->awalkontrak);
    $akhirkontrak = date_create($model->akhirkontrak);
    foreach ($userfamilys as $key => $userfamily) {
      // SUBTY relationship, 1 = pasangan (suami/istri), 2 = anak, 11 = ayah, 12 = ibu, 91 = saudara kandung
      if ($userfamily->relationship == "husband" or $userfamily->relationship == "wife") {
        $subty = "1";
        $objps = "01";
      } elseif ($userfamily->relationship == "child") {
        $subty = "2";
        $objps = "0" . $objpschild;
        $objpschild = $objpschild + 1;
      } elseif ($userfamily->relationship == "father") {
        $subty = "11";
        $objps = "";
      } elseif ($userfamily->relationship == "mother") {
        $subty = "12";
        $objps = "";
      } else {
        $subty = "91";
        $objps = "0" . $objpssib;
        $objpssib = $objpssib + 1;
      }
      if ($userfamily->gender == 'male') {
        $gender = '1';
      } else {
        $gender = '2';
      }
      $birthdate = date_create($userfamily->birthdate);
      $userfamilydata[] =
        [
          'endda' => '31.12.9999',
          'begda' => date_format($tglinput, 'd.m.Y'),
          'operation' => 'INS',
          'pernr' => "$model->perner",
          'infty' => '0021',
          'subty' => $subty, //di isi tergantung data relationship
          'objps' => $objps, //ibu = 01, bapak = 01, pasangan=01, kecuali anak atau saudara kandung di urutkan ex, 01, 02
          'famsa' => $subty, //sama dengan subty
          'fgbdt' => date_format($birthdate, 'd.m.Y'),
          'fgbld' => 'ID',
          'fanat' => 'ID',
          'fasex' => $gender,
          'fanam' => $userfamily->fullname,
          'fgbot' => $userfamily->birthplace,
          'fcnam' => $userfamily->fullname,
          'zzslart' => $userfamily->lasteducation0->sapid //tambahkan id sap pada master education (id ada pada telegram mas joko)
        ];
    }
    return $userfamilydata;
  }
  protected function findUserfamilyJt($model, $userfamilys)
  {
    $objpssib = 1;
    $objpschild = 1;
    $tglinput = date_create($model->tglinput);
    $awalkontrak = date_create($model->awalkontrak);
    $akhirkontrak = date_create($model->akhirkontrak);
    foreach ($userfamilys as $key => $userfamily) {
      // SUBTY relationship, 1 = pasangan (suami/istri), 2 = anak, 11 = ayah, 12 = ibu, 91 = saudara kandung
      if ($userfamily->relationship == "husband" or $userfamily->relationship == "wife") {
        $subty = "1";
        $objps = "01";
      } elseif ($userfamily->relationship == "child") {
        $subty = "2";
        $objps = "0" . $objpschild;
        $objpschild = $objpschild + 1;
      } elseif ($userfamily->relationship == "father") {
        $subty = "11";
        $objps = "01";
      } elseif ($userfamily->relationship == "mother") {
        $subty = "12";
        $objps = "01";
      } else {
        $subty = "91";
        $objps = "0" . $objpssib;
        $objpssib = $objpssib + 1;
      }

      $userfamilyJtdata[] =
        [
          'endda' => '31.12.9999',
          'begda' => date_format($tglinput, 'd.m.Y'),
          'operation' => 'INS',
          'pernr' => "$model->perner",
          'infty' => '0318',
          'subty' => $subty, //di isi tergantung data relationship
          'objps' => $objps, //ibu = 01, bapak = 01, pasangan=01, kecuali anak atau saudara kandung di urutkan ex, 01, 02
          'jobtl' => $userfamily->jobtitle,
          'spems' => '',
          'marct' => ''
        ];
    }
    return $userfamilyJtdata;
  }
  protected function findUsereducation($model, $userfedus, $usernfedus)
  {
    $tglinput = date_create($model->tglinput);
    $awalkontrak = date_create($model->awalkontrak);
    $akhirkontrak = date_create($model->akhirkontrak);

    foreach ($userfedus as $key => $userfedu) {
      $enddate = date_create($userfedu->enddate);
      if ($userfedu->status == "finished") {
        $slabs = "00";
      } else {
        $slabs = "01";
      }
      $userfedudata[] =
        [
          'endda' => '31.12.9999',
          'begda' => date_format($enddate, 'd.m.Y'),
          'operation' => 'INS',
          'pernr' => "$model->perner",
          'infty' => '0022',
          'subty' => $userfedu->educationallevel0->sapid, //tambahkan id sap pada master education (id ada pada telegram mas joko)
          'slart' => $userfedu->educationallevel0->sapid, //sama dengan subty
          'insti' => $userfedu->institutions,
          'sland' => 'ID',
          'slabs' => $slabs, // menggunakan sertifikat atau tidak, apabila ada kode = 00, tidak ada = 01
          'emark' => $userfedu->gpa,
          'zzjurusan' => $userfedu->majoring, //untuk yang non fomal tidak perlu di isi
        ];
    }
    if ($usernfedus) {
      foreach ($usernfedus as $key => $usernfedu) {
        if ($usernfedu->type == "kursus" or $usernfedu->type == "training") {
          $subty = "ZB";
        } else {
          $subty = "ZC";
        }
        if ($usernfedu->iscertificate == 1) {
          $slabs = "00";
        } else {
          $slabs = "01";
        }
        $enddate = date_create($usernfedu->enddate);
        $usernfedudata[] =
          [
            'endda' => '31.12.9999',
            'begda' =>  date_format($tglinput, 'd.m.Y'),
            'operation' => 'INS',
            'pernr' => "$model->perner",
            'infty' => '0022',
            'subty' => $subty, //tambahkan id sap pada master education (id ada pada telegram mas joko)
            'slart' => $subty, //sama dengan subty
            'insti' => $usernfedu->institutions,
            'sland' => 'ID',
            'slabs' => $slabs, // menggunakan sertifikat atau tidak, apabila ada kode = 00, tidak ada = 01
            'emark' => "",
            'zzjurusan' => "", //untuk yang non fomal tidak perlu di isi
          ];
      }
      $usereducation = array_merge($userfedudata, $usernfedudata);
    } else {
      $usereducation = $userfedudata;
    }


    return $usereducation;
  }
  /**
   * Updates an existing Hiring model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   */
  public function actionUpdate($id)
  {
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->id]);
    } else {
      return $this->render('update', [
        'model' => $model,
      ]);
    }
  }
  public function actionApprovetest($id)
  {
    $model = $this->findModel($id);
    $modelcountjohiring = Hiring::find()->where('recruitreqid = ' . $model->recruitreqid . ' AND statushiring <> 5 AND statushiring <> 6 AND statushiring <> 7')->count();
    $modellisthiring = Hiring::find()->where('recruitreqid = ' . $model->recruitreqid . ' AND statushiring <> 5 AND statushiring <> 6 AND statushiring <> 7')->all();
    $transrincian = Transrincian::find()->where(['id' => $model->recruitreqid])->one();
    $personalarea = (Yii::$app->utils->getpersonalarea($transrincian->persa_sap)) ? Yii::$app->utils->getpersonalarea($transrincian->persa_sap) : "";
    $area =  (Yii::$app->utils->getarea($transrincian->area_sap)) ? Yii::$app->utils->getarea($transrincian->area_sap) : "";
    $skilllayanan = (Yii::$app->utils->getskilllayanan($transrincian->skill_sap)) ? Yii::$app->utils->getskilllayanan($transrincian->skill_sap) : "";
    $payrollarea = (Yii::$app->utils->getpayrollarea($transrincian->abkrs_sap)) ? Yii::$app->utils->getpayrollarea($transrincian->abkrs_sap) : "";
    $jabatan = (Yii::$app->utils->getjabatan($transrincian->hire_jabatan_sap)) ? Yii::$app->utils->getjabatan($transrincian->hire_jabatan_sap) : "";
    $curl = new curl\Curl();
    $getlevels = $curl->setPostParams([
      'level' => $transrincian->level_sap,
      'token' => 'ish**2019',
    ])->post('http://192.168.88.5/service/index.php/sap_profile/getlevel');
    $level  = json_decode($getlevels);
    $leveljabatan = ($level) ? $level : "";
    if ($modelcountjohiring == $transrincian->jumlah) {
      foreach ($modellisthiring as $key => $value) {
        $no = $key + 1;
        $listperner[] =  $no . '. ' . $value->perner;
      }

      $listpernerconv = implode('<br>', $listperner);
      // var_dump($listpernerconv);die;
      // $to = 'seysi.lupi@ish.co.id';
      $to = 'khusnul.hisyam@ish.co.id';
      $subject = 'Job Order Information - Done';
      $body = 'Selamat !!!
      <br>
      Permintaan Recruitment sudah terpenuhi untuk rincian sebagai berikut :

      <br>
      <br>
      <table>
      <tr>
      <td valign="top">No Job Order</td>
      <td valign="top">:</td>
      <td valign="top">' . $transrincian->nojo . '</td>
      </tr>
      <tr>
      <td valign="top">Personal Area</td>
      <td valign="top">:</td>
      <td valign="top">' . $personalarea . '</td>
      </tr>
      <tr>
      <td valign="top">Area</td>
      <td valign="top">:</td>
      <td valign="top">' . $area . '</td>
      </tr>
      <tr>
      <td valign="top">Skill Layanan</td>
      <td valign="top">:</td>
      <td valign="top">' . $skilllayanan . '</td>
      </tr>
      <tr>
      <td valign="top">Payroll Area</td>
      <td valign="top">:</td>
      <td valign="top">' . $payrollarea . '</td>
      </tr>
      <tr>
      <td valign="top">Jabatan</td>
      <td valign="top">:</td>
      <td valign="top">' . $jabatan . '</td>
      </tr>
      <tr>
      <td valign="top">Level</td>
      <td valign="top">:</td>
      <td valign="top">' . $leveljabatan . '</td>
      </tr>
      </table>
      <br>
      <br>
      Berikut daftar pekerjanya :
      <br><br>
      ' . $listpernerconv;
      // var_dump($body);die;
      $sendemail = Yii::$app->utils->sendmailinternal($to, $subject, $body, 11);
      if ($sendemail) {
        echo 'successfully';
      }
    }
  }
  public function actionApprove($id)
  {
    $model = $this->findModel($id);
    $modelrecreq = Transrincian::find()->where(['id' => $model->recruitreqid])->one();
    $modelcountjo = Hiring::find()->where('recruitreqid = ' . $model->recruitreqid . ' and statushiring <> 5')->count();
    // var_dump($modelcountjo);die;
    if ($model->typejo == 1) {
      $model->setScenario('approveish');
    } else {
      $model->setScenario('approvesso');
    }

    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
      if ($model->typejo == 1) {
        $model->statushiring = 2;
        $model->statusbiodata = 2;
      } else {
        $model->statushiring = 8;
        $model->statusbiodata = 8;
        $maxperner = Hiring::find()->where(['typejo' => 2])->max('perner');
        $getnumbperner = substr($maxperner, 6);
        $getnumbperner = (int)$getnumbperner;
        $newnumber = $getnumbperner + 1;
        if ($newnumber < 10) {
          $newnumber = '000' . $newnumber;
        } else if ($newnumber < 100) {
          $newnumber = '00' . $newnumber;
        } else if ($newnumber < 1000) {
          $newnumber = '0' . $newnumber;
        } else {
          $newnumber = $newnumber;
        }
        $newperner = date('Ym') . $newnumber;
        $model->perner = $newperner;
      }
      $model->approvedby = Yii::$app->user->identity->id;
      $model->updatetime = date('Y-m-d H-i-s');
      $model->save();
      $model = $this->findModel($id);
      $modelrecreq = Transrincian::find()->where(['id' => $model->recruitreqid])->one();
      $modelcountjo = Hiring::find()->where('recruitreqid = ' . $model->recruitreqid . ' and statushiring <> 5')->count();
      // var_dump($modelcountjo);die;
      if ($model->typejo == 1) {
        $model->setScenario('approveish');
      } else {
        $model->setScenario('approvesso');
      }

      if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        if ($model->typejo == 1) {
          $model->statushiring = 2;
          $model->statusbiodata = 2;
        } else {
          $model->statushiring = 8;
          $model->statusbiodata = 8;
          $maxperner = Hiring::find()->where(['typejo' => 2])->max('perner');
          $getnumbperner = substr($maxperner, 6);
          $getnumbperner = (int)$getnumbperner;
          $newnumber = $getnumbperner + 1;
          if ($newnumber < 10) {
            $newnumber = '000' . $newnumber;
          } else if ($newnumber < 100) {
            $newnumber = '00' . $newnumber;
          } else if ($newnumber < 1000) {
            $newnumber = '0' . $newnumber;
          } else {
            $newnumber = $newnumber;
          }
          $newperner = date('Ym') . $newnumber;
          $model->perner = $newperner;
        }
        $model->approvedby = Yii::$app->user->identity->id;
        $model->updatetime = date('Y-m-d H-i-s');
        $model->save();
        if ($modelcountjo == $modelrecreq->jumlah) {
          if ($modelrecreq->status_rekrut == 3) {
            $modelrecreq->status_rekrut = 4;
          } else {
            $modelrecreq->status_rekrut = 2;
          }
          $modelrecreq->save(false);
        }
      }
      if ($modelcountjo == $modelrecreq->jumlah) {
        if ($modelrecreq->status_rekrut == 3) {
          $modelrecreq->status_rekrut = 4;
        } else {
          $modelrecreq->status_rekrut = 2;
        }
        $modelrecreq->save(false);
      }
      return $this->redirect(['index']);
    } else {
      return $this->renderAjax('approve', [
        'model' => $model,
        'modelrecreq' => $modelrecreq,
      ]);
    }
  }
  public function actionReject($id)
  {
    $model = $this->findModel($id);
    $model->statushiring = 5;
    $model->statusbiodata = 5;
    $model->rejectedby = Yii::$app->user->identity->id;

    $model->save();

    return $this->redirect(['index']);
  }

  /**
   * Deletes an existing Hiring model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   */



  /**
   * Finds the Hiring model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Hiring the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Hiring::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }
}
