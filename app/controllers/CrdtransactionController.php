<?php

namespace app\controllers;

use Yii;
use app\models\Crdtransaction;
use app\models\Crdtransactionsearch;
use app\models\Chagerequestdata;
use app\models\Userprofile;
use app\models\Userabout;
use app\models\Uploadocument;
use app\models\Masterbank;
use app\models\Masterbankreason;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use linslin\yii2\curl;

/**
 * CrdtransactionController implements the CRUD actions for Crdtransaction model.
 */
class CrdtransactionController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Crdtransaction models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Crdtransactionsearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Crdtransaction model.
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
     * Creates a new Crdtransaction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($crdid, $param)
    {
    $check = Crdtransaction::find()->where(['crdid'=>$crdid, 'dataid'=>$param,'status'=>1])->one();

    $modelcrd = Chagerequestdata::find()->where(['id'=>$crdid])->one();
    $modeldata = Userprofile::find()->where(['userid'=>$modelcrd->userid])->one();
    $modelaboutdata = Userabout::find()->where(['userid'=>$modelcrd->userid])->one();
    $document = Uploadocument::find()->where(['userid'=>$modelcrd->userid])->one();
    $bank = ArrayHelper::map(Masterbank::find()->asArray()->all(), 'id', 'bank');
    $bankreason = ArrayHelper::map(Masterbankreason::find()->asArray()->all(), 'id', 'reason');
    $perner = $modelcrd->perner;
    switch ($param) {
        case 1:
            $oldvalue = $modeldata->npwpnumber;
            $olddoc = $document->npwp;
            $path = 'npwp';
            $scenarioname = 'npwp';
            break;
        case 2:
            $oldvalue = $modeldata->bpjsnumber;
            $olddoc = $document->bpjskesehatan;
            $path = 'bpjskesehatan';
            $scenarioname = 'bpjs';
            break;
        case 3:
            $oldvalue = $modeldata->jamsosteknumber;
            $olddoc = $document->jamsostek;
            $path = 'jamsostek';
            $scenarioname = 'jamsostek';
            break;
        case 4:
        if($modeldata){
            $oldvalue = $modelaboutdata->bankid;
            $oldvalue2 = $modelaboutdata->bankaccountnumber;
            $olddoc = ($document)?$document->bankaccount:'';

        }else{
            $curl = new curl\Curl();
            $getdatapekerjabyperner =  $curl->setPostParams([
            'perner' => $perner,
            'token' => 'ish**2019',
            ])
            ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerjaall');
            $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
            $masterbank = Masterbank::find()->where(['sapid'=>$datapekerjabyperner[0]->BANKL])->one();
            $oldvalue = ($masterbank)?$masterbank->id:null;
            $oldvalue2 = $datapekerjabyperner[0]->BANKN;
            $olddoc = ($document)?$document->bankaccount:null;
        }
        $path = 'bankaccount';
        $scenarioname = 'bankaccount';
            break;
        default:
            $oldvalue = null;
            $olddoc = null;
            $path = '';
            $scenarioname = '';
    }

    if($check){

        $model = $check;
        $olddoc = $model->newdoc;
        if($olddoc){
        $model->scenario = $scenarioname.'_1';
        }else{
        $model->scenario = $scenarioname.'_2';
        }
        if ($model->load(Yii::$app->request->post())) {
        $model->newdoc = UploadedFile::getInstance($model,'newdoc');
        if($model->newdoc && $model->validate()){
            $assetUrl = Yii::getAlias('@app'). '/assets';
            $fileextp = $model->newdoc->extension;
            $oldfilename = (($modeldata)?$modeldata->userid:$perner).'-'.$path;
            if($olddoc){
            $getoldfilename = explode(".",$olddoc);
            $oldfilename = $getoldfilename[0];
            }
            $filep = $oldfilename.'-cr'.$crdid.'.'.$fileextp;
            if ($model->newdoc->saveAs($assetUrl.'/upload/'.$path.'/'.$filep)){
            $model->newdoc = $filep;
            }
        }else{
            $model->newdoc = $olddoc;
        }

        $model->save();
        if($param == 4){
            return $this->redirect(['/chagerequestdatabank/create', 'id' => $crdid]);
        }else{
            return $this->redirect(['/chagerequestdata/create', 'id' => $crdid]);
        }
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
                'param' => $param,
                'bank' => $bank,
                'bankreason' => $bankreason,
            ]);
        }
    }else{
        $model = new Crdtransaction();
        // $model->scenario = 'npwp_2';
        switch ($param) {
            case 1:
                $model->scenario = 'npwp_2';
                break;
            case 2:
                $model->scenario = 'bpjs_2';
                break;
            case 3:
                $model->scenario = 'jamsostek_2';
                break;
            case 4:
                $model->scenario = 'bankaccount_2';
                break;
            default:

        }
        if ($model->load(Yii::$app->request->post())) {
            $model->crdid = $crdid;
            $model->oldvalue = $oldvalue;
            if($param == 4){
            $model->oldvalue2 = $oldvalue2;
            }
            $model->oldvalue = $oldvalue;
            $model->olddoc = $olddoc;
            $model->dataid = $param;
            $model->newdoc = UploadedFile::getInstance($model,'newdoc');
            if($model->newdoc){
            $assetUrl = Yii::getAlias('@app'). '/assets';
            $fileextp = $model->newdoc->extension;
            $oldfilename = (($modeldata)?$modeldata->userid:$perner).'-'.$path;

            // if($olddoc){
            //   $getoldfilename = explode(".",$olddoc);
            //   $oldfilename = $getoldfilename[0];
            // }
            // var_dump($oldfilename);die;
            $filep = $oldfilename.'-cr'.$crdid.'.'.$fileextp;
            if ($model->newdoc->saveAs($assetUrl.'/upload/'.$path.'/'.$filep)){
                $model->newdoc = $filep;
            }
            }
            $model->save(false);
            if($param == 4){
                return $this->redirect(['/chagerequestdatabank/create', 'id' => $crdid]);
            }else{
                return $this->redirect(['/chagerequestdata/create', 'id' => $crdid]);
            }
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
                'param' => $param,
                'bank' => $bank,
                'bankreason' => $bankreason,
            ]);
        }
    }

    }

    /**
     * Updates an existing Crdtransaction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $param)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
                'param' => $param,
            ]);
        }
    }

    /**
     * Deletes an existing Crdtransaction model.
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
     * Finds the Crdtransaction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Crdtransaction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Crdtransaction::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
