<?php

namespace app\controllers;

use Yii;
use app\models\Userforeignlanguage;
use app\models\Englishskill;
use app\models\Computerskill;
use app\models\Userforeignlanguagesearch;
use app\models\Modeldynamic;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

/**
 * UserforeignlanguageController implements the CRUD actions for Userforeignlanguage model.
 */
class UserskillController extends Controller
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


  public function actionView($id)
  {
    return $this->render('view', [
      'model' => $this->findModel($id),
    ]);
  }
  public function actionViews($userid)
  {
    $this->layout = Yii::$app->utils->getlayout();
    $model = Userforeignlanguage::find()->where(['userid' => $userid])->one();
    if ($model) {
      $modelall = Userforeignlanguage::find()->where(['userid' => $userid])->all();
      $modeleskill = Englishskill::find()->where(['userid' => $userid])->one();
      $modelcskill = Computerskill::find()->where(['userid' => $userid])->one();
      return $this->render('view', [
        'model' => $model,
        'modelall' => $modelall,
        'modeleskill' => $modeleskill,
        'modelcskill' => $modelcskill,
        'userid' => $userid,
      ]);
    } else {
      return $this->redirect(['create', 'userid' => $userid]);
    }
  }

  /**
   * Creates a new Userforeignlanguage model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate($userid)
  {
    $id = $userid;
    $this->layout = Yii::$app->utils->getlayout();
    $model = new Userforeignlanguage();
    $modeleskill = new Englishskill();
    $modelcskill = new Computerskill();


    $modelflang = [new Userforeignlanguage()];
    if ($model->load(Yii::$app->request->post()) && $modeleskill->load(Yii::$app->request->post()) && $modelcskill->load(Yii::$app->request->post())) {
      $modeleskill->userid = $id;
      $modeleskill->createtime = date('Y-m-d H-i-s');
      $modeleskill->updatetime = date('Y-m-d H-i-s');
      $modelcskill->userid = $id;
      $modelcskill->createtime = date('Y-m-d H-i-s');
      $modelcskill->updatetime = date('Y-m-d H-i-s');
      $modelflang = Modeldynamic::createMultiple(Userforeignlanguage::classname());


      Modeldynamic::loadMultiple($modelflang, Yii::$app->request->post());
      if (Yii::$app->request->isAjax) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ArrayHelper::merge(
          ActiveForm::validateMultiple($modelflang)
        );
      }
      $valid = Modeldynamic::validateMultiple($modelflang);
      if ($valid) {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
          if ($flag = $modeleskill->save(false) && $flag = $modelcskill->save(false)) {
            foreach ($modelflang as $modelflangs) {
              $modelflangs->userid = $id;
              $modelflangs->createtime = date('Y-m-d H-i-s');
              $modelflangs->updatetime = date('Y-m-d H-i-s');

              if (!($flag = $modelflangs->save(false))) {
                $transaction->rollBack();
                break;
              }
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
      'modelflang' => $modelflang,
      'modeleskill' => $modeleskill,
      'modelcskill' => $modelcskill,
      'userid' => $userid,
    ]);
  }
  public function actionCwizard()
  {
    $id = Yii::$app->user->identity->id;
    if (Yii::$app->check->cuserflang($id) == 0) {
      $this->layout = Yii::$app->utils->getlayout();
      $model = new Userforeignlanguage();
      $modeleskill = new Englishskill();
      $modelcskill = new Computerskill();


      $modelflang = [new Userforeignlanguage()];

      if ($model->load(Yii::$app->request->post()) && $modeleskill->load(Yii::$app->request->post()) && $modelcskill->load(Yii::$app->request->post())) {
        $modeleskill->userid = $id;
        $modeleskill->createtime = date('Y-m-d H-i-s');
        $modeleskill->updatetime = date('Y-m-d H-i-s');
        $modelcskill->userid = $id;
        $modelcskill->createtime = date('Y-m-d H-i-s');
        $modelcskill->updatetime = date('Y-m-d H-i-s');
        $modelflang = Modeldynamic::createMultiple(Userforeignlanguage::classname());
        Modeldynamic::loadMultiple($modelflang, Yii::$app->request->post());
        if (Yii::$app->request->isAjax) {
          Yii::$app->response->format = Response::FORMAT_JSON;
          return ArrayHelper::merge(
            ActiveForm::validateMultiple($modelflang)
          );
        }
        $valid = Modeldynamic::validateMultiple($modelflang);
        if ($valid) {
          $transaction = \Yii::$app->db->beginTransaction();
          try {
            if ($flag = $modeleskill->save(false) && $flag = $modelcskill->save(false)) {
              foreach ($modelflang as $modelflangs) {
                $modelflangs->userid = $id;
                $modelflangs->createtime = date('Y-m-d H-i-s');
                $modelflangs->updatetime = date('Y-m-d H-i-s');

                if (!($flag = $modelflangs->save(false))) {
                  $transaction->rollBack();
                  break;
                }
              }
            }


            if ($flag) {

              $transaction->commit();
              return $this->redirect(['userworkexperience/cwizard']);
            }
          } catch (Exception $e) {
            $transaction->rollBack();
          }
        }
      }
      return $this->render('create', [
        'model' => $model,
        'modelflang' => $modelflang,
        'modeleskill' => $modeleskill,
        'modelcskill' => $modelcskill,
        'userid' => $id,
      ]);
    } else {
      return $this->redirect(['uwizard', 'id' => $id]);
    }
  }

  /**
   * Updates an existing Userforeignlanguage model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   */
  public function actionUwizard($id)
  {
    $this->layout = Yii::$app->utils->getlayout();
    $userid = $id;
    $model = Userforeignlanguage::find()->where(['userid' => $userid])->one();
    $modeleskill = Englishskill::find()->where(['userid' => $userid])->one();
    $modelcskill = Computerskill::find()->where(['userid' => $userid])->one();
    $oldIDs = Userforeignlanguage::find()->select('id')->where(['userid' => $model->userid])->asArray()->all();
    $oldIDs = ArrayHelper::getColumn($oldIDs, 'id');
    $modelflangs = Userforeignlanguage::findAll(['id' => $oldIDs]);
    $modelflang = (empty($modelflangs)) ? [new Userforeignlanguage] : $modelflangs;

    if ($model->load(Yii::$app->request->post()) && $modeleskill->load(Yii::$app->request->post()) && $modelcskill->load(Yii::$app->request->post())) {

      $modelflang = Modeldynamic::createMultiple(Userforeignlanguage::classname());
      Modeldynamic::loadMultiple($modelflang, Yii::$app->request->post());
      $newaudIds = ArrayHelper::getColumn($modelflang, 'id');

      $delaudIds = array_diff($oldIDs, $newaudIds);
      if (!empty($delaudIds)) Userforeignlanguage::deleteAll(['id' => $delaudIds]);

      if (Yii::$app->request->isAjax) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ArrayHelper::merge(
          ActiveForm::validateMultiple($modelflang)
        );
      }
      $valid = Modeldynamic::validateMultiple($modelflang);
      if ($valid) {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
          if ($flag = $modeleskill->save(false) && $flag = $modelcskill->save(false)) {
            foreach ($modelflang as $modelflangs) {
              $modelflangs->userid = $userid;
              $modelflangs->createtime = date('Y-m-d H-i-s');
              $modelflangs->updatetime = date('Y-m-d H-i-s');
              if (!($flag = $modelflangs->save(false))) {
                $transaction->rollBack();
                break;
              }
            }
          }

          if ($flag) {
            $transaction->commit();
            return $this->redirect(['userworkexperience/cwizard']);
          }
        } catch (Exception $e) {
          $transaction->rollBack();
        }
      }
    }
    return $this->render('update', [
      'model' => $model,
      'modelflang' => $modelflang,
      'modeleskill' => $modeleskill,
      'modelcskill' => $modelcskill,
    ]);
  }
  public function actionUpdate($id)
  {
    $this->layout = Yii::$app->utils->getlayout();

    $userid = $id;
    $model = Userforeignlanguage::find()->where(['userid' => $userid])->one();
    $modeleskill = Englishskill::find()->where(['userid' => $userid])->one();
    $modelcskill = Computerskill::find()->where(['userid' => $userid])->one();
    $oldIDs = Userforeignlanguage::find()->select('id')->where(['userid' => $model->userid])->asArray()->all();
    $oldIDs = ArrayHelper::getColumn($oldIDs, 'id');
    $modelflangs = Userforeignlanguage::findAll(['id' => $oldIDs]);
    $modelflang = (empty($modelflangs)) ? [new Userforeignlanguage] : $modelflangs;

    if ($model->load(Yii::$app->request->post()) && $modeleskill->load(Yii::$app->request->post()) && $modelcskill->load(Yii::$app->request->post())) {

      $modelflang = Modeldynamic::createMultiple(Userforeignlanguage::classname());
      Modeldynamic::loadMultiple($modelflang, Yii::$app->request->post());
      $newaudIds = ArrayHelper::getColumn($modelflang, 'id');

      $delaudIds = array_diff($oldIDs, $newaudIds);
      if (!empty($delaudIds)) Userforeignlanguage::deleteAll(['id' => $delaudIds]);

      if (Yii::$app->request->isAjax) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ArrayHelper::merge(
          ActiveForm::validateMultiple($modelflang)
        );
      }
      $valid = Modeldynamic::validateMultiple($modelflang);
      if ($valid) {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
          if ($flag = $modeleskill->save(false) && $flag = $modelcskill->save(false)) {
            foreach ($modelflang as $modelflangs) {
              $modelflangs->userid = $userid;
              $modelflangs->createtime = date('Y-m-d H-i-s');
              $modelflangs->updatetime = date('Y-m-d H-i-s');
              if (!($flag = $modelflangs->save(false))) {
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
      'modelflang' => $modelflang,
      'modeleskill' => $modeleskill,
      'modelcskill' => $modelcskill,
      'userid' => $model->userid,
    ]);
  }

  /**
   * Deletes an existing Userforeignlanguage model.
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
   * Finds the Userforeignlanguage model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Userforeignlanguage the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Userforeignlanguage::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }
}
