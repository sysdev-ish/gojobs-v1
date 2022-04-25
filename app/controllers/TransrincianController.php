<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Transrincian;
use app\models\Transkomponen;
use app\models\Recruitmentcandidate;
use app\models\Transrinciansearch;
use app\models\Chagerequestjo;
use app\models\Interview;
use app\models\Psikotest;
use app\models\Userinterview;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use linslin\yii2\curl;


/**
 * TransrincianController implements the CRUD actions for Transrincian model.
 */
class TransrincianController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
          'access' => [
              'class' => AccessControl::className(),
              'only' => ['index','update','create','view','delete'],
              'rules' => [
                [
                    'actions' => ['index','update','create','view','delete'],
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback'=>function(){
                         return (Yii::$app->utils->permission(Yii::$app->user->identity->role,'m1'));
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
     * Lists all Transrincian models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Transrinciansearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // $model =  $this->findModel($sid);
        // $data = Transrincian::find()->one();
        // var_dump($data->subfamily->mappingjob->hire_jabatan_sap);die();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Transrincian model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
      $model =  $this->findModel($id);
      $transkomponen = Transkomponen::find()->where(['nojo'=>$model->nojo,'area'=>$model->lokasi,'jabatan'=>$model->jabatan,'level'=>$model->level, 'skill'=>$model->skilllayanan,'detail_komp'=>$model->detail_komp])->all();
      $candidate = Recruitmentcandidate::find()->where(['recruitreqid'=>$model->id])->all();
      $candidatecount = Recruitmentcandidate::find()->where(['recruitreqid'=>$model->id])->count();
      $onintcount = Recruitmentcandidate::find()->where(['recruitreqid'=>$model->id,'status'=>1])->count();
      $onpsicount = Recruitmentcandidate::find()->where(['recruitreqid'=>$model->id,'status'=>2])->count();
      $onuintcount = Recruitmentcandidate::find()->where(['recruitreqid'=>$model->id,'status'=>3])->count();
      $candidates = array();
      foreach($candidate as $val){
        $candidates[] = $val->id;
      }
      $intcount = Interview::find()->where('recruitmentcandidateid IN ("' . implode('","', $candidates) . '")', [])->count();
      $psicount = Psikotest::find()->where('recruitmentcandidateid IN ("' . implode('","', $candidates) . '")', [])->count();
      $uintcount = Userinterview::find()->where('recruitmentcandidateid IN ("' . implode('","', $candidates) . '")', [])->count();
      $crjo = Chagerequestjo::find()->where(['recruitreqid'=>$model->id])->all();
        return $this->render('view', [
            'model' => $model,
            'transkomponen' => $transkomponen,
            'candidate' => $candidate,
            'candidatecount' => $candidatecount,
            'onintcount' => $onintcount,
            'onpsicount' => $onpsicount,
            'onuintcount' => $onuintcount,
            'intcount' => $intcount,
            'psicount' => $psicount,
            'uintcount' => $uintcount,
            'crjo' => $crjo,
        ]);
    }
    public function actionViewshort($id)
    {
      $model =  $this->findModel($id);
      $transkomponen = Transkomponen::find()->where(['nojo'=>$model->nojo,'area'=>$model->lokasi,'jabatan'=>$model->jabatan,'level'=>$model->level, 'skill'=>$model->skilllayanan])->all();
      $candidate = Recruitmentcandidate::find()->where(['recruitreqid'=>$model->id])->all();
      $candidatecount = Recruitmentcandidate::find()->where(['recruitreqid'=>$model->id])->count();
      $onintcount = Recruitmentcandidate::find()->where(['recruitreqid'=>$model->id,'status'=>1])->count();
      $onpsicount = Recruitmentcandidate::find()->where(['recruitreqid'=>$model->id,'status'=>2])->count();
      $onuintcount = Recruitmentcandidate::find()->where(['recruitreqid'=>$model->id,'status'=>3])->count();
      $candidates = array();
      foreach($candidate as $val){
        $candidates[] = $val->id;
      }
      $intcount = Interview::find()->where('recruitmentcandidateid IN ("' . implode('","', $candidates) . '")', [])->count();
      $psicount = Psikotest::find()->where('recruitmentcandidateid IN ("' . implode('","', $candidates) . '")', [])->count();
      $uintcount = Userinterview::find()->where('recruitmentcandidateid IN ("' . implode('","', $candidates) . '")', [])->count();
      $crjo = Chagerequestjo::find()->where(['recruitreqid'=>$model->id])->all();
        return $this->renderAjax('view', [
          'model' => $model,
          'transkomponen' => $transkomponen,
          'candidate' => $candidate,
          'candidatecount' => $candidatecount,
          'onintcount' => $onintcount,
          'onpsicount' => $onpsicount,
          'onuintcount' => $onuintcount,
          'intcount' => $intcount,
          'psicount' => $psicount,
          'uintcount' => $uintcount,
          'crjo' => $crjo,
        ]);
    }

    /**
     * Creates a new Transrincian model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Transrincian();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Transrincian model.
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

    /**
     * Deletes an existing Transrincian model.
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
     * Finds the Transrincian model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Transrincian the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transrincian::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionRecreqlist($q = null, $id = null) {
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $outs = ['results' => ['id' => '', 'text' => '']];
    if (!is_null($q)) {
      $wherecontent = $q;
      // var_dump($wherecontent);die;
    $query =  Transrincian::find()
        ->select(['trans_rincian_rekrut.id','trans_rincian_rekrut.nojo','trans_rincian_rekrut.jabatan','trans_rincian_rekrut.lokasi', 'projectrekrut'=>'trans_rincian_rekrut.n_project','job_function.name_job_function','trans_jo.type_replace','trans_jo.type_jo','trans_jo.n_project','trans_jo.project','mapping_city.city_name','sapjabatan'=>'sapjob.value2', 'trans_rincian_rekrut.hire_jabatan_sap','trans_rincian_rekrut.persa_sap','trans_rincian_rekrut.area_sap','trans_rincian_rekrut.skill_sap','level_sap'=>'trans_rincian_rekrut.level_sap','saparea'=>'saparea.value2','sappersa'=>'sappersonalarea.value2','sapskill'=>'sapskilllayanan.value2'])

        ->joinWith("jobfunc")
        ->joinWith("transjo")
        ->joinWith("city")
        ->joinWith("jabatansap")
        ->joinWith("areasap")
        ->joinWith("persasap")
        ->joinWith("skillsap")

        // ->where('trans_jo.type_jo = 1')
        // ->andWhere('trans_jo.new_rekrut = 2')
        ->andWhere('trans_rincian_rekrut.skema = 1')
        // ->andWhere('trans_rincian_rekrut.hire_jabatan_sap <> null')
        // ->andWhere('trans_rincian_rekrut.area_sap <> null')
        // ->andWhere('trans_rincian_rekrut.persa_sap <> null')
        ->andWhere(['or',
           ['LIKE', 'trans_rincian_rekrut.nojo', $wherecontent ],
           ['LIKE', 'trans_rincian_rekrut.id', $wherecontent ],
           // ['LIKE', 'trans_rincian_rekrut.jabatan', $wherecontent ],
           // ['LIKE', 'trans_rincian_rekrut.n_project', $wherecontent ],
           // ['LIKE', 'job_function.name_job_function', $wherecontent],
           // ['LIKE', 'mapping_city.city_name', $wherecontent],
           // ['LIKE', 'trans_jo.n_project', $wherecontent],
           // ['LIKE', 'trans_rincian_rekrut.n_project', $wherecontent],
           ['LIKE', 'sapjob.value2', $wherecontent],
           ['LIKE', 'saparea.value2', $wherecontent],
           ['LIKE', 'sappersonalarea.value2', $wherecontent]
       ])
       ->orderBy([
         'trans_rincian_rekrut.id' => SORT_DESC
       ])
        ->limit(200)
        ->asArray()->all();
        $out = null;
        foreach ($query as $key => $value) {
          // if($value['level_sap']){
          //   $curl = new curl\Curl();
          //   $getlevels = $curl->setPostParams([
          //     'level' => $value['level_sap'],
          //     'token' => 'ish**2019',
          //   ])
          //   ->post('http://192.168.88.5/service/index.php/sap_profile/getlevel');
          //   $level  = json_decode($getlevels);
          //   if($level){
          //     $level = ['level'=>$level];
          //   }else{
          //     $level =  ['level'=>'n/a'];
          //   }
          // }else{
          //   $level =  ['level'=>'n/a'];
          // }
          //
          // $values = array_merge_recursive($value, $level);
          $out[] = $value;

          // $out['results'] = $value['jobfunc']['name_job_function'];
        }
        if($out){
          $outs['results'] = $out;
        }else{
          $outs['results'] = null;
        }


    }
    elseif ($id > 0) {
        $outs['results'] = ['id' => $id, 'text' => Transrincian::findOne($id)->nojo];
    }else{
      $outs['results'] = ['id' => ' ', 'text' => ' '];
    }
    // var_dump($outs);die;
    return $outs;
}
}
