<?php

namespace app\controllers;

use Yii;
use app\models\Psikotest;
use app\models\Userprofile;
use app\models\Recruitmentcandidate;
use app\models\Transrincian;
use app\models\Masteroffice;
use app\models\Userlogin;
use app\models\Psikotestsearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * PsikotestController implements the CRUD actions for Psikotest model.
 */
class PsikotestController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
      return [
          'access' => [
              'class' => AccessControl::className(),
              'only' => ['index','update','create','view','delete','psiproc'],
              'rules' => [
                [
                    'actions' => ['index','update','create','view','delete','psiproc'],
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback'=>function(){
                         return (Yii::$app->utils->permission(Yii::$app->user->identity->role,'m7'));
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
     * Lists all Psikotest models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Psikotestsearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Psikotest model.
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
     * Creates a new Psikotest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Psikotest();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Psikotest model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

      public function actionUpdate($id)
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
          $office = ArrayHelper::map(Masteroffice::find()->asArray()->all(), 'id', 'officename');
          $pic = ArrayHelper::map(Userlogin::find()->asArray()->where('role = 3 or role = 22')->all(), 'id', 'name');
          $model->setScenario('updatepsi');
          if ($model->load(Yii::$app->request->post())) {

            $model->updatetime = date('Y-m-d H-i-s');
            $model->date = date('Y-m-d H-i-s');
            $model->status = 1;
              $model->save();
              return $this->redirect(['psikotest/index']);
          } else {
              return $this->renderAjax('update', [
                  'model' => $model,
                  'modelreccan' => $modelreccan,
                  'modelrecreq' => $modelrecreq,
                  'office' => $office,
                  'pic' => $pic,
              ]);
          }
      }
      public function actionPsiproc($id)
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
          $office = ArrayHelper::map(Masteroffice::find()->asArray()->all(), 'id', 'officename');
          $pic = ArrayHelper::map(Userlogin::find()->asArray()->where(['role'=> 1])->all(), 'id', 'name');
          $model->setScenario('psiproc');
          if ($model->load(Yii::$app->request->post())) {
            $model->updatetime = date('Y-m-d H-i-s');
            if ($model->status == 3){
              $modelreccan->status = 9;
            }else{
              $modelreccan->status = 6;
            }
            $model->documentpsikotest = UploadedFile::getInstance($model,'documentpsikotest');
            if($model->documentpsikotest){
              $assetUrl = Yii::getAlias('@app'). '/assets';
              $fileextp = $model->documentpsikotest->extension;
              $filep = $userid.'-documentpsikotest.'.$fileextp;
              if ($model->documentpsikotest->saveAs($assetUrl.'/upload/documentpsikotest/'.$filep)){
                $model->documentpsikotest = $filep;
              }
            }
            // var_dump($modelreccan->recruitreqid);die;
              $model->save();
              $modelreccan->save();
              return $this->redirect(['psikotest/index']);
          } else {
              return $this->renderAjax('psiproc', [
                  'model' => $model,
                  'modelreccan' => $modelreccan,
                  'modelrecreq' => $modelrecreq,
                  'office' => $office,
                  'pic' => $pic,
              ]);
          }
      }
      public function actionPsiupload($id)
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
          $office = ArrayHelper::map(Masteroffice::find()->asArray()->all(), 'id', 'officename');
          $pic = ArrayHelper::map(Userlogin::find()->asArray()->where(['role'=> 1])->all(), 'id', 'name');
          $model->setScenario('psiupload');
          if ($model->load(Yii::$app->request->post())) {
            $model->updatetime = date('Y-m-d H-i-s');
            $model->documentpsikotest = UploadedFile::getInstance($model,'documentpsikotest');
            if($model->documentpsikotest){
              $assetUrl = Yii::getAlias('@app'). '/assets';
              $fileextp = $model->documentpsikotest->extension;
              $filep = $userid.'-documentpsikotest.'.$fileextp;
              if ($model->documentpsikotest->saveAs($assetUrl.'/upload/documentpsikotest/'.$filep)){
                $model->documentpsikotest = $filep;
              }
            }
            // var_dump($modelreccan->recruitreqid);die;
              $model->save();
              return $this->redirect(['psikotest/index']);
          } else {
              return $this->renderAjax('psiupload', [
                  'model' => $model,
                  'modelreccan' => $modelreccan,
                  'modelrecreq' => $modelrecreq,
                  'office' => $office,
                  'pic' => $pic,
              ]);
          }
      }


    /**
     * Deletes an existing Psikotest model.
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
     * Finds the Psikotest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Psikotest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Psikotest::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
