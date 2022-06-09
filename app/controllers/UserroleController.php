<?php

namespace app\controllers;

use Yii;
use app\models\Userrole;
use app\models\Rolepermission;
use app\models\Userrolesearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UserroleController implements the CRUD actions for Userrole model.
 */
class UserroleController extends Controller
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
                      return (Yii::$app->utils->permission(Yii::$app->user->identity->role,'m19'));
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
     * Lists all Userrole models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Userrolesearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Userrole model.
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
     * Creates a new Userrole model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Userrole();
        if ($model->load(Yii::$app->request->post()))
        {
          // var_dump($model->countcheck);die;
          $model->createtime = date('Y-m-d H-i-s');
          $model->updatetime = date('Y-m-d H-i-s');
          if ($model->save())
          {  
            for ($i=1; $i <= $model->countcheck ; $i++)
            {
              $modelname = 'm'.$i;
              $module = $model->$modelname;
              if($module != 0){
                $modelrpermission = new Rolepermission();
                $modelrpermission->createtime = date('Y-m-d H-i-s');
                $modelrpermission->updatetime = date('Y-m-d H-i-s');
                $modelrpermission->roleid = $model->id;
                $modelrpermission->modulecode = $modelname;
                $modelrpermission->save();
              }
            }
          }
          return $this->redirect(['index']);
        }
        else
        {
          return $this->render('create', [
              'model' => $model,
          ]);
        }
    }

    /**
     * Updates an existing Userrole model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $checkrolepermission = Rolepermission::find()->where(['roleid'=>$id])->one();
        $rolepermission = Rolepermission::find()->where(['roleid'=>$id])->all();
        foreach ($rolepermission as $key => $value) {
          $modelname = $value->modulecode;
          $model->$modelname = 1;
        }
        if ($model->load(Yii::$app->request->post()) ) {
          $model->updatetime = date('Y-m-d H-i-s');
          if($checkrolepermission){
            Rolepermission::deleteAll('roleid = :roleid', [':roleid' => $id]);
          }

          if($model->save()){

            for ($i=1; $i <= $model->countcheck ; $i++) {
              $modelname = 'm'.$i;
              $module = $model->$modelname;

              if($module != 0){
                $modelrpermission = new Rolepermission();
                $modelrpermission->createtime = date('Y-m-d H-i-s');
                $modelrpermission->updatetime = date('Y-m-d H-i-s');
                $modelrpermission->roleid = $id;
                $modelrpermission->modulecode = $modelname;
                $modelrpermission->save();
              }

            }
          }

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Userrole model.
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
     * Finds the Userrole model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Userrole the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Userrole::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
