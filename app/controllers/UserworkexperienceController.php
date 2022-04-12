<?php

namespace app\controllers;

use Yii;
use app\models\Userworkexperience;
use app\models\Userworkexperienceposition;
use app\models\Userworkexperiencesearch;
use app\models\Modeldynamic;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

/**
* UserworkexperienceController implements the CRUD actions for Userworkexperience model.
*/
class UserworkexperienceController extends Controller
{
  /**
  * @inheritdoc
  */
  public function behaviors()
  {
    return [
        'access' => [
            'class' => AccessControl::className(),
            'only' => ['update','create','view','delete','views','cwizard','uwizard'],
            'rules' => [

                [
                    'actions' => ['view','delete'],
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback'=>function(){
                         return (Yii::$app->utils->permission(Yii::$app->user->identity->role,'m13'));
                     }

                ],
                [
                    'actions' => ['views','view'],
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback'=>function(){
                      // var_dump( (int)Yii::$app->request->get('userid'));die;
                        if(Yii::$app->user->identity->role == 2){
                            if((int)Yii::$app->request->get('userid') == Yii::$app->user->identity->id){
                              $ret = true;
                            }else{
                              $ret = false;
                            }
                        }else{
                          $ret = (Yii::$app->utils->permission(Yii::$app->user->identity->role,'m13'));
                        }
                         return $ret;
                     }

                ],
                [
                    'actions' => ['update'],
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback'=>function(){

                        if(Yii::$app->user->identity->role == 2){

                            if((int)Yii::$app->request->get('id') == Yii::$app->user->identity->id){
                              $ret = true;
                            }else{
                              $ret = false;
                            }
                        }else{
                          $ret = (Yii::$app->utils->permission(Yii::$app->user->identity->role,'m13'));
                        }
                         return $ret;
                     }

                ],
                [
                        'actions' => ['cwizard','uwizard','create'],
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
  * Lists all Userworkexperience models.
  * @return mixed
  */
  // public function actionIndex()
  // {
  //   $searchModel = new Userworkexperiencesearch();
  //   $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
  //
  //   return $this->render('index', [
  //     'searchModel' => $searchModel,
  //     'dataProvider' => $dataProvider,
  //   ]);
  // }

  /**
  * Displays a single Userworkexperience model.
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
    $model = Userworkexperience::find()->where(['userid'=>$userid])->one();
    if($model){
      $modelall = Userworkexperience::find()->where(['userid'=>$userid])->all();
        return $this->render('view', [
            'userid'=> $userid,
            'model' => $model,
            'modelall' => $modelall,
        ]);
    }else{
      return $this->redirect(['create','userid'=>$userid]);
    }

  }

  /**
  * Creates a new Userworkexperience model.
  * If creation is successful, the browser will be redirected to the 'view' page.
  * @return mixed
  */
  public function actionCreate($userid)
  {
      $id = $userid;
      $this->layout = Yii::$app->utils->getlayout();
      $model = new Userworkexperience();
      $modelwexp = [new Userworkexperience()];

      if ($model->load(Yii::$app->request->post())) {

        $modelwexp = Modeldynamic::createMultiple(Userworkexperience::classname());
        Modeldynamic::loadMultiple($modelwexp, Yii::$app->request->post());

        if (Yii::$app->request->isAjax) {
          Yii::$app->response->format = Response::FORMAT_JSON;
          return ArrayHelper::merge(
            ActiveForm::validateMultiple($modelwexp)
          );
        }

        $valid = Modeldynamic::validateMultiple($modelwexp);

        if ($valid) {
          $transaction = \Yii::$app->db->beginTransaction();
          try {

            foreach ($modelwexp as $indexmodelwexps => $modelwexps) {
              $modelwexps->userid = $id;
              $modelwexps->createtime = date('Y-m-d H-i-s');
              $modelwexps->updatetime = date('Y-m-d H-i-s');
              $modelwexps->startdate = $modelwexps->startdate.'-01';
              $modelwexps->enddate = $modelwexps->enddate.'-01';

              if (! ($flag = $modelwexps->save(false))) {
                $transaction->rollBack();
                break;
              }

            }
            if ($flag) {

              $transaction->commit();
              return $this->redirect(['views', 'userid' => $id]);
            }
          } catch (Exception $e) {
            $transaction->rollBack();
          }
        }
      }
      return $this->render('create', [
        'model' => $model,
        'modelwexp' => $modelwexp,
        'userid'=>$userid,
      ]);

  }
  public function actionCwizard()
  {
    $id = Yii::$app->user->identity->id;
    if(Yii::$app->check->cuserwexperience($id) == 0){
      $this->layout = Yii::$app->utils->getlayout();
      $model = new Userworkexperience();
      $modelwexp = [new Userworkexperience()];

      if ($model->load(Yii::$app->request->post())) {

        $modelwexp = Modeldynamic::createMultiple(Userworkexperience::classname());
        Modeldynamic::loadMultiple($modelwexp, Yii::$app->request->post());

        if (Yii::$app->request->isAjax) {
          Yii::$app->response->format = Response::FORMAT_JSON;
          return ArrayHelper::merge(
            ActiveForm::validateMultiple($modelwexp)
          );
        }

        $valid = Modeldynamic::validateMultiple($modelwexp);

        if ($valid) {
          $transaction = \Yii::$app->db->beginTransaction();
          try {

            foreach ($modelwexp as $indexmodelwexps => $modelwexps) {
              $modelwexps->userid = $id;
              $modelwexps->createtime = date('Y-m-d H-i-s');
              $modelwexps->updatetime = date('Y-m-d H-i-s');
              $modelwexps->startdate = $modelwexps->startdate.'-01';
              $modelwexps->enddate = $modelwexps->enddate.'-01';

              if (! ($flag = $modelwexps->save(false))) {
                $transaction->rollBack();
                break;
              }

            }
            if ($flag) {

              $transaction->commit();
              return $this->redirect(['organizationactivity/cwizard']);
            }
          } catch (Exception $e) {
            $transaction->rollBack();
          }
        }
      }
      return $this->render('create', [
        'model' => $model,
        'modelwexp' => $modelwexp,
        'userid' => $id,
      ]);
    }else{
      return $this->redirect(['uwizard', 'id' => $id]);
    }
  }

  /**
  * Updates an existing Userworkexperience model.
  * If update is successful, the browser will be redirected to the 'view' page.
  * @param integer $id
  * @return mixed
  */
  public function actionUwizard($id)
  {
    $this->layout = Yii::$app->utils->getlayout();
    $userid = $id;
    $model = Userworkexperience::find()->where(['userid'=>$userid])->one();

    $oldIDs = Userworkexperience::find()->select('id')->where(['userid' => $model->userid])->asArray()->all();
    $oldIDs = ArrayHelper::getColumn($oldIDs, 'id');

    $modelwexps = Userworkexperience::findAll(['id' => $oldIDs]);
    $modelwexp = (empty($modelwexps)) ? [new Userworkexperience] : $modelwexps;

    if ($model->load(Yii::$app->request->post())) {

      $modelwexp = Modeldynamic::createMultiple(Userworkexperience::classname());
      Modeldynamic::loadMultiple($modelwexp, Yii::$app->request->post());
      $newaudIds =ArrayHelper::getColumn($modelwexp,'id');

      $delaudIds = array_diff($oldIDs,$newaudIds);
      if (! empty($delaudIds)) Userworkexperience::deleteAll(['id' => $delaudIds]);

      if (Yii::$app->request->isAjax) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ArrayHelper::merge(
        ActiveForm::validateMultiple($modelwexp)
      );
      }
      $valid = Modeldynamic::validateMultiple($modelwexp);
      if ($valid) {
        $transaction = \Yii::$app->db->beginTransaction();
        try {

            foreach ($modelwexp as $modelwexps) {
              $modelwexps->userid = $userid;
              $modelwexps->createtime = date('Y-m-d H-i-s');
              $modelwexps->updatetime = date('Y-m-d H-i-s');
              $modelwexps->startdate = $modelwexps->startdate.'-01';
              $modelwexps->enddate = $modelwexps->enddate.'-01';
              if (! ($flag = $modelwexps->save(false))) {
                $transaction->rollBack();
                break;
              }
            }


          if ($flag) {
            $transaction->commit();
            return $this->redirect(['organizationactivity/cwizard']);
          }
        } catch (Exception $e) {
          $transaction->rollBack();
        }
      }
    }
        return $this->render('update', [
            'model' => $model,
            'modelwexp' => $modelwexp,
        ]);
  }
  public function actionUpdate($id)
  {
    $this->layout = Yii::$app->utils->getlayout();

    $userid = $id;
    $model = Userworkexperience::find()->where(['userid'=>$userid])->one();

    $oldIDs = Userworkexperience::find()->select('id')->where(['userid' => $model->userid])->asArray()->all();
    $oldIDs = ArrayHelper::getColumn($oldIDs, 'id');

    $modelwexps = Userworkexperience::findAll(['id' => $oldIDs]);
    $modelwexp = (empty($modelwexps)) ? [new Userworkexperience] : $modelwexps;



    if ($model->load(Yii::$app->request->post())) {

      $modelwexp = Modeldynamic::createMultiple(Userworkexperience::classname());
      Modeldynamic::loadMultiple($modelwexp, Yii::$app->request->post());
      $newaudIds =ArrayHelper::getColumn($modelwexp,'id');

      $delaudIds = array_diff($oldIDs,$newaudIds);
      if (! empty($delaudIds)) Userworkexperience::deleteAll(['id' => $delaudIds]);

      if (Yii::$app->request->isAjax) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ArrayHelper::merge(
        ActiveForm::validateMultiple($modelwexp)
      );
      }
      $valid = Modeldynamic::validateMultiple($modelwexp);
      if ($valid) {
        $transaction = \Yii::$app->db->beginTransaction();
        try {

            foreach ($modelwexp as $modelwexps) {
              $modelwexps->userid = $userid;
              $modelwexps->createtime = date('Y-m-d H-i-s');
              $modelwexps->updatetime = date('Y-m-d H-i-s');
              $modelwexps->startdate = $modelwexps->startdate.'-01';
              $modelwexps->enddate = $modelwexps->enddate.'-01';
              if (! ($flag = $modelwexps->save(false))) {
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
            'modelwexp' => $modelwexp,
            'userid'=>$model->userid,
        ]);
  }

  /**
  * Deletes an existing Userworkexperience model.
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
  * Finds the Userworkexperience model based on its primary key value.
  * If the model is not found, a 404 HTTP exception will be thrown.
  * @param integer $id
  * @return Userworkexperience the loaded model
  * @throws NotFoundHttpException if the model cannot be found
  */
  protected function findModel($id)
  {
    if (($model = Userworkexperience::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }
}
