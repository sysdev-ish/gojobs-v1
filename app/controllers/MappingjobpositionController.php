<?php

namespace app\controllers;

use Yii;
use app\models\Mappingjobposition;
use app\models\MappingjobpositionSearch;
use app\models\Sapjob;
use app\models\Mastersubjobfamily;
use app\models\Transrincianrekrut;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\filters\AccessControl;

/**
 * MappingjobpositionController implements the CRUD actions for Mappingjobposition model.
 */
class MappingjobpositionController extends Controller
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
                            return (Yii::$app->utils->permission(Yii::$app->user->identity->role, 'm51'));
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
     * Lists all Mappingjobposition models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MappingjobpositionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Mappingjobposition model.
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
     * Creates a new Mappingjobposition model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionJabatans()
    {
        $out = [];

        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $id = $parents[0];
                $out = Sapjob::find()
                    ->where(['value1' => $id])
                    ->select(['value1', 'value2 AS jabatansap'])->asArray()->all();
                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
    }
    public function actionCreate()
    {
        $model = new Mappingjobposition();

        $subjobfamilyid = ArrayHelper::map(Mastersubjobfamily::find()->asArray()->all(), 'id', 'subjobfamily');
        // $jabatansap = ArrayHelper::map(Sapjob::find()->all(), 'value1', 'value2');
        // $kodejabatan = ArrayHelper::map(Sapjob::find()->all(), 'value1', 'value3');
        if ($model->load(Yii::$app->request->post())) {
            $model->createtime = date('Y-m-d H-i-s');
            $model->updatetime = date('Y-m-d H-i-s');
            $model->status = 1;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Data ditambahkan.");
            } else {
                Yii::$app->session->setFlash('error', "Data sudah ada.");
            }
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
                'subjobfamilyid' => $subjobfamilyid,
                // 'jabatansap' => $jabatansap,
                // 'kodejabatan' => $kodejabatan,
            ]);
        }
    }

    /**
     * Updates an existing Mappingjobposition model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $subjobfamilyid = ArrayHelper::map(Mastersubjobfamily::find()->asArray()->all(), 'id', 'subjobfamily');
        // $jabatansap = ArrayHelper::map(Sapjob::find()->all(), 'value1', 'value2');
        // $kodejabatan = ArrayHelper::map(Sapjob::find()->all(), 'value1', 'value3');
        if ($model->load(Yii::$app->request->post())) {
            $model->updatetime = date('Y-m-d H-i-s');
            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Data diupdate.");
            } else {
                Yii::$app->session->setFlash('error', "Data sudah ada.");
            }
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
                'subjobfamilyid' => $subjobfamilyid,
                // 'jabatansap' => $jabatansap,
                // 'kodejabatan' => $kodejabatan,
            ]);
        }
    }

    /**
     * Deletes an existing Mappingjobposition model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', "Data dihapus.");
        } else {
            Yii::$app->session->setFlash('error', "Data tidak dihapus.");
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Mappingjobposition model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mappingjobposition the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mappingjobposition::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
