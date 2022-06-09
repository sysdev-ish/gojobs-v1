<?php

namespace app\controllers;

use Yii;
use app\models\Mastersubjobfamily;
use app\models\MastersubjobfamilySearch;
use app\models\Masterjobfamily;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\filters\AccessControl;
use yii\db\IntegrityException;

/**
 * MastersubjobfamilyController implements the CRUD actions for Mastersubjobfamily model.
 */
class MastersubjobfamilyController extends Controller
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
                            return (Yii::$app->utils->permission(Yii::$app->user->identity->role, 'm80'));
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
     * Lists all Mastersubjobfamily models.
     * @return mixed
     */
    public function actionIndex()
    {
        $jobfamily = Masterjobfamily::find()->all();        
        if ($jobfamily==null) {
            // return $this->redirect(array(‘rekrut/masterjobfamily/index));
            return $this->redirect(['masterjobfamily/index']);
        } else {
            $searchModel = new MastersubjobfamilySearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);            
        }
        

    }

    /**
     * Displays a single Mastersubjobfamily model.
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
     * Creates a new Mastersubjobfamily model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Mastersubjobfamily();

        $jobfamily = ArrayHelper::map(Masterjobfamily::find()->asArray()->all(), 'id', 'jobfamily');
        if ($model->load(Yii::$app->request->post())) {
            $model->createtime = date('Y-m-d H-i-s');
            $model->updatetime = date('Y-m-d H-i-s');
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
                'jobfamily' => $jobfamily,
            ]);
        }
    }

    /**
     * Updates an existing Mastersubjobfamily model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $jobfamily = ArrayHelper::map(Masterjobfamily::find()->asArray()->all(), 'id', 'jobfamily');
        if ($model->load(Yii::$app->request->post())) {
            $model->updatetime = date('Y-m-d H-i-s');
            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Data diupdate.");
            } else {
                Yii::$app->session->setFlash('error', "Data sudah ada.");
            }
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
                'jobfamily' => $jobfamily,
            ]);
        }
    }

    /**
     * Deletes an existing Mastersubjobfamily model.
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
            // else {
            //     Yii::$app->session->setFlash('error', "Data Digunakan Di Tabel Lain.");
            // }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', "Data Digunakan Di Tabel Lain.");
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Mastersubjobfamily model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mastersubjobfamily the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mastersubjobfamily::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
