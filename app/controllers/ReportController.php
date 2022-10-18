<?php

namespace app\controllers;

use Yii;
use app\models\Computerskill;
use app\models\Canceljoinreport;
use app\models\Changejoreport;
use app\models\Englishskill;
use app\models\Hiring;
use app\models\Hiringsearch;
use app\models\Hiringreport;
use app\models\Applicantreport;
use app\models\Joborderreport;
use app\models\Organizationactivity;
use app\models\Mastereducation;
use app\models\Masterstatuscandidate;
use app\models\Masterareaish;
use app\models\Masterregion;
use app\models\Mappingregionarea;
use app\models\Mappingsegmen;
use app\models\Mastercity;
use app\models\Masterjobfamily;
use app\models\Masterstatuscr;
use app\models\Mastersubjobfamily;
use app\models\Saparea;
use app\models\Sappersonalarea;
use app\models\Sapjob;
use app\models\Transrincian;
use app\models\Transjo;
use app\models\Userreference;
use app\models\Userhealth;
use app\models\Userprofile;
use app\models\Useremergencycontact;
use app\models\Userfamily;
use app\models\Userformaleducation;
use app\models\Usernonformaleducation;
use app\models\Userforeignlanguage;
use app\models\Userabout;
use app\models\Userworkexperience;
use app\models\Uploadocument;
use app\models\Recruitmentcandidatefhsearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use linslin\yii2\curl;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use kartik\mpdf\Pdf;
use ZipArchive;
use yii\helpers\Json;

/**
 * HiringController implements the CRUD actions for Hiring model.
 */
class ReportController extends Controller
{
  /**
   * @inheritdoc
   */
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'only' => ['reporthiring', 'reportapplicant', 'reportjoborder'],
        'rules' => [
          [
            'actions' => ['reporthiring'],
            'allow' => true,
            'roles' => ['@'],
            'matchCallback' => function () {
              return (Yii::$app->utils->permission(Yii::$app->user->identity->role, 'm48'));
            }

          ],
          [
            'actions' => ['reportapplicant'],
            'allow' => true,
            'roles' => ['@'],
            'matchCallback' => function () {
              return (Yii::$app->utils->permission(Yii::$app->user->identity->role, 'm50'));
            }

          ],
          [
            'actions' => ['reportjoborder'],
            'allow' => true,
            'roles' => ['@'],
            'matchCallback' => function () {
              return (Yii::$app->utils->permission(Yii::$app->user->identity->role, 'm66'));
            }

          ],
          [
            'actions' => ['reportcanceljoin'],
            'allow' => true,
            'roles' => ['@'],
            'matchCallback' => function () {
              return (Yii::$app->utils->permission(Yii::$app->user->identity->role, 'm66'));
            }

          ],
          [
            'actions' => ['reportchangejo'],
            'allow' => true,
            'roles' => ['@'],
            'matchCallback' => function () {
              return (Yii::$app->utils->permission(Yii::$app->user->identity->role, 'm66'));
            }

          ],
          // [
          //     'actions' => ['index','reporthiring','reportapplicant','reportjoborder'],
          //     'allow' => true,
          //     'roles' => ['@'],
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
   * Lists all Hiring models.
   * @return mixed
   */

  public function actionReporthiring()
  {
    $searchModel = new Hiringreport();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    $area = ArrayHelper::map(Saparea::find()->asArray()->all(), 'value1', 'value2');
    $parea = ArrayHelper::map(Sappersonalarea::find()->asArray()->all(), 'value1', 'value2');
    $jabatan = ArrayHelper::map(Sapjob::find()->asArray()->all(), 'value1', 'value2');
    $areaish = ArrayHelper::map(Masterareaish::find()->asArray()->all(), 'id', 'area');
    $region = ArrayHelper::map(Masterregion::find()->asArray()->all(), 'id', 'regionname');
    $jobfamily = ArrayHelper::map(Masterjobfamily::find()->asArray()->all(), 'id', 'jobfamily');
    $subjobfamily = ArrayHelper::map(Mastersubjobfamily::find()->asArray()->all(), 'id', 'subjobfamily');
    return $this->render('reporthiring', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
      'area' => $area,
      'parea' => $parea,
      'jabatan' => $jabatan,
      'areaish' => $areaish,
      'region' => $region,
      'jobfamily' => $jobfamily,
      'subjobfamily' => $subjobfamily,
    ]);
  }

  public function actionReportapplicant()
  {
    $searchModel = new Applicantreport();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    $education = ArrayHelper::map(Mastereducation::find()->asArray()->all(), 'idmastereducation', 'education');
    $statuscandidate = ArrayHelper::map(Masterstatuscandidate::find()->asArray()->all(), 'id', 'statusname');
    $mastercity = ArrayHelper::map(Mastercity::find()->asArray()->all(), 'kotaid', 'kota');
    return $this->render('reportapplicant', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
      'education' => $education,
      'statuscandidate' => $statuscandidate,
      'mastercity' => $mastercity,
    ]);
  }
  public function actionReportjoborder()
  {
    // $this->scenario
    $searchModel = new Joborderreport();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    $area = ArrayHelper::map(Saparea::find()->asArray()->all(), 'value1', 'value2');
    $parea = ArrayHelper::map(Sappersonalarea::find()->asArray()->all(), 'value1', 'value2');
    $areaish = ArrayHelper::map(Masterareaish::find()->asArray()->all(), 'id', 'area');
    $region = ArrayHelper::map(Masterregion::find()->asArray()->all(), 'id', 'regionname');
    $jobfamily = ArrayHelper::map(Masterjobfamily::find()->asArray()->all(), 'id', 'jobfamily');
    $subjobfamily = ArrayHelper::map(Mastersubjobfamily::find()->asArray()->all(), 'id', 'subjobfamily');
    return $this->render('reportjoborder', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
      'area' => $area,
      'parea' => $parea,
      'areaish' => $areaish,
      'region' => $region,
      'jobfamily' => $jobfamily,
      'subjobfamily' => $subjobfamily,

    ]);
  }
  public function actionReportcanceljoin()
  {
    $searchModel = new Canceljoinreport();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    $status = ArrayHelper::map(Masterstatuscr::find()->where('id in (4, 5, 7, 8, 9)')->asArray()->all(), 'id', 'statusname');
    $segmen = ArrayHelper::map(Mappingsegmen::find()->asArray()->all(), 'id', 'divisi');
    return $this->render('reportcanceljoin', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
      'status' => $status,
      'segmen' => $segmen,
    ]);
  }
  public function actionReportchangehiring()
  {
    // $this->scenario
    $searchModel = new Changejoreport();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    $area = ArrayHelper::map(Saparea::find()->asArray()->all(), 'value1', 'value2');
    $parea = ArrayHelper::map(Sappersonalarea::find()->asArray()->all(), 'value1', 'value2');
    $areaish = ArrayHelper::map(Masterareaish::find()->asArray()->all(), 'id', 'area');
    $region = ArrayHelper::map(Masterregion::find()->asArray()->all(), 'id', 'regionname');
    $jobfamily = ArrayHelper::map(Masterjobfamily::find()->asArray()->all(), 'id', 'jobfamily');
    $subjobfamily = ArrayHelper::map(Mastersubjobfamily::find()->asArray()->all(), 'id', 'subjobfamily');
    return $this->render('reportchangejo', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
      'area' => $area,
      'parea' => $parea,
      'areaish' => $areaish,
      'region' => $region,
      'jobfamily' => $jobfamily,
      'subjobfamily' => $subjobfamily,

    ]);
  }
  protected function generateCV($userid)
  {
    $this->layout = 'print-custom';
    $userprofile = Userprofile::find()->where(['userid' => $userid])->one();
    $userfamily = Userfamily::find()->where(['userid' => $userid])->all();
    $userfedu = Userformaleducation::find()->where(['userid' => $userid])->all();
    $usernfedu = Usernonformaleducation::find()->where(['userid' => $userid])->all();
    $usernflang = Userforeignlanguage::find()->where(['userid' => $userid])->all();
    $usereskill = Englishskill::find()->where(['userid' => $userid])->one();
    $usercskill = Computerskill::find()->where(['userid' => $userid])->one();
    $usercskill = Computerskill::find()->where(['userid' => $userid])->one();
    $userwexp = Userworkexperience::find()->where(['userid' => $userid])->all();
    $userorgac = Organizationactivity::find()->where(['userid' => $userid])->all();
    $userecontact = Useremergencycontact::find()->where(['userid' => $userid])->all();
    $userreff = Userreference::find()->where(['userid' => $userid])->all();
    $userhealth = Userhealth::find()->where(['userid' => $userid])->one();
    $userabout = Userabout::find()->where(['userid' => $userid])->one();

    $content = $this->render('printcv', [
      'userprofile' => $userprofile,
      'userfamily' => $userfamily,
      'userfedu' => $userfedu,
      'usernfedu' => $usernfedu,
      'usernflang' => $usernflang,
      'usereskill' => $usereskill,
      'usercskill' => $usercskill,
      'userwexp' => $userwexp,
      'userorgac' => $userorgac,
      'userecontact' => $userecontact,
      'userreff' => $userreff,
      'userhealth' => $userhealth,
      'userabout' => $userabout,
    ]);
    $pdf = new Pdf([
      // set to use core fonts only
      'mode' => Pdf::FORMAT_A4,
      // 'destination' => Pdf::DEST_BROWSER,
      'destination' => Pdf::DEST_FILE,
      'filename' => 'cvtemp/cv.pdf',
      'content' => $content,
      'cssFile' => 'css/pdf.css',

    ]);
    return $pdf->render();
  }
  public function actionDownload($userid)
  {
    $this->generateCV($userid);
    $userprofile = Userprofile::find()->where(['userid' => $userid])->one();
    $doc = Uploadocument::find()->where(['userid' => $userid])->one();
    //set zip file name for download
    $zipFilename = 'ISH-' . $userprofile->fullname . '.zip';

    //zip file name with path
    $zipPath = 'cvtemp/' . $zipFilename;

    //start adding the files into the zip archive
    $zip = new \ZipArchive();

    //open zip archive
    $zip->open($zipPath, \ZipArchive::CREATE | ZipArchive::OVERWRITE);

    // for ($x = 1; $x <= $vlt; $x++) {
    if ($doc) {

      if ($doc->ktp) {
        if (file_exists('app/assets/upload/ktp/' . $doc->ktp)) {
          $ext = explode(".", $doc->ktp);
          $zip->addFile(realpath('app/assets/upload/ktp/' . $doc->ktp), "05. Copy KTP-" . $userprofile->fullname . "." . $ext[1]);
        }
      }
      if ($doc->suratlamarankerja) {
        if (file_exists('app/assets/upload/suratlamarankerja/' . $doc->suratlamarankerja)) {
          $ext = explode(".", $doc->suratlamarankerja);
          $zip->addFile(realpath('app/assets/upload/suratlamarankerja/' . $doc->suratlamarankerja), "01. Surat Lamaran-" . $userprofile->fullname . "." . $ext[1]);
        }
      }
      if ($doc->ijazah) {
        if (file_exists('app/assets/upload/ijazah/' . $doc->ijazah)) {
          $ext = explode(".", $doc->ijazah);
          $zip->addFile(realpath('app/assets/upload/ijazah/' . $doc->ijazah), "03. Copy Ijazah-" . $userprofile->fullname . "." . $ext[1]);
        }
      }
      if ($doc->transkipnilai) {
        if (file_exists('app/assets/upload/transkipnilai/' . $doc->transkipnilai)) {
          $ext = explode(".", $doc->transkipnilai);
          $zip->addFile(realpath('app/assets/upload/transkipnilai/' . $doc->transkipnilai), "04. Copy Transkrip nilai-" . $userprofile->fullname . "." . $ext[1]);
        }
      }
      if ($doc->npwp) {
        if (file_exists('app/assets/upload/npwp/' . $doc->npwp)) {
          $ext = explode(".", $doc->npwp);
          $zip->addFile(realpath('app/assets/upload/npwp/' . $doc->npwp), "06. Copy NPWP-" . $userprofile->fullname . "." . $ext[1]);
        }
      }
      if ($doc->jamsostek) {
        if (file_exists('app/assets/upload/jamsostek/' . $doc->jamsostek)) {
          $ext = explode(".", $doc->jamsostek);
          $zip->addFile(realpath('app/assets/upload/jamsostek/' . $doc->jamsostek), "07. Copy Jamsostek-" . $userprofile->fullname . "." . $ext[1]);
        }
      }
      if ($doc->bpjskesehatan) {
        if (file_exists('app/assets/upload/bpjskesehatan/' . $doc->bpjskesehatan)) {
          $ext = explode(".", $doc->bpjskesehatan);
          $zip->addFile(realpath('app/assets/upload/bpjskesehatan/' . $doc->bpjskesehatan), "08. Copy BPJS Kesehatan-" . $userprofile->fullname . "." . $ext[1]);
        }
      }
      if ($doc->suratketerangansehat) {
        if (file_exists('app/assets/upload/suratketerangansehat/' . $doc->suratketerangansehat)) {
          $ext = explode(".", $doc->suratketerangansehat);
          $zip->addFile(realpath('app/assets/upload/suratketerangansehat/' . $doc->suratketerangansehat), "09. Copy Surat Keterangan Sehat-" . $userprofile->fullname . "." . $ext[1]);
        }
      }
    }

    // }
    $zip->addFile(realpath('cvtemp/cv.pdf'), '02. Riwayat Hidup-' . $userprofile->fullname . '.pdf');

    $zip->close();

    //return zip archive name without path
    Yii::$app->response->sendFile($zipPath);

    // return $this->redirect(['recruitmentcandidate/index']);
    // return $this->goBack();

  }



  /**
   * Finds the Hiring model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Hiring the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */


  //add by kaha dependent input with depdrop
  public function actionGethiring()
  {
    $out = [];
    if (isset($_POST['depdrop_parents'])) {
      $parents = $_POST['depdrop_parents'];
      $subjobfamily = empty($parents[0]) ? null : $parents[0];

      $model = Mastersubjobfamily::find()->asArray()->where(['jobfamily_id' => $subjobfamily])->all();
      // var_dump($model);die;
      $selected  = null;
      if ($parents != null && count($model) > 0) {
        $selected = '';
        $id1 = '';
        if (!empty($_POST['depdrop_params'])) {
          $params = $_POST['depdrop_params'];
          $id1 = $params[0]; // get the value of model_id1
          foreach ($model as $key => $value) {
            $out[] = ['id' => $value['id'], 'name' => '' . $value['subjobfamily']];
            $oc[] = $value['id'];
            if ($key == 0) {
              $out[] = ['id' => '0', 'name' => 'all'];
              $aux = '0';
            }
          }
          ((in_array($id1, $oc))) ? $selected = $id1 : $selected = $aux;
        }
        // $outs = array_push($out, ['id'=>"0",'name'=>'all']);
        // var_dump($outs);die;
        sort($out);
        echo Json::encode(['output' => $out, 'selected' => $selected]);
        return;
      }
    }
    echo Json::encode(['output' => '', 'selected' => '']);
  }

  public function actionGetregion()
  {
    $out = [];
    if (isset($_POST['depdrop_parents'])) {
      $parents = $_POST['depdrop_parents'];
      $areaish = empty($parents[0]) ? null : $parents[0];

      $model = Saparea::find()->asArray()->where(['areaid' => $areaish])->groupby(['regionalid'])->all();
      // var_dump($model);die;
      $selected  = null;
      if ($parents != null && count($model) > 0) {
        $selected = '';
        $id1 = '';
        if (!empty($_POST['depdrop_params'])) {
          $params = $_POST['depdrop_params'];
          $id1 = $params[0]; // get the value of model_id1
          foreach ($model as $key => $value) {
            $out[] = ['id' => $value['regionalid'], 'name' => 'Region ' . $value['regionalid']];
            $oc[] = $value['regionalid'];
            if ($key == 0) {
              $out[] = ['id' => '0', 'name' => 'all'];
              $aux = '0';
            }
          }
          ((in_array($id1, $oc))) ? $selected = $id1 : $selected = $aux;
        }
        // $outs = array_push($out, ['id'=>"0",'name'=>'all']);
        // var_dump($outs);die;
        sort($out);
        echo Json::encode(['output' => $out, 'selected' => $selected]);
        return;
      }
    }
    echo Json::encode(['output' => '', 'selected' => '']);
  }
  protected function findModel($id)
  {
    if (($model = Hiring::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }
}
