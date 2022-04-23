<?php

namespace app\controllers;

use Yii;
use app\models\Masterjobfamily;
use app\models\MasterjobfamilySearch;
use app\models\Mastersubjobfamily;
use Codeception\Lib\Di;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\db\IntegrityException;

/**
 * MasterjobfamilyController implements the CRUD actions for Masterjobfamily model.
 */
class MasterjobfamilyController extends Controller
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
     * Lists all Masterjobfamily models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MasterjobfamilySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = Masterjobfamily::find()->one();

        var_dump($model->subfamily->mappingjob->hire_jabatan_sap);die();





        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Masterjobfamily model.
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
     * Creates a new Masterjobfamily model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Masterjobfamily();
        if ($model->load(Yii::$app->request->post())) {
            $model->createtime = date('Y-m-d H-i-s');
            $model->updatetime = date('Y-m-d H-i-s');
            $model->status = 1;
            if ($model->save()){
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
     * Updates an existing Masterjobfamily model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

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
            ]);
        }
    }

    /**
     * Deletes an existing Masterjobfamily model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    // public function beforeDelete()
    // {
    //     if (parent::beforeDelete()) {
    //         Masterjobfamily::deleteAll(['id' => $this->id]);
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }
    public function actionDelete($id)
    {
        $jobfamily = Masterjobfamily::find($id)->all();
        foreach ($jobfamily as $jobfamily) {
            try {
                if ($jobfamily->delete()) {
                Yii::$app->session->setFlash('success', "Data Dihapus.");
                }
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', "Data Digunakan Di Tabel Lain.");
            }
        }
        return $this->redirect(['index']);
        

    }

    /**
     * Finds the Masterjobfamily model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Masterjobfamily the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Masterjobfamily::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
