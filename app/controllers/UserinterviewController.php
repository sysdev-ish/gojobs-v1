<?php

namespace app\controllers;

use Yii;
use app\models\Userinterview;
use app\models\Userprofile;
use app\models\Recruitmentcandidate;
use app\models\Transrincian;
use app\models\Masteroffice;
use app\models\Userlogin;
use app\models\Interviewform;
use app\models\Masteraspekpenilaian;
use app\models\Userinterviewsearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * UserinterviewController implements the CRUD actions for Userinterview model.
 */
class UserinterviewController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
      return [
          'access' => [
              'class' => AccessControl::className(),
              'only' => ['index','update','create','view','delete','uintproc','downloadinterviewform'],
              'rules' => [
                [
                    'actions' => ['index','update','create','view','delete','uintproc','downloadinterviewform'],
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback'=>function(){
                         return (Yii::$app->utils->permission(Yii::$app->user->identity->role,'m10'));
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
     * Lists all Userinterview models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Userinterviewsearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Userinterview model.
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
     * Creates a new Userinterview model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Userinterview();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Userinterview model.
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
         $model->setScenario('updateuint');
         if ($model->load(Yii::$app->request->post())) {

           $model->updatetime = date('Y-m-d H-i-s');
           $model->date = date('Y-m-d H-i-s');
           $model->status = 1;
             $model->save(false);
             return $this->redirect(['userinterview/index']);
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

     public function actionUintproc($id)
     {
         $model = $this->findModel($id);
         $userid = $model->userid;
         $reccanid = $model->recruitmentcandidateid;
         $modeluprofile = Userprofile::find()->where(['userid'=>$userid])->one();
         $modelulogin = Userlogin::find()->where(['id'=>$userid])->one();
         $modelreccan = Recruitmentcandidate::find()->where(['id'=>$reccanid])->one();
         $modelrecreq = Transrincian::find()->where(['id'=>$modelreccan->recruitreqid])->one();
         $model->fullname = $modeluprofile->fullname;
         $model->userid = $modeluprofile->userid;
         $model->recruitmentcandidateid = $reccanid;
         $office = ArrayHelper::map(Masteroffice::find()->asArray()->all(), 'id', 'officename');
         $pic = ArrayHelper::map(Userlogin::find()->asArray()->where(['role'=> 1])->all(), 'id', 'name');
         $model->setScenario('uintproc');

         if ($model->load(Yii::$app->request->post())) {
           $model->documentinterview = UploadedFile::getInstance($model,'documentinterview');
           if($model->documentinterview){
             $assetUrl = Yii::getAlias('@app'). '/assets';
             $fileextp = $model->documentinterview->extension;
             $filep = $userid.'-documentinterview.'.$fileextp;
             if ($model->documentinterview->saveAs($assetUrl.'/upload/documentinterview/'.$filep)){
               $model->documentinterview = $filep;
             }
           }

           $model->updatetime = date('Y-m-d H-i-s');
           if ($model->status == 3){
             $modelreccan->status = 10;
           }else{
             if($modelrecreq->train_soft == 1 OR $modelrecreq->train_hard == 1 OR $modelrecreq->tendem_pasif == 1 OR $modelrecreq->tendem_aktif == 1){

               $modelreccan->status = 7;
             }else{
               $modelreccan->status = 4;
               // $modelrecreq->status_rekrut = 2;
               // $modelrecreq->save();
             }
           }
             if($model->save(false) && $modelreccan->save()){
             if($model->roomid != null){$room = $model->masterroom->room; $floor = $model->masterroom->floor;}else{$room= '';$floor = '';};
             $datancomp = Yii::$app->check->datanotcompleted($userid);
             $date = date_create($model->scheduledate);
             $to = [$modelulogin->email];
             $subject = 'Informasi hasil seleksi PT Infomedia Solusi Humanika';
             $body = 'Yth '.$modeluprofile->fullname.' .. ,
             <br>
             Sdr/i PT. Infomedia Solusi Humanika ingin menginformasikan bahwa anda lolos tahap seleksi Interview dan Psikotest untuk posisi "'. ($modelrecreq->jabatan)?$modelrecreq->jabatan:'-' .'".

             <br>
             <br>

              Sebelumnya mohon untuk melengkapi data '.str_replace(array("[","]"),array(" "),json_encode($datancomp)).' pada sistem kami dengan melakukan login pada http://gojobs.id/
             ';
             if($model->status == 2){
               $verification = Yii::$app->utils->sendmail($to,$subject,$body,12);
             }
             return $this->redirect(['userinterview/index']);
           }
         } else {
             return $this->renderAjax('uintproc', [
                 'model' => $model,
                 'modelreccan' => $modelreccan,
                 'modelrecreq' => $modelrecreq,
                 'office' => $office,
                 'pic' => $pic,
             ]);
         }
     }


    /**
     * Deletes an existing Userinterview model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
     public function actionDownloadinterviewform($id){
       // Yii::$app->response->format = 'pdf';
       $this->layout = 'pdfprint';
       $model = $this->findModel($id);
       $profile = Userprofile::find()->where(['userid'=>$model->userid])->one();
       $masterpenilaian = Masteraspekpenilaian::find()->where(['grouppenilaian'=>2])->all();
       // $query = new Query;
       // $query->select('id, educationallevel')
       //     ->from('userformaleducation');
       //
       // $lasteducation = $query->all();

       $content = $this->render('interviewform', [
         'model' => $model,
         'profile' => $profile,
         'masterpenilaian' => $masterpenilaian,
         // 'lasteducation' => $lasteducation,
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
     * Finds the Userinterview model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Userinterview the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Userinterview::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
