<?php

namespace app\controllers;

use app\models\WoRecruitmentCandidate;
use app\models\WoRecruitmentInterview;
use app\models\WoRecruitmentPsikotest;
use Yii;
use app\models\WorkOrder;
use app\models\WorkOrderSearch;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\db\IntegrityException;
use yii\web\UploadedFile;

/**
 * WorkorderController implements the CRUD actions for WorkOrder model.
 */
class WorkorderController extends Controller
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
     * Lists all WorkOrder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WorkOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionManage()
    {
        //
        $query = Workorder::find()->orderBy(['id' => SORT_DESC]);
        // $query->joinWith("city")->distinct();
        $query->joinWith("jobsap");
        // $query->andWhere('workorder.flag_wo = 1');

        // initiate filter data
        $filters = array(
            'id' => null,
            'wo_number' => null,
            'type_wo' => null,
            'job' => null,
            'area' => null,
            'project_name' => null,
            'gender' => null,
            'status' => null,
        );

        // function filter data
        if (isset($_GET['Filter'])) {
            if (isset($_GET['Filter']['id'])) {
                $filters['id'] = $_GET['Filter']['id'];
                $query->andWhere('workorder.id LIKE :id', [':id' => '%' . $filters['id'] . '%']);
            }
            if (isset($_GET['Filter']['wo_number'])) {
                $filters['wo_number'] = $_GET['Filter']['wo_number'];
                $query->andWhere('workorder.wo_number LIKE :wo_number', [':wo_number' => '%' . $filters['wo_number'] . '%']);
            }
            if (isset($_GET['Filter']['type_wo'])) {
                $filters['type_wo'] = $_GET['Filter']['type_wo'];
                $query->andWhere('workorder.type_wo LIKE :type_wo', [':type_wo' => '%' . $filters['type_wo'] . '%']);
            }
            if (isset($_GET['Filter']['job'])) {
                $filters['job'] = $_GET['Filter']['job'];
                $query->andWhere('workorder.job LIKE :job', [':job' => '%' . $filters['job'] . '%']);
            }
            if (isset($_GET['Filter']['area'])) {
                $filters['area'] = $_GET['Filter']['area'];
                $query->andWhere('master_city.city_name LIKE :area', [':area' => '%' . $filters['area'] . '%']);
            }
            if (isset($_GET['Filter']['project_name'])) {
                $filters['project_name'] = $_GET['Filter']['project_name'];
                $query->andWhere('workorder.project_name LIKE :project_name', [':project_name' => '%' . $filters['project_name'] . '%']);
            }
            if (isset($_GET['Filter']['gender'])) {
                $filters['gender'] = $_GET['Filter']['gender'];
                $query->andWhere('workorder.gender LIKE :gender', [':gender' => '%' . $filters['gender'] . '%']);
            }
            if (isset($_GET['Filter']['status'])) {
                $filters['status'] = $_GET['Filter']['status'];
                $query->andWhere('workorder.flag_recruitment LIKE :status', [':status' => '%' . $filters['status'] . '%']);
            }
        }

        $status = [1 => "On Progress", 2 => "Done"];
        $type = [1 => "New Project", 2 => "Replacement"];

        $countQuery = clone $query;
        $pages = new Pagination(['pageSize' => 15, 'totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('manage', [
            'models' => $models,
            'pages' => $pages,
            'filters' => $filters,
            'status' => $status,
            'type' => $type,
        ]);
    }

    /**
     * Creates a new WorkOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WorkOrder();
        if ($model->load(Yii::$app->request->post())) {
            $model->file_path = UploadedFile::getInstance($model, 'file_path');
            if ($model->file_path) {
                $assetUrl = Yii::getAlias('@app') . '/assets';
                $fileextp = $model->file_path->extension;
                $filep = $model->file_path . date('Y') .  '-WO.' . $fileextp;
                if ($model->file_path->saveAs($assetUrl . '/upload/wo/' . $filep)) {
                    $model->file_path = $filep;
                }
            }
            // var_dump(Yii::$app->request->post('Workorder')['job_code']);die();
            $model->wo_number = Yii::$app->utils->latestwo();
            $model->created_time = date('Y-m-d H-i-s');
            $model->created_by = Yii::$app->user->identity->id;
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
     * Updates an existing WorkOrder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->file_path = UploadedFile::getInstance($model, 'file_path');
            if ($model->file_path) {
                $assetUrl = Yii::getAlias('@app') . '/assets';
                $fileextp = $model->file_path->extension;
                $filep = $model->type_content . date('Y') .  '-WO.' . $fileextp;
                if ($model->file_path->saveAs($assetUrl . '/upload/wo/' . $filep)) {
                    $model->file_path = $filep;
                }
            }
            // $model->wo_number = Yii::$app->utils->latestwo();
            $model->updated_time = date('Y-m-d H-i-s');
            $model->updated_by = Yii::$app->user->identity->id;
            $model->status = 1;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Data ditambahkan.");
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

    /**
     * Displays a single WorkOrder model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model =  $this->findModel($id);
        $candidate = WoRecruitmentCandidate::find()->where(['wo_id' => $model->id])->all();
        $candidatecount = WoRecruitmentCandidate::find()->where(['wo_id' => $model->id])->count();
        $onintcount = WoRecruitmentCandidate::find()->where(['wo_id' => $model->id, 'status' => 1])->count();
        $onpsicount = WoRecruitmentCandidate::find()->where(['wo_id' => $model->id, 'status' => 2])->count();
        $onuintcount = WoRecruitmentCandidate::find()->where(['wo_id' => $model->id, 'status' => 3])->count();
        $candidates = array();
        foreach ($candidate as $val) {
            $candidates[] = $val->id;
        }
        $intcount = WoRecruitmentInterview::find()->where('candidate_id IN ("' . implode('","', $candidates) . '")', [])->count();
        $psicount = WoRecruitmentPsikotest::find()->where('candidate_id IN ("' . implode('","', $candidates) . '")', [])->count();
        $uintcount = WoRecruitmentInterview::find()->where('candidate_id IN ("' . implode('","', $candidates) . '")', [])->count();
        // var_dump($model);die();
        return $this->renderAjax('view', [
            'model' => $model,
            'candidate' => $candidate,
            'candidatecount' => $candidatecount,
            'onintcount' => $onintcount,
            'onpsicount' => $onpsicount,
            'onuintcount' => $onuintcount,
            'intcount' => $intcount,
            'psicount' => $psicount,
            'uintcount' => $uintcount,
        ]);
    }

    public function actionWolist($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $outs = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $wherecontent = $q;
            // var_dump($wherecontent);die;
            $query =  WorkOrder::find()
                ->select(['trans_rincian_rekrut.id', 'trans_rincian_rekrut.nojo', 'trans_rincian_rekrut.jabatan', 'trans_rincian_rekrut.lokasi', 'projectrekrut' => 'trans_rincian_rekrut.n_project', 'job_function.name_job_function', 'trans_jo.type_replace', 'trans_jo.type_jo', 'trans_jo.n_project', 'trans_jo.project', 'mapping_city.city_name', 'sapjabatan' => 'sapjob.value2', 'trans_rincian_rekrut.hire_jabatan_sap', 'trans_rincian_rekrut.persa_sap', 'trans_rincian_rekrut.area_sap', 'trans_rincian_rekrut.skill_sap', 'level_sap' => 'trans_rincian_rekrut.level_sap', 'saparea' => 'saparea.value2', 'sappersa' => 'sappersonalarea.value2', 'sapskill' => 'sapskilllayanan.value2'])

                ->joinWith("jobfunc")
                ->joinWith("transjo")
                ->joinWith("city")
                ->joinWith("jabatansap")
                ->joinWith("areasap")
                ->joinWith("persasap")
                ->joinWith("skillsap")

                ->andWhere([
                    'or',
                    ['LIKE', 'trans_rincian_rekrut.nojo', $wherecontent],
                    ['LIKE', 'trans_rincian_rekrut.id', $wherecontent],
                    ['LIKE', 'sapjob.value2', $wherecontent],
                    ['LIKE', 'saparea.value2', $wherecontent],
                    ['LIKE', 'sappersonalarea.value2', $wherecontent]
                ])
                ->orderBy([
                    'trans_rincian_rekrut.id' => SORT_DESC
                ])
                ->limit(100)
                ->asArray()->all();
            $out = null;
            foreach ($query as $key => $value) {
                $out[] = $value;
            }
            if ($out) {
                $outs['results'] = $out;
            } else {
                $outs['results'] = null;
            }
        } elseif ($id > 0) {
            $outs['results'] = ['id' => $id, 'text' => WorkOrder::findOne($id)->nojo];
        } else {
            $outs['results'] = ['id' => ' ', 'text' => ' '];
        }

        return $outs;
    }
    /**
     * Deletes an existing WorkOrder model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        try {
            if ($model->delete()) {
                Yii::$app->session->setFlash('success', "Data Dihapus.");
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', "Data Digunakan Di Tabel Lain.");
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the WorkOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WorkOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WorkOrder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
