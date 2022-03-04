<?php

namespace app\controllers;

use Yii;
use app\models\Grouprolepermission;
use app\models\Grouprolepermissionsearch;
use app\models\Mappinggrouprolepermission;
use app\models\Userrole;
use yii\base\Model;
use app\models\Modeldynamic;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * GrouprolepermissionController implements the CRUD actions for Grouprolepermission model.
 */
class GrouprolepermissionController extends Controller
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
     * Lists all Grouprolepermission models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Grouprolepermissionsearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Grouprolepermission model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
      $rolepermission = Mappinggrouprolepermission::find()->where(['grouprolepermissionid' => $id])->all();
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
            'rolepermission' => $rolepermission,
        ]);
    }

    /**
     * Creates a new Grouprolepermission model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Grouprolepermission();
        $userrole = Userrole::find()->all();
        $mappinggrps = [new Mappinggrouprolepermission()];
        for($i = 1; $i < count($userrole); $i++) {
          $mappinggrps[] = new Mappinggrouprolepermission();
        }
        if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($mappinggrps, Yii::$app->request->post()) && Model::validateMultiple($mappinggrps)) {

          $model->createtime = date('Y-m-d H-i-s');
          $model->updatetime = date('Y-m-d H-i-s');
          $model->save();
          // $count = count(Yii::$app->request->post('Mappinggrouprolepermission', []));
          foreach ($mappinggrps as $mappinggrp) {
              $mappinggrp->grouprolepermissionid = $model->id;
              $mappinggrp->save(false);
          }

            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'mappinggrps' => $mappinggrps,
                'userrole' => $userrole,
            ]);
        }
    }

    /**
     * Updates an existing Grouprolepermission model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $userrole = Userrole::find()->all();
        foreach ($userrole as $key => $value) {
          $mappinggrps[] = Mappinggrouprolepermission::find()->where(['roleid' => $value->id,'grouprolepermissionid'=>$model->id])->one();
        }
        $oldIDs = Mappinggrouprolepermission::find()->select('id')->where(['grouprolepermissionid' => $model->id])->asArray()->all();
        $oldIDs = ArrayHelper::getColumn($oldIDs, 'id');

        $mappinggrpss = Mappinggrouprolepermission::findAll(['id' => $oldIDs]);
        $mappinggrps = (empty($mappinggrpss)) ? [new Mappinggrouprolepermission] : $mappinggrpss;
        // var_dump($mappinggrps);die;
        if ($model->load(Yii::$app->request->post())) {
          $mappinggrps = Modeldynamic::createMultiple(Mappinggrouprolepermission::classname());
          Modeldynamic::loadMultiple($mappinggrps, Yii::$app->request->post());
          Modeldynamic::validateMultiple($mappinggrps);

          $newaudIds =ArrayHelper::getColumn($mappinggrps,'id');
          $delaudIds = array_diff($oldIDs,$newaudIds);
          if (! empty($delaudIds)) Mappinggrouprolepermission::deleteAll(['id' => $delaudIds]);

          $model->updatetime = date('Y-m-d H-i-s');
          $model->save();

          // Mappinggrouprolepermission::deleteAll(['grouprolepermissionid' => $id]);
          // $count = count(Yii::$app->request->post('Mappinggrouprolepermission', []));
          // var_dump($count);die;
          foreach ($mappinggrps as $mappinggrp) {
            if($mappinggrp->active == 1){
            $mappinggrp->grouprolepermissionid = $model->id;
            $mappinggrp->save(false);
            }
          }
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'mappinggrps' => $mappinggrps,
                'userrole' => $userrole,
            ]);
        }
    }

    /**
     * Deletes an existing Grouprolepermission model.
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
     * Finds the Grouprolepermission model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Grouprolepermission the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Grouprolepermission::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
