<?php

namespace app\controllers;

use Yii;
use app\models\Organizationactivity;
use app\models\Organizationactivitysearch;
use app\models\Modeldynamic;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;


/**
 * OrganizationactivityController implements the CRUD actions for Organizationactivity model.
 */
class OrganizationactivityController extends Controller
{
  /**
   * @inheritdoc
   */
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'only' => ['update', 'create', 'view', 'delete', 'getroom', 'views', 'cwizard', 'uwizard'],
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
   * Lists all Organizationactivity models.
   * @return mixed
   */
  // public function actionIndex()
  // {
  //     $searchModel = new Organizationactivitysearch();
  //     $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
  //
  //     return $this->render('index', [
  //         'searchModel' => $searchModel,
  //         'dataProvider' => $dataProvider,
  //     ]);
  // }

  /**
   * Displays a single Organizationactivity model.
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
    $model = Organizationactivity::find()->where(['userid' => $userid])->one();
    if ($model) {
      $modelall = Organizationactivity::find()->where(['userid' => $userid])->all();
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
   * Creates a new Organizationactivity model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate($userid)
  {
    $id = $userid;
    $this->layout = Yii::$app->utils->getlayout();
    $model = new Organizationactivity();
    $modeloact = [new Organizationactivity()];

    if ($model->load(Yii::$app->request->post())) {

      $modeloact = Modeldynamic::createMultiple(Organizationactivity::classname());
      Modeldynamic::loadMultiple($modeloact, Yii::$app->request->post());

      if (Yii::$app->request->isAjax) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ArrayHelper::merge(
          ActiveForm::validateMultiple($modeloact)
        );
      }

      $valid = Modeldynamic::validateMultiple($modeloact);


      if ($valid) {
        $transaction = \Yii::$app->db->beginTransaction();
        try {

          foreach ($modeloact as $indexmodelwexps => $modeloacts) {
            $modeloacts->userid = $id;
            $modeloacts->createtime = date('Y-m-d H-i-s');
            $modeloacts->updatetime = date('Y-m-d H-i-s');

            if (!($flag = $modeloacts->save(false))) {
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
      'modeloact' => $modeloact,
      'userid' => $userid,
    ]);
  }
  public function actionCwizard()
  {
    $id = Yii::$app->user->identity->id;
    if (Yii::$app->check->cuserorgac($id) == 0) {
      $this->layout = Yii::$app->utils->getlayout();
      $model = new Organizationactivity();
      $modeloact = [new Organizationactivity()];

      if ($model->load(Yii::$app->request->post())) {

        $modeloact = Modeldynamic::createMultiple(Organizationactivity::classname());
        Modeldynamic::loadMultiple($modeloact, Yii::$app->request->post());

        if (Yii::$app->request->isAjax) {
          Yii::$app->response->format = Response::FORMAT_JSON;
          return ArrayHelper::merge(
            ActiveForm::validateMultiple($modeloact)
          );
        }

        $valid = Modeldynamic::validateMultiple($modeloact);


        if ($valid) {
          $transaction = \Yii::$app->db->beginTransaction();
          try {

            foreach ($modeloact as $indexmodelwexps => $modeloacts) {
              $modeloacts->userid = $id;
              $modeloacts->createtime = date('Y-m-d H-i-s');
              $modeloacts->updatetime = date('Y-m-d H-i-s');

              if (!($flag = $modeloacts->save(false))) {
                $transaction->rollBack();
                break;
              }
            }
            if ($flag) {

              $transaction->commit();
              return $this->redirect(['useremergencycontact/cwizard']);
            }
          } catch (Exception $e) {
            $transaction->rollBack();
          }
        }
      }
      return $this->render('create', [
        'model' => $model,
        'modeloact' => $modeloact,
        'userid' => $id,
      ]);
    } else {
      return $this->redirect(['uwizard', 'id' => $id]);
    }
  }

  /**
   * Updates an existing Organizationactivity model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   */
  public function actionUwizard($id)
  {
    $this->layout = Yii::$app->utils->getlayout();
    $userid = $id;
    $model = Organizationactivity::find()->where(['userid' => $userid])->one();

    $oldIDs = Organizationactivity::find()->select('id')->where(['userid' => $model->userid])->asArray()->all();
    $oldIDs = ArrayHelper::getColumn($oldIDs, 'id');

    $modeloacts = Organizationactivity::findAll(['id' => $oldIDs]);
    $modeloact = (empty($modeloacts)) ? [new Organizationactivity] : $modeloacts;



    if ($model->load(Yii::$app->request->post())) {

      $modeloact = Modeldynamic::createMultiple(Organizationactivity::classname());
      Modeldynamic::loadMultiple($modeloact, Yii::$app->request->post());
      $newaudIds = ArrayHelper::getColumn($modeloact, 'id');

      $delaudIds = array_diff($oldIDs, $newaudIds);
      if (!empty($delaudIds)) Organizationactivity::deleteAll(['id' => $delaudIds]);

      if (Yii::$app->request->isAjax) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ArrayHelper::merge(
          ActiveForm::validateMultiple($modeloact)
        );
      }
      $valid = Modeldynamic::validateMultiple($modeloact);
      if ($valid) {
        $transaction = \Yii::$app->db->beginTransaction();
        try {

          foreach ($modeloact as $modeloacts) {
            $modeloacts->userid = $userid;
            $modeloacts->createtime = date('Y-m-d H-i-s');
            $modeloacts->updatetime = date('Y-m-d H-i-s');
            if (!($flag = $modeloacts->save(false))) {
              $transaction->rollBack();
              break;
            }
          }


          if ($flag) {
            $transaction->commit();
            return $this->redirect(['useremergencycontact/cwizard']);
          }
        } catch (Exception $e) {
          $transaction->rollBack();
        }
      }
    }
    return $this->render('update', [
      'model' => $model,
      'modeloact' => $modeloact,
    ]);
  }
  public function actionUpdate($id)
  {
    $this->layout = Yii::$app->utils->getlayout();

    $userid = $id;
    $model = Organizationactivity::find()->where(['userid' => $userid])->one();

    $oldIDs = Organizationactivity::find()->select('id')->where(['userid' => $model->userid])->asArray()->all();
    $oldIDs = ArrayHelper::getColumn($oldIDs, 'id');

    $modeloacts = Organizationactivity::findAll(['id' => $oldIDs]);
    $modeloact = (empty($modeloacts)) ? [new Organizationactivity] : $modeloacts;



    if ($model->load(Yii::$app->request->post())) {

      $modeloact = Modeldynamic::createMultiple(Organizationactivity::classname());
      Modeldynamic::loadMultiple($modeloact, Yii::$app->request->post());
      $newaudIds = ArrayHelper::getColumn($modeloact, 'id');

      $delaudIds = array_diff($oldIDs, $newaudIds);
      if (!empty($delaudIds)) Organizationactivity::deleteAll(['id' => $delaudIds]);

      if (Yii::$app->request->isAjax) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ArrayHelper::merge(
          ActiveForm::validateMultiple($modeloact)
        );
      }
      $valid = Modeldynamic::validateMultiple($modeloact);
      if ($valid) {
        $transaction = \Yii::$app->db->beginTransaction();
        try {

          foreach ($modeloact as $modeloacts) {
            $modeloacts->userid = $userid;
            $modeloacts->createtime = date('Y-m-d H-i-s');
            $modeloacts->updatetime = date('Y-m-d H-i-s');
            if (!($flag = $modeloacts->save(false))) {
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
      'modeloact' => $modeloact,
      'userid' => $model->userid,
    ]);
  }

  /**
   * Deletes an existing Organizationactivity model.
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
   * Finds the Organizationactivity model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Organizationactivity the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Organizationactivity::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }
}
