<?php

namespace app\controllers;

use Yii;
use app\models\Chagerequestdata;
use app\models\Chagerequestdatabanksearch;
use app\models\Hiring;
use app\models\Userprofile;
use app\models\Transrincian;
use app\models\Userabout;
use app\models\Uploadocument;
use app\models\Crdtransaction;
use app\models\User;
use app\models\Masterbank;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\filters\AccessControl;
use linslin\yii2\curl;

/**
 * ChagerequestdataController implements the CRUD actions for Chagerequestdata model.
 */
class ChagerequestdatabankController extends Controller
{
  /**
   * @inheritdoc
   */
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'only' => ['index', 'update', 'create', 'view', 'delete'],
        'rules' => [
          [
            'actions' => ['index', 'update', 'create', 'view', 'delete'],
            'allow' => true,
            'roles' => ['@'],
            'matchCallback' => function () {
              return (Yii::$app->utils->permission(Yii::$app->user->identity->role, 'm57'));
            }

          ],
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
   * Lists all Chagerequestdata models.
   * @return mixed
   */
  public function actionIndex()
  {
    $searchModel = new Chagerequestdatabanksearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Displays a single Chagerequestdata model.
   * @param integer $id
   * @return mixed
   */
  public function actionView($id)
  {
    $model = $this->findModel($id);
    $userid = $model->userid;
    $perner = $model->perner;
    $curl = new curl\Curl();
    $getdatapekerjabyperner =  $curl->setPostParams([
      'perner' => $perner,
      'token' => 'ish**2019',
    ])->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerjaall');
    $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
    if ($model->status == 2 or $model->status == 3 or $model->status == 7) {
      $statusresign = 1;
      $resigndate = "";
      $resignreason = "";

      if ($datapekerjabyperner[0]->MASSN == "Z8") {
        $statusresign = 2;
        $resigndate = "";
        $resignreason = $datapekerjabyperner[0]->MSGTX;
        if ($datapekerjabyperner[0]->DAT35) {
          $year = substr($datapekerjabyperner[0]->DAT35, 0, 4);
          $month = substr($datapekerjabyperner[0]->DAT35, 4, 2);
          $date = substr($datapekerjabyperner[0]->DAT35, 6, 2);
          $resigndate = $year . "-" . $month . "-" . $date;
        }
      }

      $resignreason = $datapekerjabyperner[0]->MSGTX;
      $model->statusresign = $statusresign;
      $model->resignreason = $resignreason;
      $model->resigndate = $resigndate;
      $model->save(false);
    }
    if ($userid) {
      // $userprofile = Userprofile::find()->where(['userid'=>$userid])->one();
      // $document = Uploadocument::find()->where(['userid'=>$userid])->one();
      $userabout = Userabout::find()->where(['userid' => $userid])->one();
      $bankaccount = $userabout->bankname->bank;
      $bankaccountnumber = $userabout->bankaccountnumber;
      $bankaccountfile = $userabout->passbook;
      $datapekerjabyperner = null;
    } else {

      $name = ($datapekerjabyperner) ? $datapekerjabyperner[0]->CNAME : 'not found';
      $hire = 'Non Gojobs';
      $masterbank = ($datapekerjabyperner) ? Masterbank::find()->where(['sapid' => $datapekerjabyperner[0]->BANKL])->one() : "not found";
      $bankaccount = ($datapekerjabyperner) ? (($masterbank) ? $masterbank->bank : null) : "not found";
      $bankaccountnumber = ($datapekerjabyperner) ? $datapekerjabyperner[0]->BANKN : "not found";
      $bankaccountfile = null;
    }
    $crdtransbankacc = Crdtransaction::find()->where(['crdid' => $id, 'dataid' => 4])->one();
    // var_dump($crdtransbankacc);die;
    return $this->renderAjax('view', [
      'model' => $model,
      // 'userprofile'=>$userprofile,
      // 'userabout'=>$userabout,
      // 'document'=>$document,
      'datapekerjabyperner' => $datapekerjabyperner,
      'bankaccount' => $bankaccount,
      'bankaccountnumber' => $bankaccountnumber,
      'bankaccountfile' => $bankaccountfile,
      'bankaccountoldval' => ($crdtransbankacc) ? (($crdtransbankacc->oldbankname) ? $crdtransbankacc->oldbankname->bank : null) : null,
      'bankaccountnumberoldval' => ($crdtransbankacc) ? $crdtransbankacc->oldvalue2 : null,
      'bankaccountnewval' => ($crdtransbankacc) ? (($crdtransbankacc->bankname) ? $crdtransbankacc->bankname->bank : null) : null,
      'bankaccountnumbernewval' => ($crdtransbankacc) ? $crdtransbankacc->newvalue2 : null,
      'bankaccountolddoc' => ($crdtransbankacc) ? $crdtransbankacc->olddoc : null,
      'bankaccountnewdoc' => ($crdtransbankacc) ? $crdtransbankacc->newdoc : null,
    ]);
  }

  /**
   * Creates a new Chagerequestdata model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionAutosave()
  {
    $id = $_POST['id'];
    $approvedby = $_POST['approvedby'];
    if ($id) {
      $model = $this->findModel($id);
      $model->approvedby = $approvedby;
      $model->save(false);
    }
  }

  public function actionGetuserabout()
  {

    $perner = $_POST['perner'];
    $id = $_POST['id'];
    $updatecr = $this->findModel($id);
    $crdtransbankacc = Crdtransaction::find()->where(['crdid' => $id, 'dataid' => 4])->one();
    if ($perner) {
      $cekhiring = Hiring::find()->where(['perner' => $perner, 'statushiring' => 4])->one();

      if ($cekhiring) {

        $getjo = Transrincian::find()->where(['id' => $cekhiring->recruitreqid])->one();
        $model = Userabout::find()->where(['userid' => $cekhiring->userid])->one();
        $document = Uploadocument::find()->where(['userid' => $cekhiring->userid])->one();
        $updatecr->userid = $cekhiring->userid;
        $name = $cekhiring->userprofile->fullname;
        $persa = (Yii::$app->utils->getpersonalarea($getjo->persa_sap)) ? Yii::$app->utils->getpersonalarea($getjo->persa_sap) : "";
        $area = (Yii::$app->utils->getarea($getjo->area_sap)) ? Yii::$app->utils->getarea($getjo->area_sap) : "";
        $skilllayanan = (Yii::$app->utils->getskilllayanan($getjo->skill_sap)) ? Yii::$app->utils->getskilllayanan($getjo->skill_sap) : "";
        $payrollarea = (Yii::$app->utils->getpayrollarea($getjo->abkrs_sap)) ? Yii::$app->utils->getpayrollarea($getjo->abkrs_sap) : "";
        $jabatan = (Yii::$app->utils->getjabatan($getjo->hire_jabatan_sap)) ? Yii::$app->utils->getjabatan($getjo->hire_jabatan_sap) : "";
        $curl = new curl\Curl();
        $getlevels = $curl->setPostParams([
          'level' => $getjo->level_sap,
          'token' => 'ish**2019',
        ])
          ->post('http://192.168.88.5/service/index.php/sap_profile/getlevel');
        $level  = json_decode($getlevels);
        $level = ($level) ? $level : "";
        $status = "Active";
        $resignreason = "-";
        $resigndate = "-";
        $hire = "Gojobs";
        $bankaccount = ($model->bankname) ? $model->bankname->bank : null;
        $bankaccountnumber = $model->bankaccountnumber;
        $bankaccountfile = ($model->passbook) ? $model->passbook : null;
        $updatecr->fullname = $name;
        $updatecr->perner = $cekhiring->perner;
      } else {
        $updatecr->userid = null;
        $updatecr->perner = $perner;

        $curl = new curl\Curl();
        $getdatapekerjabyperner =  $curl->setPostParams([
          'perner' => $perner,
          'token' => 'ish**2019',
        ])
          ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerjaall');
        $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
        $name = $datapekerjabyperner[0]->CNAME;
        $persa = $datapekerjabyperner[0]->WKTXT;
        $area = $datapekerjabyperner[0]->BTRTX;
        $skilllayanan = $datapekerjabyperner[0]->PEKTX;
        $payrollarea = $datapekerjabyperner[0]->ABTXT;
        $jabatan = $datapekerjabyperner[0]->PLATX;
        $level = $datapekerjabyperner[0]->TRFAR_TXT;
        $status = "Active";
        $resigndate = "-";

        if ($datapekerjabyperner[0]->MASSN == "Z8") {
          $status = "Resign";
          $resigndate = "-";

          if ($datapekerjabyperner[0]->DAT35) {
            $year = substr($datapekerjabyperner[0]->DAT35, 0, 4);
            $month = substr($datapekerjabyperner[0]->DAT35, 4, 2);
            $date = substr($datapekerjabyperner[0]->DAT35, 6, 2);
            $resigndate = $date . "-" . $month . "-" . $year;
          }
        }

        $resignreason = $datapekerjabyperner[0]->MSGTX;
        $hire = 'Non Gojobs';
        $masterbank = Masterbank::find()->where(['sapid' => $datapekerjabyperner[0]->BANKL])->one();
        $bankaccount = ($masterbank) ? $masterbank->bank : $datapekerjabyperner[0]->BANKL;
        $bankaccountnumber = $datapekerjabyperner[0]->BANKN;
        $bankaccountfile = null;
        $updatecr->fullname = $name;
      }
      $bankaccountnewval = ($crdtransbankacc) ? (($crdtransbankacc->bankname) ? $crdtransbankacc->bankname->bank : null) : null;
      $bankaccountnumbernewval = ($crdtransbankacc) ? $crdtransbankacc->newvalue2 : null;
      $bankaccountnewdoc = ($crdtransbankacc) ? $crdtransbankacc->newdoc : null;
      $updatecr->save(false);

      if ($bankaccount) {
        $dataprofile = [
          'perner' => $perner,
          'name' => $name,
          'persa' => $persa,
          'area' => $area,
          'skilllayanan' => $skilllayanan,
          'payrollarea' => $payrollarea,
          'jabatan' => $jabatan,
          'level' => $level,
          'status' => $status,
          'resignreason' => $resignreason,
          'resigndate' => $resigndate,
          'hire' => $hire,
          'bankaccount' => $bankaccount,
          'bankaccountnumber' => $bankaccountnumber,
          'bankaccountfile' => $bankaccountfile,
          'bankaccountnewval' => $bankaccountnewval,
          'bankaccountnumbernewval' => $bankaccountnumbernewval,
          'bankaccountnewdoc' => $bankaccountnewdoc,
        ];
      } else {
        $dataprofile = '';
      }
    } else {
      $dataprofile = '';
    }
    return Json::encode($dataprofile);
  }

  public function actionCreate($id = null)
  {
    // $getid = Userprofile::find()->where(['userid'=>$userid])->one();
    $approvalname = ArrayHelper::map(User::find()->where(['role' => 15])->asArray()->all(), 'id', 'name');

    if ($id) {
      $model = $this->findModel($id);
      $model->approvedby = 53;
      $model->approvedby2 = 18608;
      $model->approvedbyname = User::findOne(53)->name;
      $model->approvedby2name = User::findOne(18608)->name;
      //  $name = ArrayHelper::map(Hiring::find()
      //  ->joinWith(['userprofile'])
      //  ->joinWith(['changereqdata'])
      //  ->andWhere(['statushiring'=>4])
      //  ->andWhere(['or',
      //   ['chagerequestdata.userid'=>null],
      //   ['hiring.userid' => $model->userid],
      // ])
      //  ->asArray()->all(), 'userid', 'userprofile.fullname');
      $namaquery = Hiring::find()
        ->joinWith(['userprofile'])
        ->joinWith(['changereqdata'])
        ->andWhere(['statushiring' => 4])
        // ->andWhere(['chagerequestdata.kategorydata'=>2])
        ->andWhere([
          'or',
          ['chagerequestdata.userid' => null],
          ['chagerequestdata.status' => 3],
          ['hiring.userid' => $model->userid],
        ])->all();
    } else {
      $getid = new Chagerequestdata();
      $getid->createtime = date('Y-m-d H-i-s');
      $getid->updatetime = date('Y-m-d H-i-s');
      $getid->createdby = Yii::$app->user->identity->id;
      $getid->updatedby = Yii::$app->user->identity->id;
      $getid->kategorydata = 2;
      $getid->save();
      return $this->redirect(['create', 'id' => $getid->id]);
    }
    if ($model->load(Yii::$app->request->post()))
    {
      $curl = new curl\Curl();
      $getdatapekerjabyperner =  $curl->setPostParams([
        'perner' => $model->perner,
        'token' => 'ish**2019',
      ])
        ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerjaall');
      $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
      $statusresign = 1;
      $resigndate = "";
      $resignreason = "";

      if ($datapekerjabyperner[0]->MASSN == "Z8")
      {
        $statusresign = 2;
        $resigndate = "";
        $resignreason = $datapekerjabyperner[0]->MSGTX;
        if ($datapekerjabyperner[0]->DAT35)
        {
          $year = substr($datapekerjabyperner[0]->DAT35, 0, 4);
          $month = substr($datapekerjabyperner[0]->DAT35, 4, 2);
          $date = substr($datapekerjabyperner[0]->DAT35, 6, 2);
          $resigndate = $year . "-" . $month . "-" . $date;
        }
      }

      $resignreason = $datapekerjabyperner[0]->MSGTX;
      $model->statusresign = $statusresign;
      $model->resignreason = $resignreason;
      $model->resigndate = $resigndate;
      $model->status = 2;
      if ($model->save())
      {
        if ($model->status == 2)
        {
          $user = User::find()->where(['id' => $model->approvedby])->one();
        } else {
          $user = User::find()->where(['id' => $model->approvedby2])->one();
        }
        if ($model->userid)
        {
          $getjo = Hiring::find()->where(['userid' => $model->userid, 'statushiring' => 4])->one();

          $modelrecreq = Transrincian::find()->where(['id' => $getjo->recruitreqid])->one();
          $userprofile = Userprofile::find()->where(['userid' => $model->userid])->one();

          $name = $userprofile->fullname;
          $perner = $getjo->perner;
          if ($modelrecreq->transjo->n_project == "" || $modelrecreq->transjo->n_project == "Pilih") {
            $layanan = $modelrecreq->transjo->project;
          } else {
            $layanan = $modelrecreq->transjo->n_project;
          }
          if (Yii::$app->utils->getarea($modelrecreq->area_sap)) {
            $area = Yii::$app->utils->getarea($modelrecreq->area_sap);
          } else {
            $area = '-';
          }
          if (Yii::$app->utils->getjabatan($modelrecreq->hire_jabatan_sap)) {
            $jabatan = Yii::$app->utils->getjabatan($modelrecreq->hire_jabatan_sap);
          } else {
            $jabatan = '-';
          }
        } else {

          $name = $datapekerjabyperner[0]->CNAME;
          $perner = $model->perner;
          $layanan = $datapekerjabyperner[0]->WKTXT;
          $area = $datapekerjabyperner[0]->BTRTX;
          $jabatan = $datapekerjabyperner[0]->PLATX;
        }
        // $to = $user->email;
        $to = 'khusnul.hisyam@ish.co.id';
        $subject = 'Notifikasi Approval Perubahan Data Bank';
        $body = 'Semangat Pagi,,
              <br>
              Anda mendapatkan permintaan Approval Perubahan Data Bank dari <span style="text-transform: uppercase;"><b>' . $model->createduser->name . '</b></span> dengan rincian sebagai berikut :
              <br>
              <br>
              <table>
              <tr>
              <td valign="top">Nama Pekerja</td>
              <td valign="top">:</td>
              <td valign="top">' . $name . '</td>
              </tr>
              <tr>
              <td valign="top">Perner</td>
              <td valign="top">:</td>
              <td valign="top">' . $perner . '</td>
              </tr>
              <tr>
              <td valign="top">Nama Project</td>
              <td valign="top">:</td>
              <td valign="top">' . $layanan . '</td>
              </tr>
              <tr>
              <td valign="top">Area</td>
              <td valign="top">:</td>
              <td valign="top">' . $area . '</td>
              </tr>
              <tr>
              <td valign="top">Jabatan</td>
              <td valign="top">:</td>
              <td valign="top">' . $jabatan . '</td>
              </tr>
              <tr>
              </table>
              <br>
              <br>
              Silakan masuk ke link <a href="https://gojobs.id">gojobs.id</a> untuk melakukan verifikasi lebih lanjut.
              <br><br>
              Have a great day !
              ';
        // var_dump($body);die;
        $verification = Yii::$app->utils->sendmail($to, $subject, $body, 11);
      }
      return $this->redirect(['index']);
    } else {
      return $this->render('create', [
        'model' => $model,
        'approvalname' => $approvalname,
      ]);
    }
  }

  /**
   * Updates an existing Chagerequestdata model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   */
  public function actionUpdate($id)
  {

    return $this->redirect(['create', 'id' => $id]);
  }

  public function actionApprove($id)
  {
    $model = $this->findModel($id);
    $userid = $model->userid;
    $perner = $model->perner;
    $curl = new curl\Curl();
    $getdatapekerjabyperner =  $curl->setPostParams([
      'perner' => $perner,
      'token' => 'ish**2019',
    ])->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerjaall');
    $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
    if ($model->status == 2 or $model->status == 3 or $model->status == 7) {
      $statusresign = 1;
      $resigndate = "";
      $resignreason = "";

      if ($datapekerjabyperner[0]->MASSN == "Z8") {
        $statusresign = 2;
        $resigndate = "";
        $resignreason = $datapekerjabyperner[0]->MSGTX;
        if ($datapekerjabyperner[0]->DAT35) {
          $year = substr($datapekerjabyperner[0]->DAT35, 0, 4);
          $month = substr($datapekerjabyperner[0]->DAT35, 4, 2);
          $date = substr($datapekerjabyperner[0]->DAT35, 6, 2);
          $resigndate = $year . "-" . $month . "-" . $date;
        }
      }

      $resignreason = $datapekerjabyperner[0]->MSGTX;
      $model->statusresign = $statusresign;
      $model->resignreason = $resignreason;
      $model->resigndate = $resigndate;
      $model->save(false);
    }
    if ($userid) {
      // $userprofile = Userprofile::find()->where(['userid'=>$userid])->one();
      // $document = Uploadocument::find()->where(['userid'=>$userid])->one();
      $userabout = Userabout::find()->where(['userid' => $userid])->one();
      $bankaccount = $userabout->bankname->bank;
      $bankaccountnumber = $userabout->bankaccountnumber;
      $bankaccountfile = $userabout->passbook;
    } else {

      $name = $datapekerjabyperner[0]->CNAME;
      $hire = 'Non Gojobs';
      $masterbank = Masterbank::find()->where(['sapid' => $datapekerjabyperner[0]->BANKL])->one();
      $bankaccount = ($masterbank) ? $masterbank->bank : null;
      $bankaccountnumber = $datapekerjabyperner[0]->BANKN;
      $bankaccountfile = null;
    }

    $crdtransbankacc = Crdtransaction::find()->where(['crdid' => $id, 'dataid' => 4])->one();
    $model->scenario = 'approve';
    if ($model->load(Yii::$app->request->post())) {
      $model->approvedtime = date('Y-m-d H-i-s');
      $model->save();
      
      $model->status = 3;
      if ($model->status == 3) {
        $user = User::find()->where(['id' => $model->approvedby2])->one();

        if ($model->userid) {
          $getjo = Hiring::find()->where(['userid' => $model->userid, 'statushiring' => 4])->one();

          $modelrecreq = Transrincian::find()->where(['id' => $getjo->recruitreqid])->one();
          $userprofile = Userprofile::find()->where(['userid' => $model->userid])->one();

          $name = $userprofile->fullname;
          $perner = $getjo->perner;
          if ($modelrecreq->transjo->n_project == "" || $modelrecreq->transjo->n_project == "Pilih") {
            $layanan = $modelrecreq->transjo->project;
          } else {
            $layanan = $modelrecreq->transjo->n_project;
          }
          if (Yii::$app->utils->getarea($modelrecreq->area_sap)) {
            $area = Yii::$app->utils->getarea($modelrecreq->area_sap);
          } else {
            $area = '-';
          }
          if (Yii::$app->utils->getjabatan($modelrecreq->hire_jabatan_sap)) {
            $jabatan = Yii::$app->utils->getjabatan($modelrecreq->hire_jabatan_sap);
          } else {
            $jabatan = '-';
          }
        } else {

          $name = $datapekerjabyperner[0]->CNAME;
          $perner = $model->perner;
          $layanan = $datapekerjabyperner[0]->WKTXT;
          $area = $datapekerjabyperner[0]->BTRTX;
          $jabatan = $datapekerjabyperner[0]->PLATX;
        }
        // $to = $user->email;
        $to = 'khusnul.hisyam@ish.co.id';
        $subject = 'Notifikasi Approval II Perubahan Data Bank';
        $body = 'Semangat Pagi,,
          <br>
          Anda mendapatkan permintaan Approval Perubahan Data Bank dari <span style="text-transform: uppercase;"><b>' . $model->createduser->name . '</b></span> dengan rincian sebagai berikut :

          <br>
          <br>
          <table>
          <tr>
          <td valign="top">Nama Pekerja</td>
          <td valign="top">:</td>
          <td valign="top">' . $name . '</td>
          </tr>
          <tr>
          <td valign="top">Perner</td>
          <td valign="top">:</td>
          <td valign="top">' . $perner . '</td>
          </tr>
          <tr>
          <td valign="top">Nama Project</td>
          <td valign="top">:</td>
          <td valign="top">' . $layanan . '</td>
          </tr>
          <tr>
          <td valign="top">Area</td>
          <td valign="top">:</td>
          <td valign="top">' . $area . '</td>
          </tr>
          <tr>
          <td valign="top">Jabatan</td>
          <td valign="top">:</td>
          <td valign="top">' . $jabatan . '</td>
          </tr>
          <tr>
          </table>
          <br>
          <br>
          Silakan masuk ke link <a href="https://gojobs.id">gojobs.id</a> untuk melakukan verifikasi lebih lanjut.
          <br><br>
          Have a great day !
          ';
        // var_dump($body);die;
        $verification = Yii::$app->utils->sendmail($to, $subject, $body, 12);
      }
      // $model->save();
      return $this->redirect(['index']);
    } else {
      return $this->renderAjax('approve', [
        'model' => $model,
        // 'userprofile'=>$userprofile,
        // 'userabout'=>$userabout,
        // 'document'=>$document,
        'bankaccount' => $bankaccount,
        'bankaccountnumber' => $bankaccountnumber,
        'bankaccountfile' => $bankaccountfile,
        'bankaccountoldval' => ($crdtransbankacc) ? (($crdtransbankacc->oldbankname) ? $crdtransbankacc->oldbankname->bank : null) : null,
        'bankaccountnumberoldval' => ($crdtransbankacc) ? $crdtransbankacc->oldvalue2 : null,
        'bankaccountnewval' => ($crdtransbankacc) ? (($crdtransbankacc->bankname) ? $crdtransbankacc->bankname->bank : null) : null,
        'bankaccountnumbernewval' => ($crdtransbankacc) ? $crdtransbankacc->newvalue2 : null,
        'bankaccountolddoc' => ($crdtransbankacc) ? $crdtransbankacc->olddoc : null,
        'bankaccountnewdoc' => ($crdtransbankacc) ? $crdtransbankacc->newdoc : null,
      ]);
    }
  }
  
  public function actionApprove2($id)
  {
    $model = $this->findModel($id);
    $userid = $model->userid;
    $perner = $model->perner;
    $cekpekerja = '';
    // var_dump($userid);die;
    if ($userid) {
      $userprofile = Userprofile::find()->where(['userid' => $userid])->one();
      $document = Uploadocument::find()->where(['userid' => $userid])->one();
      $userabout = Userabout::find()->where(['userid' => $userid])->one();
      $bankaccount = $userabout->bankname->bank;
      $bankaccountnumber = $userabout->bankaccountnumber;
      $bankaccountfile = $userabout->passbook;
    } else {
      $curl = new curl\Curl();
      $getdatapekerjabyperner =  $curl->setPostParams([
        'perner' => $perner,
        'token' => 'ish**2019',
      ])->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerja');

      $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
      // if($datapekerjabyperner) {
      //   $cekpekerja = 1;
      // }
      $name = ($datapekerjabyperner) ? $datapekerjabyperner[0]->CNAME : null;
      $hire = 'Non Gojobs';
      $masterbank = Masterbank::find()->where(['sapid' => (($datapekerjabyperner) ? $datapekerjabyperner[0]->BANKL : null)])->one();
      $bankaccount = ($masterbank) ? $masterbank->bank : null;
      $bankaccountnumber = ($datapekerjabyperner) ? $datapekerjabyperner[0]->BANKN : null;
      $bankaccountfile = null;
      $userprofile = null;
    }
    $crdtransbankacc = Crdtransaction::find()->where(['crdid' => $id, 'dataid' => 4])->one();

    $model->scenario = 'approve';
    if ($model->load(Yii::$app->request->post())) {
      if ($model->status == 4) {
        $updatesap = $this->UpdateSapPersonaldata($id, $userid, $perner);
        // var_dump($updatesap);die;
        if ($updatesap) {
          $model->remarks = $updatesap;
          $model->status = 7;
          $model->save();
        } else {

          $model->remarks = 'successful';
          $model->approvedtime2 = date('Y-m-d H-i-s');
          $model->save();
          if ($userprofile) {

            if ($crdtransbankacc) {
              $userabout->bankid = ($crdtransbankacc->newvalue) ? $crdtransbankacc->newvalue : '';
              $userabout->bankaccountnumber = ($crdtransbankacc->newvalue2) ? $crdtransbankacc->newvalue2 : '';
              $userabout->passbook = ($crdtransbankacc->newdoc) ? $crdtransbankacc->newdoc : '';
              $document->bankaccount = ($crdtransbankacc->newdoc) ? $crdtransbankacc->newdoc : '';
            }

            $userabout->save(false);
            $document->save(false);
          }
        }
      } else {
        $model->save();
      }

      // $model->save();
      return $this->redirect(['index']);
    } else {
      return $this->renderAjax('approve', [
        'model' => $model,
        // 'userprofile'=>$userprofile,
        // 'userabout'=>$userabout,
        // 'document'=>$document,
        'bankaccount' => $bankaccount,
        'bankaccountnumber' => $bankaccountnumber,
        'bankaccountfile' => $bankaccountfile,
        'bankaccountoldval' => ($crdtransbankacc) ? (($crdtransbankacc->oldbankname) ? $crdtransbankacc->oldbankname->bank : null) : null,
        'bankaccountnumberoldval' => ($crdtransbankacc) ? $crdtransbankacc->oldvalue2 : null,
        'bankaccountnewval' => ($crdtransbankacc) ? (($crdtransbankacc->bankname) ? $crdtransbankacc->bankname->bank : null) : null,
        'bankaccountnumbernewval' => ($crdtransbankacc) ? $crdtransbankacc->newvalue2 : null,
        'bankaccountolddoc' => ($crdtransbankacc) ? $crdtransbankacc->olddoc : null,
        'bankaccountnewdoc' => ($crdtransbankacc) ? $crdtransbankacc->newdoc : null,
        'cekpekerja' => $cekpekerja
      ]);
    }
  }

  protected function UpdateSapPersonaldata($id, $userid, $perner)
  {
    $tglapprove = date('d');
    $bulanapprove = date('m');
    $tahunapprove = date('Y');
    $backmonth = $bulanapprove - 1;
    $getlastdatebackmonth = $tahunapprove . '-' . $backmonth . '-' . $tglapprove;
    if ($tglapprove > 15) {
      $tglinput = date("t.m.Y");
    } else {
      $tglinput = date("t.m.Y", strtotime($getlastdatebackmonth));
    }
    $modelcr = $this->findModel($id);
    if ($userid) {
      $model = Hiring::find()->where(['userid' => $userid, 'statushiring' => 4])->one();
      $userprofile = Userprofile::find()->where(['userid' => $userid])->one();
      $userabout = Userabout::find()->where(['userid' => $userid])->one();
      $perner = $model->perner;
    } else {
      $perner = $perner;
    }

    $curl = new curl\Curl();
    $getdatapekerjabyperner =  $curl->setPostParams([
      'perner' => $perner,
      'token' => 'ish**2019',
    ])->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerjaall');
    $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
    $ABKRS = $datapekerjabyperner[0]->ABKRS;

    $curl = new curl\Curl();
    $cekpaycontroll =  $curl->setPostParams([
      'token' => 'ish@2019!',
      'ABKRS' => $ABKRS,
    ])
      ->post('http://192.168.88.5/service/index.php/Rfccekpayrollcontroll');
    $payrollcontrollresult  = json_decode($cekpaycontroll);
    // var_dump($cekpaycontroll);die;
    if ($payrollcontrollresult->status == 1) {

      $crdtransbankacc = Crdtransaction::find()->where(['crdid' => $id, 'dataid' => 4])->one();


      $url = "http://192.168.88.60:8080/ish-rest/ZINFHRF_00025";

      $infotype = ['0009'];
      $request_data = [
        [
          'pernr' => "$perner",
          'inftypList' => $infotype,
          //01  no ktp, 02  sim a, 03  sim b, 04  sim c, 05  nik, 06  agent id, 07  passport, 08  virtual bpjs, 09  kartu keluarga, 80  application id

          'p00009List' => [
            [
              'endda' => '31.12.9999',
              'begda' => $tglinput,
              'operation' => 'INS',
              'pernr' => "$perner",
              'infty' => '0009',
              'subty' => '0',
              'bnksa' => '0',
              'waers' => 'IDR',
              'zlsch' => 'T',
              'banks' => 'ID',
              'bankl' => $crdtransbankacc->bankname->sapid, //nama bank, kode ambil dari master bank ditambahkan kode bank sap
              'bankn' => $crdtransbankacc->newvalue2
            ]
          ],
        ]
      ];

      $json = json_encode($request_data);
      // var_dump($json);die;
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
      // var_dump($response);die;
      // var_dump(curl_error($ch));die;
      curl_close($ch);
      $ret = json_decode($response);
      $log = array();
      if ($ret) {
        foreach ($ret as $key => $value) {
          if ($value->success <> TRUE) {
            $log  = $value->message;
          }
        }
      } else {
        $log = 'error';
      }
    } else {
      $log = 'error payroll controll';
    }


    return $log;
  }

  /**
   * Deletes an existing Chagerequestdata model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   */
  public function actionDelete($id)
  {
    $this->findModel($id)->delete();

    return $this->redirect(['index']);
  }
  public function actionGetdatakaryawan($q = null, $id = null)
  {
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    // var_dump($id);die;
    $outs = ['results' => ['id' => '', 'text' => '']];
    if (!is_null($q)) {
      $wherecontent = $q;
      // var_dump($wherecontent);die;
      $curl = new curl\Curl();
      $getdatapekerja = $curl->setPostParams([
        'q' => $q,
        'token' => 'ish**2019',
      ])->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerjaall');
      $datapekerja  = json_decode($getdatapekerja);

      // var_dump($datapekerja);die;
      $out = null;
      if ($datapekerja) {
        foreach ($datapekerja as $key => $value) {
          $out[] = $value;

          // $out['results'] = $value['jobfunc']['name_job_function'];
        }
      }
      if ($out) {
        $outs['results'] = $out;
      } else {
        $outs['results'] = null;
      }
    } elseif ($id > 0) {
      $curl =  new curl\Curl();
      $getdatapekerjabyperner =  $curl->setPostParams([
        'perner' => $id,
        'token' => 'ish**2019',
      ])->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerjaall');
      $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
      $outs['results'] = ['id' => $id, 'text' => $datapekerjabyperner];
    } else {
      
      $outs['results'] = ['id' => ' ', 'text' => ' '];
    }
    // var_dump($outs);die;
    return $outs;
  }

  /**
   * Finds the Chagerequestdata model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Chagerequestdata the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Chagerequestdata::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }
}
