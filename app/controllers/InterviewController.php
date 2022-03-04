<?php

namespace app\controllers;

use Yii;
use app\models\Interview;
use app\models\Userprofile;
use app\models\Recruitmentcandidate;
use app\models\Transrincian;
use app\models\Masteroffice;
use app\models\Userlogin;
use app\models\Interviewform;
use app\models\Masteraspekpenilaian;
use app\models\Userformaleducation;
use app\models\Interviewsearch;
use app\models\Mastereducation;
use app\models\Userworkexperience;
use app\models\Masterformtype;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
* InterviewController implements the CRUD actions for Interview model.
*/
class InterviewController extends Controller
{
  /**
  * @inheritdoc
  */
  public function behaviors()
  {
    return [
        'access' => [
            'class' => AccessControl::className(),
            'only' => ['index','update','create','view','intproc','delete'],
            'rules' => [
              [
                  'actions' => ['index','update','create','view','intproc','delete'],
                  'allow' => true,
                  'roles' => ['@'],
                  'matchCallback'=>function(){
                       return (Yii::$app->utils->permission(Yii::$app->user->identity->role,'m4'));
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
  * Lists all Interview models.
  * @return mixed
  */
  public function actionIndex()
  {
    $searchModel = new Interviewsearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
    ]);
  }

  /**
  * Displays a single Interview model.
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
  * Creates a new Interview model.
  * If creation is successful, the browser will be redirected to the 'view' page.
  * @return mixed
  */
  public function actionCreate($userid,$reccanid)
  {
    $model = new Interview();
    $modeluprofile = Userprofile::find()->where(['userid'=>$userid])->one();
    $modelreccan = Recruitmentcandidate::find()->where(['id'=>$reccanid])->one();
    $modelrecreq = Transrincian::find()->where(['id'=>$modelreccan->recruitreqid])->one();
    $model->fullname = $modeluprofile->fullname;
    $model->userid = $modeluprofile->userid;
    $model->recruitmentcandidateid = $reccanid;
    $office = ArrayHelper::map(Masteroffice::find()->asArray()->all(), 'id', 'officename');

    if ($model->load(Yii::$app->request->post())) {
      $model->createtime = date('Y-m-d H-i-s');
      $model->updatetime = date('Y-m-d H-i-s');
      $model->status = 0;
      $modelreccan->typeinterview = 1;
      $modelreccan->status = 1;
      $model->save();
      $modelreccan->save();
      return $this->redirect(['recruitmentcandidate/index']);
    } else {
      return $this->renderAjax('create', [
        'model' => $model,
        'modelreccan' => $modelreccan,
        'modelrecreq' => $modelrecreq,
        'office' => $office,
      ]);
    }
  }

  /**
  * Updates an existing Interview model.
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
    $model->setScenario('update');
    if ($model->load(Yii::$app->request->post())) {

      $model->updatetime = date('Y-m-d H-i-s');
      $model->date = date('Y-m-d H-i-s');
      $model->status = 1;
      $model->save();
      return $this->redirect(['interview/index']);
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
  public function actionIntprocnew($id)
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
    $model->setScenario('intproc');
    if ($model->load(Yii::$app->request->post()) && $modelreccan->load(Yii::$app->request->post()) ) {

      // var_dump('sampe');die;
      $model->updatetime = date('Y-m-d H-i-s');
      if ($model->status == 3){
        $modelreccan->status = 8;
      }else{
        $modelreccan->status = 5;
      }
      $model->documentinterview = UploadedFile::getInstance($model,'documentinterview');
      if($model->documentinterview){
        $assetUrl = Yii::getAlias('@app'). '/assets';
        $fileextp = $model->documentinterview->extension;
        $filep = $userid.'-documentinterview.'.$fileextp;
        if ($model->documentinterview->saveAs($assetUrl.'/upload/documentinterview/'.$filep)){
          $model->documentinterview = $filep;
        }
      }
      // var_dump($modelreccan->recruitreqid);die;
      $model->save(false);
      $modelreccan->save();
      return $this->redirect(['interview/index']);
    } else {
      return $this->renderAjax('intproc', [
        'model' => $model,
        'modelreccan' => $modelreccan,
        'modelrecreq' => $modelrecreq,
        'office' => $office,
        'pic' => $pic,
      ]);
    }
  }
  public function actionIntproc($id)
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
    $formtype = ArrayHelper::map(Masterformtype::find()->asArray()->all(), 'id', 'formtype');
    $model->setScenario('intproc');
    $masterpenilaian = Masteraspekpenilaian::find()->where(['grouppenilaian'=>1])->all();
    $interviewforms = [new Interviewform()];
    for($i = 1; $i < count($masterpenilaian); $i++) {
      $interviewforms[] = new Interviewform();
    }

    if ($model->load(Yii::$app->request->post()) && $modelreccan->load(Yii::$app->request->post()) && Model::loadMultiple($interviewforms, Yii::$app->request->post()) && Model::validateMultiple($interviewforms)) {

      $count = count(Yii::$app->request->post('Interviewform', []));
      foreach ($interviewforms as $interviewform) {
        $interviewform->userid = $userid;
        $interviewform->interviewid = $model->id;
        $interviewform->createtime = date('Y-m-d H-i-s');
        $interviewform->updatetime = date('Y-m-d H-i-s');
        $interviewform->save(false);
      }
      // var_dump('sampe');die;
      $model->updatetime = date('Y-m-d H-i-s');
      if ($model->status == 3){
        $modelreccan->status = 8;
      }else{
        $modelreccan->status = 5;
      }
      // var_dump($modelreccan->recruitreqid);die;
      $model->save();
      $modelreccan->save();
      return $this->redirect(['interview/index']);
    } else {
      return $this->renderAjax('intproc', [
        'model' => $model,
        'modelreccan' => $modelreccan,
        'modelrecreq' => $modelrecreq,
        'office' => $office,
        'pic' => $pic,
        'interviewforms' => $interviewforms,
        'masterpenilaian' => $masterpenilaian,
        'formtype' => $formtype,
      ]);
    }
  }

  /**
  * Deletes an existing Interview model.
  * If deletion is successful, the browser will be redirected to the 'index' page.
  * @param integer $id
  * @return mixed
  */
  public function actionDownloadinterviewform($id){
    // Yii::$app->response->format = 'pdf';
    $this->layout = 'pdfprint';
    $model = $this->findModel($id);
    $profile = Userprofile::find()->where(['userid'=>$model->userid])->one();
    $masterpenilaian = Masteraspekpenilaian::find()->where(['grouppenilaian'=>1])->all();
    $lasteducationid = Userformaleducation::find()->where(['userid'=>$model->userid])->orderBy("educationallevel DESC")->one();

    if($lasteducationid){ $lasteducation = Mastereducation::find()->where(['idmastereducation'=>$lasteducationid->educationallevel])->one(); }else{
      $lasteducation =  null;
    }
    $lastexperiences = Userworkexperience::find()->where(['userid'=>$model->userid])->orderBy("startdate DESC")->one();
    if($lastexperiences){
      $lastexperience = $lastexperiences;
    }else{
      $lastexperience = null;
    }

    $content = $this->render('interviewform', [
      'model' => $model,
      'profile' => $profile,
      'masterpenilaian' => $masterpenilaian,
      'lasteducation' => $lasteducation,
      'lastexperience' => $lastexperience,
    ]);
    // $content = $this->renderPartial('_reportView');

    // setup kartik\mpdf\Pdf component
    $pdf = new Pdf([
      // set to use core fonts only
      'mode' => Pdf::MODE_CORE,
      'content' => $content,
      // 'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
      'cssInline' => '
      .header {
        text-align: center;
        font-size: 12pt;
        margin-top: 20px;
      }
      .sub-header {
        text-align: center;
        font-size: 10pt;
        margin-top: 5px;
      }
      .table > thead > tr > th,
      .table > tbody > tr > th,
      .table > tfoot > tr > th,
      .table > thead > tr > td,
      .table > tbody > tr > td,
      .table > tfoot > tr > td {
        border-top: 1px solid #000;

      }
      .table > thead > tr > th {
        border-bottom: 2px solid #000;
      }
      .table tr td .progress {
        margin-top: 5px;
      }
      .table-bordered {
        border: 1px solid #000;
      }
      .table-bordered > thead > tr > th,
      .table-bordered > tbody > tr > th,
      .table-bordered > tfoot > tr > th,
      .table-bordered > thead > tr > td,
      .table-bordered > tbody > tr > td,
      .table-bordered > tfoot > tr > td {
        border: 1px solid #000;
      }
      .table-bordered > thead > tr > th,
      .table-bordered > thead > tr > td {
        border-bottom-width: 2px;
      }
      .table.no-border,
      .table.no-border td,
      .table.no-border th {
        border: 0;
      }
      /* .text-center in tables */
      table.text-center,
      table.text-center td,
      table.text-center th {
        text-align: center;
      }
      .table.align th {
        text-align: left;
      }
      .table.align td {
        text-align: right;
      }
      ',
      'options' => ['title' => 'Interview Form']


    ]);

    // return the pdf output as per the destination setting
    return $pdf->render();

  }
  public function actionDelete($id)
  {
    $this->findModel($id)->delete();

    return $this->redirect(['index']);
  }

  /**
  * Finds the Interview model based on its primary key value.
  * If the model is not found, a 404 HTTP exception will be thrown.
  * @param integer $id
  * @return Interview the loaded model
  * @throws NotFoundHttpException if the model cannot be found
  */
  protected function findModel($id)
  {
    if (($model = Interview::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }
}
