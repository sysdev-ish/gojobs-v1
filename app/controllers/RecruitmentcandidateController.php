<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Recruitmentcandidate;
use app\models\Userprofile;
use app\models\Userprofilesearch;
use app\models\Userlogin;
use app\models\Interview;
use app\models\Psikotest;
use app\models\Userinterview;
use app\models\Transrincian;
use app\models\Masteroffice;
use app\models\Tsoftskill;
use app\models\Thardskill;
use app\models\Tpasif;
use app\models\Taktif;
use app\models\Recruitmentcandidatesearch;
use app\models\Mappingjob;
use app\models\Masterjobfamily;
use app\models\Mastersubjobfamily;
use Codeception\Lib\Di;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
* RecruitmentcandidateController implements the CRUD actions for Recruitmentcandidate model.
*/
class RecruitmentcandidateController extends Controller
{
  /**
  * @inheritdoc
  */
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'only' => ['view','index','addcandidate','applyjob','walkin','addcandidate2','myapplication'],
        'rules' => [
          [
            'actions' => ['view','index','addcandidate','addcandidate2'],
            'allow' => true,
            'roles' => ['@'],
            'matchCallback'=>function(){
              return (Yii::$app->utils->permission(Yii::$app->user->identity->role,'m2'));
            }

          ],
          [
            'actions' => ['myapplication','applyjob','walkin'],
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
                $ret = (Yii::$app->utils->permission(Yii::$app->user->identity->role,'m2'));
              }
              return $ret;
            }

          ],
          // [
          //         'actions' => ['applyjob'],
          //         'allow' => true,
          //         'roles' => ['@'],
          // ],
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
  * Lists all Recruitmentcandidate models.
  * @return mixed
  */
  public function actionIndex()
  {
    $searchModel = new Recruitmentcandidatesearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
    ]);
  }

  /**
  * Displays a single Recruitmentcandidate model.
  * @param integer $id
  * @return mixed
  */
  public function actionView($id)
  {
    return $this->renderAjax('view', [
      'model' => $this->findModel($id),
    ]);
  }
  public function actionMyapplication($userid)
  {
    $this->layout = Yii::$app->utils->getlayout();
    $model = Userprofile::find()->where(['userid'=>$userid])->one();
    $modelall = Recruitmentcandidate::find()->where(['userid'=>$userid])->all();
    return $this->render('viewmyapp', [
      'model' => $model,
      'modelall' => $modelall,
      'userid' => $userid,
    ]);
  }


  /**
  * Creates a new Recruitmentcandidate model.
  * If creation is successful, the browser will be redirected to the 'view' page.
  * @return mixed
  */
  public function actionCreate()
  {
    $model = new Recruitmentcandidate();

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->id]);
    } else {
      return $this->render('create', [
        'model' => $model,
      ]);
    }
  }

  /**
  * Updates an existing Recruitmentcandidate model.
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
  public function actionAddcandidate($userid)
  {
    $model = new Recruitmentcandidate();
    $modeluprofile = Userprofile::find()->where(['userid'=>$userid])->one();
    $model->fullname = $modeluprofile->fullname;
    $model->userid = $modeluprofile->userid;
    $recruitreq = ArrayHelper::map(Transrincian::find()->asArray()->limit(100)->all(), 'id', 'nojo');

    if ($model->load(Yii::$app->request->post())) {
      $model->createtime = date('Y-m-d H-i-s');
      $model->updatetime = date('Y-m-d H-i-s');
      $model->status = 0;
      $model->typeinterview = 1;
      $model->save();
      return $this->redirect(['userprofile/index']);
    } else {
      return $this->renderAjax('addcandidate', [
        'model' => $model,
        'modeluprofile' => $modeluprofile,
        'recruitreq' => $recruitreq,
      ]);
    }
  }

  public function actionAddtocandidate($id,$userid)
  {
    $model = new Recruitmentcandidate();
    //
    if (Yii::$app->request->isAjax) {
      $model->userid = $userid;
      $model->createtime = date('Y-m-d H-i-s');
      $model->updatetime = date('Y-m-d H-i-s');
      $model->recruitreqid = $id;
      $model->status = 0;
      $model->typeinterview = 1;

      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      if($model->save()){
        return 'Add candidate successful';
      }


    }
    // return $this->redirect(['addcandidate2','id'=>$id]);
  }
  public function actionAddcandidate2($id)
  {
    $model = new Recruitmentcandidate();
    $modeluprofile = Userprofile::find()->all();
    $recruitreq = ArrayHelper::map(Transrincian::find()->asArray()->limit(100)->all(), 'id', 'nojo');
    $modelrecreq = Transrincian::find()->where(['id'=>$id])->one();
    $searchModelprofile = new Userprofilesearch();
    $dataProviderprofile = $searchModelprofile->search(Yii::$app->request->queryParams);

    return $this->renderAjax('addcandidate2', [
      'model' => $model,
      'modeluprofile' => $modeluprofile,
      'recruitreq' => $recruitreq,
      'searchModelprofile' => $searchModelprofile,
      'dataProviderprofile' => $dataProviderprofile,
      'transrincianid' => $id,
      'modelrecreq' => $modelrecreq,

    ]);

  }
  public function actionInvite($userid,$reccanid)
  {
    $modelreccan = Recruitmentcandidate::find()->where(['id'=>$reccanid])->one();
    $modelrecreq = Transrincian::find()->where(['id'=>$modelreccan->recruitreqid])->one();
    // var_dump($modelreccan->status);die;

    if($modelreccan->status == 0){
      $model = new Psikotest();
      $invitefor = 'Psikotest';
      $identifier = 5;
    }else if ($modelreccan->status == 6){
      $model = new Interview();
      $invitefor = 'Interview';
      $identifier = 4;
    }else if ($modelreccan->status == 5){
      $model = new Userinterview();
      $invitefor = 'User interview';
      $identifier = 6;
    }else if ($modelreccan->status == 7 AND $modelrecreq->train_soft == 1){
      $model = new tsoftskill();
      $invitefor = 'Training Soft Skill';
      $identifier = 7;
    }else if (($modelreccan->status == 12 OR $modelreccan->status == 7) AND $modelrecreq->train_hard == 1){
      $model = new thardskill();
      $invitefor = 'Training Hard Skill';
      $identifier = 8;
    }else if (($modelreccan->status == 13 OR $modelreccan->status == 12 OR $modelreccan->status == 7) AND $modelrecreq->tendem_pasif == 1){
      $model = new tpasif();
      $invitefor = 'Tendem Pasif';
      $identifier = 9;
    }else if (($modelreccan->status == 14 OR $modelreccan->status == 13 OR $modelreccan->status == 12 OR $modelreccan->status == 7) AND $modelrecreq->tendem_aktif == 1){
      $model = new taktif();
      $invitefor = 'Tendem Aktif';
      $identifier = 10;
    }

    $modeluprofile = Userprofile::find()->where(['userid'=>$userid])->one();
    $modelulogin = Userlogin::find()->where(['id'=>$userid])->one();
    // if()
    $model->fullname = $modeluprofile->fullname;
    $model->userid = $modeluprofile->userid;

    $model->recruitmentcandidateid = $reccanid;
    $office = ArrayHelper::map(Masteroffice::find()->asArray()->all(), 'id', 'officename');

    if ($model->load(Yii::$app->request->post())) {
      $model->createtime = date('Y-m-d H-i-s');
      $model->updatetime = date('Y-m-d H-i-s');
      $model->status = 0;
      if($modelreccan->status == 7 OR $modelreccan->status == 12 OR $modelreccan->status == 13 OR $modelreccan->status == 14 ){
        $model->date = $model->scheduledate;
      }
      if($modelreccan->status == 0){
        $modelreccan->status = 2;
      }elseif($modelreccan->status == 6){
          $modelreccan->status = 1;
          $modelreccan->typeinterview = 1;
          $modelreccan->invitationnumber = $model->userid.$modelreccan->id.'-ISHINVT';
      }elseif($modelreccan->status == 5){
        $modelreccan->status = 3;
      }elseif($modelreccan->status == 7){
        $modelreccan->status = 20;
        $model->status = 1;
      }elseif($modelreccan->status == 12){
        $modelreccan->status = 21;
        $model->status = 1;
      }elseif($modelreccan->status == 13){
        $modelreccan->status = 22;
        $model->status = 1;
      }elseif($modelreccan->status == 14){
        $modelreccan->status = 23;
        $model->status = 1;
      }
      $pic = Userlogin::find()->where(['id'=>$model->officepic])->one();
      // var_dump($model->method);die;
      if($modelreccan->status == 2){

        $modelreccan->method = $model->method;
        $modelreccan->kodetoken = $model->kodetoken;
      }
      if($model->save() && $modelreccan->save()){
        if($model->roomid != null){$room = $model->masterroom->room; $floor = $model->masterroom->floor;}else{$room= '';$floor = '';};
        $datancomp = Yii::$app->check->datanotcompleted($userid);
        if($datancomp ==  null){
          $infodata = '';
        }else{
          $infodata = 'Sebelumnya mohon untuk melengkapi data '.str_replace(array("[","]"),array(" "),json_encode($datancomp)).' pada sistem kami dengan melakukan login pada http://gojobs.id/ ';
        }
        if(is_numeric($modelrecreq->jabatan)){
          $jabatans = $modelrecreq->jobfunc->name_job_function;
        }else{
          $jabatans = $modelrecreq->jabatan;
        }
        if(Yii::$app->utils->getarea($modelrecreq->area_sap)){
          $areas = Yii::$app->utils->getarea($modelrecreq->area_sap);
        }else{
          $areas = '';

        }
        $date = date_create($model->scheduledate);
        $to = $modelulogin->email;
        $subject = 'Undangan '.$invitefor.' PT Infomedia Solusi Humanika';
        // var_dump($modelreccan->status.' '.$modelreccan->method);die;
        if($modelreccan->status == 2 && $modelreccan->method == 2){
          $body = '
          <table>
          <tr>
          <td valign="top">No Undangan</td>
          <td valign="top">:</td>
          <td valign="top">'.$modelreccan->invitationnumber.'</td>
          </tr>
          </table>
          <br>
          <br>
          Semangat Pagiii..
          <br>
          <br>
          Hallo Sdr/i'.$modeluprofile->fullname.' .. ,
          <br>
          <br>
          PT Infomedia Solusi Humanika (ISH) mengucapkan selamat kepada anda yang telah lulus seleksi dokumen untuk posisi pekerjaan posisi "'. $jabatans .'", dan lokasi kerja di "'.$areas.'"

          <br>
          <br>
          Selanjutnya anda diminta untuk mengerjakan psikotest online dengan panduan sebagi berikut :
          <br>
          <br>
          1.Psikotes online dikerjakan menggunakan ponsel pintar, pastikan jaringan akses internet bagus dan paket data tersedia<
          <br>
          2.Waktu pengerjaan psikotes adalah 30 menit sehingga pastikan anda bebas dari gangguan selama mengerjakan psikotes
          <br>
          3.Untuk memulai psikotes online, silahkan klik http://app.hipotest.com
          <br>
          4.Selanjutnya anda diminta untuk melakukan Registrasi & Login sesuai dengan ketentuan pada website tersebut
          <br>
          5.Untuk memulai Tes, masukkan kode token : '.$modelreccan->kodetoken.'
          <br>
          6.Anda diminta untuk mengerjakan seluruh rangkaian psikotes
          <br>
          <br>
          <i>  PERHATIAN !</i>
          <br>
          <br>
          <i>  Pengerjaan psikotes ini WAJIB DISELESAIKAN sebelum (H+2 dari Tanggal Pengajuan) dan pukul 24.00. </i>
          <br>
          <br>
          <i>  Selamat Mengerjakan.. </i>
          <br>
          Salam,
          <br>
          <br>
          HR Process - PT Infomedia Solusi Humanika (ISH)
          <br>
          <br>
          <br>
          <b>
          Talented and Qualified People| Solid-Speed-Smart
          </b>

          ';
        }else{
          $body = 'Yth '.$modeluprofile->fullname.' .. ,
          <br>
          Sdr/i PT. Infomedia Solusi Humanika Mengundang anda untuk '.$invitefor.' posisi "'. $jabatans .'", Pada :

            <br>
            <br>
            <table>
            <tr>
            <td valign="top">No Undangan</td>
            <td valign="top">:</td>
            <td valign="top">'.$modelreccan->invitationnumber.'</td>
            </tr>
            <tr>
            <td valign="top">Hari</td>
            <td valign="top">:</td>
            <td valign="top">'.Yii::$app->utils->indodate($model->scheduledate).'</td>
            </tr>
            <tr>
            <td valign="top">Pukul</td>
            <td valign="top">:</td>
            <td valign="top"> '.date("H:i", strtotime($model->scheduledate)).'</td>
            </tr>
            <tr>
            <td valign="top">Bertemu</td>
            <td valign="top">:</td>
            <td valign="top">'.$pic->name.'</td>
            </tr>
            <tr>
            <td valign="top">Alamat</td>
            <td valign="top">:</td>
            <td valign="top">'.$model->masteroffice->address.'('.Html::a('Link location map', 'https://maps.google.com/?q='.$model->masteroffice->lat.','.$model->masteroffice->long, ['target' => '_blank']).')</td>
            </tr>
            <tr>
            <td valign="top">Ruangan</td>
            <td valign="top">:</td>
            <td valign="top">'.$room.'</td>
            </tr>
            <tr>
            <td valign="top">Lantai</td>
            <td valign="top">:</td>
            <td valign="top">'.$floor.'</td>
            </tr>

            </table>
            <br>
            <br>
            <i>  -- Note : Dgn Menggunakan Pakaian Formal Rapih ( No Jeans ) dan Membawa CV dan Lamaran Kerja Lengkapnya . -- </i>
            <br>
            <i>  Konfirmasi dengan sms ke no :'.$pic->mobile.'  </i>
            <br>
            <i> '.$infodata.'</i>
            ';
          }

          // var_dump($body);die;
          $verification = Yii::$app->utils->sendmail($to,$subject,$body,$identifier);
          return $this->redirect(['index']);
        }

      } else {
        return $this->renderAjax('invite', [
          'model' => $model,
          'modelreccan' => $modelreccan,
          'modelrecreq' => $modelrecreq,
          'office' => $office,
          'invitefor' => $invitefor,
        ]);
      }
    }
    public function actionChangejo($userid,$reccanid)
    {
      $model = $this->findModel($reccanid);
      $modelreccan = Recruitmentcandidate::find()->where(['id'=>$reccanid])->one();
      $modelrecreq = Transrincian::find()->where(['id'=>$modelreccan->recruitreqid])->one();


      $modeluprofile = Userprofile::find()->where(['userid'=>$userid])->one();
      $modelulogin = Userlogin::find()->where(['id'=>$userid])->one();


      $model->fullname = $modeluprofile->fullname;


      if ($model->load(Yii::$app->request->post())) {

        if($model->save()){
          return $this->redirect(['index']);
        }

      } else {
        return $this->renderAjax('changejo', [
          'model' => $model,
          'modelreccan' => $modelreccan,
          'modelrecreq' => $modelrecreq,
        ]);
      }
    }

    public function actionApplyjob() //action apply job pada user page -> save ke recruitmentcandidate
    {
      $jobsid = $_GET['jobsid'];
      $userid = $_GET['userid'];

      $model = new Recruitmentcandidate();
      $recruitreqid = Recruitmentcandidate::find()->where(['recruitreqid' => $jobsid])->one();
      $transrincian = Transrincian::find()->where(['id' => $recruitreqid])->all();
      $hirejabatan = Transrincian::find()->where(['hire_jabatan_sap' => $transrincian])->one();
      // var_dump($hirejabatan);die;      
      $kodejabatan = Mappingjob::find()->where(['kodejabatan' => $hirejabatan])->one();
      $subjobfamilyid = Mappingjob::find()->where(['subjobfamilyid' => $kodejabatan->subjobfamilyid])->one();
      $mappingid = Mappingjob::find()->where(['id' => $subjobfamilyid])->all();

      $jobfamily = Mastersubjobfamily::find()->where(['id' => $mappingid])->one();
      // var_dump($jobfamily->id);die;
      $jobfamilyid = Mastersubjobfamily::find()->where(['jobfamily_id' => $jobfamily->jobfamily_id])->one();

      $subjobfamily_id = $subjobfamilyid->subjobfamilyid;
      $jobfamily_id = $jobfamilyid->jobfamily_id;

      $model->createtime = date('Y-m-d H-i-s');
      $model->updatetime = date('Y-m-d H-i-s');
      $model->status = 0;
      $model->typeinterview = 1;
      $model->recruitreqid = $jobsid;
      $model->userid = $userid;
      $model->subjobfamily = $subjobfamily_id;
      $model->jobfamily = $jobfamily_id;
      $model->save();
      return $this->redirect(['site/searchjob']);
    }

    public function actionWalkin($userid,$jobsid)
    {
      $interviewcheck = Interview::find()
      ->where(['DATE(scheduledate)'=>date('Y-m-d')])
      ->orWhere(['DATE(date)'=>date('Y-m-d')])
      ->andWhere(['userid'=>$userid])
      ->one();

      if(!$interviewcheck){
        $model = new Recruitmentcandidate();
        $modelinterview = new Interview();
        $recancheck = Recruitmentcandidate::find()->where(['userid'=>$userid,'recruitreqid'=>$jobsid])->one();

        $model->createtime = date('Y-m-d H-i-s');
        $model->updatetime = date('Y-m-d H-i-s');
        $model->status = 1;
        $model->recruitreqid = $jobsid;
        $model->userid = $userid;
        $model->typeinterview = 2;

        $modelinterview->createtime = date('Y-m-d H-i-s');
        $modelinterview->updatetime = date('Y-m-d H-i-s');
        $modelinterview->status = 0;

        $modelinterview->scheduledate = date('Y-m-d H-i-s');
        $modelinterview->userid = $userid;
        if($recancheck){
          $recancheck->invitationnumber = $model->userid.$recancheck->id.'-ISHINVTWI';
          $recancheck->typeinterview = 2;
          $recancheck->status = 1;
          $recancheck->save();
          $modelinterview->recruitmentcandidateid = $recancheck->id;
        }else{

          $model->save();
          $geninvtno = Recruitmentcandidate::find()->where(['id'=>$model->id])->one();
          $geninvtno->invitationnumber = $model->userid.$geninvtno->id.'-ISHINVTWI';
          $geninvtno->save();
          $modelinterview->recruitmentcandidateid = $model->id;
        }
        $modelinterview->save(false);
      }else{
        echo "<script>alert('message');</script>";
      }

      return $this->redirect(['site/searchjob']);
    }

    /**
    * Deletes an existing Recruitmentcandidate model.
    * If deletion is successful, the browser will be redirected to the 'index' page.
    * @param integer $id
    * @return mixed
    */
    public function actionDelete($id)
    {
      $this->findModel($id)->delete();

      return $this->redirect(['index']);
    }
    public function actionCancel($id)
    {
      $model = $this->findModel($id);
      $model->status = 24;
      $model->save(false);
      return $this->redirect(['index']);
    }

    /**
    * Finds the Recruitmentcandidate model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @param integer $id
    * @return Recruitmentcandidate the loaded model
    * @throws NotFoundHttpException if the model cannot be found
    */
    protected function findModel($id)
    {
      if (($model = Recruitmentcandidate::findOne($id)) !== null) {
        return $model;
      } else {
        throw new NotFoundHttpException('The requested page does not exist.');
      }
    }
  }
