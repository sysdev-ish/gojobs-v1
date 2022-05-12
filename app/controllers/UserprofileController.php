<?php

namespace app\controllers;

use Yii;
use app\models\Userprofile;
use app\models\Masterprovince;
use app\models\Mastercity;
use app\models\Userfamily;
use app\models\Userformaleducation;
use app\models\Usernonformaleducation;
use app\models\Userforeignlanguage;
use app\models\Userworkexperience;
use app\models\Organizationactivity;
use app\models\Useremergencycontact;
use app\models\Userreference;
use app\models\Userhealth;
use app\models\Englishskill;
use app\models\Computerskill;
use app\models\Userabout;
use app\models\Recruitmentcandidate;
use app\models\Userprofilesearch;
use app\models\Uservaksin;
use app\models\Masteralasanvaksin;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * UserprofileController implements the CRUD actions for Userprofile model.
 */
class UserprofileController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
      return [
          'access' => [
              'class' => AccessControl::className(),
              'only' => ['index','update','create','view','delete','views','cwizard','uwizard', 'viewshort','printcv'],
              'rules' => [

                  [
                      'actions' => ['index','create','view','delete'],
                      'allow' => true,
                      'roles' => ['@'],
                      'matchCallback'=>function(){
                           return (Yii::$app->utils->permission(Yii::$app->user->identity->role,'m13'));
                       }

                  ],
                  [
                      'actions' => ['views','view'],
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
                            $ret = (Yii::$app->utils->permission(Yii::$app->user->identity->role,'m13'));
                          }
                           return $ret;
                       }

                  ],
                  [
                      'actions' => ['update'],
                      'allow' => true,
                      'roles' => ['@'],
                      'matchCallback'=>function(){

                          if(Yii::$app->user->identity->role == 2){
                            $model = Userprofile::find()->where(['userid'=>Yii::$app->user->identity->id])->one();
                            // var_dump($model->id);die;
                              if((int)Yii::$app->request->get('id') == $model->id){
                                $ret = true;
                              }else{
                                $ret = false;
                              }
                          }else{
                            $ret = (Yii::$app->utils->permission(Yii::$app->user->identity->role,'m13'));
                          }
                           return $ret;
                       }

                  ],
                  [
                          'actions' => ['cwizard','uwizard', 'viewshort','printcv'],
                          'allow' => true,
                          'roles' => ['@'],
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
     * Lists all Userprofile models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Userprofilesearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // var_dump((Yii::$app->utils->permission(Yii::$app->user->identity->role,'m13')));die;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Userprofile model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout = Yii::$app->utils->getlayout();
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionViews($userid)
    {
      $this->layout = Yii::$app->utils->getlayout();
      $model = Userprofile::find()->where(['userid'=>$userid])->one();
      if($model){
        return $this->render('view', [
            'model' => $model,
            'userid' => $userid,
        ]);
      }else{
        return $this->redirect(['create','userid'=>$userid]);
      }
    }

    public function actionViewshort($userid)
    {
      $this->layout = Yii::$app->utils->getlayout();
      $model = Userprofile::find()->where(['userid'=>$userid])->one();
        return $this->renderAjax('view', [
            'model' => $model,
            'userid' => $userid,
        ]);
    }
    public function actionViewshortwd($userid,$recid)
    {
      $this->layout = Yii::$app->utils->getlayout();
      $model = Userprofile::find()->where(['userid'=>$userid])->one();
      $recruitmentcand = Recruitmentcandidate::find()->where(['userid'=>$userid,'recruitreqid'=>$recid,'status'=>4])->one();
      if($recruitmentcand){
        $recid = $recruitmentcand->id;
      }else{
        $recid = null;
      }
        return $this->renderAjax('view', [
            'model' => $model,
            'userid' => $userid,
            'recid' => $recid,
        ]);
    }

    /**
     * Creates a new Userprofile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($userid)
    {
        $this->layout = Yii::$app->utils->getlayout();
          $model = new Userprofile();
          $modelvaksin = new Uservaksin();
          $modelvaksin->scenario = 'create';
          $alasanvaksin = ArrayHelper::map(Masteralasanvaksin::find()->asArray()->all(), 'id', 'alasan');

          $province = ArrayHelper::map(MasterProvince::find()->asArray()->all(), 'provinsiid', 'provinsi');
          $kota = ArrayHelper::map(Mastercity::find()->asArray()->where(['kotaid'=>$model->cityid])->all(), 'kotaid', 'kota');
          $provincektp = ArrayHelper::map(MasterProvince::find()->asArray()->all(), 'provinsiid', 'provinsi');
          $kotaktp = ArrayHelper::map(Mastercity::find()->asArray()->where(['kotaid'=>$model->cityidktp])->all(), 'kotaid', 'kota');


          if ($model->load(Yii::$app->request->post()) && $modelvaksin->load(Yii::$app->request->post())) {
            if($model->havejamsostek == 0 OR $model->jamsosteknumber == ''){
              $model->jamsosteknumber = "00000000000";
            }
            if($model->havebpjs == 0 OR $model->bpjsnumber == ''){
              $model->bpjsnumber = "00000000000";
            }
            if($model->havenpwp == 0 OR $model->npwpnumber == ''){
              $model->npwpnumber = "000000000000000";
            }
            $model->photo = UploadedFile::getInstance($model,'photo');
            $model->cvupload = UploadedFile::getInstance($model,'cvupload');
            $modelvaksin->sertvaksin1 = UploadedFile::getInstance($modelvaksin,'sertvaksin1');
            $modelvaksin->sertvaksin2 = UploadedFile::getInstance($modelvaksin,'sertvaksin2');

            $model->userid = $userid;
            $model->createtime = date('Y-m-d H-i-s');
            $model->updatetime = date('Y-m-d H-i-s');
            $modelvaksin->userid = $userid;
            $modelvaksin->createtime = date('Y-m-d H-i-s');
            $modelvaksin->updatetime = date('Y-m-d H-i-s');
            $modelvaksin->createdby = Yii::$app->user->identity->id;
            $modelvaksin->updateby = Yii::$app->user->identity->id;
             if($model->photo){
               $assetUrl = Yii::getAlias('@app'). '/assets';
               $fileextp = $model->photo->extension;
               $filep = $userid.'-PHOTO.'.$fileextp;
               if ($model->photo->saveAs($assetUrl.'/upload/photo/'.$filep)){
                 $model->photo = $filep;
               }
             }
             if($model->cvupload){
               $assetUrl = Yii::getAlias('@app'). '/assets';
               $fileextp = $model->cvupload->extension;
               $filep = $userid.'-CVUPLOAD.'.$fileextp;
               if ($model->cvupload->saveAs($assetUrl.'/upload/cvupload/'.$filep)){
                 $model->cvupload = $filep;
               }
             }
             if($modelvaksin->sertvaksin1){
               $assetUrl = Yii::getAlias('@app'). '/assets';
               $fileextp = $modelvaksin->sertvaksin1->extension;
               $filep = $userid.'-SERTVAKSIN1.'.$fileextp;
               if ($modelvaksin->sertvaksin1->saveAs($assetUrl.'/upload/sertifikatvaksin/'.$filep)){
                 $modelvaksin->sertvaksin1 = $filep;
               }
             }
             if($modelvaksin->sertvaksin2){
               $assetUrl = Yii::getAlias('@app'). '/assets';
               $fileextp = $modelvaksin->sertvaksin2->extension;
               $filep = $userid.'-SERTVAKSIN2.'.$fileextp;
               if ($modelvaksin->sertvaksin2->saveAs($assetUrl.'/upload/sertifikatvaksin/'.$filep)){
                 $modelvaksin->sertvaksin2 = $filep;
               }
             }
             if($model->save() && $modelvaksin->save()){
               return $this->redirect(['views', 'userid' => $userid]);
              }else{
                return $this->render('create', [
                    'model' => $model,
                    'modelvaksin' => $modelvaksin,
                    'province' => $province,
                    'kota' => $kota,
                    'provincektp' => $provincektp,
                    'kotaktp' => $kotaktp,
                    'userid'=>$userid,
                    'alasanvaksin'=>$alasanvaksin,
                ]);
              }
          }
              return $this->render('create', [
                  'model' => $model,
                  'modelvaksin' => $modelvaksin,
                  'alasanvaksin'=>$alasanvaksin,
                  'province' => $province,
                  'kota' => $kota,
                  'provincektp' => $provincektp,
                  'kotaktp' => $kotaktp,
                  'userid'=>$userid,
              ]);


    }
    public function actionCwizard()
    {
      $id = Yii::$app->user->identity->id;
      if(Yii::$app->check->cuserprofile($id) == 0){
        $this->layout = Yii::$app->utils->getlayout();
          $model = new Userprofile();
          $modelvaksin = new Uservaksin();
          $modelvaksin->scenario = 'create';

          $alasanvaksin = ArrayHelper::map(Masteralasanvaksin::find()->asArray()->all(), 'id', 'alasan');
          $province = ArrayHelper::map(MasterProvince::find()->asArray()->all(), 'provinsiid', 'provinsi');
          $kota = ArrayHelper::map(Mastercity::find()->asArray()->where(['kotaid'=>$model->cityid])->all(), 'kotaid', 'kota');
          $provincektp = ArrayHelper::map(MasterProvince::find()->asArray()->all(), 'provinsiid', 'provinsi');
          $kotaktp = ArrayHelper::map(Mastercity::find()->asArray()->where(['kotaid'=>$model->cityidktp])->all(), 'kotaid', 'kota');

          if ($model->load(Yii::$app->request->post()) && $modelvaksin->load(Yii::$app->request->post())) {

            if($model->havejamsostek == 0 OR $model->jamsosteknumber == ''){
              $model->jamsosteknumber = "00000000000";
            }
            if($model->havebpjs == 0 OR $model->bpjsnumber == ''){
              $model->bpjsnumber = "00000000000";
            }
            if($model->havenpwp == 0 OR $model->npwpnumber == ''){
              $model->npwpnumber = "000000000000000";
            }
            $model->photo = UploadedFile::getInstance($model,'photo');
            $model->cvupload = UploadedFile::getInstance($model,'cvupload');
            $modelvaksin->sertvaksin1 = UploadedFile::getInstance($modelvaksin,'sertvaksin1');
            $modelvaksin->sertvaksin2 = UploadedFile::getInstance($modelvaksin,'sertvaksin2');

            $model->userid = $id;
            $model->createtime = date('Y-m-d H-i-s');
            $model->updatetime = date('Y-m-d H-i-s');
            $modelvaksin->userid = $id;
            $modelvaksin->createtime = date('Y-m-d H-i-s');
            $modelvaksin->updatetime = date('Y-m-d H-i-s');
            $modelvaksin->createdby = Yii::$app->user->identity->id;
            $modelvaksin->updateby = Yii::$app->user->identity->id;
             if($model->photo){
               $assetUrl = Yii::getAlias('@app'). '/assets';
               $fileextp = $model->photo->extension;
               $filep = $id.'-PHOTO.'.$fileextp;
               if ($model->photo->saveAs($assetUrl.'/upload/photo/'.$filep)){
                 $model->photo = $filep;
               }
             }
             if($model->cvupload){
               $assetUrl = Yii::getAlias('@app'). '/assets';
               $fileextp = $model->cvupload->extension;
               $filep = $id.'-CVUPLOAD.'.$fileextp;
               if ($model->cvupload->saveAs($assetUrl.'/upload/cvupload/'.$filep)){
                 $model->cvupload = $filep;
               }
             }
             if($modelvaksin->sertvaksin1){
               $assetUrl = Yii::getAlias('@app'). '/assets';
               $fileextp = $modelvaksin->sertvaksin1->extension;
               $filep = $id.'-SERTVAKSIN1.'.$fileextp;
               if ($modelvaksin->sertvaksin1->saveAs($assetUrl.'/upload/sertifikatvaksin/'.$filep)){
                 $modelvaksin->sertvaksin1 = $filep;
               }
             }
             if($modelvaksin->sertvaksin2){
               $assetUrl = Yii::getAlias('@app'). '/assets';
               $fileextp = $modelvaksin->sertvaksin2->extension;
               $filep = $id.'-SERTVAKSIN2.'.$fileextp;
               if ($modelvaksin->sertvaksin2->saveAs($assetUrl.'/upload/sertifikatvaksin/'.$filep)){
                 $modelvaksin->sertvaksin2 = $filep;
               }
             }
             // var_dump($model->cvupload);die;
             if($model->save() && $modelvaksin->save()){
               // return $this->goHome();
               // return $this->redirect(['userfamily/cwizard']);
               return $this->redirect(['views', 'userid' => $model->userid]);
             }else{
               return $this->render('create', [
                   'model' => $model,
                   'province' => $province,
                   'kota' => $kota,
                   'provincektp' => $provincektp,
                   'kotaktp' => $kotaktp,
                   'userid'=>$id,
                   'modelvaksin' => $modelvaksin,
                   'alasanvaksin'=>$alasanvaksin,
               ]);
             }

          }
              return $this->render('create', [
                  'model' => $model,
                  'province' => $province,
                  'kota' => $kota,
                  'provincektp' => $provincektp,
                  'kotaktp' => $kotaktp,
                  'userid'=>$id,
                  'modelvaksin' => $modelvaksin,
                  'alasanvaksin'=>$alasanvaksin,
              ]);

      }else{
        // var_dump('test');die;
        $model = Userprofile::find()->where(['userid'=>$id])->one();
        return $this->redirect(['uwizard', 'id' => $model->id]);
      }

    }

    /**
     * Updates an existing Userprofile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUwizard($id)
    {
        $this->layout = Yii::$app->utils->getlayout();
        $model = $this->findModel($id);
        $modelvaksin = Uservaksin::find()->where(['userid'=>$model->userid])->one();
        if(!$modelvaksin){
          $modelvaksin = new Uservaksin();
          $modelvaksin->scenario = 'create';

        }else{
          $modelvaksin->scenario = 'update';

        }

        $alasanvaksin = ArrayHelper::map(Masteralasanvaksin::find()->asArray()->all(), 'id', 'alasan');
        $old_filep = $model->photo;
        $old_filecv = $model->cvupload;
        $old_filesert1 = null;
        $old_filesert2 = null;
        if($modelvaksin){
        $old_filesert1 = $modelvaksin->sertvaksin1;
        $old_filesert2 = $modelvaksin->sertvaksin2;
        }

        $province = ArrayHelper::map(MasterProvince::find()->asArray()->all(), 'provinsiid', 'provinsi');
        $kota = ArrayHelper::map(Mastercity::find()->asArray()->where(['kotaid'=>$model->cityid])->all(), 'kotaid', 'kota');
        $provincektp = ArrayHelper::map(MasterProvince::find()->asArray()->all(), 'provinsiid', 'provinsi');
        $kotaktp = ArrayHelper::map(Mastercity::find()->asArray()->where(['kotaid'=>$model->cityidktp])->all(), 'kotaid', 'kota');

        if ($model->load(Yii::$app->request->post()) && $modelvaksin->load(Yii::$app->request->post())) {

          if($model->havejamsostek == 0 OR $model->jamsosteknumber == ''){
            $model->jamsosteknumber = "00000000000";
          }
          if($model->havebpjs == 0 OR $model->bpjsnumber == ''){
            $model->bpjsnumber = "00000000000";
          }
          if($model->havenpwp == 0 OR $model->npwpnumber == ''){
            $model->npwpnumber = "000000000000000";
          }
          $model->photo = UploadedFile::getInstance($model,'photo');
          $model->cvupload = UploadedFile::getInstance($model,'cvupload');
          $modelvaksin->sertvaksin1 = UploadedFile::getInstance($modelvaksin,'sertvaksin1');
          $modelvaksin->sertvaksin2 = UploadedFile::getInstance($modelvaksin,'sertvaksin2');

          // if(!$modelvaksin){
            $modelvaksin->userid = $model->userid;
            $modelvaksin->createtime = date('Y-m-d H-i-s');
            $modelvaksin->createdby = Yii::$app->user->identity->id;
          // }
          $modelvaksin->updatetime = date('Y-m-d H-i-s');
          $modelvaksin->updateby = Yii::$app->user->identity->id;

          if($model->photo){
            $assetUrl = Yii::getAlias('@app'). '/assets';
            $fileextp = $model->photo->extension;
            $filep = $model->userid.'-PHOTO.'.$fileextp;
            if ($model->photo->saveAs($assetUrl.'/upload/photo/'.$filep)){
              $model->photo = $filep;
            }
          }
          if($model->cvupload){
            $assetUrl = Yii::getAlias('@app'). '/assets';
            $fileextp = $model->cvupload->extension;
            $filep = $model->userid.'-CVUPLOAD.'.$fileextp;
            if ($model->cvupload->saveAs($assetUrl.'/upload/cvupload/'.$filep)){
              $model->cvupload = $filep;
            }
          }
          if($modelvaksin->sertvaksin1){
            $assetUrl = Yii::getAlias('@app'). '/assets';
            $fileextp = $modelvaksin->sertvaksin1->extension;
            $filep = $model->userid.'-SERTVAKSIN1.'.$fileextp;
            if ($modelvaksin->sertvaksin1->saveAs($assetUrl.'/upload/sertifikatvaksin/'.$filep)){
              $modelvaksin->sertvaksin1 = $filep;
            }
          }
          if($modelvaksin->sertvaksin2){
            $assetUrl = Yii::getAlias('@app'). '/assets';
            $fileextp = $modelvaksin->sertvaksin2->extension;
            $filep = $model->userid.'-SERTVAKSIN2.'.$fileextp;
            if ($modelvaksin->sertvaksin2->saveAs($assetUrl.'/upload/sertifikatvaksin/'.$filep)){
              $modelvaksin->sertvaksin2 = $filep;
            }
          }

          if (empty($model->photo)){
            $model->photo = $old_filep;
          }
          if (empty($model->cvupload)){
            $model->cvupload = $old_filecv;
          }
          if ($modelvaksin->statusvaksin == 2 || $modelvaksin->statusvaksin == 3) {
            if (empty($modelvaksin->sertvaksin1)){
              $modelvaksin->sertvaksin1 = $old_filesert1;
            }
          }
          if ($modelvaksin->statusvaksin == 3) {
            if (empty($modelvaksin->sertvaksin2)){
              $modelvaksin->sertvaksin2 = $old_filesert2;
            }
          }

          if($model->save() && $modelvaksin->save()){

            // return $this->goHome();
            return $this->redirect(['views', 'userid' => $model->userid]);
          }else{
            return $this->render('update', [
                'model' => $model,
                'province' => $province,
                'kota' => $kota,
                'provincektp' => $provincektp,
                'kotaktp' => $kotaktp,
                'modelvaksin' => $modelvaksin,
                'alasanvaksin'=>$alasanvaksin,
            ]);
          }
        } else {
            return $this->render('update', [
                'model' => $model,
                'province' => $province,
                'kota' => $kota,
                'provincektp' => $provincektp,
                'kotaktp' => $kotaktp,
                'modelvaksin' => $modelvaksin,
                'alasanvaksin'=>$alasanvaksin,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $this->layout = Yii::$app->utils->getlayout();
        $model = $this->findModel($id);
        $modelvaksin = Uservaksin::find()->where(['userid'=>$model->userid])->one();

        if(!$modelvaksin){
          $modelvaksin = new Uservaksin();
          $modelvaksin->scenario = 'create';

        }else{
          $modelvaksin->scenario = 'update';

        }

        $alasanvaksin = ArrayHelper::map(Masteralasanvaksin::find()->asArray()->all(), 'id', 'alasan');
        $old_filep = $model->photo;
        $old_filecv = $model->cvupload;
        $old_filesert1 = null;
        $old_filesert2 = null;
        if($modelvaksin){
        $old_filesert1 = $modelvaksin->sertvaksin1;
        $old_filesert2 = $modelvaksin->sertvaksin2;
        }
        $province = ArrayHelper::map(MasterProvince::find()->asArray()->all(), 'provinsiid', 'provinsi');
        $kota = ArrayHelper::map(Mastercity::find()->asArray()->where(['kotaid'=>$model->cityid])->all(), 'kotaid', 'kota');
        $provincektp = ArrayHelper::map(MasterProvince::find()->asArray()->all(), 'provinsiid', 'provinsi');
        $kotaktp = ArrayHelper::map(Mastercity::find()->asArray()->where(['kotaid'=>$model->cityidktp])->all(), 'kotaid', 'kota');

        if ($model->load(Yii::$app->request->post()) && $modelvaksin->load(Yii::$app->request->post())) {

          if($model->havejamsostek == 0 OR $model->jamsosteknumber == ''){
            $model->jamsosteknumber = "00000000000";
          }
          if($model->havebpjs == 0 OR $model->bpjsnumber == ''){
            $model->bpjsnumber = "00000000000";
          }
          if($model->havenpwp == 0 OR $model->npwpnumber == ''){
            $model->npwpnumber = "000000000000000";
          }
          $model->photo = UploadedFile::getInstance($model,'photo');
          $model->cvupload = UploadedFile::getInstance($model,'cvupload');
          $modelvaksin->sertvaksin1 = UploadedFile::getInstance($modelvaksin,'sertvaksin1');
          $modelvaksin->sertvaksin2 = UploadedFile::getInstance($modelvaksin,'sertvaksin2');


            $modelvaksin->userid = $model->userid;
            $modelvaksin->createtime = date('Y-m-d H-i-s');
            $modelvaksin->createdby = Yii::$app->user->identity->id;

          $modelvaksin->updatetime = date('Y-m-d H-i-s');
          $modelvaksin->updateby = Yii::$app->user->identity->id;


          if($model->photo){
            $assetUrl = Yii::getAlias('@app'). '/assets';
            $fileextp = $model->photo->extension;
            $filep = $model->userid.'-PHOTO.'.$fileextp;
            if ($model->photo->saveAs($assetUrl.'/upload/photo/'.$filep)){
              $model->photo = $filep;
            }
          }
          if($model->cvupload){
            $assetUrl = Yii::getAlias('@app'). '/assets';
            $fileextp = $model->cvupload->extension;
            $filep = $model->userid.'-CVUPLOAD.'.$fileextp;
            if ($model->cvupload->saveAs($assetUrl.'/upload/cvupload/'.$filep)){
              $model->cvupload = $filep;
            }
          }

          if($modelvaksin->sertvaksin1){
            $assetUrl = Yii::getAlias('@app'). '/assets';
            $fileextp = $modelvaksin->sertvaksin1->extension;
            $filep = $model->userid.'-SERTVAKSIN1.'.$fileextp;
            if ($modelvaksin->sertvaksin1->saveAs($assetUrl.'/upload/sertifikatvaksin/'.$filep)){
              $modelvaksin->sertvaksin1 = $filep;
            }
          }
          if($modelvaksin->sertvaksin2){
            $assetUrl = Yii::getAlias('@app'). '/assets';
            $fileextp = $modelvaksin->sertvaksin2->extension;
            $filep = $model->userid.'-SERTVAKSIN2.'.$fileextp;
            if ($modelvaksin->sertvaksin2->saveAs($assetUrl.'/upload/sertifikatvaksin/'.$filep)){
              $modelvaksin->sertvaksin2 = $filep;
            }
          }

          if (empty($model->photo)){
            $model->photo = $old_filep;
          }
          if (empty($model->cvupload)){
            $model->cvupload = $old_filecv;
          }
          if ($modelvaksin->statusvaksin == 2 || $modelvaksin->statusvaksin == 3) {
            if (empty($modelvaksin->sertvaksin1)){
              $modelvaksin->sertvaksin1 = $old_filesert1;
            }
          }
          if ($modelvaksin->statusvaksin == 3) {
            if (empty($modelvaksin->sertvaksin2)){
              $modelvaksin->sertvaksin2 = $old_filesert2;
            }
          }

          if($model->save() && $modelvaksin->save()){
            return $this->redirect(['views', 'userid' => $model->userid]);
          }else{
            return $this->render('update', [
                'model' => $model,
                'province' => $province,
                'kota' => $kota,
                'provincektp' => $provincektp,
                'kotaktp' => $kotaktp,
                'userid'=>$model->userid,
                'modelvaksin' => $modelvaksin,
                'alasanvaksin'=>$alasanvaksin,
            ]);
          }
        } else {
          return $this->render('update', [
              'model' => $model,
              'province' => $province,
              'kota' => $kota,
              'provincektp' => $provincektp,
              'kotaktp' => $kotaktp,
              'userid'=>$model->userid,
              'modelvaksin' => $modelvaksin,
              'alasanvaksin'=>$alasanvaksin,
          ]);
        }
    }

    /**
     * Deletes an existing Userprofile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionPrintcv($userid)
    {
      $this->layout = 'print-custom';
      $userprofile = Userprofile::find()->where(['userid'=>$userid])->one();
      $userfamily = Userfamily::find()->where(['userid'=>$userid])->all();
      $userfedu = Userformaleducation::find()->where(['userid'=>$userid])->all();
      $usernfedu = Usernonformaleducation::find()->where(['userid'=>$userid])->all();
      $usernflang = Userforeignlanguage::find()->where(['userid'=>$userid])->all();
      $usereskill = Englishskill::find()->where(['userid'=>$userid])->one();
      $usercskill = Computerskill::find()->where(['userid'=>$userid])->one();
      $usercskill = Computerskill::find()->where(['userid'=>$userid])->one();
      $userwexp = Userworkexperience::find()->where(['userid'=>$userid])->all();
      $userorgac = Organizationactivity::find()->where(['userid'=>$userid])->all();
      $userecontact = Useremergencycontact::find()->where(['userid'=>$userid])->all();
      $userreff = Userreference::find()->where(['userid'=>$userid])->all();
      $userhealth = Userhealth::find()->where(['userid'=>$userid])->one();
      $userabout = Userabout::find()->where(['userid'=>$userid])->one();

      return $this->render('printcv', [
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
    }

    /**
     * Finds the Userprofile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Userprofile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Userprofile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
