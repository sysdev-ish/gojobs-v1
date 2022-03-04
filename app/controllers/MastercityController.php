<?php

namespace app\controllers;

use Yii;
use app\models\Mastercity;
use app\models\Mastercitysearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\filters\AccessControl;

/**
 * MastercityController implements the CRUD actions for Mastercity model.
 */
class MastercityController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
      return [
          'access' => [
              'class' => AccessControl::className(),
              'only' => ['index','update','create','view','getcity','delete'],
              'rules' => [
                  [
                      'actions' => ['index','update','create','view','getcity','delete'],
                      'allow' => true,
                      'roles' => ['@'],
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
     * Lists all Mastercity models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Mastercitysearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Mastercity model.
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
     * Creates a new Mastercity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Mastercity();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->kotaid]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Mastercity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->kotaid]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Mastercity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function actionGetcity() {
      $out = [];
  		if (isset($_POST['depdrop_parents'])) {
  			$parents = $_POST['depdrop_parents'];
        $provinsiid = empty($parents[0]) ? null : $parents[0];
  			$model = Mastercity::find()->asArray()->where(['provinsiid'=>$provinsiid])->all();
  			$selected  = null;
  			if ($parents != null && count($model) > 0 ) {
  				$selected = '';
          $id1 = '';
  				if (!empty($_POST['depdrop_params'])) {
  					$params = $_POST['depdrop_params'];
  					$id1 = $params[0]; // get the value of model_id1
  					foreach ($model as $key => $value) {
  						$out[] = ['id'=>$value['kotaid'],'name'=> $value['kota']];
              $oc[] = $value['kotaid'];
  						if($key == 0){
  						$aux = $value['kotaid'];
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
    /**
     * Finds the Mastercity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mastercity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mastercity::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
