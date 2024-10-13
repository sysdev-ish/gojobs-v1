<?php

namespace app\controllers;

use Yii;
use app\models\Uploadocument;
use app\models\Uploadocumentsearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;



/**
 * UploadocumentController implements the CRUD actions for Uploadocument model.
 */
class UploadocumentController extends Controller
{
  /**
   * @inheritdoc
   */
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'only' => ['index', 'update', 'create', 'view', 'delete', 'views', 'cwizard', 'uwizard'],
        'rules' => [

          [
            'actions' => ['index', 'view', 'delete'],
            'allow' => true,
            'roles' => ['@'],
            'matchCallback' => function () {
              return (Yii::$app->utils->permission(Yii::$app->user->identity->role, 'm13'));
            }

          ],
          [
            'actions' => ['views', 'view'],
            'allow' => true,
            'roles' => ['@'],
            'matchCallback' => function () {
              // var_dump( (int)Yii::$app->request->get('userid'));die;
              if (Yii::$app->user->identity->role == 2) {
                if ((int)Yii::$app->request->get('userid') == Yii::$app->user->identity->id) {
                  $ret = true;
                } else {
                  $ret = false;
                }
              } else {
                $ret = (Yii::$app->utils->permission(Yii::$app->user->identity->role, 'm13'));
              }
              return $ret;
            }

          ],
          [
            'actions' => ['update'],
            'allow' => true,
            'roles' => ['@'],
            'matchCallback' => function () {

              if (Yii::$app->user->identity->role == 2) {

                if ((int)Yii::$app->request->get('id') == Yii::$app->user->identity->id) {
                  $ret = true;
                } else {
                  $ret = false;
                }
              } else {
                $ret = (Yii::$app->utils->permission(Yii::$app->user->identity->role, 'm13'));
              }
              return $ret;
            }

          ],
          [
            'actions' => ['cwizard', 'uwizard', 'create'],
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
   * Lists all Uploadocument models.
   * @return mixed
   */
  public function actionIndex()
  {
    $searchModel = new Uploadocumentsearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Displays a single Uploadocument model.
   * @param integer $id
   * @return mixed
   */
  public function actionView($id)
  {
    return $this->render('view', [
      'model' => $this->findModel($id),
    ]);
  }
  public function actionViews($userid)
  {
    $this->layout = Yii::$app->utils->getlayout();
    $model = Uploadocument::find()->where(['userid' => $userid])->one();
    if ($model) {
      return $this->render('view', [
        'model' => $model,
        'userid' => $userid,
      ]);
    } else {
      return $this->redirect(['create', 'userid' => $userid]);
    }
  }

  /**
   * Creates a new Uploadocument model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate($userid)
  {
    $id = $userid;
    $this->layout = Yii::$app->utils->getlayout();
    $model = new Uploadocument();

    $model->scenario = 'create';

    if ($model->load(Yii::$app->request->post())) {
      $model->userid = $id;
      $model->createtime = date('Y-m-d H-i-s');
      $model->updatetime = date('Y-m-d H-i-s');
      $model->ijazah = UploadedFile::getInstance($model, 'ijazah');
      $model->transkipnilai = UploadedFile::getInstance($model, 'transkipnilai');
      $model->suratketerangansehat = UploadedFile::getInstance($model, 'suratketerangansehat');
      $model->kartukeluarga = UploadedFile::getInstance($model, 'kartukeluarga');
      $model->ktp = UploadedFile::getInstance($model, 'ktp');
      $model->jamsostek = UploadedFile::getInstance($model, 'jamsostek');
      $model->bpjskesehatan = UploadedFile::getInstance($model, 'bpjskesehatan');
      $model->npwp = UploadedFile::getInstance($model, 'npwp');
      $model->suratlamarankerja = UploadedFile::getInstance($model, 'suratlamarankerja');
      if ($model->ijazah) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        $fileextp = $model->ijazah->extension;
        $filep = $id . '-' . $this->getRandomString() . '-ijazah.' . $fileextp;
        if ($model->ijazah->saveAs($assetUrl . '/upload/ijazah/' . $filep)) {
          $model->ijazah = $filep;
        }
      }
      if ($model->transkipnilai) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        $fileextp = $model->transkipnilai->extension;
        $filep = $id . '-' . $this->getRandomString() . '-transkipnilai.' . $fileextp;
        if ($model->transkipnilai->saveAs($assetUrl . '/upload/transkipnilai/' . $filep)) {
          $model->transkipnilai = $filep;
        }
      }
      if ($model->suratketerangansehat) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        $fileextp = $model->suratketerangansehat->extension;
        $filep = $id . '-' . $this->getRandomString() . '-suratketerangansehat.' . $fileextp;
        if ($model->suratketerangansehat->saveAs($assetUrl . '/upload/suratketerangansehat/' . $filep)) {
          $model->suratketerangansehat = $filep;
        }
      }
      if ($model->kartukeluarga) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        $fileextp = $model->kartukeluarga->extension;
        $filep = $id . '-' . $this->getRandomString() . '-kartukeluarga.' . $fileextp;
        if ($model->kartukeluarga->saveAs($assetUrl . '/upload/kartukeluarga/' . $filep)) {
          $model->kartukeluarga = $filep;
        }
      }
      if ($model->ktp) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        $fileextp = $model->ktp->extension;
        $filep = $id . '-' . $this->getRandomString() . '-ktp.' . $fileextp;
        if ($model->ktp->saveAs($assetUrl . '/upload/ktp/' . $filep)) {
          $model->ktp = $filep;
        }
      }
      if ($model->jamsostek) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        $fileextp = $model->jamsostek->extension;
        $filep = $id . '-' . $this->getRandomString() . '-jamsostek.' . $fileextp;
        if ($model->jamsostek->saveAs($assetUrl . '/upload/jamsostek/' . $filep)) {
          $model->jamsostek = $filep;
        }
      }
      if ($model->bpjskesehatan) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        $fileextp = $model->bpjskesehatan->extension;
        $filep = $id . '-' . $this->getRandomString() . '-bpjskesehatan.' . $fileextp;
        if ($model->bpjskesehatan->saveAs($assetUrl . '/upload/bpjskesehatan/' . $filep)) {
          $model->bpjskesehatan = $filep;
        }
      }
      if ($model->npwp) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        $fileextp = $model->npwp->extension;
        $filep = $id . '-' . $this->getRandomString() . '-npwp.' . $fileextp;
        if ($model->npwp->saveAs($assetUrl . '/upload/npwp/' . $filep)) {
          $model->npwp = $filep;
        }
      }
      if ($model->suratlamarankerja) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        $fileextp = $model->suratlamarankerja->extension;
        $filep = $id . '-' . $this->getRandomString() . '-suratlamarankerja.' . $fileextp;
        if ($model->suratlamarankerja->saveAs($assetUrl . '/upload/suratlamarankerja/' . $filep)) {
          $model->suratlamarankerja = $filep;
        }
      }
      if ($model->save()) {
        return $this->redirect(['views', 'userid' => $userid]);
      } else {
        return $this->render('create', [
          'model' => $model,
          'userid' => $userid,
        ]);
      }
    } else {
      return $this->render('create', [
        'model' => $model,
        'userid' => $userid,
      ]);
    }
  }
  public function actionCwizard()
  {
    $id = Yii::$app->user->identity->id;
    if (Yii::$app->check->cuploaddoc($id) == 0) {
      $this->layout = Yii::$app->utils->getlayout();
      $model = new Uploadocument();
      $model->scenario = 'create';

      if ($model->load(Yii::$app->request->post())) {
        $model->userid = $id;
        $model->createtime = date('Y-m-d H-i-s');
        $model->updatetime = date('Y-m-d H-i-s');
        $model->ijazah = UploadedFile::getInstance($model, 'ijazah');
        $model->transkipnilai = UploadedFile::getInstance($model, 'transkipnilai');
        $model->suratketerangansehat = UploadedFile::getInstance($model, 'suratketerangansehat');
        $model->kartukeluarga = UploadedFile::getInstance($model, 'kartukeluarga');
        $model->ktp = UploadedFile::getInstance($model, 'ktp');
        $model->jamsostek = UploadedFile::getInstance($model, 'jamsostek');
        $model->bpjskesehatan = UploadedFile::getInstance($model, 'bpjskesehatan');
        $model->npwp = UploadedFile::getInstance($model, 'npwp');
        $model->suratlamarankerja = UploadedFile::getInstance($model, 'suratlamarankerja');
        if ($model->ijazah) {
          $assetUrl = Yii::getAlias('@app') . '/assets';
          $fileextp = $model->ijazah->extension;
          $filep = $id . '-' . $this->getRandomString() . '-ijazah.' . $fileextp;
          if ($model->ijazah->saveAs($assetUrl . '/upload/ijazah/' . $filep)) {
            $model->ijazah = $filep;
          }
        }
        if ($model->transkipnilai) {
          $assetUrl = Yii::getAlias('@app') . '/assets';
          $fileextp = $model->transkipnilai->extension;
          $filep = $id . '-' . $this->getRandomString() . '-transkipnilai.' . $fileextp;
          if ($model->transkipnilai->saveAs($assetUrl . '/upload/transkipnilai/' . $filep)) {
            $model->transkipnilai = $filep;
          }
        }
        if ($model->suratketerangansehat) {
          $assetUrl = Yii::getAlias('@app') . '/assets';
          $fileextp = $model->suratketerangansehat->extension;
          $filep = $id . '-' . $this->getRandomString() . '-suratketerangansehat.' . $fileextp;
          if ($model->suratketerangansehat->saveAs($assetUrl . '/upload/suratketerangansehat/' . $filep)) {
            $model->suratketerangansehat = $filep;
          }
        }
        if ($model->kartukeluarga) {
          $assetUrl = Yii::getAlias('@app') . '/assets';
          $fileextp = $model->kartukeluarga->extension;
          $filep = $id . '-' . $this->getRandomString() . '-kartukeluarga.' . $fileextp;
          if ($model->kartukeluarga->saveAs($assetUrl . '/upload/kartukeluarga/' . $filep)) {
            $model->kartukeluarga = $filep;
          }
        }
        if ($model->ktp) {
          $assetUrl = Yii::getAlias('@app') . '/assets';
          $fileextp = $model->ktp->extension;
          $filep = $id . '-' . $this->getRandomString() . '-ktp.' . $fileextp;
          if ($model->ktp->saveAs($assetUrl . '/upload/ktp/' . $filep)) {
            $model->ktp = $filep;
          }
        }
        if ($model->jamsostek) {
          $assetUrl = Yii::getAlias('@app') . '/assets';
          $fileextp = $model->jamsostek->extension;
          $filep = $id . '-' . $this->getRandomString() . '-jamsostek.' . $fileextp;
          if ($model->jamsostek->saveAs($assetUrl . '/upload/jamsostek/' . $filep)) {
            $model->jamsostek = $filep;
          }
        }
        if ($model->bpjskesehatan) {
          $assetUrl = Yii::getAlias('@app') . '/assets';
          $fileextp = $model->bpjskesehatan->extension;
          $filep = $id . '-' . $this->getRandomString() . '-bpjskesehatan.' . $fileextp;
          if ($model->bpjskesehatan->saveAs($assetUrl . '/upload/bpjskesehatan/' . $filep)) {
            $model->bpjskesehatan = $filep;
          }
        }
        if ($model->npwp) {
          $assetUrl = Yii::getAlias('@app') . '/assets';
          $fileextp = $model->npwp->extension;
          $filep = $id . '-' . $this->getRandomString() . '-npwp.' . $fileextp;
          if ($model->npwp->saveAs($assetUrl . '/upload/npwp/' . $filep)) {
            $model->npwp = $filep;
          }
        }
        if ($model->suratlamarankerja) {
          $assetUrl = Yii::getAlias('@app') . '/assets';
          $fileextp = $model->suratlamarankerja->extension;
          $filep = $id . '-' . $this->getRandomString() . '-suratlamarankerja.' . $fileextp;
          if ($model->suratlamarankerja->saveAs($assetUrl . '/upload/suratlamarankerja/' . $filep)) {
            $model->suratlamarankerja = $filep;
          }
        }
        if ($model->save()) {
          return $this->goHome();
        } else {
          return $this->render('create', [
            'model' => $model,
            'userid' => $id,
          ]);
        }
      } else {
        return $this->render('create', [
          'model' => $model,
          'userid' => $id,
        ]);
      }
    } else {
      // var_dump('test');die;
      return $this->redirect(['uwizard', 'id' => $id]);
    }
  }

  /**
   * Updates an existing Uploadocument model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   */
  public function actionUwizard($id)
  {
    $this->layout = Yii::$app->utils->getlayout();
    $userid = $id;
    $model = Uploadocument::find()->where(['userid' => $userid])->one();
    $userid = $model->userid;
    $old_filei = $model->ijazah;
    $old_filetn = $model->transkipnilai;
    $old_filesks = $model->suratketerangansehat;
    $old_filekk = $model->kartukeluarga;
    $old_filektp = $model->ktp;
    $old_filej = $model->jamsostek;
    $old_filebk = $model->bpjskesehatan;
    $old_filen = $model->npwp;
    $old_fileslk = $model->suratlamarankerja;

    if ($model->load(Yii::$app->request->post())) {
      $model->userid = $userid;
      $model->createtime = date('Y-m-d H-i-s');
      $model->updatetime = date('Y-m-d H-i-s');
      $model->ijazah = UploadedFile::getInstance($model, 'ijazah');
      $model->transkipnilai = UploadedFile::getInstance($model, 'transkipnilai');
      $model->suratketerangansehat = UploadedFile::getInstance($model, 'suratketerangansehat');
      $model->kartukeluarga = UploadedFile::getInstance($model, 'kartukeluarga');
      $model->ktp = UploadedFile::getInstance($model, 'ktp');
      $model->jamsostek = UploadedFile::getInstance($model, 'jamsostek');
      $model->bpjskesehatan = UploadedFile::getInstance($model, 'bpjskesehatan');
      $model->npwp = UploadedFile::getInstance($model, 'npwp');
      $model->suratlamarankerja = UploadedFile::getInstance($model, 'suratlamarankerja');
      if ($model->ijazah) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        @unlink($assetUrl . '/upload/ijazah/' . $old_filei);
        $fileextp = $model->ijazah->extension;
        $filep = $userid . '-' . $this->getRandomString() . '-ijazah.' . $fileextp;
        if ($model->ijazah->saveAs($assetUrl . '/upload/ijazah/' . $filep)) {
          $model->ijazah = $filep;
        }
      }
      if (empty($model->ijazah)) {
        $model->ijazah = $old_filei;
      }
      if ($model->transkipnilai) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        @unlink($assetUrl . '/upload/transkipnilai/' . $old_filetn);
        $fileextp = $model->transkipnilai->extension;
        $filep = $userid . '-' . $this->getRandomString() . '-transkipnilai.' . $fileextp;
        if ($model->transkipnilai->saveAs($assetUrl . '/upload/transkipnilai/' . $filep)) {
          $model->transkipnilai = $filep;
        }
      }
      if (empty($model->transkipnilai)) {
        $model->transkipnilai = $old_filetn;
      }
      if ($model->suratketerangansehat) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        @unlink($assetUrl . '/upload/suratketerangansehat/' . $old_filesks);
        $fileextp = $model->suratketerangansehat->extension;
        $filep = $userid . '-' . $this->getRandomString() . '-suratketerangansehat.' . $fileextp;
        if ($model->suratketerangansehat->saveAs($assetUrl . '/upload/suratketerangansehat/' . $filep)) {
          $model->suratketerangansehat = $filep;
        }
      }
      if (empty($model->suratketerangansehat)) {
        $model->suratketerangansehat = $old_filesks;
      }
      if ($model->kartukeluarga) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        @unlink($assetUrl . '/upload/kartukeluarga/' . $old_filekk);
        $fileextp = $model->kartukeluarga->extension;
        $filep = $userid . '-' . $this->getRandomString() . '-kartukeluarga.' . $fileextp;
        if ($model->kartukeluarga->saveAs($assetUrl . '/upload/kartukeluarga/' . $filep)) {
          $model->kartukeluarga = $filep;
        }
      }
      if (empty($model->kartukeluarga)) {
        $model->kartukeluarga = $old_filekk;
      }
      if ($model->ktp) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        @unlink($assetUrl . '/upload/ktp/' . $old_filektp);
        $fileextp = $model->ktp->extension;
        $filep = $userid . '-' . $this->getRandomString() . '-ktp.' . $fileextp;
        if ($model->ktp->saveAs($assetUrl . '/upload/ktp/' . $filep)) {
          $model->ktp = $filep;
        }
      }
      if (empty($model->ktp)) {
        $model->ktp = $old_filektp;
      }
      if ($model->jamsostek) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        @unlink($assetUrl . '/upload/jamsostek/' . $old_filej);
        $fileextp = $model->jamsostek->extension;
        $filep = $userid . '-' . $this->getRandomString() . '-jamsostek.' . $fileextp;
        if ($model->jamsostek->saveAs($assetUrl . '/upload/jamsostek/' . $filep)) {
          $model->jamsostek = $filep;
        }
      }
      if (empty($model->jamsostek)) {
        $model->jamsostek = $old_filej;
      }
      if ($model->bpjskesehatan) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        @unlink($assetUrl . '/upload/bpjskesehatan/' . $old_filebk);
        $fileextp = $model->bpjskesehatan->extension;
        $filep = $userid . '-' . $this->getRandomString() . '-bpjskesehatan.' . $fileextp;
        if ($model->bpjskesehatan->saveAs($assetUrl . '/upload/bpjskesehatan/' . $filep)) {
          $model->bpjskesehatan = $filep;
        }
      }
      if (empty($model->bpjskesehatan)) {
        $model->bpjskesehatan = $old_filebk;
      }
      if ($model->npwp) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        @unlink($assetUrl . '/upload/npwp/' . $old_filen);
        $fileextp = $model->npwp->extension;
        $filep = $userid . '-' . $this->getRandomString() . '-npwp.' . $fileextp;
        if ($model->npwp->saveAs($assetUrl . '/upload/npwp/' . $filep)) {
          $model->npwp = $filep;
        }
      }
      if (empty($model->npwp)) {
        $model->npwp = $old_filen;
      }
      if ($model->suratlamarankerja) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        @unlink($assetUrl . '/upload/suratlamarankerja/' . $old_fileslk);
        $fileextp = $model->suratlamarankerja->extension;
        $filep = $userid . '-' . $this->getRandomString() . '-suratlamarankerja.' . $fileextp;
        if ($model->suratlamarankerja->saveAs($assetUrl . '/upload/suratlamarankerja/' . $filep)) {
          $model->suratlamarankerja = $filep;
        }
      }
      if (empty($model->suratlamarankerja)) {
        $model->suratlamarankerja = $old_fileslk;
      }
      if ($model->save()) {
        return $this->goHome();
      } else {
        return $this->render('update', [
          'model' => $model,
        ]);
      }
    } else {
      return $this->render('update', [
        'model' => $model,
      ]);
    }
  }
  public function actionUpdate($id)
  {
    $this->layout = Yii::$app->utils->getlayout();
    $userid = $id;
    $model = Uploadocument::find()->where(['userid' => $userid])->one();

    $userid = $model->userid;
    $old_filei = $model->ijazah;
    $old_filetn = $model->transkipnilai;
    $old_filesks = $model->suratketerangansehat;
    $old_filekk = $model->kartukeluarga;
    $old_filektp = $model->ktp;
    $old_filej = $model->jamsostek;
    $old_filebk = $model->bpjskesehatan;
    $old_filen = $model->npwp;
    $old_fileslk = $model->suratlamarankerja;

    if ($model->load(Yii::$app->request->post())) {
      $model->userid = $userid;
      $model->createtime = date('Y-m-d H-i-s');
      $model->updatetime = date('Y-m-d H-i-s');
      $model->ijazah = UploadedFile::getInstance($model, 'ijazah');
      $model->transkipnilai = UploadedFile::getInstance($model, 'transkipnilai');
      $model->suratketerangansehat = UploadedFile::getInstance($model, 'suratketerangansehat');
      $model->kartukeluarga = UploadedFile::getInstance($model, 'kartukeluarga');
      $model->ktp = UploadedFile::getInstance($model, 'ktp');
      $model->jamsostek = UploadedFile::getInstance($model, 'jamsostek');
      $model->bpjskesehatan = UploadedFile::getInstance($model, 'bpjskesehatan');
      $model->npwp = UploadedFile::getInstance($model, 'npwp');
      $model->suratlamarankerja = UploadedFile::getInstance($model, 'suratlamarankerja');
      if ($model->ijazah) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        @unlink($assetUrl . '/upload/ijazah/' . $old_filei);
        $fileextp = $model->ijazah->extension;
        $filep = $userid . '-' . $this->getRandomString() . '-ijazah.' . $fileextp;
        if ($model->ijazah->saveAs($assetUrl . '/upload/ijazah/' . $filep)) {
          $model->ijazah = $filep;
        }
      }
      if (empty($model->ijazah)) {
        $model->ijazah = $old_filei;
      }
      if ($model->transkipnilai) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        @unlink($assetUrl . '/upload/transkipnilai/' . $old_filetn);
        $fileextp = $model->transkipnilai->extension;
        $filep = $userid . '-' . $this->getRandomString() . '-transkipnilai.' . $fileextp;
        if ($model->transkipnilai->saveAs($assetUrl . '/upload/transkipnilai/' . $filep)) {
          $model->transkipnilai = $filep;
        }
      }
      if (empty($model->transkipnilai)) {
        $model->transkipnilai = $old_filetn;
      }
      if ($model->suratketerangansehat) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        @unlink($assetUrl . '/upload/suratketerangansehat/' . $old_filesks);
        $fileextp = $model->suratketerangansehat->extension;
        $filep = $userid . '-' . $this->getRandomString() . '-suratketerangansehat.' . $fileextp;
        if ($model->suratketerangansehat->saveAs($assetUrl . '/upload/suratketerangansehat/' . $filep)) {
          $model->suratketerangansehat = $filep;
        }
      }
      if (empty($model->suratketerangansehat)) {
        $model->suratketerangansehat = $old_filesks;
      }
      if ($model->kartukeluarga) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        @unlink($assetUrl . '/upload/kartukeluarga/' . $old_filekk);
        $fileextp = $model->kartukeluarga->extension;
        $filep = $userid . '-' . $this->getRandomString() . '-kartukeluarga.' . $fileextp;
        if ($model->kartukeluarga->saveAs($assetUrl . '/upload/kartukeluarga/' . $filep)) {
          $model->kartukeluarga = $filep;
        }
      }
      if (empty($model->kartukeluarga)) {
        $model->kartukeluarga = $old_filekk;
      }
      if ($model->ktp) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        @unlink($assetUrl . '/upload/ktp/' . $old_filektp);
        $fileextp = $model->ktp->extension;
        $filep = $userid . '-' . $this->getRandomString() . '-ktp.' . $fileextp;
        if ($model->ktp->saveAs($assetUrl . '/upload/ktp/' . $filep)) {
          $model->ktp = $filep;
        }
      }
      if (empty($model->ktp)) {
        $model->ktp = $old_filektp;
      }
      if ($model->jamsostek) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        @unlink($assetUrl . '/upload/jamsostek/' . $old_filej);
        $fileextp = $model->jamsostek->extension;
        $filep = $userid . '-' . $this->getRandomString() . '-jamsostek.' . $fileextp;
        if ($model->jamsostek->saveAs($assetUrl . '/upload/jamsostek/' . $filep)) {
          $model->jamsostek = $filep;
        }
      }
      if (empty($model->jamsostek)) {
        $model->jamsostek = $old_filej;
      }
      if ($model->bpjskesehatan) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        @unlink($assetUrl . '/upload/bpjskesehatan/' . $old_filebk);
        $fileextp = $model->bpjskesehatan->extension;
        $filep = $userid . '-' . $this->getRandomString() . '-bpjskesehatan.' . $fileextp;
        if ($model->bpjskesehatan->saveAs($assetUrl . '/upload/bpjskesehatan/' . $filep)) {
          $model->bpjskesehatan = $filep;
        }
      }
      if (empty($model->bpjskesehatan)) {
        $model->bpjskesehatan = $old_filebk;
      }
      if ($model->npwp) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        @unlink($assetUrl . '/upload/npwp/' . $old_filen);
        $fileextp = $model->npwp->extension;
        $filep = $userid . '-' . $this->getRandomString() . '-npwp.' . $fileextp;
        if ($model->npwp->saveAs($assetUrl . '/upload/npwp/' . $filep)) {
          $model->npwp = $filep;
        }
      }
      if (empty($model->npwp)) {
        $model->npwp = $old_filen;
      }
      if ($model->suratlamarankerja) {
        $assetUrl = Yii::getAlias('@app') . '/assets';
        @unlink($assetUrl . '/upload/suratlamarankerja/' . $old_fileslk);
        $fileextp = $model->suratlamarankerja->extension;
        $filep = $userid . '-' . $this->getRandomString() . '-suratlamarankerja.' . $fileextp;
        if ($model->suratlamarankerja->saveAs($assetUrl . '/upload/suratlamarankerja/' . $filep)) {
          $model->suratlamarankerja = $filep;
        }
      }
      if (empty($model->suratlamarankerja)) {
        $model->suratlamarankerja = $old_fileslk;
      }
      if ($model->save()) {
        return $this->redirect(['views', 'userid' => $model->userid]);
      } else {
        return $this->render('update', [
          'model' => $model,
          'userid' => $model->userid,
        ]);
      }
    } else {
      return $this->render('update', [
        'model' => $model,
        'userid' => $model->userid,
      ]);
    }
  }

  public function actionDownload($filename)
  {
    // Check if the user is authenticated
    if (Yii::$app->user->isGuest) {
      throw new \yii\web\ForbiddenHttpException('You are not allowed to access this file.');
    }

    // Check if the user has permission to access the file (you can implement RBAC here)
    // Example:
    // if (!Yii::$app->user->can('downloadFile')) {
    //     throw new \yii\web\ForbiddenHttpException('You are not allowed to access this file.');
    // }

    // Construct the file path
    $filePath = Yii::getAlias('@app/uploads/') . $filename;

    // Check if the file exists
    if (!file_exists($filePath)) {
      throw new NotFoundHttpException('The requested file does not exist.');
    }

    // Serve the file
    return Yii::$app->response->sendFile($filePath);
  }

  // Helper method to generate random string
  public function getRandomString()
  {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < 6; $i++) {
      $index = rand(0, strlen($characters) - 1);
      $randomString .= $characters[$index];
    }

    return $randomString;
  }


  /**
   * Deletes an existing Uploadocument model.
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
   * Finds the Uploadocument model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Uploadocument the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Uploadocument::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }
}
