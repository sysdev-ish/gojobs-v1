<?php

namespace app\controllers;

use Yii;
use app\models\Transrincianrekrut;
use app\models\Transrincianori;
use app\models\Transrincian;
use app\models\Transrincianlogupdate;
use app\models\Hiring;
use app\models\Transrincianrekruttemp;
use app\models\Transperner;
use app\models\Transjo;
use app\models\Transrincianrekrutsearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use linslin\yii2\curl;

/**
 * TransrincianrekrutController implements the CRUD actions for Transrincianrekrut model.
 */
class TransrincianrekrutController extends Controller
{
  /**
   * @inheritdoc
   */
  public function behaviors()
  {
      return [
          'verbs' => [
              'class' => VerbFilter::className(),
              'actions' => [
                  'delete' => ['POST'],
              ],
          ],
      ];
  }

  /**
   * Lists all Transrincianrekrut models.
   * @return mixed
   */
  public function actionIndex()
  {
      $searchModel = new Transrincianrekrutsearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('index', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
      ]);
  }

  /**
   * Displays a single Transrincianrekrut model.
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
   * Creates a new Transrincianrekrut model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
    // public function actionSyncdataproject()
    // {
    //   $modeltr = Transrincianori::find()->where(['flagrekrut'=> 1])->all();
    //   foreach ($modeltr as $key => $value) {
    //     $model = Transrincian::find()->where(['idpktable'=> $value->id])->one();
    //     if($model){
    //       $checkjo = Transjo::find()->where(['nojo'=> $value->nojo])->one();
    //       if($checkjo){
    //         if($checkjo->n_project || $checkjo->project){
    //           if($checkjo->n_project == '' || $checkjo->n_project == 'Pilih'){
    //             $nproject = $checkjo->project;
    //           }else{
    //             $nproject = $checkjo->n_project;
    //           }
    //         }else{
    //           $nproject = '';
    //         }
    //
    //       $model->n_project = $nproject;
    //       $model->save();
    //       }
    //     }
    //
    //     $count = $key;
    //   }
    //   echo "total row ".$key;
    // }
    // public function actionSyncdataproject2()
    // {
    //   $modeltp = Transperner::find()->where(['flagrekrut'=> 1])->all();
    //
    //   foreach ($modeltp as $key => $value) {
    //     $model = Transrincian::find()->where(['idpktable'=> $value->id])->one();
    //     if($model){
    //       $checkjo = Transjo::find()->where(['nojo'=> $value->nojo])->one();
    //       if($checkjo){
    //         $model->n_project = $value->nm_persa;
    //         $model->save();
    //       }
    //     }
    //
    //     $count = $key;
    //   }
    //   echo "total row ".$key;
    // }

    public function actionUpdatetyperekrutdata()
    {
      $model = Transrincian::find()->where(['typejo'=> 1])->all();
      foreach ($model as $key => $value) {
        $transori = Transrincianori::find()->where(['id'=> $value->idpktable])->one();
        if($transori){
        if($transori->type_rekrut){
          $modelupdate = Transrincian::find()->where(['typejo'=> 1, 'idpktable'=>$value->idpktable])->one();

          $modelupdate->type_rekrut = $transori->type_rekrut;
          $modelupdate->save(false);
        }
        }

      }

    }
    public function actionSyncdata()
    {
        $modeltrori = Transrincianori::find()->where(['flagrekrut'=> 0 , 'skema'=> 1])->all();
        // $checklog = Transrincianlogupdate::find()->where(['statusupdate'=> 'waiting', 'typejo'=> 1])->all();
        $checklog = null;
        if($checklog){
          $modeltr = $checklog;
          if($modeltr){
            echo "data rincian update";
          }else{
            echo "no data change";
          }
          $confirm = 1;
        }else{
          $modeltr = $modeltrori;
          if($modeltr){
            echo "data rincian new insert ";
          }else{
            echo "no data change";
          }
          $confirm = 2;
        }

            foreach ($modeltr as $key => $valueopsi) {
              $transjo = Transjo::find()->where(['nojo'=> $valueopsi->nojo])->one();
                if($confirm == 1){
                  break;
                  if($valueopsi->typejo == 2){
                    break;
                  }
                  $value = Transrincianori::find()->where(['id'=> $valueopsi->idpktable])->one();
                  $model = Transrincian::find()->where(['idpktable'=> $value->id , 'typejo'=> 1])->one();

                }else{
                  $value = $valueopsi;
                  $model = new Transrincian();
                }
                $model->nojo = $value->nojo;
                $model->detail_komp = $value->detail_komp;
                $model->jabatan = $value->jabatan;
                $model->gender = $value->gender;
                $model->pendidikan =$value->pendidikan;
                $model->lokasi = $value->lokasi;
                $model->atasan = $value->atasan;
                $model->kontrak = $value->kontrak;
                $model->waktu = $value->waktu;
                $model->jumlah = $value->jumlah;
                $model->komentar = $value->komentar;
                $model->skema = $value->skema;
                $model->ket_done = $value->ket_done;
                $model->upd = $value->upd;
                $model->lup = $value->lup;
                $model->flag_jobs = $value->flag_jobs;
                $model->upd_jobs = $value->upd_jobs;
                $model->lup_jobs = $value->lup_jobs;
                $model->flag_app = $value->flag_app;
                $model->upd_app = $value->upd_app;
                $model->ket_rej = $value->ket_rej;
                if($confirm == 2){
                  if($value->status_rekrut == 2){
                    $model->status_rekrut = $value->status_rekrut;
                  }
                }
                if($transjo->flag_peralihan == 1){
                  if($value->type_rekrut == 1 OR $value->type_rekrut == 3){
                    $model->status_rekrut = 2;
                  }
                }else{
                  if($value->type_rekrut == 3){
                    $model->status_rekrut = 2;
                  }
                }
                $model->ket_rekrut = $value->ket_rekrut;
                $model->upd_rekrut = $value->upd_rekrut;
                $model->pic_hi = $value->pic_hi;
                $model->n_pic_hi = $value->n_pic_hi;
                $model->pic_manar = $value->pic_manar;
                $model->n_pic_manar = $value->n_pic_manar;
                $model->pic_rekrut = $value->pic_rekrut;
                $model->n_pic_rekrut = $value->n_pic_rekrut;
                $model->level = $value->level;
                $model->level_txt = $value->level_txt;
                $model->skilllayanan = $value->skilllayanan;
                $model->skilllayanan_txt = $value->skilllayanan_txt;
                $model->level_sap = $value->level_sap;
                $model->persa_sap = $value->persa_sap;
                $model->skill_sap = $value->skill_sap;
                $model->area_sap = $value->area_sap;
                $model->jabatan_sap = $value->jabatan_sap;
                $model->jabatan_sap_nm = $value->jabatan_sap_nm;
                $model->jenis_pro_sap = $value->jenis_pro_sap;
                $model->skema_sap = $value->skema_sap;
                $model->abkrs_sap = $value->abkrs_sap;
                $model->hire_jabatan_sap = $value->hire_jabatan_sap;
                $model->zparam = $value->zparam;
                $model->lup_skema = $value->lup_skema;
                $model->upd_skema = $value->upd_skema;
                $model->finish_view_manar = $value->finish_view_manar;
                $model->idpktable = $value->id;
                $model->typejo = 1;
                if($value->train_soft){
                  $model->train_soft = $value->train_soft;
                }
                if($value->train_hard){
                  $model->train_hard = $value->train_hard;
                }
                if($value->tendem_aktif){
                  $model->tendem_aktif = $value->tendem_aktif;
                }
                if($value->tendem_pasif){
                  $model->tendem_pasif = $value->tendem_pasif;
                }
                $model->userpm = $value->userpm;
                if($value->type_rekrut){
                  $model->type_rekrut = $value->type_rekrut;
                }
                $checkjo = Transjo::find()->where(['nojo'=> $value->nojo])->one();
                if($checkjo){
                $model->n_project = ($checkjo->n_project == '' || $checkjo->n_project == 'Pilih' || $checkjo->n_project == null)?$checkjo->project : $checkjo->n_project;
                }
                if($model->save(false)){
                  if($confirm == 1){
                    $modelupdflag = Transrincianlogupdate::find()->where(['id'=> $valueopsi->id])->one();
                    $modelupdflag->statusupdate = 'done';
                    $modelupdflag->save(false);
                  }else{
                    $modelupdflag = Transrincianori::find()->where(['id'=>$model->idpktable])->one();
                    $modelupdflag->flagrekrut = 1;
                    $modelupdflag->save();
                  }
                }
          }




        $modeltrori = Transperner::find()->where(['flagrekrut'=> 0 , 'skema'=> 1])->all();
        // $checklog = Transrincianlogupdate::find()->where(['statusupdate'=> 'waiting', 'typejo'=> 2])->all();
        $checklog = null;
        // var_dump($modeltrori);die;
        if($checklog){
          $modeltr = $checklog;
          if($modeltr){
            echo "data perner update";
          }else{
            echo "no data change";
          }
          $confirm = 1;
        }else{
          $modeltr = $modeltrori;
          if($modeltr){
            echo "data perner new insert ";
          }else{
            echo "no data change";
          }
          $confirm = 2;
          // var_dump($modeltr);die;
        }

            foreach ($modeltr as $key => $valueopsi) {
              $transjo = Transjo::find()->where(['nojo'=> $valueopsi->nojo])->one();
                if($confirm == 1){
                  break;
                  if($valueopsi->typejo == 1){
                    break;
                  }
                  $value = Transperner::find()->where(['id'=> $valueopsi->idpktable])->one();
                  $model = Transrincian::find()->where(['idpktable'=> $value->id , 'typejo'=> 2])->one();

                }else{
                  $value = $valueopsi;
                  $model = new Transrincian();
                }


          if (is_numeric($value->perner)){
            $curl = new curl\Curl();
            $getsapprofile = $curl->setPostParams([
              'perner' 	=> $value->perner,
              'jabatan' 	=> $value->nm_jabatan,
              'token' 		=> 'ish**2019',
            ])
            ->post('http://192.168.88.5/service/index.php/sap_profile/getdataperner');
            $sapprofile  = json_decode($getsapprofile);
            if($value->rotasi_resign == 2){
              // $hirejabatansap = $sapprofile->value1_fromjo;
              $hirejabatansap = $sapprofile->value1;
            }else{
              $hirejabatansap = Yii::$app->utils->getjabatanid($value->nm_jabatan);
            }
            // var_dump($sapprofile->platx);die;

            $model->nojo = $value->nojo;
            $model->detail_komp = '';
            $model->jabatan = $value->nm_jabatan;
            $model->gender = '-';
            $model->pendidikan ='-';
            $model->lokasi = $value->area;
            $model->atasan = '';
            $model->kontrak = $sapprofile->anstt;
            $model->waktu = '';
            $model->jumlah = '1';
            $model->komentar = '';
            $model->skema = $value->skema;
            $model->ket_done = $value->ket_done;
            $model->upd = $value->upd;
            $model->lup = $value->lup;
            $model->flag_jobs = '';
            $model->upd_jobs = '';
            $model->lup_jobs = '';
            $model->flag_app = 0;
            if($confirm == 2){
            if($value->status_rekrut == 2){
              $model->status_rekrut = $value->status_rekrut;
            }
          }
          if($transjo->flag_peralihan == 1){
            if($value->type_rep == 1 OR $value->type_rep == 3){
              $model->status_rekrut = 2;
            }
          }else{
            if($value->type_rep == 3){
              $model->status_rekrut = 2;
            }
          }
            // $model->level = $value->level;
            // $model->level_txt = $value->level_txt;
            $model->skilllayanan = $value->skilllayanan;
            $model->skilllayanan_txt = $value->nm_skilllayanan;
            $model->level_sap = $sapprofile->trfar;
            $model->persa_sap = $value->persa;
            $model->skill_sap = $value->skilllayanan;
            $model->area_sap = $value->area;
            $model->jabatan_sap = $value->jabatan;
            $model->jabatan_sap_nm = $value->nm_jabatan;
            // $model->jenis_pro_sap = $value->jenis_pro_sap;
            // $model->skema_sap = $value->skema_sap;
            $model->abkrs_sap = $sapprofile->abkrs;
            $model->hire_jabatan_sap = $hirejabatansap;
            // $model->zparam = $value->zparam;
            // $model->lup_skema = $value->lup_skema;
            // $model->upd_skema = $value->upd_skema;
            $model->finish_view_manar = $value->finish_view_manar;
            $model->idpktable = $value->id;
            $model->typejo = 2;
            $model->n_project = $value->nm_persa;
            $model->userpm = $value->userpm;
            $model->type_rekrut = 0;

            // var_dump($model);die;
            if($model->save(false)){
              if($confirm == 1){
                $modelupdflag = Transrincianlogupdate::find()->where(['id'=> $valueopsi->id])->one();
                $modelupdflag->statusupdate = 'done';
                $modelupdflag->save(false);
              }else{
                $modelupdflag = Transperner::find()->where(['id'=>$model->idpktable])->one();
                $modelupdflag->flagrekrut = 1;
                $modelupdflag->save();
              }
            }
          }
        }

    }
  
  
    public function actionUpdatedata()
    {
      $model = Transrincian::find()->where(['typejo'=> 2])->all();
      foreach ($model as $key => $value) {
        $modeltr = Transperner::find()->where(['id'=> $value->idpktable])->one();
        $modelsave = Transrincian::find()->where(['id'=> $value->id])->one();
        if($modeltr){
        if($modeltr->lup_skema){
          $modelsave->lup_skema = $modeltr->lup_skema;
          if($modelsave->save(false)){

          }else{
            echo "fail ".$modelsave->id;
          }
        }
        }

      }
      echo "done";
    }
  public function actionSyncdata2()
  {
      $modeltr = Transrincianori::find()->where(['flagrekrut'=> 1 , 'skema'=> 1])->all();
      if($modeltr){
        foreach ($modeltr as $key => $value) {
          $model = new Transrincianrekruttemp();
          $model->nojo = $value->nojo;
          $model->detail_komp = $value->detail_komp;
          $model->jabatan = $value->jabatan;
          $model->gender = $value->gender;
          $model->pendidikan =$value->pendidikan;
          $model->lokasi = $value->lokasi;
          $model->atasan = $value->atasan;
          $model->kontrak = $value->kontrak;
          $model->waktu = $value->waktu;
          $model->jumlah = $value->jumlah;
          $model->komentar = $value->komentar;
          $model->skema = $value->skema;
          $model->ket_done = $value->ket_done;
          $model->upd = $value->upd;
          $model->lup = $value->lup;
          $model->flag_jobs = $value->flag_jobs;
          $model->upd_jobs = $value->upd_jobs;
          $model->lup_jobs = $value->lup_jobs;
          $model->flag_app = $value->flag_app;
          $model->upd_app = $value->upd_app;
          $model->ket_rej = $value->ket_rej;
          if($value->status_rekrut == 2){
            $model->status_rekrut = $value->status_rekrut;
          }
          $model->ket_rekrut = $value->ket_rekrut;
          $model->upd_rekrut = $value->upd_rekrut;
          $model->pic_hi = $value->pic_hi;
          $model->n_pic_hi = $value->n_pic_hi;
          $model->pic_manar = $value->pic_manar;
          $model->n_pic_manar = $value->n_pic_manar;
          $model->pic_rekrut = $value->pic_rekrut;
          $model->n_pic_rekrut = $value->n_pic_rekrut;
          $model->level = $value->level;
          $model->level_txt = $value->level_txt;
          $model->skilllayanan = $value->skilllayanan;
          $model->skilllayanan_txt = $value->skilllayanan_txt;
          $model->level_sap = $value->level_sap;
          $model->persa_sap = $value->persa_sap;
          $model->skill_sap = $value->skill_sap;
          $model->area_sap = $value->area_sap;
          $model->jabatan_sap = $value->jabatan_sap;
          $model->jabatan_sap_nm = $value->jabatan_sap_nm;
          $model->jenis_pro_sap = $value->jenis_pro_sap;
          $model->skema_sap = $value->skema_sap;
          $model->abkrs_sap = $value->abkrs_sap;
          $model->hire_jabatan_sap = $value->hire_jabatan_sap;
          $model->zparam = $value->zparam;
          $model->lup_skema = $value->lup_skema;
          $model->upd_skema = $value->upd_skema;
          $model->finish_view_manar = $value->finish_view_manar;
          $model->idpktable = $value->id;
          $model->typejo = 1;
          if($value->train_soft){
            $model->train_soft = $value->train_soft;
          }
          if($value->train_hard){
            $model->train_hard = $value->train_hard;
          }
          if($value->tendem_aktif){
            $model->tendem_aktif = $value->tendem_aktif;
          }
          if($value->tendem_pasif){
            $model->tendem_pasif = $value->tendem_pasif;
          }
          $checkjo = Transjo::find()->where(['nojo'=> $value->nojo])->one();
          if($checkjo){
          $model->n_project = ($checkjo->n_project == '' || $checkjo->n_project == 'Pilih' || $checkjo->n_project == null)?$checkjo->project : $checkjo->n_project;
          }
          if($model->save()){
            $modelupdflag = Transrincianori::find()->where(['id'=>$model->idpktable])->one();
            $modelupdflag->flagrekrut = 1;
            $modelupdflag->save();
          }

        }
        echo "data rincian update ";
      }else{
        echo "no data rincian update ";
      }

      $modeltp = Transperner::find()->where(['flagrekrut'=> 1, 'skema'=> 1 ])->all();
      if($modeltp){
      foreach ($modeltp as $key => $value) {
        if (is_numeric($value->perner)){
          $curl = new curl\Curl();
          $getsapprofile = $curl->setPostParams([
            'perner' => $value->perner,
            'token' => 'ish**2019',
          ])
          ->post('http://192.168.88.5/service/index.php/sap_profile/getdataperner');
          $sapprofile  = json_decode($getsapprofile);
          // var_dump($sapprofile->platx);die;
          $model = new Transrincianrekruttemp();
          $model->nojo = $value->nojo;
          $model->detail_komp = '';
          $model->jabatan = $value->nm_jabatan;
          $model->gender = '-';
          $model->pendidikan ='-';
          $model->lokasi = $value->area;
          $model->atasan = '';
          $model->kontrak = $sapprofile->anstt;
          $model->waktu = '';
          $model->jumlah = '1';
          $model->komentar = '';
          $model->skema = $value->skema;
          $model->ket_done = $value->ket_done;
          $model->upd = $value->upd;
          $model->lup = $value->lup;
          $model->flag_jobs = '';
          $model->upd_jobs = '';
          $model->lup_jobs = '';
          $model->flag_app = 0;
          if($value->status_rekrut == 2){
            $model->status_rekrut = $value->status_rekrut;
          }
          // $model->level = $value->level;
          // $model->level_txt = $value->level_txt;
          $model->skilllayanan = $value->skilllayanan;
          $model->skilllayanan_txt = $value->nm_skilllayanan;
          $model->level_sap = $sapprofile->trfar;
          $model->persa_sap = $value->persa;
          $model->skill_sap = $value->skilllayanan;
          $model->area_sap = $value->area;
          $model->jabatan_sap = $sapprofile->value1;
          $model->jabatan_sap_nm = $sapprofile->value2;
          // $model->jenis_pro_sap = $value->jenis_pro_sap;
          // $model->skema_sap = $value->skema_sap;
          $model->abkrs_sap = $sapprofile->abkrs;
          $model->hire_jabatan_sap = $sapprofile->value1;
          // $model->zparam = $value->zparam;
          // $model->lup_skema = $value->lup_skema;
          // $model->upd_skema = $value->upd_skema;
          $model->finish_view_manar = $value->finish_view_manar;
          $model->idpktable = $value->id;
          $model->typejo = 2;
          $model->n_project = $value->nm_persa;
          if($model->save()){
            $modelupdflag = Transperner::find()->where(['id'=>$model->idpktable])->one();
            $modelupdflag->flagrekrut = 1;
            $modelupdflag->save();
          }
        }
      }
        echo "data perner update ";
      }else{
        echo "no data perner update ";
      }
  }



  protected function findModel($id)
  {
      if (($model = Transrincianrekrut::findOne($id)) !== null) {
          return $model;
      } else {
          throw new NotFoundHttpException('The requested page does not exist.');
      }
  }
}
