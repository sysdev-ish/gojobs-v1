<?php

namespace app\controllers;

use Yii;
use app\models\Masterroom;
use app\models\Masterroomsearch;
use app\models\Masteroffice;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\filters\AccessControl;

/**
 * MasterroomController implements the CRUD actions for Masterroom model.
 */
class MasterroomController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
      return [
          'access' => [
              'class' => AccessControl::className(),
              'only' => ['index','update','create','view','delete','getroom'],
              'rules' => [
                [
                    'actions' => ['index','update','create','view','delete','getroom'],
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback'=>function(){
                         return (Yii::$app->utils->permission(Yii::$app->user->identity->role,'m27'));
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
     * Lists all Masterroom models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Masterroomsearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Masterroom model.
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
     * Creates a new Masterroom model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Masterroom();
        $office = ArrayHelper::map(Masteroffice::find()->asArray()->all(), 'id', 'officename');
        if ($model->load(Yii::$app->request->post())) {
          $model->createtime = date('Y-m-d H-i-s');
          $model->updatetime = date('Y-m-d H-i-s');
          $model->save();
          return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
                'office' => $office,
            ]);
        }
    }

    /**
     * Updates an existing Masterroom model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $office = ArrayHelper::map(Masteroffice::find()->asArray()->all(), 'id', 'officename');
        if ($model->load(Yii::$app->request->post())) {
          $model->updatetime = date('Y-m-d H-i-s');
          $model->save();
          return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
                'office' => $office,
            ]);
        }
    }

    /**
     * Deletes an existing Masterroom model.
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
     * Finds the Masterroom model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Masterroom the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Masterroom::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionGetroom() {
      $out = [];
  		if (isset($_POST['depdrop_parents'])) {
  			$parents = $_POST['depdrop_parents'];
            $officeid = empty($parents[0]) ? null : $parents[0];
  			$model = Masterroom::find()->asArray()->where(['masterofficeid'=>$officeid])->all();
  			$selected  = null;
  			if ($parents != null && count($model) > 0 ) {
  				$selected = '';
          $id1 = '';
  				if (!empty($_POST['depdrop_params'])) {
  					$params = $_POST['depdrop_params'];
  					$id1 = $params[0]; // get the value of model_id1
  					foreach ($model as $key => $value) {
  						$out[] = ['id'=>$value['id'],'name'=> $value['room']];
              $oc[] = $value['id'];
  						if($key == 0){
  						$aux = $value['id'];
  						}
  						}
              ((in_array($id1, $oc))) ? $selected = $id1 : $selected = $aux;
  				}
  				echo Json::encode(['output'=>$out, 'selected'=>$selected]);
  				return;
  			}
  		}
  	    echo Json::encode(['output'=>'', 'selected'=>'']);
    }
}
