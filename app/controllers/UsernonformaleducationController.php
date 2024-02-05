<?php

namespace app\controllers;

use Yii;
use app\models\Usernonformaleducation;
use app\models\Usernonformaleducationsearch;
use app\models\Modeldynamic;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

/**
 * UsernonformaleducationController implements the CRUD actions for Usernonformaleducation model.
 */
class UsernonformaleducationController extends Controller
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
   * Lists all Usernonformaleducation models.
   * @return mixed
   */
  // public function actionIndex()
  // {
  //     $searchModel = new Usernonformaleducationsearch();
  //     $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
  //
  //     return $this->render('index', [
  //         'searchModel' => $searchModel,
  //         'dataProvider' => $dataProvider,
  //     ]);
  // }

  /**
   * Displays a single Usernonformaleducation model.
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
    $model = Usernonformaleducation::find()->where(['userid' => $userid])->one();
    if ($model) {
      $modelall = Usernonformaleducation::find()->where(['userid' => $userid])->all();
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
   * Creates a new Usernonformaleducation model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate($userid)
  {
    $id = $userid;

    $this->layout = Yii::$app->utils->getlayout();
    $model = new Usernonformaleducation();
    $modelnfedu = [new Usernonformaleducation()];

    if ($model->load(Yii::$app->request->post())) {
      $modelnfedu = Modeldynamic::createMultiple(Usernonformaleducation::classname());
      Modeldynamic::loadMultiple($modelnfedu, Yii::$app->request->post());
      if (Yii::$app->request->isAjax) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ArrayHelper::merge(
          ActiveForm::validateMultiple($modelnfedu)
        );
      }
      $valid = Modeldynamic::validateMultiple($modelnfedu);
      if ($valid) {
        $transaction = \Yii::$app->db->beginTransaction();
        try {

          foreach ($modelnfedu as $modelnfedus) {
            $modelnfedus->userid = $id;
            $modelnfedus->createtime = date('Y-m-d H-i-s');
            $modelnfedus->updatetime = date('Y-m-d H-i-s');
            $modelnfedus->startdate = $modelnfedus->startdate . '-01';
            $modelnfedus->enddate = $modelnfedus->enddate . '-01';

            if (!($flag = $modelnfedus->save(false))) {
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
      'modelnfedu' => $modelnfedu,
      'userid' => $userid,
    ]);
  }
  public function actionCwizard()
  {
    $id = Yii::$app->user->identity->id;
    if (Yii::$app->check->cusernfeducation($id) == 0) {
      $this->layout = Yii::$app->utils->getlayout();
      $model = new Usernonformaleducation();
      $modelnfedu = [new Usernonformaleducation()];

      if ($model->load(Yii::$app->request->post())) {
        $modelnfedu = Modeldynamic::createMultiple(Usernonformaleducation::classname());
        Modeldynamic::loadMultiple($modelnfedu, Yii::$app->request->post());
        if (Yii::$app->request->isAjax) {
          Yii::$app->response->format = Response::FORMAT_JSON;
          return ArrayHelper::merge(
            ActiveForm::validateMultiple($modelnfedu)
          );
        }
        $valid = Modeldynamic::validateMultiple($modelnfedu);
        if ($valid) {
          $transaction = \Yii::$app->db->beginTransaction();
          try {

            foreach ($modelnfedu as $modelnfedus) {
              $modelnfedus->userid = $id;
              $modelnfedus->createtime = date('Y-m-d H-i-s');
              $modelnfedus->updatetime = date('Y-m-d H-i-s');
              $modelnfedus->startdate = $modelnfedus->startdate . '-01';
              $modelnfedus->enddate = $modelnfedus->enddate . '-01';

              if (!($flag = $modelnfedus->save(false))) {
                $transaction->rollBack();
                break;
              }
            }


            if ($flag) {
              $transaction->commit();
              return $this->redirect(['userskill/cwizard']);
            }
          } catch (Exception $e) {
            $transaction->rollBack();
          }
        }
      }
      return $this->render('create', [
        'model' => $model,
        'modelnfedu' => $modelnfedu,
        'userid' => $id,
      ]);
    } else {
      return $this->redirect(['uwizard', 'id' => $id]);
    }
  }

  /**
   * Updates an existing Usernonformaleducation model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   */
  public function actionUwizard($id)
  {
    $this->layout = Yii::$app->utils->getlayout();
    $userid = $id;
    $model = Usernonformaleducation::find()->where(['userid' => $userid])->one();
    $oldIDs = Usernonformaleducation::find()->select('id')->where(['userid' => $model->userid])->asArray()->all();
    $oldIDs = ArrayHelper::getColumn($oldIDs, 'id');
    $modelnfedus = Usernonformaleducation::findAll(['id' => $oldIDs]);
    $modelnfedu = (empty($modelnfedus)) ? [new Usernonformaleducation] : $modelnfedus;

    if ($model->load(Yii::$app->request->post())) {

      $modelnfedu = Modeldynamic::createMultiple(Usernonformaleducation::classname());
      Modeldynamic::loadMultiple($modelnfedu, Yii::$app->request->post());
      $newaudIds = ArrayHelper::getColumn($modelnfedu, 'id');

      $delaudIds = array_diff($oldIDs, $newaudIds);
      if (!empty($delaudIds)) Usernonformaleducation::deleteAll(['id' => $delaudIds]);

      if (Yii::$app->request->isAjax) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ArrayHelper::merge(
          ActiveForm::validateMultiple($modelnfedu)
        );
      }
      $valid = Modeldynamic::validateMultiple($modelnfedu);
      if ($valid) {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
          if ($flag = $model->save(false)) {
            foreach ($modelnfedu as $modelnfedus) {
              $modelnfedus->userid = $userid;
              $modelnfedus->createtime = date('Y-m-d H-i-s');
              $modelnfedus->updatetime = date('Y-m-d H-i-s');
              $modelnfedus->startdate = $modelnfedus->startdate . '-01';
              $modelnfedus->enddate = $modelnfedus->enddate . '-01';
              if (!($flag = $modelnfedus->save(false))) {
                $transaction->rollBack();
                break;
              }
            }
          }

          if ($flag) {
            $transaction->commit();
            return $this->redirect(['userskill/cwizard']);
          }
        } catch (Exception $e) {
          $transaction->rollBack();
        }
      }
    }
    return $this->render('update', [
      'model' => $model,
      'modelnfedu' => $modelnfedu,
    ]);
  }
  public function actionUpdate($id)
  {
    $this->layout = Yii::$app->utils->getlayout();
    $userid = $id;
    $model = Usernonformaleducation::find()->where(['userid' => $userid])->one();
    $oldIDs = Usernonformaleducation::find()->select('id')->where(['userid' => $model->userid])->asArray()->all();
    $oldIDs = ArrayHelper::getColumn($oldIDs, 'id');
    $modelnfedus = Usernonformaleducation::findAll(['id' => $oldIDs]);
    $modelnfedu = (empty($modelnfedus)) ? [new Usernonformaleducation] : $modelnfedus;

    if ($model->load(Yii::$app->request->post())) {

      $modelnfedu = Modeldynamic::createMultiple(Usernonformaleducation::classname());
      Modeldynamic::loadMultiple($modelnfedu, Yii::$app->request->post());
      $newaudIds = ArrayHelper::getColumn($modelnfedu, 'id');

      $delaudIds = array_diff($oldIDs, $newaudIds);
      if (!empty($delaudIds)) Usernonformaleducation::deleteAll(['id' => $delaudIds]);

      if (Yii::$app->request->isAjax) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ArrayHelper::merge(
          ActiveForm::validateMultiple($modelnfedu)
        );
      }
      $valid = Modeldynamic::validateMultiple($modelnfedu);
      if ($valid) {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
          if ($flag = $model->save(false)) {
            foreach ($modelnfedu as $modelnfedus) {
              $modelnfedus->userid = $model->userid;
              $modelnfedus->createtime = date('Y-m-d H-i-s');
              $modelnfedus->updatetime = date('Y-m-d H-i-s');
              $modelnfedus->startdate = $modelnfedus->startdate . '-01';
              $modelnfedus->enddate = $modelnfedus->enddate . '-01';
              if (!($flag = $modelnfedus->save(false))) {
                $transaction->rollBack();
                break;
              }
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
      'modelnfedu' => $modelnfedu,
      'userid' => $model->userid,
    ]);
  }

  /**
   * Deletes an existing Usernonformaleducation model.
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
   * Finds the Usernonformaleducation model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Usernonformaleducation the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Usernonformaleducation::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }
}
