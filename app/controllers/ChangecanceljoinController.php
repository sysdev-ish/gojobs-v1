<?php

namespace app\controllers;

use Yii;
use app\models\Changecanceljoin;
use app\models\Changecanceljoinsearch;
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
use linslin\yii2\curl\Curl as CurlCurl;
use yii\helpers\Json;

/**
 * ChangecanceljoinController implements the CRUD actions for Changecanceljoin model.
 */
class ChangecanceljoinController extends Controller
{
  /**
   * @inheritdoc
   */
  public function behaviors()
  {
    return [
        'access' => [
            'class' => AccessControl::className(),
            'only' => ['index','update','create','view','delete'],
            'rules' => [
              [
                  'actions' => ['index','update','create','view','delete'],
                  'allow' => true,
                  'roles' => ['@'],
                  'matchCallback'=>function(){
                      return (Yii::$app->utils->permission(Yii::$app->user->identity->role,'m67'));
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
   * Lists all Changecanceljoin models.
   * @return mixed
   */
  public function actionIndex()
  {
      $searchModel = new Changecanceljoinsearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('index', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
      ]);
  }

  /**
   * Displays a single Changecanceljoin model.
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
   * Creates a new Changecanceljoin model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate($id = null)
  {
      // $approvalname = ArrayHelper::map(User::find()->where('role = 20 OR role = 17')->asArray()->all(), 'id', 'name');
      $approvalname = ArrayHelper::map(User::find()->where('role')->asArray()->all(), 'id', 'name');
      $reason = ArrayHelper::map(Masterresignreason::find()->asArray()->all(), 'id', 'reason');
      if($id){
        $model = $this->findModel($id);
      }else{
        $getid = new Changecanceljoin();
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
          if($model->save()){
              $user = User::find()->where(['id'=>$model->approvedby])->one();
            if($model->userid){
              $getjo = Hiring::find()->where(['userid'=>$model->userid, 'statushiring'=>4])->one();

              $modelrecreq = Transrincian::find()->where(['id'=>$getjo->recruitreqid])->one();
              $userprofile = Userprofile::find()->where(['userid'=>$model->userid])->one();

              $name = $userprofile->fullname;
              $perner = $getjo->perner;
              if ($modelrecreq->transjo->n_project == "" || $modelrecreq->transjo->n_project == "Pilih"){
                $layanan = $modelrecreq->transjo->project;
              }else{
                $layanan = $modelrecreq->transjo->n_project;
              }
              if(Yii::$app->utils->getarea($modelrecreq->area_sap)){
                $area = Yii::$app->utils->getarea($modelrecreq->area_sap);
              }else{
                $area = '-';
              }
              if(Yii::$app->utils->getjabatan($modelrecreq->hire_jabatan_sap)){
                $jabatan = Yii::$app->utils->getjabatan($modelrecreq->hire_jabatan_sap);
              }else{
                $jabatan = '-';
              }
            }else{
              $curl = new curl\Curl();
              $getdatapekerjabyperner =  $curl->setPostParams([
                'perner' => $model->perner,
                'token' => 'ish**2019',
              ])
              ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerja');
              $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
              $name = $datapekerjabyperner[0]->CNAME;
              $perner = $model->perner;
              $layanan = $datapekerjabyperner[0]->WKTXT;
              $area = $datapekerjabyperner[0]->BTRTX;
              $jabatan = $datapekerjabyperner[0]->PLATX;
            }
            $to = $user->email;
            // $to = "indra.gunawan@ish.co.id";
            $subject = 'Notifikasi Approval Resign Pekerja';
            $body = 'Semangat Pagi,,
            <br>
            Anda mendapatkan permintaan Approval "Resign Pekerja" dari <span style="text-transform: uppercase;"><b>'.$model->createduser->name.'</b></span> dengan rincian sebagai berikut :

            <br>
            <br>
            <table>
            <tr>
            <td valign="top">Nama Pekerja</td>
            <td valign="top">:</td>
            <td valign="top">'.$name.'</td>
            </tr>
            <tr>
            <td valign="top">Perner</td>
            <td valign="top">:</td>
            <td valign="top">'.$perner.'</td>
            </tr>
            <tr>
            <td valign="top">Nama Project</td>
            <td valign="top">:</td>
            <td valign="top">'.$layanan.'</td>
            </tr>
            <tr>
            <td valign="top">Area</td>
            <td valign="top">:</td>
            <td valign="top">'.$area.'</td>
            </tr>
            <tr>
            <td valign="top">Jabatan</td>
            <td valign="top">:</td>
            <td valign="top">'.$jabatan.'</td>
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
            $verification = Yii::$app->utils->sendmail($to,$subject,$body,12);
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
    $userprofile = Userprofile::find()->where(['userid'=>$userid])->one();
    $model->scenario = 'approve';
    if ($model->load(Yii::$app->request->post())) {
      $model->approvedtime = date('Y-m-d H-i-s');
      if($model->status == 8){
          $model->remarks = "Waiting for Resign Execution process";
          $model->save();
      }else{
        $model->save();
      }

      // $model->save();
      return $this->redirect(['index']);
    }else{
      return $this->renderAjax('_formapprove', [
          'model' => $model,
          'userprofile'=>$userprofile,
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
          ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerja');
          $dataprofile  = json_decode($getdatapekerja);
          if($dataprofile){
            $begda = date_create($model->resigndate);
            $cekpaycontroll =  $curl->setPostParams([
              'token' => 'ish@2019!',
              'ABKRS' => $dataprofile[0]->ABKRS,
            ])
            ->post('http://192.168.88.5/service/index.php/Rfccekpayrollcontroll');
            $payrollcontrollresult  = json_decode($cekpaycontroll);
            if($payrollcontrollresult->status == 1){
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
              // var_dump($cek);die;
              $putrfcresign =  $curl->setPostParams([
                'token' => 'ish@2019!',
                'PERNR' => $model->perner,
                'BEGDA' => date_format($begda,'Ymd'),
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
              if($rfcresign->CODE == 'S'){
                $url = "http://192.168.88.60:8080/ish-rest/ZINFHRF_00025";
                $infotype = ['0041','0035'];
                $request_data = [
                  [
                    'pernr'=> "$model->perner",
                    'inftypList'=>$infotype,
                    'p00041List' => [
                      [
                        'endda'=>'',
                        'begda'=> '',
                        'operation'=>'INS',
                        'pernr'=> "$model->perner",
                        'infty'=>'0041',
                        'dar01'=> '01',
                        'dat01'=> '',
                        'dar02'=> '',
                        'dat02'=> ''
                      ]
                    ],

                    'p00035List'=>[
                      [
                        'endda'=>'31.12.9999',
                        'begda'=> date_format($begda,'d.m.Y'),
                        'operation'=>'INS',
                        'pernr'=> "$model->perner",
                        'infty'=>'0035',
                        'subty'=>'Z8',
                        'itxex'=>'X',
                        'dat35'=> date_format($begda,'d.m.Y'),
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
                $log = array();
                foreach ($ret as $key => $value) {
                  if ($value->success != 1){
                    $log  = $value->message;
                  }
                }
                if($log){
                  $message = $log;
                  $model->remarks = $message;
                  $model->status = 7;
                  $model->save(false);
                  $retpos = ['status'=>"OK",'message'=>$message];
                  print_r(json_encode($retpos));
                }else{
                  $message = "successful";
                  $model->remarks = $message;
                  $model->status = 4;
                  $model->save(false);
                  $retpos = ['status'=>"OK",'message'=>$message];
                  $hiring = Hiring::find()->where(['perner'=>$model->perner,'statushiring'=>4])->one();
                  if($hiring){
                    $recruitmentcandidate = Recruitmentcandidate::find()->where(['userid'=>$model->userid,'recruitreqid'=>$hiring->recruitreqid])->one();
                    $hiring->statushiring = 7;
                    $recruitmentcandidate->status = 26;
                    $hiring->save(false);
                    $recruitmentcandidate->save(false);
                  }
                  print_r(json_encode($retpos));
                }


              }else{
                $message = $rfcresign->MESSAGE;
                $model->remarks = $message;
                $model->status = 7;
                $model->save(false);
                $retpos = ['status'=>"OK",'message'=>$message];
                print_r(json_encode($retpos));
              }
            }else{
              // $message = $rfcresign->MESSAGE;
              $model->remarks = 'You have already locked payroll controll';
              $model->status = 7;
              $model->save(false);
              $retpos = ['status'=>"NOK",'message'=>'lock'];
              print_r(json_encode($retpos));
            }

          }else{
            // $message = $rfcresign->MESSAGE;
            $model->remarks = 'data pekerja sudah tidak ada di sap profile 1 atau sudah di resign kan';
            $model->status = 4;
            $model->save(false);
            $hiring = Hiring::find()->where(['perner'=>$model->perner,'statushiring'=>4])->one();
            if($hiring){
              $recruitmentcandidate = Recruitmentcandidate::find()->where(['userid'=>$model->userid,'recruitreqid'=>$hiring->recruitreqid])->one();
              $hiring->statushiring = 7;
              $recruitmentcandidate->status = 26;
              $hiring->save(false);
              $recruitmentcandidate->save(false);
            }
            $retpos = ['status'=>"NOK",'message'=>'data pekerja sudah tidak ada di sap profile 1 atau sudah di resign kan'];
            print_r(json_encode($retpos));
          }


  }

  /**
   * Updates an existing Changecanceljoin model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   */

    public function actionGetdatakaryawan($q = null, $id = null) {
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
      ])
      ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerja');
      $datapekerja  = json_decode($getdatapekerja);
      // var_dump($datapekerja);die;
        $out = null;
        foreach ($datapekerja as $key => $value) {
          $out[] = $value;

          // $out['results'] = $value['jobfunc']['name_job_function'];
        }
        if($out){
          $outs['results'] = $out;
        }else{
          $outs['results'] = null;
        }


    }
    elseif ($id > 0) {
    //addbykaha
    $curl = new curl\Curl();
      $getdatapekerjabyperner =  $curl->setPostParams([
        'perner' => $id,
        'token' => 'ish**2019',
      ])
      ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerja');
      $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
        $outs['results'] = ['id' => $id, 'text' => $datapekerjabyperner];
    }else{

      $outs['results'] = ['id' => ' ', 'text' => ' '];
    }
    return $outs;
}
  public function actionUpdate($id)
  {
      return $this->redirect(['create', 'id' => $id]);
  }
  public function actionGetuserabout() {

    $perner = $_POST['perner'];
    $id = $_POST['id'];
    $updatecr = $this->findModel($id);
    if($perner){
      $cekhiring = Hiring::find()->where(['perner'=>$perner,'statushiring'=>4])->one();
      if($cekhiring){

        $getjo = Transrincian::find()->where(['id'=>$cekhiring->recruitreqid])->one();
        $model = Userabout::find()->where(['userid'=>$cekhiring->userid])->one();
        $updatecr->userid = $cekhiring->userid;
        $name = $cekhiring->userprofile->fullname;
        $persa = (Yii::$app->utils->getpersonalarea($getjo->persa_sap))?Yii::$app->utils->getpersonalarea($getjo->persa_sap): "";
        $area = (Yii::$app->utils->getarea($getjo->area_sap))?Yii::$app->utils->getarea($getjo->area_sap): "";
        $skilllayanan = (Yii::$app->utils->getskilllayanan($getjo->skill_sap))?Yii::$app->utils->getskilllayanan($getjo->skill_sap): "";
        $payrollarea = (Yii::$app->utils->getpayrollarea($getjo->abkrs_sap))?Yii::$app->utils->getpayrollarea($getjo->abkrs_sap): "";
        $jabatan = (Yii::$app->utils->getjabatan($getjo->hire_jabatan_sap))?Yii::$app->utils->getjabatan($getjo->hire_jabatan_sap): "";
        $curl = new curl\Curl();
        $getlevels = $curl->setPostParams([
          'level' => $getjo->level_sap,
          'token' => 'ish**2019',
        ])
        ->post('http://192.168.88.5/service/index.php/sap_profile/getlevel');
        $level  = json_decode($getlevels);
        $level = ($level)?$level : "";
        $hire = "Gojobs";
        $updatecr->fullname = $name;
        $updatecr->perner = $cekhiring->perner;
      }else{
        $updatecr->userid = null;
        $updatecr->perner = $perner;

        $curl = new curl\Curl();
        $getdatapekerjabyperner =  $curl->setPostParams([
          'perner' => $perner,
          'token' => 'ish**2019',
        ])
        ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerja');
        $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
        $name = $datapekerjabyperner[0]->CNAME;
        $persa = $datapekerjabyperner[0]->WKTXT;
        $area = $datapekerjabyperner[0]->BTRTX;
        $skilllayanan = $datapekerjabyperner[0]->PEKTX;
        $payrollarea = $datapekerjabyperner[0]->ABTXT;
        $jabatan = $datapekerjabyperner[0]->PLATX;
        $level = $datapekerjabyperner[0]->TRFAR_TXT;
        $hire = 'Non Gojobs';
        $updatecr->fullname = $name;
      }
      $checkperner = Changecanceljoin::find()->where('perner = '.$perner.' and status > 1 and status <> 5 and status <> 6')->one();

      if($checkperner){
        $checkperner = '';
      }else{
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
        ];

    }else{
      $dataprofile = '';
    }
    return Json::encode($dataprofile);
  }
  public function actionAutosave() {
    $id = $_POST['id'];
    $approvedby = $_POST['approvedby'];
    $resigndate = $_POST['resigndate'];
    $reason = $_POST['reason'];
    $userremarks = $_POST['userremarks'];
    // var_dump($resigndate);die;
    if($id){
      $model = $this->findModel($id);
      $model->approvedby = $approvedby;
      $model->resigndate = $resigndate;
      $model->reason = $reason;
      $model->remarks = "draft";
      $model->userremarks = $userremarks;
      $model->save(false);
    }
  }

  /**
   * Deletes an existing Changecanceljoin model.
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
   * Finds the Changecanceljoin model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Changecanceljoin the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
      if (($model = Changecanceljoin::findOne($id)) !== null) {
          return $model;
      } else {
          throw new NotFoundHttpException('The requested page does not exist.');
      }
  }
}
