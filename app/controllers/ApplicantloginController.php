<?php

namespace app\controllers;

use Yii;
use app\models\Userlogin;
use app\models\Userrole;
use app\models\Userloginsearch;
use app\models\Userapploginsearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

/**
 * UserloginController implements the CRUD actions for Userlogin model.
 */
class ApplicantloginController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
      return [
          'access' => [
              'class' => AccessControl::className(),
              'only' => ['index','update','create','view','delete'],
              'rules' => [
                [
                    'actions' => ['index','update','create','view','delete'],
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback'=>function(){
                         return (Yii::$app->utils->permission(Yii::$app->user->identity->role,'m51'));
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
     * Lists all Userlogin models.
     * @return mixed
     */
    public function actionIndex()
    {
      $searchModel = new Userapploginsearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('applogin', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
      ]);
    }


    /**
     * Displays a single Userlogin model.
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
     * Creates a new Userlogin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Userlogin();
        $userrole = ArrayHelper::map(Userrole::find()->where('id != 2')->andWhere('id != 1')->asArray()->all(), 'id', 'role');
        if ($model->load(Yii::$app->request->post())) {
          $model->setScenario('create');
          $model->status = 10;
          $model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
          $model->auth_key = 'admin4uthk3y';
          $model->verify_status = 1;
          $model->created_at = date('Y-m-d H-i-s');
          $model->updated_at = date('Y-m-d H-i-s');
            if($model->save()){
              return $this->redirect(['index']);
            }else{
              return $this->render('create', [
                  'model' => $model,
                  'userrole' => $userrole,
              ]);
            }

        } else {
            return $this->render('create', [
                'model' => $model,
                'userrole' => $userrole,
            ]);
        }
    }

    /**
     * Updates an existing Userlogin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $userrole = ArrayHelper::map(Userrole::find()->where('id != 2')->andWhere('id != 1')->asArray()->all(), 'id', 'role');
        if ($model->load(Yii::$app->request->post())) {
          $model->updated_at = date('Y-m-d H-i-s');
          $model->save(false);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'userrole' => $userrole,
            ]);
        }
    }

    /**
     * Deletes an existing Userlogin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionRchangepass($id)
    {
        $model = $this->findModel($id);
        $model->updated_at = date('Y-m-d H-i-s');
        $model->requestforchangepassword = 1;
        $model->save(false);
        return $this->redirect(['index']);
    }
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Userlogin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Userlogin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Userlogin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
