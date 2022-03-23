<?php

namespace app\controllers;

use Yii;
use app\models\Tsoftskill;
use app\models\Tsoftskillsearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Userprofile;
use app\models\Recruitmentcandidate;
use app\models\Transrincian;
use app\models\Masteroffice;
use app\models\Userlogin;
use yii\filters\AccessControl;

/**
 * TsoftskillController implements the CRUD actions for Tsoftskill model.
 */
class TsoftskillController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
      return [
          'access' => [
              'class' => AccessControl::className(),
              'only' => ['index','update','create','view','tproc','delete'],
              'rules' => [
                [
                    'actions' => ['index','update','create','view','tproc','delete'],
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback'=>function(){
                         return (Yii::$app->utils->permission(Yii::$app->user->identity->role,'m38'));
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
     * Lists all Tsoftskill models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Tsoftskillsearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tsoftskill model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Tsoftskill model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tsoftskill();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Tsoftskill model.
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
    public function actionTproc($id)
    {
      $model = $this->findModel($id);
      $userid = $model->userid;
      $reccanid = $model->recruitmentcandidateid;
      $modeluprofile = Userprofile::find()->where(['userid'=>$userid])->one();
      $modelreccan = Recruitmentcandidate::find()->where(['id'=>$reccanid])->one();
      $modelrecreq = Transrincian::find()->where(['id'=>$modelreccan->recruitreqid])->one();
      $model->fullname = $modeluprofile->fullname;
      $model->userid = $modeluprofile->userid;
      $model->recruitmentcandidateid = $reccanid;
      $model->setScenario('tproc');


      if ($model->load(Yii::$app->request->post())) {

        $model->updatetime = date('Y-m-d H-i-s');
        if ($model->status == 3){
          $modelreccan->status = 16;
        }else{
          if($modelrecreq->train_hard == 1 OR $modelrecreq->tendem_pasif == 1 OR $modelrecreq->tendem_aktif == 1){
            $modelreccan->status = 12;
          }else{
            $modelreccan->status = 4;
            // $modelrecreq->status_rekrut = 2;
            // $modelrecreq->save(false);
          }
        }
        // var_dump($modelreccan->recruitreqid);die;
        $model->save();
        $modelreccan->save();
        return $this->redirect(['index']);
      } else {
        return $this->renderAjax('tproc', [
          'model' => $model,
          'modelreccan' => $modelreccan,
          'modelrecreq' => $modelrecreq,
        ]);
      }
    }

    /**
     * Deletes an existing Tsoftskill model.
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
     * Finds the Tsoftskill model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tsoftskill the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tsoftskill::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
