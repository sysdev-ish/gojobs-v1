<?php

namespace app\controllers;

use Yii;
use app\models\Userformaleducation;
use app\models\Userformaleducationsearch;
use app\models\Modeldynamic;
use app\models\Mastereducation;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

/**
 * UserformaleducationController implements the CRUD actions for Userformaleducation model.
 */
class UserformaleducationController extends Controller
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
   * Lists all Userformaleducation models.
   * @return mixed
   */
  // public function actionIndex()
  // {
  //     $searchModel = new Userformaleducationsearch();
  //     $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
  //
  //     return $this->render('index', [
  //         'searchModel' => $searchModel,
  //         'dataProvider' => $dataProvider,
  //     ]);
  // }

  /**
   * Displays a single Userformaleducation model.
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
    $model = Userformaleducation::find()->where(['userid' => $userid])->one();
    if ($model) {
      $modelall = Userformaleducation::find()->where(['userid' => $userid])->all();
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
   * Creates a new Userformaleducation model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate($userid)
  {
    $id = $userid;
    if (Yii::$app->check->cuserfeducation($id) == 0) {
      $this->layout = Yii::$app->utils->getlayout();
      $education = ArrayHelper::map(Mastereducation::find()->asArray()->all(), 'idmastereducation', 'education');
      $model = new Userformaleducation();
      $modelfedu = [new Userformaleducation()];

      if ($model->load(Yii::$app->request->post())) {
        $modelfedu = Modeldynamic::createMultiple(Userformaleducation::classname());
        Modeldynamic::loadMultiple($modelfedu, Yii::$app->request->post());
        if (Yii::$app->request->isAjax) {
          Yii::$app->response->format = Response::FORMAT_JSON;
          return ArrayHelper::merge(
            ActiveForm::validateMultiple($modelfedu)
          );
        }
        $valid = Modeldynamic::validateMultiple($modelfedu);
        if ($valid) {
          $transaction = \Yii::$app->db->beginTransaction();
          try {

            foreach ($modelfedu as $modelfedus) {
              $modelfedus->userid = $id;
              $modelfedus->createtime = date('Y-m-d H-i-s');
              $modelfedus->updatetime = date('Y-m-d H-i-s');

              if (!($flag = $modelfedus->save(false))) {
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
        'modelfedu' => $modelfedu,
        'education' => $education,
        'userid' => $userid,
      ]);
    } else {
      return $this->redirect(['update', 'id' => $id]);
    }
  }
  public function actionCwizard()
  {
    $id = Yii::$app->user->identity->id;
    if (Yii::$app->check->cuserfeducation($id) == 0) {
      $this->layout = Yii::$app->utils->getlayout();
      $education = ArrayHelper::map(Mastereducation::find()->asArray()->all(), 'idmastereducation', 'education');
      $model = new Userformaleducation();
      $modelfedu = [new Userformaleducation()];

      if ($model->load(Yii::$app->request->post())) {
        $modelfedu = Modeldynamic::createMultiple(Userformaleducation::classname());
        Modeldynamic::loadMultiple($modelfedu, Yii::$app->request->post());
        if (Yii::$app->request->isAjax) {
          Yii::$app->response->format = Response::FORMAT_JSON;
          return ArrayHelper::merge(
            ActiveForm::validateMultiple($modelfedu)
          );
        }
        $valid = Modeldynamic::validateMultiple($modelfedu);
        if ($valid) {
          $transaction = \Yii::$app->db->beginTransaction();
          try {

            foreach ($modelfedu as $modelfedus) {
              $modelfedus->userid = $id;
              $modelfedus->createtime = date('Y-m-d H-i-s');
              $modelfedus->updatetime = date('Y-m-d H-i-s');

              if (!($flag = $modelfedus->save(false))) {
                $transaction->rollBack();
                break;
              }
            }


            if ($flag) {
              $transaction->commit();
              return $this->redirect(['usernonformaleducation/cwizard']);
            }
          } catch (Exception $e) {
            $transaction->rollBack();
          }
        }
      }
      return $this->render('create', [
        'model' => $model,
        'modelfedu' => $modelfedu,
        'education' => $education,
        'userid' => $id,
      ]);
    } else {
      return $this->redirect(['uwizard', 'id' => $id]);
    }
  }

  /**
   * Updates an existing Userformaleducation model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   */
  public function actionUwizard($id)
  {
    $this->layout = Yii::$app->utils->getlayout();
    $userid = $id;
    $model = Userformaleducation::find()->where(['userid' => $userid])->one();
    $oldIDs = Userformaleducation::find()->select('id')->where(['userid' => $model->userid])->asArray()->all();
    $oldIDs = ArrayHelper::getColumn($oldIDs, 'id');
    $modelfedus = Userformaleducation::findAll(['id' => $oldIDs]);
    $modelfedu = (empty($modelfedus)) ? [new Userformaleducation] : $modelfedus;
    $education = ArrayHelper::map(Mastereducation::find()->asArray()->all(), 'idmastereducation', 'education');

    if ($model->load(Yii::$app->request->post())) {

      $modelfedu = Modeldynamic::createMultiple(Userformaleducation::classname());
      Modeldynamic::loadMultiple($modelfedu, Yii::$app->request->post());
      $newaudIds = ArrayHelper::getColumn($modelfedu, 'id');

      $delaudIds = array_diff($oldIDs, $newaudIds);
      if (!empty($delaudIds)) Userformaleducation::deleteAll(['id' => $delaudIds]);

      if (Yii::$app->request->isAjax) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ArrayHelper::merge(
          ActiveForm::validateMultiple($modelfedu)
        );
      }
      $valid = Modeldynamic::validateMultiple($modelfedu);
      if ($valid) {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
          if ($flag = $model->save(false)) {
            foreach ($modelfedu as $modelfedus) {
              $modelfedus->userid = $userid;
              $modelfedus->createtime = date('Y-m-d H-i-s');
              $modelfedus->updatetime = date('Y-m-d H-i-s');
              if (!($flag = $modelfedus->save(false))) {
                $transaction->rollBack();
                break;
              }
            }
          }

          if ($flag) {
            $transaction->commit();
            return $this->redirect(['usernonformaleducation/cwizard']);
          }
        } catch (Exception $e) {
          $transaction->rollBack();
        }
      }
    }
    return $this->render('update', [
      'model' => $model,
      'modelfedu' => $modelfedu,
      'education' => $education,
    ]);
  }
  public function actionUpdate($id)
  {
    $this->layout = Yii::$app->utils->getlayout();
    $userid = $id;
    $model = Userformaleducation::find()->where(['userid' => $userid])->one();
    $oldIDs = Userformaleducation::find()->select('id')->where(['userid' => $model->userid])->asArray()->all();
    $oldIDs = ArrayHelper::getColumn($oldIDs, 'id');
    $modelfedus = Userformaleducation::findAll(['id' => $oldIDs]);
    $modelfedu = (empty($modelfedus)) ? [new Userformaleducation] : $modelfedus;
    $education = ArrayHelper::map(Mastereducation::find()->asArray()->all(), 'idmastereducation', 'education');

    if ($model->load(Yii::$app->request->post())) {

      $modelfedu = Modeldynamic::createMultiple(Userformaleducation::classname());
      Modeldynamic::loadMultiple($modelfedu, Yii::$app->request->post());
      $newaudIds = ArrayHelper::getColumn($modelfedu, 'id');

      $delaudIds = array_diff($oldIDs, $newaudIds);
      if (!empty($delaudIds)) Userformaleducation::deleteAll(['id' => $delaudIds]);

      if (Yii::$app->request->isAjax) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ArrayHelper::merge(
          ActiveForm::validateMultiple($modelfedu)
        );
      }
      $valid = Modeldynamic::validateMultiple($modelfedu);
      if ($valid) {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
          if ($flag = $model->save(false)) {
            foreach ($modelfedu as $modelfedus) {
              $modelfedus->userid = $model->userid;
              $modelfedus->createtime = date('Y-m-d H-i-s');
              $modelfedus->updatetime = date('Y-m-d H-i-s');
              if (!($flag = $modelfedus->save(false))) {
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
      'modelfedu' => $modelfedu,
      'education' => $education,
      'userid' => $model->userid,
    ]);
  }

  /**
   * Deletes an existing Userformaleducation model.
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
   * Finds the Userformaleducation model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Userformaleducation the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Userformaleducation::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }
}
