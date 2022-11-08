<?php

namespace app\controllers;

use Yii;
use app\models\Changehiring;
use app\models\Changehiringsearch;
use app\models\Crdtransaction;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Hiring;
use app\models\Userprofile;
use app\models\Transrincian;
use app\models\Masterreasonchangehiring;
use app\models\Recruitmentcandidate;
use app\models\Userabout;
use yii\helpers\ArrayHelper;
use linslin\yii2\curl;
use yii\helpers\Json;

/**
 * ChangehiringController implements the CRUD actions for Changehiring model.
 */
class ChangehiringController extends Controller
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
                            return (Yii::$app->utils->permission(Yii::$app->user->identity->role, 'm93'));
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
     * Lists all Changehiring models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Changehiringsearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Changehiring model.
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
     * Creates a new Changehiring model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id = null)
    {
        $reason = ArrayHelper::map(Masterreasonchangehiring::find()->asArray()->all(), 'id', 'reason');
        if ($id) {
            $model = $this->findModel($id);
            $dataquery = Hiring::find()
                // ->joinWith(['userprofile'])
                ->joinWith(['changehiring'])
                ->andWhere(['statushiring' => 4])
                ->andWhere(['statusbiodata' => 4])
                ->andWhere([
                    'or',
                    ['changehiring.userid' => null],
                    ['changehiring.status' => 4],
                    ['hiring.userid' => $model->userid],
                ])->orderBy([
                    'hiring.perner' => SORT_DESC])->all();
            $data = array();
            foreach ($dataquery as $key => $value) {
                if ($value->changehiring) {
                    $checkdraft =  Changehiring::find()
                        ->andWhere(['userid' => $value->userid])
                        ->andWhere([
                            'or',
                            ['status' => 1],
                            ['status' => 6],
                        ])
                        ->count();
                    if ($value->userid == $model->userid) {
                        $data[$value->userid] =  $value->perner;
                    }
                    if ($value->changehiring->status == 4 && $checkdraft == 0) {
                        $data[$value->userid] =  $value->perner;
                    }
                } else {
                    $data[$value->userid] =  $value->perner;
                }
            }
        } else {
            $getid = new Changehiring();
            $getid->createtime = date('Y-m-d H-i-s');
            $getid->updatetime = date('Y-m-d H-i-s');
            $getid->createdby = Yii::$app->user->identity->id;
            $getid->save(false);
            return $this->redirect(['create', 'id' => $getid->id]);
        }

        $model->scenario = 'createupdate';
        if ($model->load(Yii::$app->request->post())) {
            $model->status = 2;
            $model->remarks = "Process";
            // var_dump($model->userid);die();
            //existingmodel
            $hiring = Hiring::find()->where(['userid' => $model->userid, 'statushiring' => 4])->one();
            if ($model->typechangehiring == 1) {
                $modelrecreq = Transrincian::find()->where(['id' => $hiring->recruitreqid])->one();
                $model->oldrecruitreqid = $modelrecreq->id;
            } elseif ($model->typechangehiring == 2) {
                $modelrecreq = Transrincian::find()->where(['id' => $hiring->recruitreqid])->one();
                $newhiring = Hiring::find()->where(['userid' => $model->newuserid, 'statushiring' => 4])->one();
                $modelnewrecreq = Transrincian::find()->where(['id' => $newhiring->recruitreqid])->one();
                $model->oldrecruitreqid = $modelnewrecreq->id;
                $model->recruitreqid = $modelrecreq->id;
            } elseif ($model->typechangehiring == 3) {
                $model->oldtglinput = $hiring->tglinput;
            } elseif ($model->typechangehiring == 4) {
                $model->oldawalkontrak = $hiring->awalkontrak;
                $model->oldakhirkontrak = $hiring->akhirkontrak;
            } else {
                return 0;
            }
            $modelrecreq = Transrincian::find()->where(['id' => $hiring->recruitreqid])->one();
            $userprofile = Userprofile::find()->where(['userid' => $model->userid])->one();
            if ($model->save()) {
                $name = $userprofile->fullname;
                $perner = $hiring->perner;
                if ($modelrecreq->transjo->n_project == "" || $modelrecreq->transjo->n_project == "Pilih") {
                    $layanan = $modelrecreq->transjo->project;
                } else {
                    $layanan = $modelrecreq->transjo->n_project;
                }
                if (Yii::$app->utils->getarea($modelrecreq->area_sap)) {
                    $area = Yii::$app->utils->getarea($modelrecreq->area_sap);
                } else {
                    $area = '-';
                }
                if (Yii::$app->utils->getskilllayanan($modelrecreq->skill_sap)) {
                    $skill = Yii::$app->utils->getskilllayanan($modelrecreq->skill_sap);
                } else {
                    $skill = '-';
                }
                if (Yii::$app->utils->getjabatan($modelrecreq->hire_jabatan_sap)) {
                    $jabatan = Yii::$app->utils->getjabatan($modelrecreq->hire_jabatan_sap);
                } else {
                    $jabatan = '-';
                }
                $curl = new curl\Curl();
                $getlevels = $curl->setPostParams([
                    'level' => $modelrecreq->level_sap,
                    'token' => 'ish**2019',
                ])->post('http://192.168.88.5/service/index.php/sap_profile/getlevel');
                $level  = json_decode($getlevels);
                $level = ($level) ? $level : "";

                //condition scheme 1-4
                if ($model->typechangehiring == 1) { //perubahan no jo
                    //replacemodel
                    $modelnewrecreq = Transrincian::find()->where(['id' => $model->recruitreqid])->one();
                    //existingmodel
                    if ($modelnewrecreq->transjo) {
                        $newlayanan = $modelnewrecreq->transjo->n_project;
                    } else {
                        $newlayanan = '-';
                    }
                    // var_dump($newlayanan);die();
                    if (Yii::$app->utils->getarea($modelnewrecreq->area_sap)) {
                        $newarea = Yii::$app->utils->getarea($modelnewrecreq->area_sap);
                    } else {
                        $newarea = '-';
                    }
                    if (Yii::$app->utils->getskilllayanan($modelnewrecreq->skill_sap)) {
                        $newskill = Yii::$app->utils->getskilllayanan($modelnewrecreq->skill_sap);
                    } else {
                        $newskill = '-';
                    }
                    if (Yii::$app->utils->getjabatan($modelnewrecreq->hire_jabatan_sap)) {
                        $newjabatan = Yii::$app->utils->getjabatan($modelnewrecreq->hire_jabatan_sap);
                    } else {
                        $newjabatan = '-';
                    }

                    $to = 'khusnul.hisyam@ish.co.id'; //mailtesting
                    // $to = 'proman@ish.co.id';
                    $subject = 'Notifikasi Approval Change No JO Pekerja';
                    $body = Yii::$app->params['mailChangeschema1']; //cek body in utilcomponent -> params
                    $body = str_replace('{creator}', $model->createduser->name, $body);
                    //existing
                    $body = str_replace('{fullname}', $name, $body);
                    $body = str_replace('{oldrecruitreqid}', $modelrecreq->nojo, $body);
                    $body = str_replace('{perner}', $perner, $body);
                    $body = str_replace('{layanan}', $layanan, $body);
                    $body = str_replace('{skill}', $skill, $body);
                    $body = str_replace('{area}', $area, $body);
                    $body = str_replace('{jabatan}', $jabatan, $body);
                    $body = str_replace('{level}', $level, $body);
                    //replacement
                    $body = str_replace('{recruitreqid}', $modelnewrecreq->nojo, $body);
                    $body = str_replace('{newlayanan}', $newlayanan, $body);
                    $body = str_replace('{newarea}', $newarea, $body);
                    $body = str_replace('{newskill}', $newskill, $body);
                    $body = str_replace('{newjabatan}', $newjabatan, $body);
                    $body = str_replace('{reason}', $model->changehiringreason->reason, $body);
                    // var_dump($body);die();
                    // $sendmail = Yii::$app->utils->sendmail($to, $subject, $body, 21);
                } elseif ($model->typechangehiring == 2) { //swap jo
                    //replacemodel
                    $modelnewrecreq = Transrincian::find()->where(['id' => $model->recruitreqid])->one();
                    //existingmodel
                    if ($modelnewrecreq->transjo) {
                        $newlayanan = $modelnewrecreq->transjo->n_project;
                    } else {
                        $newlayanan = '-';
                    }
                    // var_dump($newlayanan);die();
                    if (Yii::$app->utils->getarea($modelnewrecreq->area_sap)) {
                        $newarea = Yii::$app->utils->getarea($modelnewrecreq->area_sap);
                    } else {
                        $newarea = '-';
                    }
                    if (Yii::$app->utils->getskilllayanan($modelnewrecreq->skill_sap)) {
                        $newskill = Yii::$app->utils->getskilllayanan($modelnewrecreq->skill_sap);
                    } else {
                        $newskill = '-';
                    }
                    if (Yii::$app->utils->getjabatan($modelnewrecreq->hire_jabatan_sap)) {
                        $newjabatan = Yii::$app->utils->getjabatan($modelnewrecreq->hire_jabatan_sap);
                    } else {
                        $newjabatan = '-';
                    }

                    $to = 'khusnul.hisyam@ish.co.id'; //mailtesting
                    // $to = 'proman@ish.co.id';
                    $subject = 'Notifikasi Approval Swap JO Pekerja';
                    $body = Yii::$app->params['mailChangeschema2']; //cek body in utilcomponent -> params
                    $body = str_replace('{creator}', $model->createduser->name, $body);
                    //existing
                    $body = str_replace('{fullname}', $name, $body);
                    $body = str_replace('{oldrecruitreqid}', $modelrecreq->nojo, $body);
                    $body = str_replace('{perner}', $perner, $body);
                    $body = str_replace('{layanan}', $layanan, $body);
                    $body = str_replace('{skill}', $skill, $body);
                    $body = str_replace('{area}', $area, $body);
                    $body = str_replace('{jabatan}', $jabatan, $body);
                    $body = str_replace('{level}', $level, $body);
                    //replacement
                    $body = str_replace('{recruitreqid}', $modelnewrecreq->nojo, $body);
                    $body = str_replace('{newlayanan}', $newlayanan, $body);
                    $body = str_replace('{newarea}', $newarea, $body);
                    $body = str_replace('{newskill}', $newskill, $body);
                    $body = str_replace('{newjabatan}', $newjabatan, $body);
                    $body = str_replace('{reason}', $model->changehiringreason->reason, $body);
                    // var_dump($body);die();
                    $sendmail = Yii::$app->utils->sendmail($to, $subject, $body, 22);
                } elseif ($model->typechangehiring == 3) { //ganti tanggal hiring
                    $to = 'khusnul.hisyam@ish.co.id'; //mailtesting
                    // $to = 'proman@ish.co.id';
                    $subject = 'Notifikasi Approval Date Hiring';
                    $body = Yii::$app->params['mailChangeschema3']; //cek body in utilcomponent -> params
                    $body = str_replace('{recruitreqid}', $modelrecreq->nojo, $body);
                    $body = str_replace('{creator}', $model->createduser->name, $body);
                    $body = str_replace('{fullname}', $name, $body);
                    $body = str_replace('{perner}', $perner, $body);
                    $body = str_replace('{layanan}', $layanan, $body);
                    $body = str_replace('{area}', $area, $body);
                    $body = str_replace('{jabatan}', $jabatan, $body);
                    $body = str_replace('{level}', $level, $body);
                    $body = str_replace('{reason}', $model->changehiringreason->reason, $body);
                    $body = str_replace('{hiringdate}', $model->awalkontrak, $body);
                    $body = str_replace('{newhiringdate}', $model->akhirkontrak, $body);
                    $sendmail = Yii::$app->utils->sendmail($to, $subject, $body, 23);
                } elseif ($model->typechangehiring == 4) { //ganti periode kontrak
                    $to = 'khusnul.hisyam@ish.co.id'; //mailtesting
                    // $to = 'proman@ish.co.id';
                    $subject = 'Notifikasi Approval Contract Periode';
                    $body = Yii::$app->params['mailChangeschema4']; //cek body in utilcomponent -> params
                    $body = str_replace('{recruitreqid}', $modelrecreq->nojo, $body);
                    $body = str_replace('{creator}', $model->createduser->name, $body);
                    $body = str_replace('{fullname}', $name, $body);
                    $body = str_replace('{perner}', $perner, $body);
                    $body = str_replace('{layanan}', $layanan, $body);
                    $body = str_replace('{area}', $area, $body);
                    $body = str_replace('{jabatan}', $jabatan, $body);
                    $body = str_replace('{level}', $level, $body);
                    $body = str_replace('{reason}', $model->changehiringreason->reason, $body);
                    $body = str_replace('{awalkontrak}', $model->awalkontrak, $body);
                    $body = str_replace('{akhirkontrak}', $model->akhirkontrak, $body);
                    $body = str_replace('{oldawalkontrak}', $model->oldawalkontrak, $body);
                    $body = str_replace('{oldakhirkontrak}', $model->oldakhirkontrak, $body);
                    $sendmail = Yii::$app->utils->sendmail($to, $subject, $body, 24);
                } else {
                    Yii::$app->session->setFlash('error', "Data Salah & Email Approval Tidak Terkirim, silakan cek data kembali.");
                    return $this->redirect(['index']);
                }
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'data' => $data,
                'reason' => $reason,
            ]);
        }
    }

    /**
     * Updates an existing Changehiring model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        return $this->redirect(['create', 'id' => $id]);
    }

    public function actionApprove($id)
    {
        $model = $this->findModel($id);
        $userid = $model->userid;
        $userprofile = Userprofile::find()->where(['userid' => $userid])->one();
        $hiring = Hiring::find()->where(['userid' => $userid])->one();
        $modelrecreq = Transrincian::find()->where(['id' => $hiring->recruitreqid])->one();
        $modelreccan = Recruitmentcandidate::find()->where(['userid' => $userid, 'recruitreqid' => $model->recruitreqid])->one();
        $model->scenario = 'approve';
        if ($model->load(Yii::$app->request->post())) {
            $model->approvedtime = date('Y-m-d H-i-s');
            if ($model->status == 8) { //approve -> check form
                // var_dump('dd');die;
                // $hiring->statusbiodata = 0;
                if ($model->typechangehiring == 1) {
                    $hiring->recruitreqid = $model->recruitreqid;
                    $modelreccan->recruitreqid = $model->recruitreqid;
                    if ($modelrecreq->status_rekrut == 2 ) {
                        $modelrecreq->status_rekrut = 1;
                    } elseif ($modelrecreq->status_rekrut == 4) {
                        $modelrecreq->status_rekrut = 3;
                    } else {
                        return 0;
                    }                    
                } elseif ($model->typechangehiring == 2) {
                    $newhiring = Hiring::find()->where(['userid' => $model->newuserid])->one();
                    $modelreccan->recruitreqid = $model->recruitreqid;
                    //swap JO
                    $hiring->recruitreqid = $model->oldrecruitreqid; //existing recruireqid replace to selected
                    $newhiring->recruitreqid = $model->recruitreqid; //selected recruireqid replace to existing
                } elseif ($model->typechangehiring == 3) {
                    $hiring->tglinput = $model->tglinput;
                } elseif ($model->typechangehiring == 4) {
                    $hiring->awalkontrak = $model->awalkontrak;
                    $hiring->akhirkontrak = $model->akhirkontrak;
                } else {
                    return 0;
                }
                
                $updatesap = $this->UpdateSapPersonaldata($id, $userid);
                var_dump($updatesap);die;
                if ($updatesap) {
                    $model->remarks = $updatesap;
                    $model->status = 6;
                    $model->save();
                } else {
                    $model->remarks = 'Successful';
                    $model->approvedtime = date('Y-m-d H-i-s');
                    $model->approvedby = Yii::$app->user->identity->id;
                    $model->save();
                }
            } else {
                $model->save();
            }
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('approve', [
                'model' => $model,
                'userprofile' => $userprofile,
            ]);
        }
    }

    /**
     * Updates an existing Changehiring model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */


    public function actionGetuserabout()
    {
        $userid = $_POST['userid'];
        $id = $_POST['id'];
        $updatecr = $this->findModel($id);
        if ($userid) {
            $cekhiring = Hiring::find()->where(['userid' => $userid, 'statushiring' => 4])->one();
            $perner = $cekhiring->perner;
            if ($cekhiring) {
                $getjo = Transrincian::find()->where(['id' => $cekhiring->recruitreqid])->one();
                $updatecr->userid = $cekhiring->userid;
                $name = $cekhiring->userprofile->fullname;
                $persa = (Yii::$app->utils->getpersonalarea($getjo->persa_sap)) ? Yii::$app->utils->getpersonalarea($getjo->persa_sap) : "";
                $area = (Yii::$app->utils->getarea($getjo->area_sap)) ? Yii::$app->utils->getarea($getjo->area_sap) : "";
                $skilllayanan = (Yii::$app->utils->getskilllayanan($getjo->skill_sap)) ? Yii::$app->utils->getskilllayanan($getjo->skill_sap) : "";
                $payrollarea = (Yii::$app->utils->getpayrollarea($getjo->abkrs_sap)) ? Yii::$app->utils->getpayrollarea($getjo->abkrs_sap) : "";
                $jabatan = (Yii::$app->utils->getjabatan($getjo->hire_jabatan_sap)) ? Yii::$app->utils->getjabatan($getjo->hire_jabatan_sap) : "";
                $curl = new curl\Curl();
                $getlevels = $curl->setPostParams([
                    'level' => $getjo->level_sap,
                    'token' => 'ish**2019',
                ])
                    ->post('http://192.168.88.5/service/index.php/sap_profile/getlevel');
                $level  = json_decode($getlevels);
                $level = ($level) ? $level : "";
                $hire = "Gojobs";
                $hiringdate = $cekhiring->tglinput;
                $cpstart = $cekhiring->awalkontrak;
                $cpend = $cekhiring->akhirkontrak;
                $updatecr->fullname = $name;
                $updatecr->perner = $cekhiring->perner;
            }
            $checkperner = Changehiring::find()->where('perner = ' . $perner . ' and status > 1 and status <> 5 and status <> 6')->one();
            if ($checkperner) {
                $checkperner = '';
            } else {
                $checkperner = 1;
                $updatecr->save(false);
            }

            $dataprofile = [
                'nojo' => $getjo->nojo,
                'perner' => $perner,
                'name' => $name,
                'persa' => $persa,
                'area' => $area,
                'skilllayanan' => $skilllayanan,
                'payrollarea' => $payrollarea,
                'jabatan' => $jabatan,
                'level' => $level,
                'hire' => $hire,
                'hiringdate' => $hiringdate,
                'cpstart' => $cpstart,
                'cpend' => $cpend,
                'checkperner' => $checkperner,
            ];
        } else {
            $dataprofile = '';
        }
        return Json::encode($dataprofile);
    }

    public function actionGetnewuserabout()
    {
        $userid = $_POST['newuserid'];
        $id = $_POST['id'];
        $updatecr = $this->findModel($id);
        if ($userid) {
            $cekhiring = Hiring::find()->where(['userid' => $userid, 'statushiring' => 4])->one();
            $perner = $cekhiring->perner;
            if ($cekhiring) {
                $getjo = Transrincian::find()->where(['id' => $cekhiring->recruitreqid])->one();
                $updatecr->userid = $cekhiring->userid;
                $name = $cekhiring->userprofile->fullname;
                $persa = (Yii::$app->utils->getpersonalarea($getjo->persa_sap)) ? Yii::$app->utils->getpersonalarea($getjo->persa_sap) : "";
                $area = (Yii::$app->utils->getarea($getjo->area_sap)) ? Yii::$app->utils->getarea($getjo->area_sap) : "";
                $skilllayanan = (Yii::$app->utils->getskilllayanan($getjo->skill_sap)) ? Yii::$app->utils->getskilllayanan($getjo->skill_sap) : "";
                $payrollarea = (Yii::$app->utils->getpayrollarea($getjo->abkrs_sap)) ? Yii::$app->utils->getpayrollarea($getjo->abkrs_sap) : "";
                $jabatan = (Yii::$app->utils->getjabatan($getjo->hire_jabatan_sap)) ? Yii::$app->utils->getjabatan($getjo->hire_jabatan_sap) : "";
                $curl = new curl\Curl();
                $getlevels = $curl->setPostParams([
                    'level' => $getjo->level_sap,
                    'token' => 'ish**2019',
                ])
                    ->post('http://192.168.88.5/service/index.php/sap_profile/getlevel');
                $level  = json_decode($getlevels);
                $level = ($level) ? $level : "";
                $hire = "Gojobs";
                $updatecr->fullname = $name;
                $updatecr->perner = $cekhiring->perner;
            }
            $checkperner = Changehiring::find()->where('perner = ' . $perner . ' and status > 1 and status <> 5 and status <> 6')->one();

            if ($checkperner) {
                $checkperner = '';
            } else {
                $checkperner = 1;
                $updatecr->save(false);
            }

            $dataprofile = [
                'nojo' => $getjo->nojo,
                'perner' => $perner,
                'name' => $name,
                'persa' => $persa,
                'area' => $area,
                'skilllayanan' => $skilllayanan,
                'payrollarea' => $payrollarea,
                'jabatan' => $jabatan,
                'level' => $level,
                'hire' => $hire,
                'checkperner' => $checkperner,
            ];
        } else {
            $dataprofile = '';
        }
        return Json::encode($dataprofile);
    }

    public function actionGetnewrecruitreqid()
    {
        $newrecruitreqid = $_POST['recruitreqid'];
        if ($newrecruitreqid) {
            $getjo = Transrincian::find()->where(['id' => $newrecruitreqid])->one();
            $persa = (Yii::$app->utils->getpersonalarea($getjo->persa_sap)) ? Yii::$app->utils->getpersonalarea($getjo->persa_sap) : "";
            $area = (Yii::$app->utils->getarea($getjo->area_sap)) ? Yii::$app->utils->getarea($getjo->area_sap) : "";
            $skilllayanan = (Yii::$app->utils->getskilllayanan($getjo->skill_sap)) ? Yii::$app->utils->getskilllayanan($getjo->skill_sap) : "";
            $payrollarea = (Yii::$app->utils->getpayrollarea($getjo->abkrs_sap)) ? Yii::$app->utils->getpayrollarea($getjo->abkrs_sap) : "";
            $jabatan = (Yii::$app->utils->getjabatan($getjo->hire_jabatan_sap)) ? Yii::$app->utils->getjabatan($getjo->hire_jabatan_sap) : "";
            $curl = new curl\Curl();
            $getlevels = $curl->setPostParams([
                'level' => $getjo->level_sap,
                'token' => 'ish**2019',
            ])
                ->post('http://192.168.88.5/service/index.php/sap_profile/getlevel');
            $level  = json_decode($getlevels);
            $level = ($level) ? $level : "";

            $datarec = [
                'new_recruitreqid' => $newrecruitreqid,
                'new_persa' => $persa,
                'new_area' => $area,
                'new_skilllayanan' => $skilllayanan,
                'new_payrollarea' => $payrollarea,
                'new_jabatan' => $jabatan,
                'new_level' => $level,
            ];
        } else {
            $datarec = '';
        }
        // var_dump($datarec);die();
        return Json::encode($datarec);
    }

    public function actionRecreqlist($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $outs = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $wherecontent = $q;
            $query =  Transrincian::find()
                ->select(['trans_rincian_rekrut.id', 'trans_rincian_rekrut.nojo', 'trans_rincian_rekrut.jabatan', 'trans_rincian_rekrut.lokasi', 'projectrekrut' => 'trans_rincian_rekrut.n_project', 'job_function.name_job_function', 'trans_jo.type_replace', 'trans_jo.type_jo', 'trans_jo.n_project', 'trans_jo.project', 'mapping_city.city_name', 'sapjabatan' => 'sapjob.value2', 'trans_rincian_rekrut.hire_jabatan_sap', 'trans_rincian_rekrut.persa_sap', 'trans_rincian_rekrut.area_sap', 'trans_rincian_rekrut.skill_sap', 'level_sap' => 'trans_rincian_rekrut.level_sap', 'saparea' => 'saparea.value2', 'sappersa' => 'sappersonalarea.value2', 'sapskill' => 'sapskilllayanan.value2'])

                ->joinWith("jobfunc")
                ->joinWith("transjo")
                ->joinWith("city")
                ->joinWith("jabatansap")
                ->joinWith("areasap")
                ->joinWith("persasap")
                ->joinWith("skillsap")
                ->andWhere('trans_rincian_rekrut.skema = 1')
                ->andWhere([
                    'or',
                    ['LIKE', 'trans_rincian_rekrut.nojo', $wherecontent],
                    ['LIKE', 'trans_rincian_rekrut.id', $wherecontent],
                    ['LIKE', 'sapjob.value2', $wherecontent],
                    ['LIKE', 'saparea.value2', $wherecontent],
                    ['LIKE', 'sappersonalarea.value2', $wherecontent]
                ])
                ->orderBy([
                    'trans_rincian_rekrut.id' => SORT_DESC
                ])
                ->limit(200)
                ->asArray()->all();
            $out = null;
            foreach ($query as $key => $value) {
                $out[] = $value;
            }
            if ($out) {
                $outs['results'] = $out;
            } else {
                $outs['results'] = null;
            }
        } elseif ($id > 0) {
            $outs['results'] = ['id' => $id, 'text' => Transrincian::findOne($id)->nojo];
        } else {
            $outs['results'] = ['id' => ' ', 'text' => ' '];
        }
        // var_dump($outs);die;
        return $outs;
    }

    public function actionAutosave()
    {
        $id = $_POST['id'];
        $userid = $_POST['userid'];
        $changehiring = $_POST['changehiring'];
        $reason = $_POST['reason'];
        $type = $_POST['typechangehiring'];
        $userremarks = $_POST['userremarks'];
        if ($id) {
            $model = $this->findModel($id);
            $model->userid = $userid;
            $model->changehiring = $changehiring;
            $model->reason = $reason;
            $model->typechangehiring = $type;
            $model->remarks = "Draft";
            $model->userremarks = $userremarks;
            $model->save(false);
        }
    }

    /**
     * Deletes an existing Changehiring model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id)->delete();
        if ($model) {
            Yii::$app->session->setFlash('success', "Data Dihapus.");
            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('error', "Data Tidak Bisa Dihapus.");
            return $this->redirect(['index']);
        }
    }

    protected function UpdateSapPersonaldata($id, $userid)
    {
        $model = Hiring::find()->where(['userid' => $userid, 'statushiring' => 4])->one();
        $tglinputhiring = date_create($model->tglinput);
        $tglinput = date_format($tglinputhiring, 'd.m.Y');
        $userabout = Userabout::find()->where(['userid' => $model->userid])->one();
        $transrincian = Transrincian::find()->where(['id' => $model->recruitreqid])->one();
        $userprofile = Userprofile::find()->where(['userid' => $model->userid])->one();
        $birthdate = date_create($userprofile->birthdate);
        $tglinput = date_create($model->tglinput);
        $awalkontrak = date_create($model->awalkontrak);
        $akhirkontrak = date_create($model->akhirkontrak);
        $wedingdate = date_create($userprofile->weddingdate);
        $url = "http://192.168.88.60:8080/ish-rest/ZINFHRF_00025";
        if ($userprofile->gender == 'male') {
            $gender = '1';
            if ($userprofile->maritalstatus == 'married') {
                $spben = 'X';
            } else {
                $spben = '';
            }
        } else {
            $gender = '2';
            if ($userprofile->maritalstatus == 'married') {
                $spben = 'X';
            } else {
                $spben = '';
            }
        }
        if ($userprofile->religion == 'islam') {
            $agama = '01';
        } elseif ($userprofile->religion == 'christian') {
            $agama = '02';
        } elseif ($userprofile->religion == 'protestant') {
            $agama = '02';
        } elseif ($userprofile->religion == 'hindu') {
            $agama = '04';
        } elseif ($userprofile->religion == 'buddha') {
            $agama = '05';
        } elseif ($userprofile->religion == 'catholic') {
            $agama = '03';
        } else {
            $agama = '07';
        }
        if ($model->flaginfotype022 == 1 and $model->flaginfotype021 == 1) {
            if ($userprofile->maritalstatus == 'single') {
                $statuskawin = '0';
                $marrd = '';
                $marst = '';
                $infotype = ['0041', '0006', '0028', '0185', '0241', '0242', '0009', '0008', '0016', '0035', '0037'];
            } else {
                $statuskawin = '1';
                $marrd = 'X';
                $marst = 'X';
                $infotype = ['0002', '0041', '0006', '0028', '0185', '0241', '0242', '0009', '0008', '0016', '0035', '0037'];
            }
        } else if ($model->flaginfotype022 == 1) {
            if ($userprofile->maritalstatus == 'single') {
                $statuskawin = '0';
                $marrd = '';
                $marst = '';
                $infotype = ['0041', '0006', '0021', '0028', '0185', '0241', '0242', '0009', '0008', '0016', '0035', '0037'];
            } else {
                $statuskawin = '1';
                $marrd = 'X';
                $marst = 'X';
                $infotype = ['0002', '0041', '0006', '0021', '0028', '0185', '0241', '0242', '0009', '0008', '0016', '0035', '0037'];
            }
        } else if ($model->flaginfotype021 == 1) {
            if ($userprofile->maritalstatus == 'single') {
                $statuskawin = '0';
                $marrd = '';
                $marst = '';
                $infotype = ['0041', '0006', '0022', '0028', '0185', '0241', '0242', '0009', '0008', '0016', '0035', '0037'];
            } else {
                $statuskawin = '1';
                $marrd = 'X';
                $marst = 'X';
                $infotype = ['0002', '0041', '0006', '0022', '0028', '0185', '0241', '0242', '0009', '0008', '0016', '0035', '0037'];
            }
        } else {
            if ($userprofile->maritalstatus == 'single') {
                $statuskawin = '0';
                $marrd = '';
                $marst = '';
                $infotype = ['0041', '0006', '0021', '0022', '0028', '0185', '0241', '0242', '0009', '0008', '0016', '0035', '0037'];
            } else {
                $statuskawin = '1';
                $marrd = 'X';
                $marst = 'X';
                $infotype = ['0002', '0041', '0006', '0021', '0022', '0028', '0185', '0241', '0242', '0009', '0008', '0016', '0035', '0037'];
            }
        }

        if ($transrincian->kontrak == 'PKWT') {
            $cttyp = '02';
        } elseif ($transrincian->kontrak == 'PARTTIME' or $transrincian->kontrak == 'Part Time') {
            $cttyp = '09';
        } elseif ($transrincian->kontrak == 'MAGANG') {
            $cttyp = '10';
        } elseif ($transrincian->kontrak == 'KEMITRAAN') {
            $cttyp = '08';
        } elseif ($transrincian->kontrak == 'THL') {
            $cttyp = '07';
        } elseif ($transrincian->kontrak == 'PKWT-KEMITRAAN PB') {
            $cttyp = '11';
        }

        $request_data = [
            [
                'pernr' => "$model->perner",
                'inftypList' => $infotype,

                //data contract
                'p00016List' => [
                    [
                        'endda' => '31.12.9999',
                        'begda' => date_format($tglinput, 'd.m.Y'),
                        'operation' => 'INS',
                        'pernr' => "$model->perner",
                        'infty' => '0016',
                        'lfzfr' => '',
                        'lfzzh' => '',
                        'lfzso' => '',
                        'kgzfr' => '',
                        'kgzzh' => '',
                        'prbzt' => '',
                        'prbeh' => '',
                        'kdgfr' => '',
                        'kdgf2' => '',
                        'arber' => date_format($akhirkontrak, 'd.m.Y'),
                        'konsl' => '59',
                        'cttyp' => $cttyp,
                        'zwrkpl' => ''
                    ]
                ],
                'p00035List' => [
                    [
                        'endda' => '31.12.9999',
                        'begda' => date_format($tglinput, 'd.m.Y'),
                        'operation' => 'INS',
                        'pernr' => "$model->perner",
                        'infty' => '0035',
                        'subty' => 'Z1',
                        'itxex' => 'X',
                        'dat35' => date_format($awalkontrak, 'd.m.Y'),
                    ]
                ],

                //data joindate
                'p00041List' => [
                    [
                        'endda' => '',
                        'begda' => '',
                        'operation' => 'INS',
                        'pernr' => "$model->perner",
                        'infty' => '0041',
                        'dar01' => '01',
                        'dat01' => date_format($awalkontrak, 'd.m.Y'),
                        'dar02' => '',
                        'dat02' => ''
                    ]
                ],

            ]
        ];

        $json = json_encode($request_data);
        // var_dump($json);die;
        $headers  = [
            'Content-Type: application/json',
            'cache-control: no-cache"=',
        ];


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // var_dump('ok');die;
        $response = curl_exec($ch);

        curl_close($ch);
        $ret = json_decode($response);
        $log = array();
        if ($ret) {
            foreach ($ret as $key => $value) {
                if ($value->success <> TRUE) {
                    $log  = $value->message;
                }
            }
        } else {
            $log = 'error SAP';
        }

        return $log;
    }

    /**
     * Finds the Changehiring model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Changehiring the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Changehiring::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
