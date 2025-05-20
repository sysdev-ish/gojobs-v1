<?php

namespace app\controllers;

use Yii;
use app\models\RequestHoldJob;
use app\models\RequestHoldJobSearch;
use app\models\Transrincian;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\helpers\FileHelper;

/**
 * RequestHoldJobController implements the CRUD actions for RequestHoldJob model.
 */
class RequestHoldJobController extends Controller
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
              return (Yii::$app->utils->permission(Yii::$app->user->identity->role, 'm93'));
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
   * Lists all RequestHoldJob models.
   * @return mixed
   */
  public function actionIndex()
  {
    $searchModel = new RequestHoldJobSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Displays a single RequestHoldJob model.
   * @param integer $id
   * @return mixed
   */
  public function actionView($id)
  {
    return $this->renderAjax('view', [
      'model' => $this->findModel($id),
    ]);
  }

  public function actionCreate($recruitreqid)
  {
    $model = new RequestHoldJob(['scenario' => 'create']);
    $dataJob = Transrincian::findOne($recruitreqid);

    if (!$dataJob) {
      throw new NotFoundHttpException('Data JO tidak ditemukan.');
    }

    $model->scheme_date_old = $dataJob->lup_skema;
    $model->recruitreqid = $dataJob->id;
    $model->created_by = Yii::$app->user->id;
    $model->created_at = date('Y-m-d H:i:s');
    $model->status = 1;

    $pmUsername = $dataJob->userpm;
    $pmId = $pmUsername == 'ikbal1' ? 20973 : ($pmUsername == 'setiawan1' ? 1095 : Yii::$app->utils->getuserid($pmUsername));
    $model->approved_by = $pmId;
    $model->recipient = $model->getRecipientEmail($pmId);

    if ($model->load(Yii::$app->request->post())) {
      $model->handleFileUpload();

      if ($model->save()) {
        $dataJob->is_hold_jobs = 1;
        $dataJob->save(false);

        $sendMail = Yii::$app->utils->sendmail(
          $model->recipient,
          'Notifikasi Approval Hold Job Order',
          $model->buildEmailBody($dataJob),
          12
        );

        Yii::$app->session->setFlash('success', 'Data created successfully' . ($sendMail['error'] === 0 ? ' & Email sent' : ''));

      }
      return $this->redirect(['request-hold-job/index']);
    }
    return $this->renderAjax(
      'create',
      [
        'model' => $model,
        'modelrecreq' => $dataJob
      ]
    );
  }

  public function actionUpdate($id)
  {
    $model = $this->findModel($id);
    $model->scenario = 'create';
    $model->updated_by = Yii::$app->user->id;
    $model->updated_at = date('Y-m-d H:i:s');
    $model->status = 1;

    $dataJob = Transrincian::findOne($model->recruitreqid);
    $model->scheme_date_old = $dataJob->lup_skema;

    $pmUsername = $dataJob->userpm;
    $pmId = $pmUsername == 'ikbal1' ? 20973 : ($pmUsername == 'setiawan1' ? 1095 : Yii::$app->utils->getuserid($pmUsername));
    $model->approved_by = $pmId;
    $model->recipient = $model->getRecipientEmail($pmId);

    if ($model->load(Yii::$app->request->post())) {
      if (UploadedFile::getInstance($model, 'evidence')) {
        if ($model->oldAttributes['evidence']) {
          @unlink(Yii::getAlias('@app/assets/upload/holdjob/') . $model->oldAttributes['evidence']);
        }
        $model->handleFileUpload();
      } else {
        $model->evidence = $model->oldAttributes['evidence'];
      }

      if ($model->save()) {
        $dataJob->is_hold_jobs = 1;
        $dataJob->save(false);

        $sendMail = Yii::$app->utils->sendmail(
          $model->recipient,
          'Notifikasi Approval Hold Job Order',
          $model->buildEmailBody($dataJob),
          12
        );

        Yii::$app->session->setFlash('success', 'Data updated successfully' . ($sendMail['error'] === 0 ? ' & Email sent' : ''));
      }
      return $this->redirect(['request-hold-job/index']);
    }

    return $this->renderAjax(
      'update',
      [
        'model' => $model,
        'modelrecreq' => $dataJob
      ]
    );
  }

  public function actionApprove($id)
  {
    $model = $this->findModel($id);
    $model->scenario = 'approve';
    $dataJob = Transrincian::find()->where(['id' => $model->recruitreqid])->one();

    if (!$model->load(Yii::$app->request->post())) {
      return $this->renderAjax('_formapprove', [
        'model' => $model,
        'modelrecreq' => $dataJob,
      ]);
    }

    $transaction = Yii::$app->db->beginTransaction();
    try {
      if ($model->status == 3) {      
        $dataJob->lup_skema = $model->scheme_date_end;
        if ($dataJob->typejo == 1 && $dataJob->transrincian) {
          $dataJob->transrincian->lup_skema = $model->scheme_date_end;
          if (!$dataJob->transrincian->save(false)) {
            throw new \Exception('Failed to save transrincian');
          }
        } elseif ($dataJob->transperner) {
          $dataJob->transperner->lup_skema = $model->scheme_date_end;
          if (!$dataJob->transperner->save(false)) {
            throw new \Exception('Failed to save transperner');
          }
        }

        if (!$dataJob->save(false)) {
          throw new \Exception('Failed to save dataJob');
        }
        Yii::$app->session->setFlash('success', 'Data approved successfully');
      } else {
        Yii::$app->session->setFlash('warning', 'Data rejected successfully');
      }

      $model->approved_at = date('Y-m-d H:i:s');

      // update approved_by
      $checkUser = User::find()->select(['id', 'name', 'role'])->where(['id' => Yii::$app->user->identity->id])->one();
      if ($checkUser && in_array($checkUser->role, [10, 16, 21])) {
        $model->approved_by = Yii::$app->user->identity->id;
      }

      if (!$model->save()) {
        throw new \Exception('Failed to save model');
      }

      $transaction->commit();
      return $this->redirect(['index']);
    } catch (\Exception $e) {
      $transaction->rollBack();
      Yii::$app->session->setFlash('error', $e->getMessage());
      return $this->redirect(['index']);
    }
  }


  /**
   * Deletes an existing RequestHoldJob model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   */
  public function actionDelete($id)
  {
    $this->findModel($id)->delete();

    Yii::$app->session->setFlash('success', 'Data deleted successfully ');
    return $this->redirect(['index']);
  }

  /**
   * Finds the RequestHoldJob model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return RequestHoldJob the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = RequestHoldJob::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }
}
