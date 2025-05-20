<?php

namespace app\controllers;

use Yii;
use app\models\MappingIndustry;
use app\models\MappingIndustrySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Masterindustry;
use yii\helpers\ArrayHelper;


/**
 * MappingIndustryController implements the CRUD actions for MappingIndustry model.
 */
class MappingIndustryController extends Controller
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
              return (Yii::$app->utils->permission(Yii::$app->user->identity->role, 'm84'));
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
   * Lists all MappingIndustry models.
   * @return mixed
   */
  public function actionIndex()
  {
    $searchModel = new MappingIndustrySearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Displays a single MappingIndustry model.
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
   * Creates a new MappingIndustry model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate()
  {
    $model = new MappingIndustry();

    $industry = ArrayHelper::map(Masterindustry::find()->asArray()->all(), 'id', 'industry_type');
    if ($model->load(Yii::$app->request->post())) {
      $model->created_by = Yii::$app->user->id;
      $model->updated_by = Yii::$app->user->id;
      $model->created_at = date('Y-m-d H-i-s');
      $model->updated_at = date('Y-m-d H-i-s');
      $model->status = 1;

      $dataIndustry = Masterindustry::find()->where(['id' => $model->category_company])->one();
      if ($model->category_company && $dataIndustry) {
        $model->description = 'Klien kami, Perusahaan yang bergerak di bidang ' . $dataIndustry->industry_type . ' terkemuka di Indonesia membutuhkan tenaga kerja dengan kualifikasi berikut :';
      } else {
        $model->description = 'Klien kami, Perusahaan terkemuka di Indonesia membutuhkan tenaga kerja dengan kualifikasi berikut :';
      }

      if ($model->save()) {
        Yii::$app->session->setFlash('success', "Data ditambahkan.");
      } else {
        Yii::$app->session->setFlash('error', "Data sudah ada.");
      }
      return $this->redirect(['index']);
    } else {
      return $this->renderAjax('create', [
        'model' => $model,
        'industry' => $industry,
      ]);
    }
  }

  /**
   * Updates an existing MappingIndustry model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   */
  public function actionUpdate($id)
  {
    $model = $this->findModel($id);

    $industry = ArrayHelper::map(Masterindustry::find()->asArray()->all(), 'id', 'industry_type');
    if ($model->load(Yii::$app->request->post())) {
      $model->updated_by = Yii::$app->user->id;
      $model->updated_at = date('Y-m-d H-i-s');

      if ($model->save()) {
        Yii::$app->session->setFlash('success', "Data diupdate.");
      } else {
        Yii::$app->session->setFlash('error', "Data sudah ada.");
      }
      return $this->redirect(['index']);
    } else {
      return $this->renderAjax('update', [
        'model' => $model,
        'industry' => $industry,
      ]);
    }
  }

  /**
   * Deletes an existing MappingIndustry model.
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
   * Finds the MappingIndustry model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return MappingIndustry the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = MappingIndustry::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }
}
