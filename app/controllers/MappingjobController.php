<?php

namespace app\controllers;

use Yii;
use app\models\Mappingjob;
use app\models\MappingjobSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Mastersubjobfamily;
use app\models\Transrincian;
use yii\helpers\ArrayHelper;


/**
 * MappingjobController implements the CRUD actions for Mappingjob model.
 */
class MappingjobController extends Controller
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
     * Lists all Mappingjob models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MappingjobSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // $model = Mappingjob::find(23001742)->one();

        // var_dump($model->kodejabatan);die();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Mappingjob model.
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
     * Creates a new Mappingjob model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Mappingjob();

        $subjobfamilyid = ArrayHelper::map(Mastersubjobfamily::find()->asArray()->all(), 'id', 'subjobfamily');
        if ($model->load(Yii::$app->request->post())) {
            $model->createtime = date('Y-m-d H-i-s');
            $model->updatetime = date('Y-m-d H-i-s');
            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Data ditambahkan.");
            } else {
                Yii::$app->session->setFlash('error', "Data sudah ada.");
            }
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
                'subjobfamilyid' => $subjobfamilyid,
            ]);
        }
    }

    /**
     * Updates an existing Mappingjob model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $subjobfamilyid = ArrayHelper::map(Mastersubjobfamily::find()->asArray()->all(), 'id', 'subjobfamily');
        if ($model->load(Yii::$app->request->post())) {
            $model->updatetime = date('Y-m-d H-i-s');
            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Data ditambahkan.");
            } else {
                Yii::$app->session->setFlash('error', "Data sudah ada.");
            }
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
                'subjobfamilyid' => $subjobfamilyid,
            ]);
        }
    }

    /**
     * Deletes an existing Mappingjob model.
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
     * Finds the Mappingjob model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mappingjob the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mappingjob::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
