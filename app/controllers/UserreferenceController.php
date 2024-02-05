<?php

namespace app\controllers;

use Yii;
use app\models\Userreference;
use app\models\Userreferencesearch;
use app\models\Modeldynamic;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

/**
 * UserreferenceController implements the CRUD actions for Userreference model.
 */
class UserreferenceController extends Controller
{
  /**
   * @inheritdoc
   */
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'only' => ['update', 'create', 'view', 'delete', 'views', 'cwizard', 'uwizard'],
        'rules' => [

          [
            'actions' => ['view', 'delete'],
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
   * Lists all Userreference models.
   * @return mixed
   */
  // public function actionIndex()
  // {
  //     $searchModel = new Userreferencesearch();
  //     $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
  //
  //     return $this->render('index', [
  //         'searchModel' => $searchModel,
  //         'dataProvider' => $dataProvider,
  //     ]);
  // }

  /**
   * Displays a single Userreference model.
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
    $model = Userreference::find()->where(['userid' => $userid])->one();
    if ($model) {
      $modelall = Userreference::find()->where(['userid' => $userid])->all();
      return $this->render('view', [
        'model' => $model,
        'modelall' => $modelall,
        'userid' => $userid,
      ]);
    } else {
      return $this->redirect(['create', 'userid' => $userid]);
    }
  }

  /**
   * Creates a new Userreference model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate($userid)
  {
    $id = $userid;
    $this->layout = Yii::$app->utils->getlayout();
    $model = new Userreference();
    $modelureff = [new Userreference()];

    if ($model->load(Yii::$app->request->post())) {

      $modelureff = Modeldynamic::createMultiple(Userreference::classname());
      Modeldynamic::loadMultiple($modelureff, Yii::$app->request->post());

      if (Yii::$app->request->isAjax) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ArrayHelper::merge(
          ActiveForm::validateMultiple($modelureff)
        );
      }

      $valid = Modeldynamic::validateMultiple($modelureff);


      if ($valid) {
        $transaction = \Yii::$app->db->beginTransaction();
        try {

          foreach ($modelureff as $indexmodelwexps => $modelureffs) {
            $modelureffs->userid = $id;
            $modelureffs->createtime = date('Y-m-d H-i-s');
            $modelureffs->updatetime = date('Y-m-d H-i-s');

            if (!($flag = $modelureffs->save(false))) {
              $transaction->rollBack();
              break;
            }
          }
          if ($flag) {

            $transaction->commit();
            return $this->redirect(['views', 'userid' => $userid]);
          }
        } catch (Exception $e) {
          $transaction->rollBack();
        }
      }
    }
    return $this->render('create', [
      'model' => $model,
      'modelureff' => $modelureff,
      'userid' => $userid,
    ]);
  }
  public function actionCwizard()
  {
    $id = Yii::$app->user->identity->id;
    if (Yii::$app->check->cuserreff($id) == 0) {
      $this->layout = Yii::$app->utils->getlayout();
      $model = new Userreference();
      $modelureff = [new Userreference()];

      if ($model->load(Yii::$app->request->post())) {

        $modelureff = Modeldynamic::createMultiple(Userreference::classname());
        Modeldynamic::loadMultiple($modelureff, Yii::$app->request->post());

        if (Yii::$app->request->isAjax) {
          Yii::$app->response->format = Response::FORMAT_JSON;
          return ArrayHelper::merge(
            ActiveForm::validateMultiple($modelureff)
          );
        }

        $valid = Modeldynamic::validateMultiple($modelureff);


        if ($valid) {
          $transaction = \Yii::$app->db->beginTransaction();
          try {

            foreach ($modelureff as $indexmodelwexps => $modelureffs) {
              $modelureffs->userid = $id;
              $modelureffs->createtime = date('Y-m-d H-i-s');
              $modelureffs->updatetime = date('Y-m-d H-i-s');

              if (!($flag = $modelureffs->save(false))) {
                $transaction->rollBack();
                break;
              }
            }
            if ($flag) {

              $transaction->commit();
              return $this->redirect(['useraddinfo/cwizard']);
            }
          } catch (Exception $e) {
            $transaction->rollBack();
          }
        }
      }
      return $this->render('create', [
        'model' => $model,
        'modelureff' => $modelureff,
        'userid' => $id,
      ]);
    } else {
      return $this->redirect(['uwizard', 'id' => $id]);
    }
  }

  /**
   * Updates an existing Userreference model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   */
  public function actionUwizard($id)
  {
    $this->layout = Yii::$app->utils->getlayout();
    $userid = $id;
    $model = Userreference::find()->where(['userid' => $userid])->one();
    $userid = $model->userid;

    $oldIDs = Userreference::find()->select('id')->where(['userid' => $model->userid])->asArray()->all();
    $oldIDs = ArrayHelper::getColumn($oldIDs, 'id');

    $modelureffs = Userreference::findAll(['id' => $oldIDs]);
    $modelureff = (empty($modelureffs)) ? [new Userreference] : $modelureffs;



    if ($model->load(Yii::$app->request->post())) {

      $modelureff = Modeldynamic::createMultiple(Userreference::classname());
      Modeldynamic::loadMultiple($modelureff, Yii::$app->request->post());
      $newaudIds = ArrayHelper::getColumn($modelureff, 'id');

      $delaudIds = array_diff($oldIDs, $newaudIds);
      if (!empty($delaudIds)) Userreference::deleteAll(['id' => $delaudIds]);

      if (Yii::$app->request->isAjax) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ArrayHelper::merge(
          ActiveForm::validateMultiple($modelureff)
        );
      }
      $valid = Modeldynamic::validateMultiple($modelureff);
      if ($valid) {
        $transaction = \Yii::$app->db->beginTransaction();
        try {

          foreach ($modelureff as $modelureffs) {
            $modelureffs->userid = $userid;
            $modelureffs->createtime = date('Y-m-d H-i-s');
            $modelureffs->updatetime = date('Y-m-d H-i-s');
            if (!($flag = $modelureffs->save(false))) {
              $transaction->rollBack();
              break;
            }
          }


          if ($flag) {
            $transaction->commit();
            return $this->redirect(['useraddinfo/cwizard']);
          }
        } catch (Exception $e) {
          $transaction->rollBack();
        }
      }
    }
    return $this->render('update', [
      'model' => $model,
      'modelureff' => $modelureff,
    ]);
  }
  public function actionUpdate($id)
  {
    $this->layout = Yii::$app->utils->getlayout();
    $userid = $id;
    $model = Userreference::find()->where(['userid' => $userid])->one();

    $oldIDs = Userreference::find()->select('id')->where(['userid' => $model->userid])->asArray()->all();
    $oldIDs = ArrayHelper::getColumn($oldIDs, 'id');

    $modelureffs = Userreference::findAll(['id' => $oldIDs]);
    $modelureff = (empty($modelureffs)) ? [new Userreference] : $modelureffs;



    if ($model->load(Yii::$app->request->post())) {

      $modelureff = Modeldynamic::createMultiple(Userreference::classname());
      Modeldynamic::loadMultiple($modelureff, Yii::$app->request->post());
      $newaudIds = ArrayHelper::getColumn($modelureff, 'id');

      $delaudIds = array_diff($oldIDs, $newaudIds);
      if (!empty($delaudIds)) Userreference::deleteAll(['id' => $delaudIds]);

      if (Yii::$app->request->isAjax) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ArrayHelper::merge(
          ActiveForm::validateMultiple($modelureff)
        );
      }
      $valid = Modeldynamic::validateMultiple($modelureff);
      if ($valid) {
        $transaction = \Yii::$app->db->beginTransaction();
        try {

          foreach ($modelureff as $modelureffs) {
            $modelureffs->userid = $userid;
            $modelureffs->createtime = date('Y-m-d H-i-s');
            $modelureffs->updatetime = date('Y-m-d H-i-s');
            if (!($flag = $modelureffs->save(false))) {
              $transaction->rollBack();
              break;
            }
          }


          if ($flag) {
            $transaction->commit();
            return $this->redirect(['views', 'userid' => $model->userid]);
          }
        } catch (Exception $e) {
          $transaction->rollBack();
        }
      }
    }
    return $this->render('update', [
      'model' => $model,
      'modelureff' => $modelureff,
      'userid' => $model->userid,
    ]);
  }

  /**
   * Deletes an existing Userreference model.
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
   * Finds the Userreference model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Userreference the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Userreference::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }
}
