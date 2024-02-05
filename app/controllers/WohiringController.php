<?php

namespace app\controllers;

use Yii;
use app\models\WoHiring;
use app\models\WoHiringSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\db\IntegrityException;
use yii\web\UploadedFile;

/**
 * WoHiringController implements the CRUD actions for WoHiring model.
 */
class WoHiringController extends Controller
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
     * Lists all WoHiring models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WoHiringSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WoHiring model.
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
     * Creates a new WoHiring model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WoHiring();
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
     * Updates an existing WoHiring model.
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

    /**
     * Deletes an existing WoHiring model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */

    public function actionDelete($id)
    {
        // $jobfamily = WoHiring::find($id)->all();
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
     * Finds the WoHiring model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WoHiring the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WoHiring::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
