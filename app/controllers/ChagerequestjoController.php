<?php

namespace app\controllers;

use Yii;
use app\models\Chagerequestjo;
use app\models\Chagerequestjosearch;
use app\models\Transrincian;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * ChagerequestjoController implements the CRUD actions for Chagerequestjo model.
 */
class ChagerequestjoController extends Controller
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
              return (Yii::$app->utils->permission(Yii::$app->user->identity->role, 'm64'));
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
   * Lists all Chagerequestjo models.
   * @return mixed
   */
  public function actionIndex()
  {
    $searchModel = new Chagerequestjosearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Displays a single Chagerequestjo model.
   * @param integer $id
   * @return mixed
   */
  public function actionView($id)
  {
    return $this->renderAjax('view', [
      'model' => $this->findModel($id),
    ]);
  }
  public function actionApprove($id)
  {
    $model = $this->findModel($id);
    $model->scenario = 'approve';
    $modelrecreq = Transrincian::find()->where(['id' => $model->recruitreqid])->one();
    if ($model->load(Yii::$app->request->post())) {
      if ($model->status == 3) {
        $modelrecreq->jumlah = $model->jumlah;
        $checkjodone = Yii::$app->check->checkstatusjoHired($model->recruitreqid, $model->jumlah);
        if ($checkjodone) {
          $modelrecreq->status_rekrut = 4;
        } else {
          $modelrecreq->status_rekrut = 3;
        }
        $modelrecreq->save(false);
        $model->approvedtime2 = date('Y-m-d H-i-s');
      }

      if ($model->status == 2) {
        $model->approvedby = Yii::$app->user->identity->id;
      }

      $model->approvedtime = date('Y-m-d H-i-s');

      // var_dump($model->approvedby);die;
      $model->save();
      return $this->redirect(['index']);
    } else {
      return $this->renderAjax('_formapprove', [
        'model' => $model,
        'modelrecreq' => $modelrecreq,
      ]);
    }
  }

  /**
   * Creates a new Chagerequestjo model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate($recruitreqid)
  {
    $model = new Chagerequestjo();
    $model->scenario = 'create';
    $modelrecreq = Transrincian::find()->where(['id' => $recruitreqid])->one();
    if ($modelrecreq) {
      $model->oldjumlah =  $modelrecreq->jumlah;
      // var_dump(Yii::$app->check->checkJohired($recruitreqid,2));die;
      $model->counthiredtype1 = $model->oldjumlah - Yii::$app->check->checkJohired($recruitreqid, 2);
      $userpm = null;
      if ($modelrecreq->userpm == 'ikbal1') {
        $userpm = 20973;
      } else if ($modelrecreq->userpm == 'setiawan1') {
        $userpm = 1095;
      } else {
        $userpm = Yii::$app->utils->getuserid($modelrecreq->userpm);
      }
      $model->approvedby = $userpm;
    }
    if ($model->load(Yii::$app->request->post())) {
      $model->recruitreqid = $modelrecreq->id;
      $model->createtime = date('Y-m-d H-i-s');
      $model->updatetime = date('Y-m-d H-i-s');
      $model->createdby = Yii::$app->user->identity->id;
      $model->updatedby = Yii::$app->user->identity->id;
      $role = Yii::$app->user->identity->role;
      $nik = Yii::$app->user->identity->username;
      $model->jumlah = $model->oldjumlah - $model->jumlahstop;
      // var_dump($model->jumlah);die;
      switch ($role) {
        //sales - approval only PM
        case 18:
          $model->typeapproval = 1;
          break;
        //admin rekrut
        case 3:
          $model->typeapproval = 2;
          $model->approvedby2 = $modelrecreq->transjo->upd;
          break;

        //operation Area
        case 22:
          $model->typeapproval = 2;
          $model->approvedby2 = $modelrecreq->transjo->upd;
          break;

        //operational Pusat
        case 23:
          $model->typeapproval = 2;
          $model->approvedby2 = $modelrecreq->transjo->upd;
          break;
        //assistant manager area
        case 25:
          $model->typeapproval = 2;
          $model->approvedby2 = $modelrecreq->transjo->upd;
          break;

        default:
          $model->typeapproval = 2;
          $model->approvedby2 = $modelrecreq->transjo->upd;
          break;
      }

      // var_dump($role);die;
      $model->documentevidence = UploadedFile::getInstance($model, 'documentevidence');
      if ($model->documentevidence) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        $fileextp = $model->documentevidence->extension;
        $filep = $modelrecreq->id . '-documentevidence.' . $fileextp;
        if ($model->documentevidence->saveAs($assetUrl . '/upload/documentevidence/' . $filep)) {
          $model->documentevidence = $filep;
        }
      }

      if ($model->save()) {
        if ($modelrecreq->transjo->n_project == "" || $modelrecreq->transjo->n_project == "Pilih") {
          $layanan = $modelrecreq->transjo->project;
        } else {
          $layanan = $modelrecreq->transjo->n_project;
        }
        if ($model->reason == 1) {
          $alasanstop = "Permintaan User/Client";
        } else {
          $alasanstop = "Project Batal";
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
        $to = 'proman@ish.co.id';
        $subject = 'Notifikasi Approval Stop Job Order';
        $body = Yii::$app->params['approvalStopJo'];
        $body = str_replace('{nojo}', $modelrecreq->nojo, $body);
        $body = str_replace('{layanan}', $layanan, $body);
        $body = str_replace('{area}', $area, $body);
        $body = str_replace('{jabatan}', $jabatan, $body);
        $body = str_replace('{old_jumlah}', $model->oldjumlah, $body);
        $body = str_replace('{jumlah}', $model->jumlahstop, $body);
        $body = str_replace('{remarks}', $model->remarks, $body);
        $body = str_replace('{reason}', $alasanstop, $body);
        // 
        $verification = Yii::$app->utils->sendmail($to, $subject, $body, 12);
      }
      return $this->redirect(['transrincian/view', 'id' => $modelrecreq->id]);
    } else {
      return $this->renderAjax('create', [
        'model' => $model,
        'modelrecreq' => $modelrecreq,
      ]);
    }
  }

  /**
   * Updates an existing Chagerequestjo model.
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

  /**
   * Deletes an existing Chagerequestjo model.
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
   * Finds the Chagerequestjo model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Chagerequestjo the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Chagerequestjo::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }
}
