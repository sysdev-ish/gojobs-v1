<?php

namespace app\controllers;

use Yii;
use app\models\Chagerequestresign;
use app\models\Chagerequestresignsearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Hiring;
use app\models\Userprofile;
use app\models\Transrincian;
use app\models\Userabout;
use app\models\User;
use app\models\Masterresignreason;
use app\models\Recruitmentcandidate;
use yii\helpers\ArrayHelper;
use linslin\yii2\curl;
use yii\helpers\Json;

/**
 * ChagerequestresignController implements the CRUD actions for Chagerequestresign model.
 */
class ChagerequestresignController extends Controller
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
              return (Yii::$app->utils->permission(Yii::$app->user->identity->role, 'm67'));
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
   * Lists all Chagerequestresign models.
   * @return mixed
   */
  public function actionIndex()
  {
    $searchModel = new Chagerequestresignsearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Displays a single Chagerequestresign model.
   * @param integer $id
   * @return mixed
   */
  public function actionView($id)
  {
    return $this->renderAjax('view', [
      'model' => $this->findModel($id),
    ]);
  }

  /**
   * Creates a new Chagerequestresign model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate($id = null)
  {
    $approvalname = ArrayHelper::map(User::find()->where('role = 20 OR role = 17')->asArray()->all(), 'id', 'name');
    $reason = ArrayHelper::map(Masterresignreason::find()->asArray()->all(), 'id', 'reason');
    if ($id) {
      $model = $this->findModel($id);
    } else {
      $getid = new Chagerequestresign();
      $getid->createtime = date('Y-m-d H-i-s');
      $getid->updatetime = date('Y-m-d H-i-s');
      $getid->createdby = Yii::$app->user->identity->id;
      $getid->updatedby = Yii::$app->user->identity->id;
      $getid->save(false);
      return $this->redirect(['create', 'id' => $getid->id]);
    }
    $model->scenario = 'createupdate';
    if ($model->load(Yii::$app->request->post())) {
      $model->status = 2;
      if ($model->save()) {
        $user = User::find()->where(['id' => $model->approvedby])->one();
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
          $curl = new curl\Curl();
          //change by kaha 21/02/23
          $getdatapekerjabyperner =  $curl->setPostParams([
            'perner' => $model->perner,
            'token' => 'ish**2019',
          ])
            ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerjaall');
          $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
          $name = $datapekerjabyperner[0]->CNAME;
          $perner = $model->perner;
          $layanan = $datapekerjabyperner[0]->WKTXT;
          $area = $datapekerjabyperner[0]->BTRTX;
          $jabatan = $datapekerjabyperner[0]->PLATX;
        }
        $to = $user->email;
        // $to = "khusnul.hisyam@ish.co.id";
        $subject = 'Notifikasi Approval Resign Pekerja';
        $body = Yii::$app->params['approvalResign'];
        $body = str_replace('{creator}', $model->createduser->name, $body);
        $body = str_replace('{fullname}', $name, $body);
        $body = str_replace('{perner}', $perner, $body);
        $body = str_replace('{layanan}', $layanan, $body);
        $body = str_replace('{area}', $area, $body);
        $body = str_replace('{jabatan}', $jabatan, $body);
        $body = str_replace('{reason}', $model->resignreason->reason, $body);

        // send mail
        $verification = Yii::$app->utils->sendmail($to, $subject, $body, 12);
      }
      return $this->redirect(['index']);
    } else {
      return $this->render('create', [
        'model' => $model,
        'approvalname' => $approvalname,
        'reason' => $reason,
      ]);
    }
  }

  public function actionApprove($id, $userid)
  {
    $model = $this->findModel($id);
    $userid = $model->userid;
    $userprofile = Userprofile::find()->where(['userid' => $userid])->one();
    $model->scenario = 'approve';
    if ($model->load(Yii::$app->request->post())) {
      $model->approvedtime = date('Y-m-d H-i-s');
      if ($model->status == 8) {
        if ($model->resigndate < date('Y-m-d')) {
          $model->remarks = "Process Resign";
        } else {
          $model->remarks = "Waiting for Resign Execution process";
        }
        $model->save();
      } else {
        $model->save();
      }
      //session for alert
      Yii::$app->session->setFlash('success', "On process.");
      return $this->redirect(['index']);
    } else {
      return $this->renderAjax('_formapprove', [
        'model' => $model,
        'userprofile' => $userprofile,
      ]);
    }
  }

  public function actionRfcresign($id)
  {
    $model = $this->findModel($id);
    // var_dump($model);die;
    $curl = new curl\Curl();
    $getdatapekerja = $curl->setPostParams([
      'perner' => $model->perner,
      'token' => 'ish**2019',
    ])
      ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerjaall');
    $dataprofile  = json_decode($getdatapekerja);
    // var_dump($dataprofile);die();
    if ($dataprofile) {
      if ($dataprofile[0]->MASSN !== 'Z8') {
        $begda = date_create($model->resigndate);
        $cekpaycontroll =  $curl->setPostParams([
          'token' => 'ish@2019!',
          'ABKRS' => $dataprofile[0]->ABKRS,
        ])
          ->post('http://192.168.88.5/service/index.php/Rfccekpayrollcontroll');
        $payrollcontrollresult  = json_decode($cekpaycontroll);
        if ($payrollcontrollresult->status == 1) {
          // $cek = [
          //   'token' => 'ish@2019!',
          //   'PERNR' => $model->perner,
          //   'BEGDA' => date_format($begda,'Ymd'),
          //   'MASSG' => $model->resignreason->sapid,
          //   'WERKS' => $dataprofile[0]->WERKS,
          //   'PERSK' => $dataprofile[0]->PERSK,
          //   'BTRTL' => $dataprofile[0]->BTRTL,
          //   'ABKRS' => $dataprofile[0]->ABKRS,
          //   'ANSVH' => $dataprofile[0]->ANSVH,
          //   'PLANS' => $dataprofile[0]->PLANS,
          // ];
          // var_dump($cek);die();
          $putrfcresign =  $curl->setPostParams([
            'token' => 'ish@2019!',
            'PERNR' => $model->perner,
            'BEGDA' => date_format($begda, 'Ymd'),
            'MASSG' => $model->resignreason->sapid,
            'WERKS' => $dataprofile[0]->WERKS,
            'PERSK' => $dataprofile[0]->PERSK,
            'BTRTL' => $dataprofile[0]->BTRTL,
            'ABKRS' => $dataprofile[0]->ABKRS,
            'ANSVH' => $dataprofile[0]->ANSVH,
            'PLANS' => $dataprofile[0]->PLANS,
          ])
            ->post('http://192.168.88.5/service/index.php/Rfcresign');
          // var_dump($putrfcresign);die();
  
          $rfcresign  = json_decode($putrfcresign);
          $message = 'successful';
          if ($rfcresign->CODE == 'S') {
            $url = "http://192.168.88.60:8080/ish-rest/ZINFHRF_00025";
            $infotype = ['0041', '0035'];
            $request_data = [
              [
                'pernr' => "$model->perner",
                'inftypList' => $infotype,
                'p00041List' => [
                  [
                    'endda' => '',
                    'begda' => '',
                    'operation' => 'INS',
                    'pernr' => "$model->perner",
                    'infty' => '0041',
                    'dar01' => '01',
                    'dat01' => '',
                    'dar02' => '',
                    'dat02' => ''
                  ]
                ],
  
                'p00035List' => [
                  [
                    'endda' => '31.12.9999',
                    'begda' => date_format($begda, 'd.m.Y'),
                    'operation' => 'INS',
                    'pernr' => "$model->perner",
                    'infty' => '0035',
                    'subty' => 'Z8',
                    'itxex' => 'X',
                    'dat35' => date_format($begda, 'd.m.Y'),
                  ]
                ],
              ]
            ];
  
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
  
            $response = curl_exec($ch);
  
            curl_close($ch);
            $ret = json_decode($response);
            $log = array();
            foreach ($ret as $key => $value) {
              if ($value->success != 1) {
                $log  = $value->message;
              }
            }
            if ($log) {
              $message = $log;
              $model->remarks = $message;
              $model->status = 7;
              $model->save(false);
              $retpos = ['status' => "OK", 'message' => $message];
              print_r(json_encode($retpos));
            } else {
              $message = "successful";
              $model->remarks = $message;
              $model->status = 4;
              $model->save(false);
              $retpos = ['status' => "OK", 'message' => $message];
              $hiring = Hiring::find()->where(['perner' => $model->perner, 'statushiring' => 4])->one();
              if ($hiring) {
                $recruitmentcandidate = Recruitmentcandidate::find()->where(['userid' => $model->userid, 'recruitreqid' => $hiring->recruitreqid])->one();
                $hiring->statushiring = 7;
                $recruitmentcandidate->status = 26;
                $hiring->save(false);
                $recruitmentcandidate->save(false);
              }
              print_r(json_encode($retpos));
            }
          } else {
            $message = $rfcresign->MESSAGE;
            $model->remarks = $message;
            $model->status = 7;
            $model->save(false);
            $retpos = ['status' => "OK", 'message' => $message];
            print_r(json_encode($retpos));
          }
        } else {
          // $message = $rfcresign->MESSAGE;
          $model->remarks = 'You have already locked payroll controll';
          $model->status = 7;
          $model->save(false);
          $retpos = ['status' => "NOK", 'message' => 'lock'];
          print_r(json_encode($retpos));
        }
      } else {
        // $message = $rfcresign->MESSAGE;
        $model->remarks = 'Data pekerja sudah tidak ada di SAP atau sudah di resign kan';
        $model->status = 4;
        $model->save(false);
        $hiring = Hiring::find()->where(['perner' => $model->perner, 'statushiring' => 4])->one();
        if ($hiring) {
          $recruitmentcandidate = Recruitmentcandidate::find()->where(['userid' => $model->userid, 'recruitreqid' => $hiring->recruitreqid])->one();
          $hiring->statushiring = 7;
          $recruitmentcandidate->status = 26;
          $hiring->save(false);
          $recruitmentcandidate->save(false);
        }
        $retpos = ['status' => "NOK", 'message' => 'Data pekerja sudah tidak ada di SAP atau sudah di resign kan'];
        print_r(json_encode($retpos));
      }
    } else {
      $model->remarks = 'Data pekerja sudah tidak ditemukan';
      $model->status = 10;
      $model->save(false);
      $hiring = Hiring::find()->where(['perner' => $model->perner, 'statushiring' => 4])->one();
      if ($hiring) {
        $recruitmentcandidate = Recruitmentcandidate::find()->where(['userid' => $model->userid, 'recruitreqid' => $hiring->recruitreqid])->one();
        $hiring->statushiring = 6;
        $recruitmentcandidate->status = 24;
        $hiring->save(false);
        $recruitmentcandidate->save(false);
      }
      $retpos = ['status' => "NOK", 'message' => 'Data pekerja sudah tidak ditemukan'];
      print_r(json_encode($retpos));
    }
  }

  public function actionCronresign($id)
  {
    $model = $this->findModel($id);
    if ($model->status == 7) {
      $curl = new curl\Curl();
      $getdatapekerja = $curl->setPostParams([
        'perner' => $model->perner,
        'token' => 'ish**2019',
      ])
        ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerja');
      $dataprofile  = json_decode($getdatapekerja);
      if ($dataprofile) {
        $begda = date_create($model->resigndate);
        $cekpaycontroll =  $curl->setPostParams([
          'token' => 'ish@2019!',
          'ABKRS' => $dataprofile[0]->ABKRS,
        ])
          ->post('http://192.168.88.5/service/index.php/Rfccekpayrollcontroll');
        $payrollcontrollresult  = json_decode($cekpaycontroll);
        if ($payrollcontrollresult->status == 1) {

          $putrfcresign =  $curl->setPostParams([
            'token' => 'ish@2019!',
            'PERNR' => $model->perner,
            'BEGDA' => date_format($begda, 'Ymd'),
            'MASSG' => $model->resignreason->sapid,
            'WERKS' => $dataprofile[0]->WERKS,
            'PERSK' => $dataprofile[0]->PERSK,
            'BTRTL' => $dataprofile[0]->BTRTL,
            'ABKRS' => $dataprofile[0]->ABKRS,
            'ANSVH' => $dataprofile[0]->ANSVH,
            'PLANS' => $dataprofile[0]->PLANS,
          ])
            ->post('http://192.168.88.5/service/index.php/Rfcresign');
  
          $rfcresign  = json_decode($putrfcresign);
          $message = 'successful';
          if ($rfcresign->CODE == 'S') {
            $url = "http://192.168.88.60:8080/ish-rest/ZINFHRF_00025";
            $infotype = ['0041', '0035'];
            $request_data = [
              [
                'pernr' => "$model->perner",
                'inftypList' => $infotype,
                'p00041List' => [
                  [
                    'endda' => '',
                    'begda' => '',
                    'operation' => 'INS',
                    'pernr' => "$model->perner",
                    'infty' => '0041',
                    'dar01' => '01',
                    'dat01' => '',
                    'dar02' => '',
                    'dat02' => ''
                  ]
                ],
  
                'p00035List' => [
                  [
                    'endda' => '31.12.9999',
                    'begda' => date_format($begda, 'd.m.Y'),
                    'operation' => 'INS',
                    'pernr' => "$model->perner",
                    'infty' => '0035',
                    'subty' => 'Z8',
                    'itxex' => 'X',
                    'dat35' => date_format($begda, 'd.m.Y'),
                  ]
                ],
              ]
            ];
  
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

            $response = curl_exec($ch);
  
            curl_close($ch);
            $ret = json_decode($response);
            $log = array();
            foreach ($ret as $key => $value) {
              if ($value->success != 1) {
                $log  = $value->message;
              }
            }
            if ($log) {
              $message = $log;
              $model->remarks = $message;
              $model->status = 7;
              $model->save(false);
              $retpos = ['status' => "OK", 'message' => $message];
              print_r(json_encode($retpos));
            } else {
              $message = "successful";
              $model->remarks = $message;
              $model->status = 4;
              $model->save(false);
              $retpos = ['status' => "OK", 'message' => $message];
              $hiring = Hiring::find()->where(['perner' => $model->perner, 'statushiring' => 4])->one();
              if ($hiring) {
                $recruitmentcandidate = Recruitmentcandidate::find()->where(['userid' => $model->userid, 'recruitreqid' => $hiring->recruitreqid])->one();
                $hiring->statushiring = 7;
                $recruitmentcandidate->status = 26;
                $hiring->save(false);
                $recruitmentcandidate->save(false);
              }
              print_r(json_encode($retpos));
            }
          } else {
            $message = $rfcresign->MESSAGE;
            $model->remarks = $message;
            $model->status = 7;
            $model->save(false);
            $retpos = ['status' => "OK", 'message' => $message];
            print_r(json_encode($retpos));
          }
        } else {
          // $message = $rfcresign->MESSAGE;
          $model->remarks = 'You have already locked payroll controll';
          $model->status = 7;
          $model->save(false);
          $retpos = ['status' => "NOK", 'message' => 'lock'];
          print_r(json_encode($retpos));
        }
      } else {
        // $message = $rfcresign->MESSAGE;
        $model->remarks = 'Data pekerja sudah tidak ada di SAP atau sudah di resign kan';
        $model->status = 4;
        $model->save(false);
        $hiring = Hiring::find()->where(['perner' => $model->perner, 'statushiring' => 4])->one();
        if ($hiring) {
          $recruitmentcandidate = Recruitmentcandidate::find()->where(['userid' => $model->userid, 'recruitreqid' => $hiring->recruitreqid])->one();
          $hiring->statushiring = 7;
          $recruitmentcandidate->status = 26;
          $hiring->save(false);
          $recruitmentcandidate->save(false);
        }
        $retpos = ['status' => "NOK", 'message' => 'Data pekerja sudah tidak ada di SAP atau sudah di resign kan'];
        print_r(json_encode($retpos));
      }
    } else {
      $retpos = ['status' => "NOK", 'message' => 'Successfull resign'];
      print_r(json_encode($retpos));      
    }
  }

  /**
   * Updates an existing Chagerequestresign model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   */

  public function actionGetdatakaryawan($q = null, $id = null)
  {
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    // var_dump($id);die;
    $outs = ['results' => ['id' => '', 'text' => '']];
    if (!is_null($q)) {
      $wherecontent = $q;
      //change by kaha 21/02/23
      $curl = new curl\Curl();
      $getdatapekerja = $curl->setPostParams([
        'q' => $q,
        'token' => 'ish**2019',
      ])
        ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerjaall');
      $datapekerja  = json_decode($getdatapekerja);
      // var_dump($datapekerja);die;
      $out = null;
      foreach ($datapekerja as $key => $value) {
        $out[] = $value;
        // $out['results'] = $value['jobfunc']['name_job_function'];
      }
      if ($out) {
        $outs['results'] = $out;
      } else {
        $outs['results'] = null;
      }
    } elseif ($id > 0) {

      $getdatapekerjabyperner =  $curl->setPostParams([
        'perner' => $id,
        'token' => 'ish**2019',
      ])
        ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerjaall');
      $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
      $outs['results'] = ['id' => $id, 'text' => $datapekerjabyperner];
    } else {

      $outs['results'] = ['id' => ' ', 'text' => ' '];
    }
    return $outs;
  }

  public function actionUpdate($id)
  {
    return $this->redirect(['create', 'id' => $id]);
  }

  public function actionGetuserabout()
  {

    $perner = $_POST['perner'];
    $id = $_POST['id'];
    $updatecr = $this->findModel($id);
    if ($perner) {
      $cekhiring = Hiring::find()->where(['perner' => $perner, 'statushiring' => 4])->one();
      if ($cekhiring) {
        $getjo = Transrincian::find()->where(['id' => $cekhiring->recruitreqid])->one();
        $model = Userabout::find()->where(['userid' => $cekhiring->userid])->one();
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
        $hire = "Gojobs";
        $updatecr->fullname = $name;
        $updatecr->perner = $cekhiring->perner;
        $status = $cekhiring->statushiring0->statusname;
        $hiringdate = $cekhiring->tglinput;
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
        $hire = 'Non Gojobs';
        $status = $datapekerjabyperner[0]->MASSN;
        $flagreason = $datapekerjabyperner[0]->MASSG;
        $updatecr->fullname = $name;
        if ($datapekerjabyperner[0]->DAT35) {
          $year = substr($datapekerjabyperner[0]->DAT35, 0, 4);
          $month = substr($datapekerjabyperner[0]->DAT35, 4, 2);
          $date = substr($datapekerjabyperner[0]->DAT35, 6, 2);
          $hiringdate = $year . "-" . $month . "-" . $date;
        } else {
          $hiringdate = "";
        }
      }

      $checkperner = Chagerequestresign::find()->where('perner = ' . $perner . ' and status > 1 and status <> 5 and status <> 6 and status <> 4 and status <> 10')->one();
      //add by kaha 21/02/23      
      if ($status == "Z8") {
        $resignreason = $datapekerjabyperner[0]->MSGTX;
        if ($datapekerjabyperner[0]->DAT35) {
          $year = substr($datapekerjabyperner[0]->DAT35, 0, 4);
          $month = substr($datapekerjabyperner[0]->DAT35, 4, 2);
          $date = substr($datapekerjabyperner[0]->DAT35, 6, 2);
          $resigndate = $year . "-" . $month . "-" . $date;
          $updatecr->resigndate = $resigndate;
        } else {
          $resigndate = "";
        }
        // var_dump($resigndate);die();
        $updatecr->reason = $flagreason;
      } else {
        $resigndate = "";
        $resignreason = "";
      } 

      if ($checkperner) {
        $checkperner = '';
      } else {
        $checkperner = 1;
        $updatecr->save(false);
      }

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
        'checkperner' => $checkperner,
        'hiring_status' => $status,
        'resign_reason' => $resignreason,
        'resign_date' => $resigndate,
        'hiring_date' => $hiringdate
      ];
    } else {
      $dataprofile = '';
    }
    return Json::encode($dataprofile);
  }

  public function actionAutosave()
  {
    $id = $_POST['id'];
    $approvedby = $_POST['approvedby'];
    $resigndate = $_POST['resigndate'];
    $reason = $_POST['reason'];
    $userremarks = $_POST['userremarks'];
    // var_dump($resigndate);die;
    if ($id) {
      $model = $this->findModel($id);
      $model->approvedby = $approvedby;
      $model->resigndate = $resigndate;
      $model->reason = $reason;
      $model->remarks = "draft";
      $model->userremarks = $userremarks;
      $model->save(false);
    }
  }

  public function actionBulkapprove()
  {
    $this->enableCsrfValidation = false;

    $userIds = [];
    $id = null;
    if (isset($_GET['id'])) {
      //get data from gojobs.js -> selected field from the table
      $userIds = $_GET['id'];
      $id = Chagerequestresign::find()->where('id IN (' . implode(',', $userIds) . ')', [])->all();

      $count = 0;
      $model = null;

      foreach ($id as $loadmodel) {
        $model = $this->findModel($loadmodel->id);
        if ($model->load(Yii::$app->request->post())) {
          $model->approvedtime = date('Y-m-d H-i-s');
          if ($model->status == 8) {
            $model->remarks = "Waiting for Resign Execution process";
            $model->save();
          }
          $model->save();
          $count++;
          if ($count == count($id)) {
            Yii::$app->session->setFlash('success', "Waiting for Resign Execution process.");
            return $this->redirect(['index']);
          }
        } else {
          return $this->renderAjax('_formbulkapprove', [
            'model' => $model,
            'id' => $id,
          ]);
        }
      }
    }
  }


  //add by kaha 13/6/23
  public function actionUpload()
  {
    $model = new Chagerequestresign();
    $uploadIdentifier = $this->user->id . '-' . Yii::$app->utils->generateRandomString(3) . '-' . time();
    $uploadData = null;
    $uploadDataFirstRow = '';

    return $this->render('upload', [
      'model' => $model,
      'uploadIdentifier' => $uploadIdentifier,
      'uploadData' => $uploadData,
      'uploadDataFirstRow' => $uploadDataFirstRow,
    ]);
  }

  //add by kaha 13/6/23
  public function actionUploaddo()
  {
    $user = User::findOne($this->user->id);
    $ret = array(
      'fileName' => null,
      'fileRealName' => null,
      'fileSize' => null,
      'countData' => 0,
      'ok' => 0,
    );
    $allowedMimeTypes = explode(',', $this->module->param->get('dataUploadMimes'));
    $allowedExtensions = explode(',', $this->module->param->get('dataUploadExtensions'));

    if (isset($_POST['identifier']) && isset($_FILES['Store'])) {
      $identifier = $_POST['identifier'];
      $filePost = array(
        'name' => $_FILES['Store']['name']['file_upload'],
        'type' => $_FILES['Store']['type']['file_upload'],
        'tmpName' => $_FILES['Store']['tmp_name']['file_upload'],
        'error' => $_FILES['Store']['error']['file_upload'],
        'size' => $_FILES['Store']['size']['file_upload'],
      );

      $mimeType = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $filePost['tmpName']);
      if (in_array($mimeType, $allowedMimeTypes)) {
        $dirAbs = Yii::getAlias('@webroot') . $this->module->param->get('dataUploadDir');
        $dirRel = Yii::getAlias('@web') . $this->module->param->get('dataUploadDir');

        $phpExe = Yii::getAlias('@app') . '/yii';

        // Copy file
        $fileNames = explode('.', $filePost['name']);
        $ext = strtolower($fileNames[count($fileNames) - 1]);
        if (in_array($ext, $allowedExtensions)) {
          if ($ext == 'txt') $ext = 'csv';
          $destFile = $dirAbs . '/' . $identifier . '.' . $ext;
          move_uploaded_file($filePost['tmpName'], $destFile);

          $phpCommand = 'php ' . $phpExe . ' uploadstore ' . $destFile . ' ' . $user->id;
          $shell = shell_exec($phpCommand);
          $shell = json_decode($shell, true);

          $ret['fileName'] = $filePost['name'];
          $ret['fileRealName'] = $identifier . '.' . $ext;
          $ret['fileSize'] = $this->module->util->formatBytes($filePost['size']);
          $ret['countData'] = isset($shell['countData']) ? $shell['countData'] : 0;
          $ret['firstDataRow'] = isset($shell['firstRow']) ? $shell['firstRow'] : '';
          if ($ret['countData'] > 0) $ret['ok'] = 1;
          else $ret['ok'] = 0;
        }
      }
    }

    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    return $ret;
  }
  
  /**
   * Deletes an existing Chagerequestresign model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   */
  public function actionDelete($id)
  {
    $model = $this->findModel($id);
    try {
      if ($model->delete()) {
        Yii::$app->session->setFlash('success', "Data Dihapus.");
      }
      // else {
      //     Yii::$app->session->setFlash('error', "Data Digunakan Di Tabel Lain.");
      // }
    } catch (\Exception $e) {
      Yii::$app->session->setFlash('error', "Data Digunakan Di Tabel Lain.");
    }

    return $this->redirect(['index']);
  }

  /**
   * Finds the Chagerequestresign model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Chagerequestresign the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Chagerequestresign::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }
}
