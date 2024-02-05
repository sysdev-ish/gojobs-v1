<?php

namespace app\controllers;

use Yii;
use app\models\Userhealth;
use app\models\Userabout;
use app\models\Masterbank;
use app\models\Masterinfoofrecruitment;
use app\models\Useraddinfosearch;
use app\models\Uploadocument;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\web\UploadedFile;


/**
 * UseraddinfoController implements the CRUD actions for Userhealth model.
 */
class UseraddinfoController extends Controller
{
  /**
   * @inheritdoc
   */
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'only' => ['index', 'update', 'create', 'view', 'delete', 'views', 'cwizard', 'uwizard'],
        'rules' => [

          [
            'actions' => ['index', 'view', 'delete'],
            'allow' => true,
            'roles' => ['@'],
            'matchCallback' => function () {
              return (Yii::$app->utils->permission(Yii::$app->user->identity->role, 'm13'));
            }

          ],
          [
            'actions' => ['views', 'view'],
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
                $ret = (Yii::$app->utils->permission(Yii::$app->user->identity->role, 'm13'));
              }
              return $ret;
            }

          ],
          [
            'actions' => ['update'],
            'allow' => true,
            'roles' => ['@'],
            'matchCallback' => function () {

              if (Yii::$app->user->identity->role == 2) {

                if ((int)Yii::$app->request->get('id') == Yii::$app->user->identity->id) {
                  $ret = true;
                } else {
                  $ret = false;
                }
              } else {
                $ret = (Yii::$app->utils->permission(Yii::$app->user->identity->role, 'm13'));
              }
              return $ret;
            }

          ],
          [
            'actions' => ['cwizard', 'uwizard', 'create'],
            'allow' => true,
            'roles' => ['@'],
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
   * Lists all Userhealth models.
   * @return mixed
   */
  public function actionIndex()
  {
    $searchModel = new Useraddinfosearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Displays a single Userhealth model.
   * @param integer $id
   * @return mixed
   */
  public function actionView($id)
  {
    return $this->render('view', [
      'model' => $this->findModel($id),
    ]);
  }
  public function actionViews($userid)
  {
    $this->layout = Yii::$app->utils->getlayout();
    $model = Userhealth::find()->where(['userid' => $userid])->one();

    if ($model) {
      $modelabout = UserAbout::find()->where(['userid' => $userid])->one();
      if ($modelabout) {
        $modelabouts = $modelabout;
      } else {
        $modelabouts = '-';
      }
      return $this->render('view', [
        'model' => $model,
        'modelabout' => $modelabouts,
        'userid' => $userid,
      ]);
    } else {
      return $this->redirect(['create', 'userid' => $userid]);
    }
  }

  /**
   * Creates a new Userhealth model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate($userid)
  {
    $id = $userid;
    $this->layout = Yii::$app->utils->getlayout();
    $model = new Userhealth();
    $modelabout = new UserAbout();
    $modelabout->scenario = 'create';
    $bank = ArrayHelper::map(Masterbank::find()->asArray()->all(), 'id', 'bank');
    $infoofrecruitment = ArrayHelper::map(Masterinfoofrecruitment::find()->where(['status' => 1])->asArray()->all(), 'id', 'infoofrecruitment');

    if ($model->load(Yii::$app->request->post()) && $modelabout->load(Yii::$app->request->post())) {
      $model->userid = $id;
      $model->createtime = date('Y-m-d H-i-s');
      $model->updatetime = date('Y-m-d H-i-s');
      $modelabout->userid = $id;
      $modelabout->createtime = date('Y-m-d H-i-s');
      $modelabout->updatetime = date('Y-m-d H-i-s');
      $modelabout->createdby = Yii::$app->user->identity->id;
      $modelabout->updatedby = Yii::$app->user->identity->id;
      $modelabout->bankaccountnumber = trim($modelabout->bankaccountnumber, " ");
      $modelabout->passbook = UploadedFile::getInstance($modelabout, 'passbook');
      if ($modelabout->passbook) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        // @unlink($assetUrl.'/upload/bankaccount/'. $old_filei);
        $fileextp = $modelabout->passbook->extension;
        $filep = $id . '-bankaccount.' . $fileextp;
        if ($modelabout->passbook->saveAs($assetUrl . '/upload/bankaccount/' . $filep)) {
          $modelabout->passbook = $filep;
        }
      }
      // var_dump($modelabout->whenpsikotest);die;
      if ($model->save() && $modelabout->save()) {
        return $this->redirect(['views', 'userid' => $userid]);
      }
    } else {
      return $this->render('create', [
        'model' => $model,
        'modelabout' => $modelabout,
        'userid' => $userid,
        'bank' => $bank,
        'infoofrecruitment' => $infoofrecruitment,
        'userid' => $userid,
      ]);
    }
  }
  public function actionCwizard()
  {
    $id = Yii::$app->user->identity->id;
    if (Yii::$app->check->cuserainfo($id) == 0) {
      $this->layout = Yii::$app->utils->getlayout();
      $model = new Userhealth();
      $modelabout = new UserAbout();
      $modelabout->scenario = 'create';
      $bank = ArrayHelper::map(Masterbank::find()->asArray()->all(), 'id', 'bank');
      $infoofrecruitment = ArrayHelper::map(Masterinfoofrecruitment::find()->where(['status' => 1])->asArray()->all(), 'id', 'infoofrecruitment');

      if ($model->load(Yii::$app->request->post()) && $modelabout->load(Yii::$app->request->post())) {
        $model->userid = $id;
        $model->createtime = date('Y-m-d H-i-s');
        $model->updatetime = date('Y-m-d H-i-s');
        $modelabout->userid = $id;
        $modelabout->createtime = date('Y-m-d H-i-s');
        $modelabout->updatetime = date('Y-m-d H-i-s');
        $modelabout->createdby = Yii::$app->user->identity->id;
        $modelabout->updatedby = Yii::$app->user->identity->id;
        $modelabout->bankaccountnumber = trim($modelabout->bankaccountnumber, " ");
        $modelabout->passbook = UploadedFile::getInstance($modelabout, 'passbook');
        if ($modelabout->passbook) {
          $assetUrl = Yii::getAlias('@app') . '/assets';
          // @unlink($assetUrl.'/upload/bankaccount/'. $old_filei);
          $fileextp = $modelabout->passbook->extension;
          $filep = $id . '-bankaccount.' . $fileextp;
          if ($modelabout->passbook->saveAs($assetUrl . '/upload/bankaccount/' . $filep)) {
            $modelabout->passbook = $filep;
          }
        }
        if ($model->save() && $modelabout->save()) {
          return $this->redirect(['uploadocument/cwizard']);
        }
      } else {
        return $this->render('create', [
          'model' => $model,
          'modelabout' => $modelabout,
          'bank' => $bank,
          'infoofrecruitment' => $infoofrecruitment,
          'userid' => $id,
        ]);
      }
    } else {
      return $this->redirect(['uwizard', 'id' => $id]);
    }
  }
  public function actionUwizard($id)
  {
    $this->layout = Yii::$app->utils->getlayout();
    $userid = $id;
    $model = Userhealth::find()->where(['userid' => $userid])->one();
    $cmodelabout = UserAbout::find()->where(['userid' => $model->userid])->one();
    if ($cmodelabout) {
      $modelabout = $cmodelabout;
    } else {
      $modelabout = new Userabout;
    }

    $old_filepb = $modelabout->passbook;
    if ($modelabout->passbook) {
      $modelabout->scenario = 'update';
    } else {
      $modelabout->scenario = 'updatepass';
    }

    $bank = ArrayHelper::map(Masterbank::find()->asArray()->all(), 'id', 'bank');
    $infoofrecruitment = ArrayHelper::map(Masterinfoofrecruitment::find()->where(['status' => 1])->asArray()->all(), 'id', 'infoofrecruitment');

    if ($model->load(Yii::$app->request->post()) && $modelabout->load(Yii::$app->request->post())) {
      $model->createtime = date('Y-m-d H-i-s');
      $model->updatetime = date('Y-m-d H-i-s');
      if ($model->userid) {
        $modelabout->userid = $model->userid;
      }
      $modelabout->createtime = date('Y-m-d H-i-s');
      $modelabout->updatetime = date('Y-m-d H-i-s');
      $modelabout->updatedby = Yii::$app->user->identity->id;
      $modelabout->bankaccountnumber = trim($modelabout->bankaccountnumber, " ");
      $modelabout->passbook = UploadedFile::getInstance($modelabout, 'passbook');
      if ($modelabout->passbook) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        @unlink($assetUrl . '/upload/bankaccount/' . $old_filepb);
        $fileextp = $modelabout->passbook->extension;
        $filep = $model->userid . '-bankaccount.' . $fileextp;
        if ($modelabout->passbook->saveAs($assetUrl . '/upload/bankaccount/' . $filep)) {
          $modelabout->passbook = $filep;
        }
      }
      if (empty($modelabout->passbook)) {
        $modelabout->passbook = $old_filepb;
      }
      if ($model->save() && $modelabout->save()) {
        return $this->redirect(['uploadocument/cwizard']);
      }
    } else {
      return $this->render('update', [
        'model' => $model,
        'modelabout' => $modelabout,
        'bank' => $bank,
        'infoofrecruitment' => $infoofrecruitment,
      ]);
    }
  }


  /**
   * Updates an existing Userhealth model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   */
  public function actionUpdate($id)
  {
    $this->layout = Yii::$app->utils->getlayout();
    $userid = $id;
    $model = Userhealth::find()->where(['userid' => $userid])->one();
    $cmodelabout = UserAbout::find()->where(['userid' => $model->userid])->one();

    if ($cmodelabout) {
      $modelabout = $cmodelabout;
    } else {
      $modelabout = new Userabout;
    }
    $old_filepb = $modelabout->passbook;

    if ($modelabout->passbook) {
      $modelabout->scenario = 'update';
    } else {
      // var_dump($old_filepb);die;
      $modelabout->scenario = 'updatepass';
    }
    $bank = ArrayHelper::map(Masterbank::find()->asArray()->all(), 'id', 'bank');
    $infoofrecruitment = ArrayHelper::map(Masterinfoofrecruitment::find()->where(['status' => 1])->asArray()->all(), 'id', 'infoofrecruitment');

    if ($model->load(Yii::$app->request->post()) && $modelabout->load(Yii::$app->request->post())) {
      $model->createtime = date('Y-m-d H-i-s');
      $model->updatetime = date('Y-m-d H-i-s');
      if ($model->userid) {
        $modelabout->userid = $model->userid;
      }
      $modelabout->createtime = date('Y-m-d H-i-s');
      $modelabout->updatetime = date('Y-m-d H-i-s');
      $modelabout->updatedby = Yii::$app->user->identity->id;

      $modelabout->bankaccountnumber = trim($modelabout->bankaccountnumber, " ");
      $modelabout->passbook = UploadedFile::getInstance($modelabout, 'passbook');

      if ($modelabout->passbook) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        @unlink($assetUrl . '/upload/bankaccount/' . $old_filepb);
        $fileextp = $modelabout->passbook->extension;
        $filep = $model->userid . '-bankaccount.' . $fileextp;
        if ($modelabout->passbook->saveAs($assetUrl . '/upload/bankaccount/' . $filep)) {
          $modelabout->passbook = $filep;
        }
      }
      if (empty($modelabout->passbook)) {
        $modelabout->passbook = $old_filepb;
      }

      if ($model->save() && $modelabout->save()) {
        return $this->redirect(['views', 'userid' => $model->userid]);
      } else {
        return $this->render('update', [
          'model' => $model,
          'modelabout' => $modelabout,
          'userid' => $model->userid,
          'bank' => $bank,
          'infoofrecruitment' => $infoofrecruitment,
        ]);
      }
    } else {
      return $this->render('update', [
        'model' => $model,
        'modelabout' => $modelabout,
        'userid' => $model->userid,
        'bank' => $bank,
        'infoofrecruitment' => $infoofrecruitment,
      ]);
    }
  }

  /**
   * Deletes an existing Userhealth model.
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
   * Finds the Userhealth model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Userhealth the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Userhealth::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }
}
