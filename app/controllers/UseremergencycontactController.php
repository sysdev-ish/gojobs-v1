<?php

namespace app\controllers;

use Yii;
use app\models\Useremergencycontact;
use app\models\Useremergencycontactsearch;
use app\models\Masterprovince;
use app\models\Mastercity;
use app\models\Modeldynamic;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

/**
 * UseremergencycontactController implements the CRUD actions for Useremergencycontact model.
 */
class UseremergencycontactController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
      return [
          'access' => [
              'class' => AccessControl::className(),
              'only' => ['index','update','create','view','delete','views','cwizard','uwizard'],
              'rules' => [

                  [
                      'actions' => ['index','view','delete'],
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
     * Lists all Useremergencycontact models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Useremergencycontactsearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Useremergencycontact model.
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
      $model = Useremergencycontact::find()->where(['userid'=>$userid])->one();
      if($model){
      $modelall = Useremergencycontact::find()->where(['userid'=>$userid])->all();
        return $this->render('view', [
            'model' => $model,
            'modelall' => $modelall,
            'userid' => $userid,
        ]);
      }else{
        return $this->redirect(['create','userid'=>$userid]);
      }
    }

    /**
     * Creates a new Useremergencycontact model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($userid)
    {
      $id = $userid;

        $this->layout = Yii::$app->utils->getlayout();
        $model = new Useremergencycontact();
        $province = ArrayHelper::map(MasterProvince::find()->asArray()->all(), 'provinsiid', 'provinsi');
        $kota = ArrayHelper::map(Mastercity::find()->asArray()->where(['kotaid'=>$model->cityid])->all(), 'kotaid', 'kota');
        $modeluecontact = [new Useremergencycontact()];

        if ($model->load(Yii::$app->request->post())) {

          $modeluecontact = Modeldynamic::createMultiple(Useremergencycontact::classname());
          Modeldynamic::loadMultiple($modeluecontact, Yii::$app->request->post());

          if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ArrayHelper::merge(
              ActiveForm::validateMultiple($modeluecontact)
            );
          }

          $valid = Modeldynamic::validateMultiple($modeluecontact);


          if ($valid) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {

              foreach ($modeluecontact as $indexmodelwexps => $modeluecontacts) {
                $modeluecontacts->userid = $id;
                $modeluecontacts->createtime = date('Y-m-d H-i-s');
                $modeluecontacts->updatetime = date('Y-m-d H-i-s');

                if (! ($flag = $modeluecontacts->save(false))) {
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
          'modeluecontact' => $modeluecontact,
          'userid'=>$userid,
          'province' => $province,
          'kota' => $kota,
          'userid' => $userid,
        ]);

    }
    public function actionCwizard()
    {
      $id = Yii::$app->user->identity->id;

      if(Yii::$app->check->cuserecontact($id) == 0){
        $this->layout = Yii::$app->utils->getlayout();
        $model = new Useremergencycontact();
        $province = ArrayHelper::map(MasterProvince::find()->asArray()->all(), 'provinsiid', 'provinsi');
        $kota = ArrayHelper::map(Mastercity::find()->asArray()->where(['kotaid'=>$model->cityid])->all(), 'kotaid', 'kota');
        $modeluecontact = [new Useremergencycontact()];

        if ($model->load(Yii::$app->request->post())) {

          $modeluecontact = Modeldynamic::createMultiple(Useremergencycontact::classname());
          Modeldynamic::loadMultiple($modeluecontact, Yii::$app->request->post());

          if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ArrayHelper::merge(
              ActiveForm::validateMultiple($modeluecontact)
            );
          }

          $valid = Modeldynamic::validateMultiple($modeluecontact);


          if ($valid) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {

              foreach ($modeluecontact as $indexmodelwexps => $modeluecontacts) {
                $modeluecontacts->userid = $id;
                $modeluecontacts->createtime = date('Y-m-d H-i-s');
                $modeluecontacts->updatetime = date('Y-m-d H-i-s');

                if (! ($flag = $modeluecontacts->save(false))) {
                  $transaction->rollBack();
                  break;
                }

              }
              if ($flag) {

                $transaction->commit();
                return $this->redirect(['userreference/cwizard']);
              }
            } catch (Exception $e) {
              $transaction->rollBack();
            }
          }
        }
        return $this->render('create', [
          'model' => $model,
          'modeluecontact' => $modeluecontact,
          'province' => $province,
          'kota' => $kota,
          'userid' => $id,
        ]);
      }else{
        return $this->redirect(['uwizard', 'id' => $id]);
      }
    }

    /**
     * Updates an existing Useremergencycontact model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUwizard($id)
    {
      $this->layout = Yii::$app->utils->getlayout();
      $userid = $id;
      $model = Useremergencycontact::find()->where(['userid'=>$userid])->one();
      $province = ArrayHelper::map(MasterProvince::find()->asArray()->all(), 'provinsiid', 'provinsi');
      $kota = ArrayHelper::map(Mastercity::find()->asArray()->where(['kotaid'=>$model->cityid])->all(), 'kotaid', 'kota');


      $oldIDs = Useremergencycontact::find()->select('id')->where(['userid' => $model->userid])->asArray()->all();
      $oldIDs = ArrayHelper::getColumn($oldIDs, 'id');

      $modeluecontacts = Useremergencycontact::findAll(['id' => $oldIDs]);
      $modeluecontact = (empty($modeluecontacts)) ? [new Useremergencycontact] : $modeluecontacts;



      if ($model->load(Yii::$app->request->post())) {

        $modeluecontact = Modeldynamic::createMultiple(Useremergencycontact::classname());
        Modeldynamic::loadMultiple($modeluecontact, Yii::$app->request->post());
        $newaudIds =ArrayHelper::getColumn($modeluecontact,'id');

        $delaudIds = array_diff($oldIDs,$newaudIds);
        if (! empty($delaudIds)) Useremergencycontact::deleteAll(['id' => $delaudIds]);

        if (Yii::$app->request->isAjax) {
          Yii::$app->response->format = Response::FORMAT_JSON;
          return ArrayHelper::merge(
          ActiveForm::validateMultiple($modeluecontact)
        );
        }
        $valid = Modeldynamic::validateMultiple($modeluecontact);
        if ($valid) {
          $transaction = \Yii::$app->db->beginTransaction();
          try {

              foreach ($modeluecontact as $modeluecontacts) {
                $modeluecontacts->userid = $userid;
                $modeluecontacts->createtime = date('Y-m-d H-i-s');
                $modeluecontacts->updatetime = date('Y-m-d H-i-s');
                if (! ($flag = $modeluecontacts->save(false))) {
                  $transaction->rollBack();
                  break;
                }
              }


            if ($flag) {
              $transaction->commit();
              return $this->redirect(['userreference/cwizard']);
            }
          } catch (Exception $e) {
            $transaction->rollBack();
          }
        }
      }
          return $this->render('update', [
              'model' => $model,
              'modeluecontact' => $modeluecontact,
              'province' => $province,
              'kota' => $kota,
          ]);
    }
    public function actionUpdate($id)
    {
      $this->layout = Yii::$app->utils->getlayout();

      $userid = $id;
      $model = Useremergencycontact::find()->where(['userid'=>$userid])->one();
      $province = ArrayHelper::map(MasterProvince::find()->asArray()->all(), 'provinsiid', 'provinsi');
      $kota = ArrayHelper::map(Mastercity::find()->asArray()->where(['kotaid'=>$model->cityid])->all(), 'kotaid', 'kota');


      $oldIDs = Useremergencycontact::find()->select('id')->where(['userid' => $model->userid])->asArray()->all();
      $oldIDs = ArrayHelper::getColumn($oldIDs, 'id');

      $modeluecontacts = Useremergencycontact::findAll(['id' => $oldIDs]);
      $modeluecontact = (empty($modeluecontacts)) ? [new Useremergencycontact] : $modeluecontacts;



      if ($model->load(Yii::$app->request->post())) {

        $modeluecontact = Modeldynamic::createMultiple(Useremergencycontact::classname());
        Modeldynamic::loadMultiple($modeluecontact, Yii::$app->request->post());
        $newaudIds =ArrayHelper::getColumn($modeluecontact,'id');

        $delaudIds = array_diff($oldIDs,$newaudIds);
        if (! empty($delaudIds)) Useremergencycontact::deleteAll(['id' => $delaudIds]);

        if (Yii::$app->request->isAjax) {
          Yii::$app->response->format = Response::FORMAT_JSON;
          return ArrayHelper::merge(
          ActiveForm::validateMultiple($modeluecontact)
        );
        }
        $valid = Modeldynamic::validateMultiple($modeluecontact);
        if ($valid) {
          $transaction = \Yii::$app->db->beginTransaction();
          try {

              foreach ($modeluecontact as $modeluecontacts) {
                $modeluecontacts->userid = $userid;
                $modeluecontacts->createtime = date('Y-m-d H-i-s');
                $modeluecontacts->updatetime = date('Y-m-d H-i-s');
                if (! ($flag = $modeluecontacts->save(false))) {
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
              'modeluecontact' => $modeluecontact,
              'userid'=>$model->userid,
              'province' => $province,
              'kota' => $kota,
          ]);
    }

    /**
     * Deletes an existing Useremergencycontact model.
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
     * Finds the Useremergencycontact model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Useremergencycontact the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Useremergencycontact::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
