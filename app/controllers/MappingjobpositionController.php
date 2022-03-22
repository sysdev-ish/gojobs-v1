<?php

namespace app\controllers;

use Yii;
use app\models\Mappingjobposition;
use app\models\MappingjobpositionSearch;
use app\models\Transrincianrekrut;
use app\models\Mastersubjobfamily;
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Mappingjobposition model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Mappingjobposition();

        $subjobfamilyid = ArrayHelper::map(Mastersubjobfamily::find()->asArray()->all(), 'id', 'subjobfamilyid');
        $jabatansap = ArrayHelper::map(Transrincianrekrut::find()->all(), 'id', 'jabatansap');
        $kodeposisi = ArrayHelper::map(Transrincianrekrut::find()->all(), 'id', 'kodeposisi');
        if ($model->load(Yii::$app->request->post())) {
            $model->createtime = date('Y-m-d H-i-s');
            $model->updatetime = date('Y-m-d H-i-s');
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
                'subjobfamilyid' => $subjobfamilyid,
                'jabatansap' => $jabatansap,
                'kodeposisi' => $kodeposisi,
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

        $subjobfamilyid = ArrayHelper::map(Mastersubjobfamily::find()->asArray()->all(), 'id', 'subjobfamilyid');
        $jabatansap = ArrayHelper::map(Transrincianrekrut::find()->all(), 'id', 'jabatansap');
        $kodeposisi = ArrayHelper::map(Transrincianrekrut::find()->all(), 'id', 'kodeposisi');
        if ($model->load(Yii::$app->request->post())) {
            $model->updatetime = date('Y-m-d H-i-s');
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
                'subjobfamilyid' => $subjobfamilyid,
                'jabatansap' => $jabatansap,
                'kodeposisi' => $kodeposisi,
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
        $this->findModel($id)->delete();

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
