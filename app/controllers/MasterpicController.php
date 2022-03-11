<?php

namespace app\controllers;

use Yii;
use app\models\Masterpic;
use app\models\Masterpicsearch;
use app\models\Masteroffice;
use app\models\Userlogin;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\filters\AccessControl;

/**
 * MasterpicController implements the CRUD actions for Masterpic model.
 */
class MasterpicController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
      return [
          'access' => [
              'class' => AccessControl::className(),
              'only' => ['index','update','create','view','delete','getpic'],
              'rules' => [
                [
                    'actions' => ['index','update','create','view','delete','getpic'],
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback'=>function(){
                         return (Yii::$app->utils->permission(Yii::$app->user->identity->role,'m31'));
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
     * Lists all Masterpic models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Masterpicsearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Masterpic model.
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
     * Creates a new Masterpic model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Masterpic();
        
        $office = ArrayHelper::map(Masteroffice::find()->asArray()->all(), 'id', 'officename');
        $userlogin = ArrayHelper::map(Userlogin::find()->asArray()->where(['!=','role',2])->all(), 'id', 'name');
        if ($model->load(Yii::$app->request->post())) {
          $model->createtime = date('Y-m-d H-i-s');
          $model->updatetime = date('Y-m-d H-i-s');
          $model->save();
          return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
                'office' => $office,
                'userlogin' => $userlogin,
            ]);
        }
    }

    /**
     * Updates an existing Masterpic model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $office = ArrayHelper::map(Masteroffice::find()->asArray()->all(), 'id', 'officename');
        $userlogin = ArrayHelper::map(Userlogin::find()->asArray()->where(['!=','role',2])->all(), 'id', 'name');
        if ($model->load(Yii::$app->request->post())) {
          $model->updatetime = date('Y-m-d H-i-s');
          $model->save();
          return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
                'office' => $office,
                'userlogin' => $userlogin,
            ]);
        }
    }

    /**
     * Deletes an existing Masterpic model.
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
     * Finds the Masterpic model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Masterpic the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Masterpic::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionGetpic() {
      $out = [];
  		if (isset($_POST['depdrop_parents'])) {
  			$parents = $_POST['depdrop_parents'];
        $officeid = empty($parents[0]) ? null : $parents[0];
  			$model = Masterpic::find()->asArray()->joinWith('userlogin')->where(['masterofficeid'=>$officeid])->all();
  			$selected  = null;
  			if ($parents != null && count($model) > 0 ) {
  				$selected = '';
          $id1 = '';
  				if (!empty($_POST['depdrop_params'])) {
  					$params = $_POST['depdrop_params'];
  					$id1 = $params[0]; // get the value of model_id1
  					foreach ($model as $key => $value) {
              // var_dump($value);die;
  						$out[] = ['id'=>$value['userid'],'name'=> $value['userlogin']['name']];
              $oc[] = $value['userid'];
  						if($key == 0){
  						$aux = $value['userid'];
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
