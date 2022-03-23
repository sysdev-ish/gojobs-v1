<?php

namespace app\controllers;

use Yii;
use app\models\Taktif;
use app\models\Taktifsearch;
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
 * TaktifController implements the CRUD actions for Taktif model.
 */
class TaktifController extends Controller
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
                         return (Yii::$app->utils->permission(Yii::$app->user->identity->role,'m44'));
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
     * Lists all Taktif models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Taktifsearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Taktif model.
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
     * Creates a new Taktif model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Taktif();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Taktif model.
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
          $modelreccan->status = 19;
        }else{
            // var_dump($modelreccan->recruitreqid);die;
            $modelreccan->status = 4;
            // $modelrecreq->status_rekrut = 2;
            // $modelrecreq->save(false);
        }

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
     * Deletes an existing Taktif model.
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
     * Finds the Taktif model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Taktif the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Taktif::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
