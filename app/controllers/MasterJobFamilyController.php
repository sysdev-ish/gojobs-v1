<?php

namespace app\controllers;

use Yii;
use app\models\Masterjobfamily;
use app\models\MasterjobfamilySearch;
use app\models\Mastersubjobfamily;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

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
            $model->save();
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
            $model->save();
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
    public function actionDelete($id)
    {
        // $jobfamily = Masterjobfamily::find()->all();
        $this->findModel($id)->delete();
        Mastersubjobfamily::deleteAll('jobfamily_id= :jobfamily_id', [':jobfamily_id' => $id]);

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
