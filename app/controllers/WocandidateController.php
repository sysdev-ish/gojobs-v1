<?php

namespace app\controllers;

use app\models\Userprofile;
use app\models\Userprofilesearch;
use Yii;
use app\models\WoRecruitmentCandidate;
use app\models\WoRecruitmentCandidateSearch;
use app\models\WorkOrder;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\db\IntegrityException;
use yii\web\UploadedFile;

/**
 * WocandidateController implements the CRUD actions for WoRecruitmentCandidate model.
 */
class WocandidateController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'update', 'create', 'view', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'update', 'create', 'view', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            return (Yii::$app->utils->permission(Yii::$app->user->identity->role, 'm102'));
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
     * Lists all WoRecruitmentCandidate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WoRecruitmentCandidateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WoRecruitmentCandidate model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new WoRecruitmentCandidate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WoRecruitmentCandidate();
        if ($model->load(Yii::$app->request->post())) {
            $model->assets_path = UploadedFile::getInstance($model, 'assets_path');
            if ($model->assets_path) {
                $assetUrl = Yii::getAlias('@app') . '/assets';
                $fileextp = $model->assets_path->extension;
                $filep = $model->type_content . date('Y') .  '-CMS.' . $fileextp;
                if ($model->assets_path->saveAs($assetUrl . '/upload/cms/' . $filep)) {
                    $model->assets_path = $filep;
                }
            }
            $model->created_time = date('Y-m-d H-i-s');
            $model->updated_time = date('Y-m-d H-i-s');
            $model->status = 1;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Data ditambahkan.");
            } else {
                Yii::$app->session->setFlash('error', "Data sudah ada.");
            }
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing WoRecruitmentCandidate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->assets_path = UploadedFile::getInstance($model, 'assets_path');
            if ($model->assets_path) {
                $assetUrl = Yii::getAlias('@app') . '/assets';
                $fileextp = $model->assets_path->extension;
                $filep = $model->type_content . date('Y') .  '-CMS.' . $fileextp;
                if ($model->assets_path->saveAs($assetUrl . '/upload/cms/' . $filep)) {
                    $model->assets_path = $filep;
                }
            }
            $model->updated_time = date('Y-m-d H-i-s');
            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Data diupdate.");
            } else {
                Yii::$app->session->setFlash('error', "Data sudah ada.");
            }
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    // 
    public function actionAddcandidate($userid)
    {
        $model = new WoRecruitmentCandidate();
        $modeluprofile = Userprofile::find()->where(['userid' => $userid])->one();
        $model->fullname = $modeluprofile->fullname;
        $model->userid = $modeluprofile->userid;
        $year = date('Y');
        $recruitreq = ArrayHelper::map(Workorder::find()->asArray()->where('flag_recruitment = 1 OR flag_recruitment = 3 ')->all(), 'id', 'wo_number');

        if ($model->load(Yii::$app->request->post())) {
            $model->created_time = date('Y-m-d H-i-s');
            $model->updated_time = date('Y-m-d H-i-s');
            $model->created_by = Yii::$app->user->id;
            $model->updated_by = Yii::$app->user->id;
            $model->status = 0;
            $model->type_interview = 1;
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

    public function actionAddtocandidate($id, $userid)
    {
        $model = new WoRecruitmentCandidate();
        //
        if (Yii::$app->request->isAjax) {
            $model->user_id = $userid;
            $model->created_time = date('Y-m-d H-i-s');
            $model->updated_time = date('Y-m-d H-i-s');
            $model->created_by = Yii::$app->user->id;
            $model->updated_by = Yii::$app->user->id;
            $model->wo_id = $id;
            $model->status = 0;
            $model->type_interview = 1;

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($model->save()) {
                return 'Add Candidate Successful';
            }
        }
        // return $this->redirect(['addcandidate2','id'=>$id]);
    }
    public function actionAddcandidate2($id)
    {
        $model = new WoRecruitmentCandidate();
        $modelrecreq = Workorder::find()->where(['id' => $id, 'flag_recruitment' => 1])->one();
        $searchModelprofile = new Userprofilesearch();

        $dataProviderprofile = $searchModelprofile->search(Yii::$app->request->queryParams);

        return $this->renderAjax('addcandidate2', [
            'model' => $model,
            'searchModelprofile' => $searchModelprofile,
            'dataProviderprofile' => $dataProviderprofile,
            'transrincianid' => $id,
            'modelrecreq' => $modelrecreq,

        ]);
    }

    /**
     * Deletes an existing WoRecruitmentCandidate model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */

    public function actionDelete($id)
    {
        // $jobfamily = WoRecruitmentCandidate::find($id)->all();
        $model = $this->findModel($id);
        try {
            if ($model->delete()) {
                Yii::$app->session->setFlash('success', "Data Dihapus.");
            }
            // else {
            //     Yii::$app->session->setFlash('error', "Data Digunakan Di Tabel Lain.");
            // }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', "Data Digunakan Di Tabel Lain.");
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the WoRecruitmentCandidate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WoRecruitmentCandidate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WoRecruitmentCandidate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
