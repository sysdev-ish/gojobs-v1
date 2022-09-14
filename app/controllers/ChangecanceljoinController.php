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
use app\models\Masterreasoncanceljoin;
use app\models\Recruitmentcandidate;
use yii\helpers\ArrayHelper;
use linslin\yii2\curl;
use yii\helpers\Json;
use app\models\Masterstatuscr;
use yii\data\Pagination;
use yii\web\UploadedFile;

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
        'only' => ['index', 'update', 'create', 'view', 'delete', 'confirmation'],
        'rules' => [
          [
            'actions' => ['index', 'update', 'create', 'view', 'delete', 'confirmation'],
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
    $reason = ArrayHelper::map(Masterreasoncanceljoin::find()->asArray()->all(), 'id', 'reason');
    if ($id) {
      $model = $this->findModel($id);
    } else {
      $getid = new Changecanceljoin();
      $getid->createtime = date('Y-m-d H-i-s');
      $getid->updatetime = date('Y-m-d H-i-s');
      $getid->createdby = Yii::$app->user->identity->id;
      $getid->save(false);
      return $this->redirect(['create', 'id' => $getid->id]);
    }

    $model->scenario = 'createupdate';
    if ($model->load(Yii::$app->request->post())) {
      $model->status = 2;
      $hiring = Hiring::find()->where(['userid' => $model->userid, 'statushiring' => 4])->one();
      $model->documentevidence = UploadedFile::getInstance($model, 'documentevidence');
      if ($model->documentevidence) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        $fileextp = $model->documentevidence->extension;
        $filep = $model->id . '-documentevidence.' . $fileextp;
        if ($model->documentevidence->saveAs($assetUrl . '/upload/documentevidence/' . $filep)) {
          $model->documentevidence = $filep;
        }
      }
      // var_dump($model->documentevidence);die();
      if ($model->save()) {
        // $user = User::find()->where(['id' => $model->approvedby])->one();
        if ($model->userid) {
          $getjo = Hiring::find()->where(['userid' => $model->userid, 'statushiring' => 4])->one();
          $modelrecreq = Transrincian::find()->where(['id' => $hiring->recruitreqid])->one();
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
        // $to = $user->email;
        // $to =  "khusnul.hisyam@ish.co.id";
        $to =  "proman@ish.co.id";
        $subject = 'Notifikasi Approval Cancel Join Pekerja';
        $body = 'Test';
        $body = 'Semangat Pagi,
            <br>
            Anda mendapatkan permintaan Approval "Cancel Join Pekerja" dari <span style="text-transform: uppercase;"><b>' . $model->createduser->name . '</b></span> dengan rincian sebagai berikut :

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
            <td valign="top">Reason</td>
            <td valign="top">:</td>
            <td valign="top">' . $model->canceljoinreason->reason . '</td>
            </tr>
            <tr>
            </table>
            <br>
            <br>
            Mohon untuk melakukan hapus perner agar bisa dilanjutkan proses yang lain.
            <br><br>
            Terima kasih!
            ';
        // var_dump($body);die;
        $verification = Yii::$app->utils->sendmail($to, $subject, $body, 15);
        //15, klasifikasi untuk changecancel join cek table mailcounter/maillog
      }
      return $this->redirect(['index']);
    } else {
      return $this->render('create', [
        'model' => $model,
        // 'approvalname' => $approvalname,
        'reason' => $reason,
      ]);
    }
  }

  /**
   * Updates an existing Changecanceljoin model.
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
    $userprofile = Userprofile::find()->where(['userid' => $userid])->one();
    $model->scenario = 'approve';
    // var_dump($userid);die();
    if ($model->load(Yii::$app->request->post())) {
      $model->approvedtime = date('Y-m-d H-i-s');
      if ($model->status == 8) {
        $model->remarks = "Waiting for Resign Execution process";
        $model->approvedby = Yii::$app->user->identity->id;
        if ($model->save()) {
          if ($model->userid) { //get data jika userid id true
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
          } else { //jika tidak ada get data dari service 88.5
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
          //sendmail notification for sap admin -> service canceljoin (belum ada)
          // $to = "khusnul.hisyam@ish.co.id";
          $to = "joko.sasongko@ish.co.id"; //SAP ADMIN
          $subject = 'Notifikasi Cancel Join SAP Admin';
          $body = 'Semangat Pagi,
            <br>
            Anda mendapatkan permintaan "Cancel Join Pekerja" dari <span style="text-transform: uppercase;"><b>' . $model->approveduser->name . '</b></span> dengan rincian sebagai berikut :

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
            <td valign="top">Reason</td>
            <td valign="top">:</td>
            <td valign="top">' . $model->canceljoinreason->reason . '</td>
            </tr>
            <tr>
            </table>
            <br>
            <br>
            Silakan masuk ke link <a href="https://gojobs.id">gojobs.id</a> sub menu cancel join (confirmation) untuk melakukan verifikasi lebih lanjut.
            <br><br>
            Have a great day !
            ';
          // var_dump($body);die();
          $verification = Yii::$app->utils->sendmail($to, $subject, $body, 20);
          //klasifisikasi 20 -> notif to admin SAP cek mailcounter
        }
      } else {
        $model->save();
      }
      return $this->redirect(['index']);
    } else {
      return $this->renderAjax('_formapprove', [
        'model' => $model,
        'userprofile' => $userprofile,
      ]);
    }
  }

  public function actionConfirmcancel($id)
  {
    $model = $this->findModel($id);
    // $model->scenario = 'confirmation';
    if ($model->load(Yii::$app->request->post())) {
      $model->approvedtime = date('Y-m-d H-i-s');
      if ($model->status = 4) {
        $model->status = 9;
        $model->remarks = 'Successfull';
        // $hiring = Hiring::find()->where(['statushiring' => 4])->one();
        $hiring = Hiring::find()->where(['perner' => $model->perner, 'statushiring' => 4])->one();
        $recruitmentcandidate = Recruitmentcandidate::find()->where(['userid' => $hiring->userid, 'recruitreqid' => $hiring->recruitreqid])->one();
        $modelrecreq = Transrincian::find()->where(['id' => $hiring->recruitreqid])->one();
        // var_dump($recruitmentcandidate);die();
        if ($model->save()) {
          if ($recruitmentcandidate == null) {
            $hiring->statushiring = 6;
            $hiring->save(false);
            if ($modelrecreq->status_rekrut = 2) {
              $modelrecreq->status_rekrut = 1;
              $modelrecreq->save(false);
            }
            if ($modelrecreq->status_rekrut = 4) {
              $modelrecreq->status_rekrut = 3;
              $modelrecreq->save(false);
            }
            if ($modelrecreq->status_rekrut = 1 or $modelrecreq->status_rekrut = 1) {
              $modelrecreq->save(false);
            }
          } 
          if ($hiring) {
            $hiring->statushiring = 6;
            $recruitmentcandidate->status = 24;
            $hiring->save(false);
            $recruitmentcandidate->save(false);
            if ($modelrecreq->status_rekrut = 2) {
              $modelrecreq->status_rekrut = 1;
              $modelrecreq->save(false);
            }
            if ($modelrecreq->status_rekrut = 4) {
              $modelrecreq->status_rekrut = 3;
              $modelrecreq->save(false);
            }
            if ($modelrecreq->status_rekrut = 1 or $modelrecreq->status_rekrut = 1) {
              $modelrecreq->save(false);
            }
          }
        }
      } else  {
        $model->save();
      } return $this->redirect(['index']);
    }
    else {
      return $this->renderAjax('_formconfirmation', [
        'model' => $model
      ]);
    }
  }

  /**
   * Updates an existing Changecanceljoin model.
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
      if ($out) {
        $outs['results'] = $out;
      } else {
        $outs['results'] = null;
      }
    } elseif ($id > 0) {

      $curl = new curl\Curl();
      $getdatapekerjabyperner =  $curl->setPostParams([
        'perner' => $id,
        'token' => 'ish**2019',
      ])
        ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerja');
      $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
      $outs['results'] = ['id' => $id, 'text' => $datapekerjabyperner];
      $ABKRS = $datapekerjabyperner[0]->ABKRS;
      $cekpaycontroll =  $curl->setPostParams([
        'token' => 'ish@2019!',
        'ABKRS' => $ABKRS,
      ])
        ->post('http://192.168.88.5/service/index.php/Rfccekpayrollcontroll');
      $payrollcontrollresult  = json_decode($cekpaycontroll);
      var_dump($payrollcontrollresult);
      die();
    } else {

      $outs['results'] = ['id' => ' ', 'text' => ' '];
    }
    return $outs;
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
      } else {
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
      $checkperner = Changecanceljoin::find()->where('perner = ' . $perner . ' and status > 1 and status <> 5 and status <> 6')->one();

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
      ];
    } else {
      $dataprofile = '';
    }
    return Json::encode($dataprofile);
  }

  public function actionAutosave()
  {
    $id = $_POST['id'];
    $perner = $_POST['perner'];
    // $approvedby = $_POST['approvedby'];
    $canceldate = $_POST['canceldate'];
    $reason = $_POST['reason'];
    $userremarks = $_POST['userremarks'];
    if ($id) {
      $model = $this->findModel($id);
      $model->perner = $perner;
      // $model->approvedby = $approvedby;
      $model->canceldate = $canceldate;
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
    $model = $this->findModel($id)->delete();
    if ($model) {
      Yii::$app->session->setFlash('success', "Data Dihapus.");
      return $this->redirect(['index']);
    } else {
      Yii::$app->session->setFlash('error', "Data Tidak Bisa Dihapus.");
      return $this->redirect(['index']);
    }
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
