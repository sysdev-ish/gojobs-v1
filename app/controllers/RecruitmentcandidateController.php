<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Recruitmentcandidate;
use app\models\Userprofile;
use app\models\Userprofilesearch;
use app\models\Userlogin;
use app\models\Interview;
use app\models\Psikotest;
use app\models\Userinterview;
use app\models\Transrincian;
use app\models\Masteroffice;
use app\models\Tsoftskill;
use app\models\Thardskill;
use app\models\Tpasif;
use app\models\Taktif;
use app\models\Recruitmentcandidatesearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * RecruitmentcandidateController implements the CRUD actions for Recruitmentcandidate model.
 */
class RecruitmentcandidateController extends Controller
{
  /**
   * @inheritdoc
   */
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'only' => ['view', 'index', 'addcandidate', 'applyjob', 'walkin', 'addcandidate2', 'myapplication'],
        'rules' => [
          [
            'actions' => ['view', 'index', 'addcandidate', 'addcandidate2'],
            'allow' => true,
            'roles' => ['@'],
            'matchCallback' => function () {
              return (Yii::$app->utils->permission(Yii::$app->user->identity->role, 'm2'));
            }

          ],
          [
            'actions' => ['myapplication', 'applyjob', 'walkin'],
            'allow' => true,
            'roles' => ['@'],
            'matchCallback' => function () {
              // var_dump( (int)Yii::$app->request->get('userid'));die;
              if (Yii::$app->user->identity->role == 2) {
                if ((int)Yii::$app->request->get('userid') == Yii::$app->user->identity->id) {
                  $ret = true;
                } else {
                  $ret = false;
                }
              } else {
                $ret = (Yii::$app->utils->permission(Yii::$app->user->identity->role, 'm2'));
              }
              return $ret;
            }

          ],
          // [
          //         'actions' => ['applyjob'],
          //         'allow' => true,
          //         'roles' => ['@'],
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
   * Lists all Recruitmentcandidate models.
   * @return mixed
   */
  public function actionIndex()
  {
    $searchModel = new Recruitmentcandidatesearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Displays a single Recruitmentcandidate model.
   * @param integer $id
   * @return mixed
   */
  public function actionView($id)
  {
    return $this->renderAjax('view', [
      'model' => $this->findModel($id),
    ]);
  }
  public function actionMyapplication($userid)
  {
    $this->layout = Yii::$app->utils->getlayout();
    $model = Userprofile::find()->where(['userid' => $userid])->one();
    $modelall = Recruitmentcandidate::find()->where(['userid' => $userid])->all();
    return $this->render('viewmyapp', [
      'model' => $model,
      'modelall' => $modelall,
      'userid' => $userid,
    ]);
  }


  /**
   * Creates a new Recruitmentcandidate model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate()
  {
    $model = new Recruitmentcandidate();

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->id]);
    } else {
      return $this->render('create', [
        'model' => $model,
      ]);
    }
  }

  /**
   * Updates an existing Recruitmentcandidate model.
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
  public function actionAddcandidate($userid)
  {
    $model = new Recruitmentcandidate();
    $modeluprofile = Userprofile::find()->where(['userid' => $userid])->one();
    $model->fullname = $modeluprofile->fullname;
    $model->userid = $modeluprofile->userid;
    $year = date('Y');
    $recruitreq = ArrayHelper::map(Transrincian::find()->asArray()->where('status_rekrut = 1 OR status_rekrut = 3 ')->all(), 'id', 'nojo');
    // $recruitreq = ArrayHelper::map(Transrincian::find()->asArray()->limit(100)->all(), 'id', 'nojo');

    if ($model->load(Yii::$app->request->post())) {
      $model->createtime = date('Y-m-d H-i-s');
      $model->updatetime = date('Y-m-d H-i-s');
      $model->status = 0;
      $model->typeinterview = 1;
      $model->save();
      return $this->redirect(['userprofile/index']);
    } else {
      return $this->renderAjax('addcandidate', [
        'model' => $model,
        'modeluprofile' => $modeluprofile,
        'recruitreq' => $recruitreq,
      ]);
    }
  }

  public function actionAddtocandidate($id, $userid)
  {
    $model = new Recruitmentcandidate();
    //
    if (Yii::$app->request->isAjax) {
      $model->userid = $userid;
      $model->createtime = date('Y-m-d H-i-s');
      $model->updatetime = date('Y-m-d H-i-s');
      $model->recruitreqid = $id;
      $model->status = 0;
      $model->typeinterview = 1;

      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      if ($model->save()) {
        return 'Add candidate successful';
      }
    }
    // return $this->redirect(['addcandidate2','id'=>$id]);
  }
  public function actionAddcandidate2($id)
  {
    $model = new Recruitmentcandidate();
    // $modeluprofile = Userprofile::find()->all();
    // $recruitreq = ArrayHelper::map(Transrincian::find()->asArray()->limit(100)->all(), 'id', 'nojo');
    // $modelrecreq = Transrincian::find()->where(['id' => $id, 'status_rekrut' => 1])->one();
    $modelrecreq = Transrincian::find()
      ->where(['id' => $id])
      ->andWhere(['in', 'status_rekrut', [1, 3]])
      ->one();

    $searchModelprofile = new Userprofilesearch();
    // $searchModelprofile->select(['id', 'fullname', 'address', 'gender', 'city'])->all();

    $dataProviderprofile = $searchModelprofile->search(Yii::$app->request->queryParams);

    return $this->renderAjax('addcandidate2', [
      'model' => $model,
      // 'modeluprofile' => $modeluprofile,
      // 'recruitreq' => $recruitreq,
      'searchModelprofile' => $searchModelprofile,
      'dataProviderprofile' => $dataProviderprofile,
      'transrincianid' => $id,
      'modelrecreq' => $modelrecreq,

    ]);
  }
  public function actionInvite($userid, $reccanid)
  {
    $modelreccan = Recruitmentcandidate::find()->where(['id' => $reccanid])->one();
    $modelrecreq = Transrincian::find()->where(['id' => $modelreccan->recruitreqid])->one();
    // var_dump($modelreccan->status);die;

    if ($modelreccan->status == 0) {
      $model = new Psikotest();
      $invitefor = 'Psikotest';
      $identifier = 5;
    } else if ($modelreccan->status == 6) {
      $model = new Interview();
      $invitefor = 'Interview';
      $identifier = 4;
    } else if ($modelreccan->status == 5) {
      $model = new Userinterview();
      $invitefor = 'User interview';
      $identifier = 6;
    } else if ($modelreccan->status == 7 and $modelrecreq->train_soft == 1) {
      $model = new tsoftskill();
      $invitefor = 'Training Soft Skill';
      $identifier = 7;
    } else if (($modelreccan->status == 12 or $modelreccan->status == 7) and $modelrecreq->train_hard == 1) {
      $model = new thardskill();
      $invitefor = 'Training Hard Skill';
      $identifier = 8;
    } else if (($modelreccan->status == 13 or $modelreccan->status == 12 or $modelreccan->status == 7) and $modelrecreq->tendem_pasif == 1) {
      $model = new tpasif();
      $invitefor = 'Tendem Pasif';
      $identifier = 9;
    } else if (($modelreccan->status == 14 or $modelreccan->status == 13 or $modelreccan->status == 12 or $modelreccan->status == 7) and $modelrecreq->tendem_aktif == 1) {
      $model = new taktif();
      $invitefor = 'Tendem Aktif';
      $identifier = 10;
    }

    $modeluprofile = Userprofile::find()->where(['userid' => $userid])->one();
    $modelulogin = Userlogin::find()->where(['id' => $userid])->one();
    // if()
    $model->fullname = $modeluprofile->fullname;
    $model->userid = $modeluprofile->userid;

    $model->recruitmentcandidateid = $reccanid;
    $office = ArrayHelper::map(Masteroffice::find()->asArray()->all(), 'id', 'officename');

    if ($model->load(Yii::$app->request->post())) {
      $model->createtime = date('Y-m-d H-i-s');
      $model->updatetime = date('Y-m-d H-i-s');
      $model->status = 0;
      if ($modelreccan->status == 7 or $modelreccan->status == 12 or $modelreccan->status == 13 or $modelreccan->status == 14) {
        $model->date = $model->scheduledate;
      }
      if ($modelreccan->status == 0) {
        $modelreccan->status = 2;
      } elseif ($modelreccan->status == 6) {
        $modelreccan->status = 1;
        $modelreccan->typeinterview = 1;
        $modelreccan->invitationnumber = $model->userid . $modelreccan->id . '-ISHINVT';
      } elseif ($modelreccan->status == 5) {
        $modelreccan->status = 3;
      } elseif ($modelreccan->status == 7) {
        $modelreccan->status = 20;
        $model->status = 1;
      } elseif ($modelreccan->status == 12) {
        $modelreccan->status = 21;
        $model->status = 1;
      } elseif ($modelreccan->status == 13) {
        $modelreccan->status = 22;
        $model->status = 1;
      } elseif ($modelreccan->status == 14) {
        $modelreccan->status = 23;
        $model->status = 1;
      }
      $pic = Userlogin::find()->where(['id' => $model->officepic])->one();
      // var_dump($model->method);die;
      if ($modelreccan->status == 2) {

        $modelreccan->method = $model->method;
        $modelreccan->kodetoken = $model->kodetoken;
      }
      if ($model->save() && $modelreccan->save()) {
        if ($model->roomid != null) {
          $room = $model->masterroom->room;
          $floor = $model->masterroom->floor;
        } else {
          $room = '';
          $floor = '';
        };
        $datancomp = Yii::$app->check->datanotcompleted($userid);
        if ($datancomp ==  null) {
          $infodata = '';
        } else {
          $infodata = 'Sebelumnya mohon untuk melengkapi data ' . str_replace(array("[", "]"), array(" "), json_encode($datancomp)) . ' pada sistem kami dengan melakukan login pada http://gojobs.id/ ';
        }
        if (is_numeric($modelrecreq->jabatan)) {
          $jabatans = $modelrecreq->jobfunc->name_job_function;
        } else {
          $jabatans = $modelrecreq->jabatan;
        }
        if (Yii::$app->utils->getarea($modelrecreq->area_sap)) {
          $areas = Yii::$app->utils->getarea($modelrecreq->area_sap);
        } else {
          $areas = '';
        }
        $date = date_create($model->scheduledate);
        $to = $modelulogin->email;
        $subject = 'Undangan ' . $invitefor . ' PT Infomedia Solusi Humanika';
        // var_dump($modelreccan->status.' '.$modelreccan->method);die;

        if ($modelreccan->status == 2 && $modelreccan->method == 2) {
          $body = Yii::$app->params['recruitmentProcessOnline'];
          $body = str_replace('{invitation_number}', $modelreccan->invitationnumber, $body);
          $body = str_replace('{fullname}', $modeluprofile->fullname, $body);
          $body = str_replace('{jabatan}', $jabatans, $body);
          $body = str_replace('{area}', $areas, $body);
          $body = str_replace('{token}', $modelreccan->kodetoken, $body);
        } else {
          $body = Yii::$app->params['recruitmentProcessOffline'];
          $body = str_replace('{invitation_number}', $modelreccan->invitationnumber, $body);
          $body = str_replace('{invitation_for}', $invitefor, $body);
          $body = str_replace('{fullname}', $modeluprofile->fullname, $body);
          $body = str_replace('{jabatan}', $jabatans, $body);
          $body = str_replace('{area}', $areas, $body);
          $body = str_replace('{date}', Yii::$app->utils->indodate($model->scheduledate), $body);
          $body = str_replace('{time}', date("H:i", strtotime($model->scheduledate)), $body);
          $body = str_replace('{pic}', $pic->name, $body);
          $body = str_replace('{pic_number}', $pic->mobile, $body);
          $body = str_replace('{pic_data}', $infodata, $body);
          $body = str_replace('{address}', $model->masteroffice->address . '(' . Html::a('Link location map', 'https://maps.google.com/?q=' . $model->masteroffice->lat . ',' . $model->masteroffice->long, ['target' => '_blank']), $body);
          $body = str_replace('{room}', $room, $body);
          $body = str_replace('{floor}', $floor, $body);
        }

        $verification = Yii::$app->utils->sendmail($to, $subject, $body, $identifier);
        return $this->redirect(['index']);
      }
    } else {
      return $this->renderAjax('invite', [
        'model' => $model,
        'modelreccan' => $modelreccan,
        'modelrecreq' => $modelrecreq,
        'office' => $office,
        'invitefor' => $invitefor,
      ]);
    }
  }

  public function actionChangejo($userid, $reccanid)
  {
    $model = $this->findModel($reccanid);
    $modelreccan = Recruitmentcandidate::find()->where(['id' => $reccanid])->one();
    $modelrecreq = Transrincian::find()->where(['id' => $modelreccan->recruitreqid])->one();


    $modeluprofile = Userprofile::find()->where(['userid' => $userid])->one();
    $modelulogin = Userlogin::find()->where(['id' => $userid])->one();


    $model->fullname = $modeluprofile->fullname;


    if ($model->load(Yii::$app->request->post())) {

      if ($model->save()) {
        return $this->redirect(['index']);
      }
    } else {
      return $this->renderAjax('changejo', [
        'model' => $model,
        'modelreccan' => $modelreccan,
        'modelrecreq' => $modelrecreq,
      ]);
    }
  }

  // add by kaha 22-10-2024
  public function actionResetCandidate($user_id, $candidate_id)
  {
    $data_candidate = Recruitmentcandidate::find()->where(['id' => $candidate_id])->one();
    $data_joborder = Transrincian::find()->where(['id' => $data_candidate->recruitreqid])->one();

    
  }

  public function actionApplyjob($userid, $jobsid)
  {
    $model = new Recruitmentcandidate();
    $model->createtime = date('Y-m-d H-i-s');
    $model->updatetime = date('Y-m-d H-i-s');
    $model->status = 0;
    $model->typeinterview = 1;
    $model->recruitreqid = $jobsid;
    $model->userid = $userid;

    // add by kaha to send notif email after apply job
    $transrincian = Transrincian::find()->where(['id' => $jobsid])->one();
    $userprofile = Userprofile::find()->where(['userid' => $userid])->one();
    if ($model->save()) {
      // get layanan
      if ($transrincian->transjo->n_project == "" || $transrincian->transjo->n_project == "Pilih") {
        $layanan = $transrincian->transjo->project;
      } else {
        $layanan = $transrincian->transjo->n_project;
      }
      // get jabatan
      if (Yii::$app->utils->getjabatan($transrincian->hire_jabatan_sap)) {
        $jabatan = Yii::$app->utils->getjabatan($transrincian->hire_jabatan_sap);
      } else {
        $jabatan = '';
      }
      $to = $userprofile->userlogin->email;
      $subject = 'PT Infomedia Solusi Humanika (ISH) – Lamaran Telah Diterima - ' . $userprofile->fullname;
      $body = Yii::$app->params['notificationApplyJob'];
      $body = str_replace('{fullname}', $userprofile->fullname, $body);
      $body = str_replace('{layanan}', $layanan, $body);
      $body = str_replace('{jabatan}', $jabatan, $body);
      // var_dump($body);die;
      $verification = Yii::$app->utils->sendmail($to, $subject, $body, 25);
    }
    return $this->redirect(['site/searchjob']);
  }

  public function actionWalkin($userid, $jobsid)
  {
    $interviewcheck = Interview::find()
      ->where(['DATE(scheduledate)' => date('Y-m-d')])
      ->orWhere(['DATE(date)' => date('Y-m-d')])
      ->andWhere(['userid' => $userid])
      ->one();

    if (!$interviewcheck) {
      $model = new Recruitmentcandidate();
      $modelinterview = new Interview();
      $recancheck = Recruitmentcandidate::find()->where(['userid' => $userid, 'recruitreqid' => $jobsid])->one();

      $model->createtime = date('Y-m-d H-i-s');
      $model->updatetime = date('Y-m-d H-i-s');
      $model->status = 1;
      $model->recruitreqid = $jobsid;
      $model->userid = $userid;
      $model->typeinterview = 2;

      $modelinterview->createtime = date('Y-m-d H-i-s');
      $modelinterview->updatetime = date('Y-m-d H-i-s');
      $modelinterview->status = 0;

      $modelinterview->scheduledate = date('Y-m-d H-i-s');
      $modelinterview->userid = $userid;
      if ($recancheck) {
        $recancheck->invitationnumber = $model->userid . $recancheck->id . '-ISHINVTWI';
        $recancheck->typeinterview = 2;
        $recancheck->status = 1;
        $recancheck->save();
        $modelinterview->recruitmentcandidateid = $recancheck->id;
      } else {

        $model->save();
        $geninvtno = Recruitmentcandidate::find()->where(['id' => $model->id])->one();
        $geninvtno->invitationnumber = $model->userid . $geninvtno->id . '-ISHINVTWI';
        $geninvtno->save();
        $modelinterview->recruitmentcandidateid = $model->id;
      }
      $modelinterview->save(false);
    } else {
      echo "<script>alert('message');</script>";
    }

    return $this->redirect(['site/searchjob']);
  }

  /**
   * Deletes an existing Recruitmentcandidate model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   */
  public function actionDelete($id)
  {
    $this->findModel($id)->delete();

    return $this->redirect(['index']);
  }
  public function actionCancel($id)
  {
    $model = $this->findModel($id);
    $modelrecreq = Transrincian::find()->where(['id' => $model->recruitreqid])->one();

    $model->status = 24;
    if ($model->save(false)) {
      if ($modelrecreq->status_rekrut = 2) {
        $modelrecreq->status_rekrut = 1;
        $modelrecreq->save(false);
      } else if ($modelrecreq->status_rekrut = 4) {
        $modelrecreq->status_rekrut = 3;
        $modelrecreq->save(false);
      } else {
        $modelrecreq->save(false);
      }
      Yii::$app->session->setFlash('success', "Done Confirm Cancel Candidate.");
      return $this->redirect(['index']);
    } else {
      Yii::$app->session->setFlash('error', "Cant Cancel.");
      return $this->redirect(['index']);
    }
  }

  /**
   * Finds the Recruitmentcandidate model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Recruitmentcandidate the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Recruitmentcandidate::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }
}
