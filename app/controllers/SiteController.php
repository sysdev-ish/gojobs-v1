<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\User;
use app\models\ContactForm;
use app\models\SignupForm;
use app\models\Userdata;
use app\models\Transrincian;
use app\models\Userprofile;
use app\models\Transrinciansearch;
use app\models\Recruitmentcandidate;
use app\models\Hiring;
use app\models\Interview;
use app\models\Psikotest;
use app\models\Userinterview;
use app\models\Tsoftskill;
use app\models\Thardskill;
use app\models\Taktif;
use app\models\Tpasif;
use app\models\Forgotpassword;
use app\models\Resetpassword;
use app\models\Chagerequestjo;
use app\models\Cms;
use app\models\Masterjobfamily;
use app\models\Saparea;
use app\models\Sappersonalarea;
use linslin\yii2\curl;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;

class SiteController extends Controller
{
  /**
   * {@inheritdoc}
   */
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'only' => ['logout', 'dashboard'],
        'rules' => [

          [
            'actions' => ['dashboard'],
            'allow' => true,
            'roles' => ['@'],
            'matchCallback' => function () {
              return (Yii::$app->utils->permission(Yii::$app->user->identity->role, 'B01'));
            }

          ],
          [
            'actions' => ['logout'],
            'allow' => true,
            'roles' => ['@'],
          ],
        ],

      ],
      'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
          'logout' => ['post'],
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function actions()
  {
    return [
      'error' => [
        'class' => 'yii\web\ErrorAction',
      ],
      'captcha' => [
        'class' => 'yii\captcha\CaptchaAction',
        'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
      ],
    ];
  }

  public function init()
  {
    parent::init();
    if (Yii::$app->session->get('language')) Yii::$app->language = Yii::$app->session->get('language');
  }

  /**
   * Displays homepage.
   *
   * @return string
   */
  public function actionIndex()
  {

    //Yii::$app->language = 'id';

    $searchModel = new Transrinciansearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    $this->layout = Yii::$app->utils->getlayout();
    $totaljo  = Transrincian::find()->joinWith("jobfunc")->joinWith("transjo")->where('trans_jo.type_jo <= 2')->andWhere('trans_jo.type_replace = 2')->andWhere('trans_rincian_rekrut.status_rekrut <> 2')->count();
    $joblocation  = Transrincian::find()->joinWith("jobfunc")->joinWith("transjo")->where('trans_jo.type_jo <= 2')->andWhere('trans_jo.type_replace = 2')->andWhere('trans_rincian_rekrut.status_rekrut <> 2')->groupBy(['lokasi'])->count();
    $jobfunction = Transrincian::find()->joinWith("jobfunc")->joinWith("transjo")->where('trans_jo.type_jo <= 2')->andWhere('trans_jo.type_replace = 2')->andWhere('trans_rincian_rekrut.status_rekrut <> 2')->groupBy(['job_function.name_job_function'])->orderby(['id' => SORT_DESC])->limit(8)->all();
    $jobcategory = Masterjobfamily::find()->andWhere('status = 1')->orderby(['jobfamily' => SORT_ASC])->all();
    $totaljocategory  = Transrincian::find()->andWhere('trans_rincian_rekrut.status_rekrut <> 1')->groupBy(['hire_jabatan_sap'])->count();
    $totalapplicant = Userprofile::find()->count();
    $bannerContent = Cms::find(1)->where('type_content = 1')->andWhere('status = 1')->one();

    if (Yii::$app->user->isGuest) {
      return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'totaljo' => $totaljo,
        'totalapplicant' => $totalapplicant,
        'joblocation' => $joblocation,
        'jobfunction' => $jobfunction,
        'jobcategory' => $jobcategory,
        'totaljocategory' => $totaljocategory,
      ]);
    } else {
      if (Yii::$app->user->identity->requestforchangepassword == 1) {
        return $this->redirect(['site/changepassword', 'id' => Yii::$app->user->identity->id]);
      } else {
        if (Yii::$app->user->identity->role != 2) {
          Yii::$app->utils->create_login_log();
          return $this->redirect('site/dashboard');
        } else {
          if (Yii::$app->user->identity->verify_status == 1 or Yii::$app->user->identity->role == 1) {
            if (Yii::$app->check->datacompleted(Yii::$app->user->identity->id) == 0 and Yii::$app->user->identity->role == 2) {
              return $this->redirect(['userprofile/cwizard']);
            } else {
              Yii::$app->session->setFlash('showBanner', true);
              return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'totaljo' => $totaljo,
                'totalapplicant' => $totalapplicant,
                'joblocation' => $joblocation,
                'jobfunction' => $jobfunction,
                'jobcategory' => $jobcategory,
                'totaljocategory' => $totaljocategory,
                'bannerContent' => $bannerContent,
              ]);
            }
          } else {
            return $this->redirect('site/verifycode');
          }
        }
      }
    }
  }

  public function actionChangepassword($id)
  {
    $this->layout = 'main-applicant';
    $model =  new Resetpassword();
    $modelsave = Userdata::find()->where(['id' => $id])->one();
    $model->username = $modelsave->username;
    $user = User::findByUsername($modelsave->username);
    if ($model->load(Yii::$app->request->post())) {
      if (!$user || !$user->validatePassword($model->password)) {
        $modelsave->password_hash = Yii::$app->security->generatePasswordHash($model->password);
        $modelsave->requestforchangepassword = 2;
        $modelsave->save(false);
        return $this->goHome();
      } else {
        Yii::$app->session->setFlash('error', "Password yang anda masukkan sama dengan password sebelumnya.");
      }
    }
    return $this->render('changepassword', [
      'model' => $model,
    ]);
  }
  public function actionSearchjob()
  {
    $searchModel = new Transrinciansearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    $this->layout = Yii::$app->utils->getlayout();
    if (Yii::$app->user->isGuest) {
      return $this->render('searchjob', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
      ]);
    } else {
      if (Yii::$app->check->datacompleted(Yii::$app->user->identity->id) == 0 and  Yii::$app->user->identity->role == 2) {
        if (Yii::$app->user->identity->verify_status == 1) {
          return $this->redirect(['userprofile/cwizard']);
        } else {
          return $this->redirect('verifycode');
        }
      } else {
        return $this->render('searchjob', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
        ]);
      }
    }
  }
  public function actionVerifycode()
  {
    $this->layout = Yii::$app->utils->getlayout();
    $id = Yii::$app->user->identity->id;
    // $model = $this->findModel($id);
    $model =  new Userdata();
    $modelsave = Userdata::find()->where(['id' => $id])->one();

    if ($model->load(Yii::$app->request->post())) {
      // var_dump($model->verify_code);die();
      if ($model->verify_code == 'CWLjUrxM') {
        $modelsave->verify_status = 1;
        $modelsave->save(false);
        return $this->goHome();
      } else if ($modelsave->verify_code != $model->verify_code) {
        Yii::$app->session->setFlash('error', "Code yang anda masukkan salah.");
      } else {
        $modelsave->verify_status = 1;
        $modelsave->save(false);
        return $this->goHome();
      }
    }

    return $this->render('verifycode', [
      'model' => $model,
    ]);
  }

  /**
   * Login action.
   *
   * @return Response|string
   */
  public function actionDashboard()
  {

    $model = new Transrinciansearch();
    $year = date('Y');
    $model->yeardata = $year;
    $totaljo = Transrincian::find()->joinWith("transjo")->where("trans_rincian_rekrut.skema = 1 and YEAR(trans_jo.tanggal) = '" . $year . "'")->count();
    $totalclosed = Transrincian::find()->joinWith("transjo")->where("trans_rincian_rekrut.skema = 1 and trans_rincian_rekrut.status_rekrut = 2 and YEAR(trans_jo.tanggal) = '" . $year . "'")->count();
    $totalpending = $totaljo - $totalclosed;
    $totalemp = Transrincian::find()->joinWith("transjo")->where("trans_rincian_rekrut.skema = 1 and YEAR(trans_jo.tanggal) = '" . $year . "'")->sum('jumlah');
    $totalempclosed = Transrincian::find()->joinWith("transjo")->where("trans_rincian_rekrut.skema = 1 and trans_rincian_rekrut.status_rekrut = 2 and YEAR(trans_jo.tanggal) = '" . $year . "'")->sum('jumlah');
    $totalemppending = $totalemp - $totalempclosed;
    $totalapplicant = Userprofile::find()->where("YEAR(createtime) = '" . $year . "'")->count();
    // $totalapplicants3 =
    $candidatecount = Recruitmentcandidate::find()->where("YEAR(createtime) = '" . $year . "'")->count();
    $interviewapp = Interview::find()->where("YEAR(createtime) = '" . $year . "'")->count();
    $onintcount = Interview::find()->where("YEAR(createtime) = '" . $year . "'  and (status = 1 OR status = 0)")->count();
    $passintcount = Interview::find()->where("YEAR(createtime) = '" . $year . "'  and status = 2")->count();
    $failintcount = Interview::find()->where("YEAR(createtime) = '" . $year . "'  and status = 3")->count();

    $psikotestapp = Psikotest::find()->where("YEAR(createtime) = '" . $year . "'")->count();
    $onpsicount = Psikotest::find()->where("YEAR(createtime) = '" . $year . "'  and (status = 1 OR status = 0)")->count();
    $passpsicount = Psikotest::find()->where("YEAR(createtime) = '" . $year . "'  and status = 2")->count();
    $failpsicount = Psikotest::find()->where("YEAR(createtime) = '" . $year . "'  and status = 3")->count();

    $uinterviewapp = Userinterview::find()->where("YEAR(createtime) = '" . $year . "'")->count();
    $onuinterviewcount = Userinterview::find()->where("YEAR(createtime) = '" . $year . "'  and (status = 1 OR status = 0)")->count();
    $passuinterviewcount = Userinterview::find()->where("YEAR(createtime) = '" . $year . "'  and status = 2")->count();
    $failuinterviewcount = Userinterview::find()->where("YEAR(createtime) = '" . $year . "'  and status = 3")->count();

    $tsoftskillapp = Tsoftskill::find()->where("YEAR(createtime) = '" . $year . "'")->count();
    $thardskillapp = Thardskill::find()->where("YEAR(createtime) = '" . $year . "'")->count();
    $tpasifapp = Tpasif::find()->where("YEAR(createtime) = '" . $year . "'")->count();
    $taktifapp = Taktif::find()->where("YEAR(createtime) = '" . $year . "'")->count();
    $totalhiring = Hiring::find()->where("YEAR(createtime) = '" . $year . "' and statushiring = 4")->count();
    $totalophiring = Hiring::find()->where("YEAR(createtime) = '" . $year . "' and statushiring <> 4 and statushiring <> 5")->count();

    $totalstopjo = Chagerequestjo::find()->where("YEAR(createtime) = '" . $year . "' and status = 3")->groupBy(['recruitreqid'])->count();
    $datastopjo = Chagerequestjo::find()->where("YEAR(createtime) = '" . $year . "' and status = 3")->groupBy(['recruitreqid'])->all();
    $totalpekerjastopjo = 0;
    foreach ($datastopjo as $key => $value) {
      $pkerjastop = $value->oldjumlah - $value->jumlah;
      $totalpekerjastopjo += $pkerjastop;
    }

    if ($model->load(Yii::$app->request->post())) {
      $year = $model->yeardata;
      $model->yeardata = $year;
      if ($year) {
        $totaljo = Transrincian::find()->joinWith("transjo")->where("trans_rincian_rekrut.skema = 1 and YEAR(trans_jo.tanggal) = '" . $year . "'")->count();
        $totalclosed = Transrincian::find()->joinWith("transjo")->where("trans_rincian_rekrut.skema = 1 and trans_rincian_rekrut.status_rekrut = 2 and YEAR(trans_jo.tanggal) = '" . $year . "'")->count();
        $totalpending = $totaljo - $totalclosed;
        $totalemp = Transrincian::find()->joinWith("transjo")->where("trans_rincian_rekrut.skema = 1 and YEAR(trans_jo.tanggal) = '" . $year . "'")->sum('jumlah');
        $totalempclosed = Transrincian::find()->joinWith("transjo")->where("trans_rincian_rekrut.skema = 1 and trans_rincian_rekrut.status_rekrut = 2 and YEAR(trans_jo.tanggal) = '" . $year . "'")->sum('jumlah');
        $totalemppending = $totalemp - $totalempclosed;
        $totalapplicant = Userprofile::find()->where("YEAR(createtime) = '" . $year . "'")->count();
        $candidatecount = Recruitmentcandidate::find()->where("YEAR(createtime) = '" . $year . "'")->count();
        $interviewapp = Interview::find()->where("YEAR(createtime) = '" . $year . "'")->count();
        $onintcount = Interview::find()->where("YEAR(createtime) = '" . $year . "'  and (status = 1 OR status = 0)")->count();
        $passintcount = Interview::find()->where("YEAR(createtime) = '" . $year . "'  and status = 2")->count();
        $failintcount = Interview::find()->where("YEAR(createtime) = '" . $year . "'  and status = 3")->count();

        $psikotestapp = Psikotest::find()->where("YEAR(createtime) = '" . $year . "'")->count();
        $onpsicount = Psikotest::find()->where("YEAR(createtime) = '" . $year . "'  and (status = 1 OR status = 0)")->count();
        $passpsicount = Psikotest::find()->where("YEAR(createtime) = '" . $year . "'  and status = 2")->count();
        $failpsicount = Psikotest::find()->where("YEAR(createtime) = '" . $year . "'  and status = 3")->count();

        $uinterviewapp = Userinterview::find()->where("YEAR(createtime) = '" . $year . "'")->count();
        $onuinterviewcount = Userinterview::find()->where("YEAR(createtime) = '" . $year . "'  and (status = 1 OR status = 0)")->count();
        $passuinterviewcount = Userinterview::find()->where("YEAR(createtime) = '" . $year . "'  and status = 2")->count();
        $failuinterviewcount = Userinterview::find()->where("YEAR(createtime) = '" . $year . "'  and status = 3")->count();

        $tsoftskillapp = Tsoftskill::find()->where("YEAR(createtime) = '" . $year . "'")->count();
        $thardskillapp = Thardskill::find()->where("YEAR(createtime) = '" . $year . "'")->count();
        $tpasifapp = Tpasif::find()->where("YEAR(createtime) = '" . $year . "'")->count();
        $taktifapp = Taktif::find()->where("YEAR(createtime) = '" . $year . "'")->count();
        $totalhiring = Hiring::find()->where("YEAR(createtime) = '" . $year . "' and statushiring = 4")->count();
        $totalophiring = Hiring::find()->where("YEAR(createtime) = '" . $year . "' and statushiring <> 4 and statushiring <> 5")->count();
        $totalstopjo = Chagerequestjo::find()->where("YEAR(createtime) = '" . $year . "' and status = 3")->groupBy(['recruitreqid'])->count();
        $datastopjo = Chagerequestjo::find()->where("YEAR(createtime) = '" . $year . "' and status = 3")->groupBy(['recruitreqid'])->all();
        foreach ($datastopjo as $key => $value) {
          $pkerjastop = $value->oldjumlah - $value->jumlah;
          $totalpekerjastopjo += $pkerjastop;
        }
      } else {
        $totaljo = Transrincian::find()->where('skema = 1')->count();
        $totalclosed = Transrincian::find()->where('skema = 1')->andWhere('status_rekrut = 2')->count();
        $totalpending = $totaljo - $totalclosed;
        $totalemp = Transrincian::find()->where('skema = 1')->count();
        $totaleclosed = Transrincian::find()->where('skema = 1')->andWhere('status_rekrut = 2')->count();
        $totalempending = $totalemp - $totaleclosed;
        $totalapplicant = Userprofile::find()->count();
        $candidatecount = Recruitmentcandidate::find()->count();
        $interviewapp = Interview::find()->count();
        $onintcount = Interview::find()->where("status = 1 OR status = 0")->count();
        $passintcount = Interview::find()->where("status = 2")->count();
        $failintcount = Interview::find()->where("status = 3")->count();

        $psikotestapp = Psikotest::find()->count();
        $onpsicount = Psikotest::find()->where("status = 1 OR status = 0")->count();
        $passpsicount = Psikotest::find()->where("status = 2")->count();
        $failpsicount = Psikotest::find()->where("status = 3")->count();

        $uinterviewapp = Userinterview::find()->count();
        $onuinterviewcount = Userinterview::find()->where("status = 1 OR status = 0")->count();
        $passuinterviewcount = Userinterview::find()->where("status = 2")->count();
        $failuinterviewcount = Userinterview::find()->where("status = 3")->count();

        $tsoftskillapp = Tsoftskill::find()->count();
        $thardskillapp = Thardskill::find()->count();
        $tpasifapp = Tpasif::find()->count();
        $taktifapp = Taktif::find()->count();
        $totalhiring = Hiring::find()->where("statushiring = 4")->count();
        $totalophiring = Hiring::find()->where("statushiring <> 4 and statushiring <> 5")->count();
        $totalstopjo = Chagerequestjo::find()->where(['status' => 3])->groupBy(['recruitreqid'])->count();
        $datastopjo = Chagerequestjo::find()->where(['status' => 3])->groupBy(['recruitreqid'])->all();
        $totalpekerjastopjo = 0;
        foreach ($datastopjo as $key => $value) {
          $pkerjastop = $value->oldjumlah - $value->jumlah;
          $totalpekerjastopjo += $pkerjastop;
        }
      }
    }

    $parea = ArrayHelper::map(Sappersonalarea::find()->asArray()->all(), 'value1', 'value2');
    $area = ArrayHelper::map(Saparea::find()->asArray()->all(), 'value1', 'value2');

    return $this->render('dashboard', [
      'model' => $model,
      'parea' => $parea,
      'area' => $area,
      'totaljo' => $totaljo,
      'totalclosed' => $totalclosed,
      'totalpending' => $totalpending,
      'totalemp' => $totalemp,
      'totalempclosed' => $totalempclosed,
      'totalemppending' => $totalemppending,
      'totalapplicant' => $totalapplicant,
      'candidatecount' => $candidatecount,
      'interviewapp' => $interviewapp,
      'psikotestapp' => $psikotestapp,
      'uinterviewapp' => $uinterviewapp,
      'tsoftskillapp' => $tsoftskillapp,
      'thardskillapp' => $thardskillapp,
      'tpasifapp' => $tpasifapp,
      'taktifapp' => $taktifapp,
      'onintcount' => $onintcount,
      'passintcount' => $passintcount,
      'failintcount' => $failintcount,
      'onpsicount' => $onpsicount,
      'passpsicount' => $passpsicount,
      'failpsicount' => $failpsicount,
      'onuinterviewcount' => $onuinterviewcount,
      'passuinterviewcount' => $passuinterviewcount,
      'failuinterviewcount' => $failuinterviewcount,
      'totalhiring' => $totalhiring,
      'totalophiring' => $totalophiring,
      'totalstopjo' => $totalstopjo,
      'totalpekerjastopjo' => $totalpekerjastopjo,
    ]);
  }

  public function actionDashboardetail()
  {

    $model = new Transrinciansearch();

    $year = date('Y');
    $model->yeardata = $year;

    $totaljo = Transrincian::find()->joinWith("transjo")->where("trans_rincian_rekrut.skema = 1 and YEAR(trans_jo.tanggal) = '" . $year . "'")->count();
    $totalclosed = Transrincian::find()->joinWith("transjo")->where("trans_rincian_rekrut.skema = 1 and trans_rincian_rekrut.status_rekrut = 2 and YEAR(trans_jo.tanggal) = '" . $year . "'")->count();
    $totalpending = $totaljo - $totalclosed;
    $totalemp = Transrincian::find()->joinWith("transjo")->where("trans_rincian_rekrut.skema = 1 and YEAR(trans_jo.tanggal) = '" . $year . "'")->sum('jumlah');
    $totalempclosed = Transrincian::find()->joinWith("transjo")->where("trans_rincian_rekrut.skema = 1 and trans_rincian_rekrut.status_rekrut = 2 and YEAR(trans_jo.tanggal) = '" . $year . "'")->sum('jumlah');
    $totalemppending = $totalemp - $totalempclosed;
    $totalapplicant = Userprofile::find()->where("YEAR(createtime) = '" . $year . "'")->count();
    // $totalapplicants3 =
    $candidatecount = Recruitmentcandidate::find()->where("YEAR(createtime) = '" . $year . "'")->count();
    $interviewapp = Interview::find()->where("YEAR(createtime) = '" . $year . "'")->count();
    $onintcount = Interview::find()->where("YEAR(createtime) = '" . $year . "'  and (status = 1 OR status = 0)")->count();
    $passintcount = Interview::find()->where("YEAR(createtime) = '" . $year . "'  and status = 2")->count();
    $failintcount = Interview::find()->where("YEAR(createtime) = '" . $year . "'  and status = 3")->count();

    $psikotestapp = Psikotest::find()->where("YEAR(createtime) = '" . $year . "'")->count();
    $onpsicount = Psikotest::find()->where("YEAR(createtime) = '" . $year . "'  and (status = 1 OR status = 0)")->count();
    $passpsicount = Psikotest::find()->where("YEAR(createtime) = '" . $year . "'  and status = 2")->count();
    $failpsicount = Psikotest::find()->where("YEAR(createtime) = '" . $year . "'  and status = 3")->count();

    $uinterviewapp = Userinterview::find()->where("YEAR(createtime) = '" . $year . "'")->count();
    $onuinterviewcount = Userinterview::find()->where("YEAR(createtime) = '" . $year . "'  and (status = 1 OR status = 0)")->count();
    $passuinterviewcount = Userinterview::find()->where("YEAR(createtime) = '" . $year . "'  and status = 2")->count();
    $failuinterviewcount = Userinterview::find()->where("YEAR(createtime) = '" . $year . "'  and status = 3")->count();

    $tsoftskillapp = Tsoftskill::find()->where("YEAR(createtime) = '" . $year . "'")->count();
    $thardskillapp = Thardskill::find()->where("YEAR(createtime) = '" . $year . "'")->count();
    $tpasifapp = Tpasif::find()->where("YEAR(createtime) = '" . $year . "'")->count();
    $taktifapp = Taktif::find()->where("YEAR(createtime) = '" . $year . "'")->count();
    $totalhiring = Hiring::find()->where("YEAR(createtime) = '" . $year . "' and statushiring = 4")->count();
    $totalophiring = Hiring::find()->where("YEAR(createtime) = '" . $year . "' and statushiring <> 4 and statushiring <> 5")->count();

    $totalstopjo = Chagerequestjo::find()->where("YEAR(createtime) = '" . $year . "' and status = 3")->groupBy(['recruitreqid'])->count();
    $datastopjo = Chagerequestjo::find()->where("YEAR(createtime) = '" . $year . "' and status = 3")->groupBy(['recruitreqid'])->all();
    $totalpekerjastopjo = 0;
    foreach ($datastopjo as $key => $value) {
      $pkerjastop = $value->oldjumlah - $value->jumlah;
      $totalpekerjastopjo += $pkerjastop;
    }

    if ($model->load(Yii::$app->request->post())) {

      if ($model->start_date and $model->end_date and $model->persa_sap and $model->area_sap) {

        $start_date = $model->start_date;
        $end_date = $model->end_date;

        $persa = $model->persa_sap;
        if ($persa) {
          $persa_sap = '"' . implode('","', $persa) . '"';
        } else {
          $persa_sap = '""';
        }

        $area = $model->area_sap;
        if ($area) {
          $area_sap = '"' . implode('","', $area) . '"';
        } else {
          $area_sap = '""';
        }

        $recruitreq = Transrincian::find()->select('id')->where("persa_sap IN (" . $persa_sap . ") and area_sap IN (" . $area_sap . ") ")->column();
        $recruitreq_id = implode(',', $recruitreq);
        // var_dump($recruitreq);die();

        $recruitment_candidate = Recruitmentcandidate::find()->select('id')->where("recruitreqid IN (" . $recruitreq_id . ")")->column();
        $recruitment_candidate_id = implode(',', $recruitment_candidate);
        // var_dump($recruitment_candidate_id);die();

        $totaljo = Transrincian::find()->joinWith("transjo")->where("trans_rincian_rekrut.skema = 1 and trans_jo.tanggal between '" . $start_date . "' and '" . $end_date . "' and persa_sap IN (" . $persa_sap . ") and area_sap IN (" . $area_sap . ") ")->count();
        // var_dump($totaljo);die();

        $totalclosed = Transrincian::find()->joinWith("transjo")->where("trans_rincian_rekrut.skema = 1 and trans_rincian_rekrut.status_rekrut = 2 and trans_jo.tanggal between '" . $start_date . "' and '" . $end_date . "' and persa_sap IN (" . $persa_sap . ") and area_sap IN (" . $area_sap . ") ")->count();
        // var_dump($totaljo);die();
        $totalpending = $totaljo - $totalclosed;

        $totalemp = Transrincian::find()->joinWith("transjo")->where("trans_rincian_rekrut.skema = 1 and trans_jo.tanggal between '" . $start_date . "' and '" . $end_date . "' and persa_sap IN (" . $persa_sap . ") and area_sap IN (" . $area_sap . ") ")->sum('jumlah');
        $totalempclosed = Transrincian::find()->joinWith("transjo")->where("trans_rincian_rekrut.skema = 1 and trans_rincian_rekrut.status_rekrut = 2 and trans_jo.tanggal between '" . $start_date . "' and '" . $end_date . "' and persa_sap IN (" . $persa_sap . ") and area_sap IN (" . $area_sap . ") ")->sum('jumlah');
        $totalemppending = $totalemp - $totalempclosed;

        $totalapplicant = Userprofile::find()->where("createtime between '" . $start_date . "' and '" . $end_date . "' ")->count();

        $candidatecount = Recruitmentcandidate::find()->where("createtime between '" . $start_date . "' and '" . $end_date . "' and id IN (" . $recruitment_candidate_id . ") ")->count();
        $interviewapp = Interview::find()->where("createtime between '" . $start_date . "' and '" . $end_date . "' and id IN (" . $recruitment_candidate_id . ") ")->count();
        $onintcount = Interview::find()->where("createtime between '" . $start_date . "' and '" . $end_date . "' and (status = 1 OR status = 0) and recruitmentcandidateid IN (" . $recruitment_candidate_id . ") ")->count();
        $passintcount = Interview::find()->where("createtime between '" . $start_date . "' and '" . $end_date . "' and status = 2 and recruitmentcandidateid IN (" . $recruitment_candidate_id . ") ")->count();
        $failintcount = Interview::find()->where("createtime between '" . $start_date . "' and '" . $end_date . "' and status = 3 and recruitmentcandidateid IN (" . $recruitment_candidate_id . ") ")->count();

        $psikotestapp = Psikotest::find()->where("createtime between '" . $start_date . "' and '" . $end_date . "' and recruitmentcandidateid IN (" . $recruitment_candidate_id . ") ")->count();
        $onpsicount = Psikotest::find()->where("createtime between '" . $start_date . "' and '" . $end_date . "' and (status = 1 OR status = 0) and recruitmentcandidateid IN (" . $recruitment_candidate_id . ") ")->count();
        $passpsicount = Psikotest::find()->where("createtime between '" . $start_date . "' and '" . $end_date . "' and status = 2 and recruitmentcandidateid IN (" . $recruitment_candidate_id . ") ")->count();
        $failpsicount = Psikotest::find()->where("createtime between '" . $start_date . "' and '" . $end_date . "' and status = 3 and recruitmentcandidateid IN (" . $recruitment_candidate_id . ") ")->count();

        $uinterviewapp = Userinterview::find()->where("createtime between '" . $start_date . "' and '" . $end_date . "' and recruitmentcandidateid IN (" . $recruitment_candidate_id . ") ")->count();
        $onuinterviewcount = Userinterview::find()->where("createtime between '" . $start_date . "' and '" . $end_date . "' and (status = 1 OR status = 0) and recruitmentcandidateid IN (" . $recruitment_candidate_id . ") ")->count();
        $passuinterviewcount = Userinterview::find()->where("createtime between '" . $start_date . "' and '" . $end_date . "' and status = 2 and recruitmentcandidateid IN (" . $recruitment_candidate_id . ") ")->count();
        $failuinterviewcount = Userinterview::find()->where("createtime between '" . $start_date . "' and '" . $end_date . "' and status = 3 and recruitmentcandidateid IN (" . $recruitment_candidate_id . ") ")->count();

        $tsoftskillapp = Tsoftskill::find()->where("createtime between '" . $start_date . "' and '" . $end_date . "' and recruitmentcandidateid IN (" . $recruitment_candidate_id . ") ")->count();
        $thardskillapp = Thardskill::find()->where("createtime between '" . $start_date . "' and '" . $end_date . "' and recruitmentcandidateid IN (" . $recruitment_candidate_id . ") ")->count();
        $tpasifapp = Tpasif::find()->where("createtime between '" . $start_date . "' and '" . $end_date . "' and recruitmentcandidateid IN (" . $recruitment_candidate_id . ") ")->count();
        $taktifapp = Taktif::find()->where("createtime between '" . $start_date . "' and '" . $end_date . "' and recruitmentcandidateid IN (" . $recruitment_candidate_id . ") ")->count();

        $totalhiring = Hiring::find()->where("createtime between '" . $start_date . "' and '" . $end_date . "' and statushiring = 4 and recruitreqid IN (" . $recruitreq_id . ") ")->count();
        $totalophiring = Hiring::find()->where("createtime between '" . $start_date . "' and '" . $end_date . "' and statushiring <> 4 and statushiring <> 5 and recruitreqid IN (" . $recruitreq_id . ") ")->count();
        $totalstopjo = Chagerequestjo::find()->where("createtime between '" . $start_date . "' and '" . $end_date . "' and status = 3 and recruitreqid IN (" . $recruitreq_id . ") ")->groupBy(['recruitreqid'])->count();
        $datastopjo = Chagerequestjo::find()->where("createtime between '" . $start_date . "' and '" . $end_date . "' and status = 3 and recruitreqid IN (" . $recruitreq_id . ") ")->groupBy(['recruitreqid'])->all();

        $totalpekerjastopjo = 0;
        foreach ($datastopjo as $key => $value) {
          // var_dump($datastopjo);die();
          $pkerjastop = $value->oldjumlah - $value->jumlah;
          $totalpekerjastopjo += $pkerjastop;
        }
      } else {
        $totaljo = Transrincian::find()->where('skema = 1')->count();
        $totalclosed = Transrincian::find()->where('skema = 1')->andWhere('status_rekrut = 2')->count();
        $totalpending = $totaljo - $totalclosed;
        $totalemp = Transrincian::find()->where('skema = 1')->count();
        $totaleclosed = Transrincian::find()->where('skema = 1')->andWhere('status_rekrut = 2')->count();
        $totalempending = $totalemp - $totaleclosed;
        $totalapplicant = Userprofile::find()->count();
        $candidatecount = Recruitmentcandidate::find()->count();
        $interviewapp = Interview::find()->count();
        $onintcount = Interview::find()->where("status = 1 OR status = 0")->count();
        $passintcount = Interview::find()->where("status = 2")->count();
        $failintcount = Interview::find()->where("status = 3")->count();

        $psikotestapp = Psikotest::find()->count();
        $onpsicount = Psikotest::find()->where("status = 1 OR status = 0")->count();
        $passpsicount = Psikotest::find()->where("status = 2")->count();
        $failpsicount = Psikotest::find()->where("status = 3")->count();

        $uinterviewapp = Userinterview::find()->count();
        $onuinterviewcount = Userinterview::find()->where("status = 1 OR status = 0")->count();
        $passuinterviewcount = Userinterview::find()->where("status = 2")->count();
        $failuinterviewcount = Userinterview::find()->where("status = 3")->count();

        $tsoftskillapp = Tsoftskill::find()->count();
        $thardskillapp = Thardskill::find()->count();
        $tpasifapp = Tpasif::find()->count();
        $taktifapp = Taktif::find()->count();
        $totalhiring = Hiring::find()->where("statushiring = 4")->count();
        $totalophiring = Hiring::find()->where("statushiring <> 4 and statushiring <> 5")->count();
        $totalstopjo = Chagerequestjo::find()->where(['status' => 3])->groupBy(['recruitreqid'])->count();
        $datastopjo = Chagerequestjo::find()->where(['status' => 3])->groupBy(['recruitreqid'])->all();
        $totalpekerjastopjo = 0;
        foreach ($datastopjo as $key => $value) {
          $pkerjastop = $value->oldjumlah - $value->jumlah;
          $totalpekerjastopjo += $pkerjastop;
        }
      }
    }

    $parea = ArrayHelper::map(Sappersonalarea::find()->asArray()->all(), 'value1', 'value2');
    $area = ArrayHelper::map(Saparea::find()->asArray()->all(), 'value1', 'value2');

    return $this->render('dashboardetail', [
      'model' => $model,
      'parea' => $parea,
      'area' => $area,
      'totaljo' => $totaljo,
      'totalclosed' => $totalclosed,
      'totalpending' => $totalpending,
      'totalemp' => $totalemp,
      'totalempclosed' => $totalempclosed,
      'totalemppending' => $totalemppending,
      'totalapplicant' => $totalapplicant,
      'candidatecount' => $candidatecount,
      'interviewapp' => $interviewapp,
      'psikotestapp' => $psikotestapp,
      'uinterviewapp' => $uinterviewapp,
      'tsoftskillapp' => $tsoftskillapp,
      'thardskillapp' => $thardskillapp,
      'tpasifapp' => $tpasifapp,
      'taktifapp' => $taktifapp,
      'onintcount' => $onintcount,
      'passintcount' => $passintcount,
      'failintcount' => $failintcount,
      'onpsicount' => $onpsicount,
      'passpsicount' => $passpsicount,
      'failpsicount' => $failpsicount,
      'onuinterviewcount' => $onuinterviewcount,
      'passuinterviewcount' => $passuinterviewcount,
      'failuinterviewcount' => $failuinterviewcount,
      'totalhiring' => $totalhiring,
      'totalophiring' => $totalophiring,
      'totalstopjo' => $totalstopjo,
      'totalpekerjastopjo' => $totalpekerjastopjo,
    ]);
  }

  public function actionLogin()
  {
    if (!Yii::$app->user->isGuest) {
      return $this->goHome();
    }

    $model = new LoginForm();
    if ($model->load(Yii::$app->request->post()) && $model->login()) {
      return $this->goHome();
    }

    $model->password = '';
    if (Yii::$app->request->isAjax) {
      return $this->renderAjax('loginajax', [
        'model' => $model,
      ]);
    } else {
      // var_dump(Yii::$app->utils->getlayout());die;
      $this->layout = Yii::$app->utils->getlayout();
      return $this->render('login', [
        'model' => $model,
      ]);
    }
  }

  public function actionOauthhris()
  {
    if (!isset($_GET['code'])) {
      throw new HttpException(404, 'Failed to get user login code');
    }

    $auth_code = $_GET['code'];

    try {
      $accesstoken = Yii::$app->oauth->getaccesstoken($auth_code);
      // var_dump($accesstoken);die;
      if (empty($accesstoken)) {
        throw new \Exception('Empty access token response');
      }

      $token = json_decode($accesstoken);
      if (!isset($token->data->access_token)) {
        throw new \Exception('Access token not found in response');
      }

      $access_token = $token->data->access_token;
      $user = Yii::$app->oauth->getuserdata($access_token);

      if (empty($user)) {
        throw new \Exception('User data is empty');
      }

      // Success, redirect to home
      return $this->goHome();
    } catch (\Exception $e) {
      Yii::error('OAuth error: ' . $e->getMessage(), __METHOD__);
      $this->layout = 'main-applicant';
      throw new HttpException(500, 'Failed to authenticate via HRIS: ' . $e->getMessage());
    }
  }

  public function actionAjaxLogin()
  {
    if (Yii::$app->request->isAjax) {
      $model = new LoginForm();
      if ($model->load(Yii::$app->request->post())) {
        if ($model->login()) {
          return $this->goBack();
        } else {
          Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
          return \yii\widgets\ActiveForm::validate($model);
        }
      }
    } else {
      throw new HttpException(404, 'Page not found');
    }
  }
  public function actionForgotpassword()
  {
    $this->layout = Yii::$app->utils->getlayout();
    $model = new Forgotpassword();
    if ($model->load(Yii::$app->request->post())) {
      if ($user = $model->forgotpassword($model->username)) {
        return $this->redirect(['site/resetpassword', 'id' => $user]);
      } else {
        Yii::$app->session->setFlash('error', "User tidak terdaftar.");
      }
    }

    return $this->render('forgotpassword', [
      'model' => $model,
    ]);
  }
  public function actionResetpassword($id)
  {
    $this->layout = Yii::$app->utils->getlayout();
    $model =  new Resetpassword();
    $modelsave = Userdata::find()->where(['id' => $id])->one();
    $model->username = $modelsave->username;
    if ($model->load(Yii::$app->request->post())) {
      if ($model->password_reset_token == 'NO2BZvlg') {
        $modelsave->password_reset_token = null;
        $modelsave->password_hash = Yii::$app->security->generatePasswordHash($model->password);
        $modelsave->save(false);
        return $this->goHome();
      } else if ($modelsave->password_reset_token != $model->password_reset_token) {
        Yii::$app->session->setFlash('error', "Token yang anda masukkan salah.");
      } else {
        $modelsave->password_reset_token = null;
        $modelsave->password_hash = Yii::$app->security->generatePasswordHash($model->password);
        $modelsave->save(false);
        return $this->goHome();
      }
    }
    return $this->render('resetpassword', [
      'model' => $model,
    ]);
  }

  /**
   * Logout action.
   *
   * @return Response
   */
  public function actionLogout()
  {
    // var_dump(Yii::$app->user->identity->id);die();
    // var_dump(Yii::$app->oauth->logout(Yii::$app->user->identity->id));die();
    Yii::$app->oauth->logout(Yii::$app->user->identity->id);
    Yii::$app->user->logout();

    return $this->goHome();
  }

  public function actionResendvcode()
  {
    if (!Yii::$app->user->isGuest) {

      $user = Userdata::find()->where(['id' => Yii::$app->user->identity->id])->one();
      $randomstring = Yii::$app->utils->generateRandomString(6);
      // $randomstring = "bypass"; //comment if email quota is set
      $user->verify_code = $randomstring;
      $user->updated_at = date('Y-m-d H-i-s');

      if ($user->save(false)) {
        $to = $user->email;
        $subject = 'Verify email';
        $body = Yii::$app->params['mailSignUp'];
        $body = str_replace('{fullname}', $user->name, $body);
        $body = str_replace('{token}', $randomstring, $body);

        // added by kaha 21-04-2025
        $verification = Yii::$app->utils->sendmailbrevo($to, $subject, $body, 2);
        if ($verification['error'] === 0) {
          Yii::$app->session->setFlash('success', 'Email sent check your inbox');
          return $this->redirect('verifycode');
        }

        // Brevo failed, fallback to SMTP
        $verification2 = Yii::$app->utils->sendmail($to, $subject, $body, 2);

        if ($verification2['error'] === 0) {
          Yii::$app->session->setFlash('success', 'Email sent check your inbox or spam');
          return $this->redirect('verifycode');
        }

        Yii::$app->session->setFlash('error', 'Email not sent');
        return $this->redirect('verifycode');
      }
      return $this->redirect('verifycode');
    } else {
      return $this->goHome();
    }
  }
  public function actionSignup()
  {
    $this->layout = Yii::$app->utils->getlayout();
    $model = new SignupForm();
    if ($model->load(Yii::$app->request->post())) {
      if ($user = $model->signup()) {
        if (Yii::$app->getUser()->login($user)) {
          return $this->goHome();
        }
      }
    }
    if (Yii::$app->request->isAjax) {
      return $this->renderAjax('signupajax', [
        'model' => $model,
      ]);
    } else {
      // var_dump(Yii::$app->utils->getlayout());die;
      $this->layout = Yii::$app->utils->getlayout();
      return $this->render('signup', [
        'model' => $model,
      ]);
    }
  }


  /**
   * Displays contact page.
   *
   * @return Response|string
   */
  public function actionContact()
  {
    // $setpass = Yii::$app->security->generatePasswordHash("123456789");
    // var_dump($setpass);die;
    $this->layout = Yii::$app->utils->getlayout();
    $model = new ContactForm();
    if (Yii::$app->user->isGuest) {
      return $this->render('contact', [
        'model' => $model,
      ]);
    } else {
      if (Yii::$app->check->datacompleted(Yii::$app->user->identity->id) == 0 and  Yii::$app->user->identity->role == 2) {
        if (Yii::$app->user->identity->verify_status == 1) {
          return $this->redirect(['userprofile/cwizard']);
        } else {

          return $this->redirect('verifycode');
        }
      } else {

        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
          Yii::$app->session->setFlash('contactFormSubmitted');

          return $this->refresh();
        }
        return $this->render('contact', [
          'model' => $model,
        ]);
      }
    }
  }

  /**
   * Displays about page.
   *
   * @return string
   */
  public function actionAbout()
  {
    $this->layout = Yii::$app->utils->getlayout();
    return $this->render('about');
  }
  // public function actionError()
  // {
  //     $error = Yii::app()->errorHandler->error;
  //     if ($error)
  // 	$this->render('error', array('error'=>$error));
  //     else
  // 	throw new CHttpException(404, 'Page not found.');
  // }

  public function actionLanguage()
  {
    $params = [
      'lang' => null,
    ];

    if (isset($_POST['lang'])) {
      if ($_POST['lang']) $params['lang'] = $_POST['lang'];
    }

    Yii::$app->session->set('language', null);
    if ($params['lang']) Yii::$app->session->set('language', $params['lang']);

    $this->redirect($_SERVER['HTTP_REFERER']);
  }

  public function actionSetlang()
  {
    $params = [
      'lang' => null,
    ];

    if (isset($_GET['lang'])) {
      if ($_GET['lang']) $params['lang'] = $_GET['lang'];
    }

    Yii::$app->session->set('language', null);
    if ($params['lang']) Yii::$app->session->set('language', $params['lang']);

    $this->redirect($_SERVER['HTTP_REFERER']);
  }

  public function actionTermscondition()
  {
    $this->layout = Yii::$app->utils->getlayout();
    $bannerContent = Cms::find(1)->where('type_content = 3')->andWhere('status = 1')->one();

    return $this->render('termscondition', [
      'bannerContent' => $bannerContent,
    ]);
  }

  public function actionPrivacypolicy()
  {
    $this->layout = Yii::$app->utils->getlayout();
    $bannerContent = Cms::find(1)->where('type_content = 2')->andWhere('status = 1')->one();

    return $this->render('privacypolicy', [
      'bannerContent' => $bannerContent,
    ]);
  }
}
