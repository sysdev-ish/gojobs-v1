<?php

namespace app\controllers;

use Yii;
use app\models\Chagerequestdata;
use app\models\Chagerequestdatasearch;
use app\models\Hiring;
use app\models\Userprofile;
use app\models\Uploadocument;
use app\models\Transrincian;
use app\models\Crdtransaction;
use app\models\User;
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
class ChagerequestdataController extends Controller
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
              return (Yii::$app->utils->permission(Yii::$app->user->identity->role, 'm52'));
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
    $searchModel = new Chagerequestdatasearch();
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
    $document = Uploadocument::find()->where(['userid' => $userid])->one();
    $userprofile = Userprofile::find()->where(['userid' => $userid])->one();
    $crdtransnpwp = Crdtransaction::find()->where(['crdid' => $id, 'dataid' => 1])->one();
    $crdtransbpjs = Crdtransaction::find()->where(['crdid' => $id, 'dataid' => 2])->one();
    $crdtransjamsostek = Crdtransaction::find()->where(['crdid' => $id, 'dataid' => 3])->one();
    return $this->renderAjax('view', [
      'model' => $model,
      'userprofile' => $userprofile,
      'document' => $document,
      'npwpnumberoldval' => ($crdtransnpwp) ? $crdtransnpwp->oldvalue : null,
      'bpjsnumberoldval' => ($crdtransbpjs) ? $crdtransbpjs->oldvalue : null,
      'jamsosteknumberoldval' => ($crdtransjamsostek) ? $crdtransjamsostek->oldvalue : null,
      'npwpnumbernewval' => ($crdtransnpwp) ? $crdtransnpwp->newvalue : null,
      'bpjsnumbernewval' => ($crdtransbpjs) ? $crdtransbpjs->newvalue : null,
      'jamsosteknumbernewval' => ($crdtransjamsostek) ? $crdtransjamsostek->newvalue : null,
      'npwpfileolddoc' => ($crdtransnpwp) ? $crdtransnpwp->olddoc : null,
      'bpjsfileolddoc' => ($crdtransbpjs) ? $crdtransbpjs->olddoc : null,
      'jamsostekfileolddoc' => ($crdtransjamsostek) ? $crdtransjamsostek->olddoc : null,
      'npwpfilenewdoc' => ($crdtransnpwp) ? $crdtransnpwp->newdoc : null,
      'bpjsfilenewdoc' => ($crdtransbpjs) ? $crdtransbpjs->newdoc : null,
      'jamsostekfilenewdoc' => ($crdtransjamsostek) ? $crdtransjamsostek->newdoc : null,
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

  public function actionGetuserprofile()
  {

    $userid = $_POST['userid'];
    $id = $_POST['id'];
    if ($userid) {
      $model = Userprofile::find()->where(['userid' => $userid])->one();
      $document = Uploadocument::find()->where(['userid' => $userid])->one();
      $cekhiring = Hiring::find()->where(['userid' => $model->userid, 'statushiring' => 4])->one();
      $getjo = Transrincian::find()->where(['id' => $cekhiring->recruitreqid])->one();
      $updatecr = $this->findModel($id);
      $updatecr->userid = $userid;
      $updatecr->perner = $cekhiring->perner;
      $updatecr->fullname = $cekhiring->userprofile->fullname;
      $perner = $cekhiring->perner;
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
      $hire = "Gojobs";
      $updatecr->save();
      $crdtransnpwp = Crdtransaction::find()->where(['crdid' => $id, 'dataid' => 1])->one();
      $crdtransbpjs = Crdtransaction::find()->where(['crdid' => $id, 'dataid' => 2])->one();
      $crdtransjamsostek = Crdtransaction::find()->where(['crdid' => $id, 'dataid' => 3])->one();
      if ($model) {
        $dataprofile = [
          'perner' => $perner,
          'name' => $name,
          'persa' => $persa,
          'area' => $area,
          'skilllayanan' => $skilllayanan,
          'payrollarea' => $payrollarea,
          'jabatan' => $jabatan,
          'level' => $level,
          'hire' => $hire,
          'npwpnumber' => $model->npwpnumber,
          'bpjsnumber' => $model->bpjsnumber,
          'jamsosteknumber' => $model->jamsosteknumber,
          'npwpfile' => ($document) ? $document->npwp : null,
          'bpjsfile' => ($document) ? $document->bpjskesehatan : null,
          'jamsostekfile' => ($document) ? $document->jamsostek : null,
          'npwpnumbernewval' => ($crdtransnpwp) ? $crdtransnpwp->newvalue : null,
          'bpjsnumbernewval' => ($crdtransbpjs) ? $crdtransbpjs->newvalue : null,
          'jamsosteknumbernewval' => ($crdtransjamsostek) ? $crdtransjamsostek->newvalue : null,
          'npwpfilenewdoc' => ($crdtransnpwp) ? $crdtransnpwp->newdoc : null,
          'bpjsfilenewdoc' => ($crdtransbpjs) ? $crdtransbpjs->newdoc : null,
          'jamsostekfilenewdoc' => ($crdtransjamsostek) ? $crdtransjamsostek->newdoc : null,
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
    $approvalname = ArrayHelper::map(User::find()->where('role in(11,17,24,25)')->asArray()->all(), 'id', 'name');
    if ($id) {
      $model = $this->findModel($id);
      $crdtrans = Crdtransaction::find()->where(['crdid' => $id])->one();
      if ($crdtrans) {
        $model->personaldatafill = 1;
      }

      $namaquery = Hiring::find()
        // ->joinWith(['userprofile']) //comment by kaha 2/11/22 -> optimize loadtime
        ->joinWith(['changereqdata'])
        // add validasi hiring success & biodata update ke SAP success
        ->andWhere(['statushiring' => 4])
        ->andWhere(['statusbiodata' => 4])
        ->andWhere([
          'or',
          ['chagerequestdata.userid' => null],
          ['chagerequestdata.status' => 4],
          // ['chagerequestdata.status'=>5],
          ['hiring.userid' => $model->userid],
        ])->all();
      $name = array();
      foreach ($namaquery as $key => $value) {
        if ($value->changereqdata) {
          $checkdraft =  Chagerequestdata::find()
            ->andWhere(['userid' => $value->userid])
            ->andWhere(['kategorydata' => 1])
            ->andWhere([
              'or',
              ['status' => 1],
              ['status' => 6],
            ])
            ->count();
          //comment by kaha 2/11/22 -> optimize loadtime
          if ($value->userid == $model->userid || $value->changereqdata->kategorydata != 1) {
            $name[$value->userid] = $value->perner;
            // $name[$value->userid] = $value->userprofile->fullname.' / '.$value->perner;
          }
          if ($value->changereqdata->status == 4 && $checkdraft == 0) {
            $name[$value->userid] = $value->perner;
            //  $name[$value->userid] = $value->userprofile->fullname.' / '.$value->perner;
          }
        } else {
          $name[$value->userid] = $value->perner;
          //  $name[$value->userid] = $value->userprofile->fullname.' / '.$value->perner;
        }
      }
    } else {
      $getid = new Chagerequestdata();
      $getid->createtime = date('Y-m-d H-i-s');
      $getid->updatetime = date('Y-m-d H-i-s');
      $getid->createdby = Yii::$app->user->identity->id;
      $getid->updatedby = Yii::$app->user->identity->id;
      $getid->kategorydata = 1;
      $getid->save();
      return $this->redirect(['create', 'id' => $getid->id]);
    }
    $model->scenario = 'submit';
    if ($model->load(Yii::$app->request->post())) {
      $getjo = Hiring::find()->where(['userid' => $model->userid, 'statushiring' => 4])->one();
      $modelrecreq = Transrincian::find()->where(['id' => $getjo->recruitreqid])->one();
      $model->status = 2;
      // $model->perner = $getjo->perner;
      // $model->perner = $getjo->userprofile->fullname;
      if ($model->save()) {

        $userprofile = Userprofile::find()->where(['userid' => $model->userid])->one();
        $user = User::find()->where(['id' => $model->approvedby])->one();
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
        $to = $user->email;
        $subject = 'Notifikasi Approval Perubahan Data Pekerja';
        $body = Yii::$app->params['approvalData'];
        $body = str_replace('{creator}', $model->createduser->name, $body);
        $body = str_replace('{fullname}', $userprofile->fullname, $body);
        $body = str_replace('{perner}', $getjo->perner, $body);
        $body = str_replace('{layanan}', $layanan, $body);
        $body = str_replace('{area}', $area, $body);
        $body = str_replace('{jabatan}', $jabatan, $body);
        // send mail
        $verification = Yii::$app->utils->sendmail($to, $subject, $body, 20);
      }
      return $this->redirect(['index']);
    } else {
      return $this->render('create', [
        'model' => $model,
        'name' => $name,
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
  public function actionApprove($id, $userid)
  {
    $model = $this->findModel($id);
    $userid = $model->userid;
    $userprofile = Userprofile::find()->where(['userid' => $userid])->one();
    $document = Uploadocument::find()->where(['userid' => $userid])->one();
    $crdtransnpwp = Crdtransaction::find()->where(['crdid' => $id, 'dataid' => 1])->one();
    $crdtransbpjs = Crdtransaction::find()->where(['crdid' => $id, 'dataid' => 2])->one();
    $crdtransjamsostek = Crdtransaction::find()->where(['crdid' => $id, 'dataid' => 3])->one();
    $model->scenario = 'approve';
    if ($model->load(Yii::$app->request->post())) {
      if ($model->status == 4) {
        $updatesap = $this->UpdateSapPersonaldata($id, $userid);
        // var_dump($updatesap);die;
        if ($updatesap) {
          $model->remarks = $updatesap;
          $model->status = 6;
          $model->save();
        } else {
          $model->remarks = 'successful';
          $model->approvedtime = date('Y-m-d H-i-s');
          $model->save();
          if ($crdtransnpwp) {
            $userprofile->npwpnumber = $crdtransnpwp->newvalue;
            $userprofile->havenpwp = 1;
            $document->npwp = $crdtransnpwp->newdoc;
          }
          if ($crdtransjamsostek) {
            $userprofile->jamsosteknumber = $crdtransjamsostek->newvalue;
            $userprofile->havejamsostek = 1;
            $document->jamsostek = $crdtransjamsostek->newdoc;
          }
          if ($crdtransbpjs) {
            $userprofile->bpjsnumber = $crdtransbpjs->newvalue;
            $userprofile->havebpjs = 1;
            $document->bpjskesehatan = $crdtransbpjs->newdoc;
          }
          $userprofile->save(false);
          $document->save(false);
        }
      } else {
        $model->save();
      }

      // $model->save();
      return $this->redirect(['index']);
    } else {
      return $this->renderAjax('approve', [
        'model' => $model,
        'userprofile' => $userprofile,
        'document' => $document,
        'npwpnumberoldval' => ($crdtransnpwp) ? $crdtransnpwp->oldvalue : null,
        'bpjsnumberoldval' => ($crdtransbpjs) ? $crdtransbpjs->oldvalue : null,
        'jamsosteknumberoldval' => ($crdtransjamsostek) ? $crdtransjamsostek->oldvalue : null,
        'npwpnumbernewval' => ($crdtransnpwp) ? $crdtransnpwp->newvalue : null,
        'bpjsnumbernewval' => ($crdtransbpjs) ? $crdtransbpjs->newvalue : null,
        'jamsosteknumbernewval' => ($crdtransjamsostek) ? $crdtransjamsostek->newvalue : null,
        'npwpfileolddoc' => ($crdtransnpwp) ? $crdtransnpwp->olddoc : null,
        'bpjsfileolddoc' => ($crdtransbpjs) ? $crdtransbpjs->olddoc : null,
        'jamsostekfileolddoc' => ($crdtransjamsostek) ? $crdtransjamsostek->olddoc : null,
        'npwpfilenewdoc' => ($crdtransnpwp) ? $crdtransnpwp->newdoc : null,
        'bpjsfilenewdoc' => ($crdtransbpjs) ? $crdtransbpjs->newdoc : null,
        'jamsostekfilenewdoc' => ($crdtransjamsostek) ? $crdtransjamsostek->newdoc : null,
      ]);
    }
  }
  protected function UpdateSapPersonaldata($id, $userid)
  {
    $model = Hiring::find()->where(['userid' => $userid, 'statushiring' => 4])->one();
    $tglinputhiring = date_create($model->tglinput);
    $tglinput = date_format($tglinputhiring, 'd.m.Y');
    $modelcr = $this->findModel($id);
    $userprofile = Userprofile::find()->where(['userid' => $userid])->one();
    $crdtransnpwp = Crdtransaction::find()->where(['crdid' => $id, 'dataid' => 1])->one();
    $crdtransbpjs = Crdtransaction::find()->where(['crdid' => $id, 'dataid' => 2])->one();
    $crdtransjamsostek = Crdtransaction::find()->where(['crdid' => $id, 'dataid' => 3])->one();
    $url = "http://192.168.88.60:8080/ish-rest/ZINFHRF_00025";
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
    if ($userprofile->maritalstatus == 'single') {
      $marrd = '';
      $marst = '';
    } else {
      $marrd = 'X';
      $marst = 'X';
    }
    $npwpval = null;
    $jamsostekval = null;
    $bpjsval = null;
    $infotypenpwp = [];
    $infotypejamsostek = [];
    $infotypebpjs = [];
    if ($crdtransnpwp) {
      $infotypenpwp = ['0241'];
      $npwpval = $crdtransnpwp->newvalue;
    }
    if ($crdtransjamsostek) {
      $infotypejamsostek = ['0242'];
      $jamsostekval = $crdtransjamsostek->newvalue;
    }
    if ($crdtransbpjs) {
      $infotypebpjs = ['0037'];
      $bpjsval = $crdtransbpjs->newvalue;
    }
    $infotype = array_merge($infotypenpwp, $infotypejamsostek, $infotypebpjs);
    $request_data = [
      [
        'pernr' => "$model->perner",
        'inftypList' => $infotype,
        //01  no ktp, 02  sim a, 03  sim b, 04  sim c, 05  nik, 06  agent id, 07  passport, 08  virtual bpjs, 09  kartu keluarga, 80  application id

        'p00241List' => [
          [
            'endda' => '31.12.9999',
            'begda' => $tglinput,
            'operation' => 'INS',
            'pernr' => "$model->perner",
            'infty' => '0241',
            'taxid' => $npwpval, //validasi max character 15
            'marrd' => $marrd,
            'spben' => $spben,
            'depnd' => 'f',
            'rdate' => ''
          ]
        ],
        'p00242List' => [
          [
            'endda' => '31.12.9999',
            'begda' => $tglinput,
            'operation' => 'INS',
            'pernr' => "$model->perner",
            'infty' => '0242',
            'jamid' => $jamsostekval, //validasi max character 11
            'marst' => $marst
          ]
        ],
        'p00037List' => [
          [
            'endda' => '31.12.9999',
            'begda' => $tglinput,
            'operation' => 'INS',
            'pernr' => "$model->perner",
            'infty' => '0037',
            'subty' => "0016",
            'vsart' => "0016",
            'vsges' => "11",
            'vsnum' => $bpjsval, //validasi max character 11
            'waers' => "IDR"
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
      $log = 'error SAP';
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
