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
                'only' => ['index', 'update', 'create', 'view', 'getcity', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'update', 'create', 'view', 'getcity', 'delete'],
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

    public function actionTestemail()
    {
        $to[] = 'khusnul.hisyam@ish.co.id';
        $to[] = 'seysi.lupi@ish.co.id';
        //170
        // $subject = 'Pemberitahuan PT Infomedia Solusi Humanika';
        // $body = Yii::$app->params['mailFeedback'];
        //
        // $subject = 'Notifikasi Approval Resign Pekerja';
        // $subject = 'Notifikasi Cancel Join SAP Admin';
        // $subject = 'Notifikasi Approval Perubahan Data Pekerja';
        // $subject = 'Notifikasi Approval Perubahan Data Bank';
        // $body = 'Semangat Pagi,,
        //     <br>
        //     Anda mendapatkan permintaan Approval SUBJECT dari <span style="text-transform: uppercase;"><b>Nama Pembuat</b></span> dengan rincian sebagai berikut :
        //     <br>
        //     <br>
        //     <table>
        //     <tr>
        //     <td valign="top">Nama Pekerja</td>
        //     <td valign="top">:</td>
        //     <td valign="top">User Demo</td>
        //     </tr>
        //     <tr>
        //     <td valign="top">Perner</td>
        //     <td valign="top">:</td>
        //     <td valign="top">1231234</td>
        //     </tr>
        //     <tr>
        //     <td valign="top">Nama Project</td>
        //     <td valign="top">:</td>
        //     <td valign="top">Nama Project</td>
        //     </tr>
        //     <tr>
        //     <td valign="top">Area</td>
        //     <td valign="top">:</td>
        //     <td valign="top">Area</td>
        //     </tr>
        //     <tr>
        //     <td valign="top">Jabatan</td>
        //     <td valign="top">:</td>
        //     <td valign="top">Jabatan</td>
        //     </tr>
        //     <tr>
        //     </table>
        //     <br>
        //     <br>
        //     Silakan masuk ke link <a href="https://gojobs.id">gojobs.id</a> untuk melakukan verifikasi lebih lanjut.
        //     <br><br>
        //     Have a great day !
        //     ';
        // //
        // $subject = 'Notifikasi Approval Cancel Join Pekerja';
        // $body = 'Semangat Pagi,
        //     <br>
        //     Anda mendapatkan permintaan "Cancel Join Pekerja" dan Hapus Perner dari <span style="text-transform: uppercase;"><b>Nama Pembuat</b></span> dengan rincian sebagai berikut :

        //     <br>
        //     <br>
        //     <table>
        //     <tr>
        //     <td valign="top">Nama Pekerja</td>
        //     <td valign="top">:</td>
        //     <td valign="top">Nama Pekerja</td>
        //     </tr>
        //     <tr>
        //     <td valign="top">Perner</td>
        //     <td valign="top">:</td>
        //     <td valign="top">1231234</td>
        //     </tr>
        //     <tr>
        //     <td valign="top">Nama Project</td>
        //     <td valign="top">:</td>
        //     <td valign="top">Nama Layanan/ Project</td>
        //     </tr>
        //     <tr>
        //     <td valign="top">Area</td>
        //     <td valign="top">:</td>
        //     <td valign="top">Area</td>
        //     </tr>
        //     <tr>
        //     <td valign="top">Jabatan</td>
        //     <td valign="top">:</td>
        //     <td valign="top">Jabatan</td>
        //     </tr>
        //     <tr>
        //     <td valign="top">Reason</td>
        //     <td valign="top">:</td>
        //     <td valign="top">Reason</td>
        //     </tr>
        //     <tr>
        //     </table>
        //     <br>
        //     <br>
        //     Silakan masuk ke link <a href="https://gojobs.id">gojobs.id</a> Sub Menu Cancel Join untuk melakukan (confirmation) dan menghapus perner di SAP.
        //     <br><br>
        //     Terima Kasih !
        //     ';
        // //
        // $subject = 'Notifikasi Approval Hiring Gojobs';
        // $body = 'Semangat Pagi,,
        //         <br>
        //         Anda mendapatkan permintaan Approval Hiring untuk :

        //         <br>
        //         <br>
        //         <table>
        //         <tr>
        //         <td valign="top">Nama</td>
        //         <td valign="top">:</td>
        //         <td valign="top">Fullname</td>
        //         </tr>
        //         <tr>
        //         <td valign="top">No Jo</td>
        //         <td valign="top">:</td>
        //         <td valign="top">NOJO</td>
        //         </tr>
        //         <tr>
        //         <td valign="top">Personal Area</td>
        //         <td valign="top">:</td>
        //         <td valign="top">Layanan/ Project</td>
        //         </tr>
        //         <tr>
        //         <td valign="top">Area</td>
        //         <td valign="top">:</td>
        //         <td valign="top">Area</td>
        //         </tr>
        //         <tr>
        //         <td valign="top">Skill layanan</td>
        //         <td valign="top">:</td>
        //         <td valign="top">Skill</td>
        //         </tr>
        //         <tr>
        //         <td valign="top">Payroll Area</td>
        //         <td valign="top">:</td>
        //         <td valign="top">Payroll Area</td>
        //         </tr>
        //         <tr>
        //         <td valign="top">Jabatan</td>
        //         <td valign="top">:</td>
        //         <td valign="top">Jabatan</td>
        //         </tr>
        //         <tr>
        //         <td valign="top">Level</td>
        //         <td valign="top">:</td>
        //         <td valign="top">Level</td>
        //         </tr>
        //         </table>
        //         <br>
        //         <br>
        //         Silakan masuk ke link gojobs.id untuk melakukan verifikasi lebih lanjut.
        //         <br><br>
        //         Have a great day !
        //         ';
        // // 
        // $subject = 'Undangan Note:Keperluan PT Infomedia Solusi Humanika';
        // $body = '
        //     <table>
        //     <tr>
        //     <td valign="top">No Undangan</td>
        //     <td valign="top">:</td>
        //     <td valign="top">Invitation Number</td>
        //     </tr>
        //     </table>
        //     <br>
        //     <br>
        //     Semangat Pagiii..
        //     <br>
        //     <br>
        //     Hallo Sdr/i Fullname .. ,
        //     <br>
        //     <br>
        //     PT Infomedia Solusi Humanika (ISH) mengucapkan selamat kepada anda yang telah lulus seleksi dokumen untuk posisi pekerjaan posisi "Jabatan", dan lokasi kerja di "Area"

        //     <br>
        //     <br>
        //     Selanjutnya anda diminta untuk mengerjakan psikotest online dengan panduan sebagi berikut :
        //     <br>
        //     <br>
        //     1.Psikotes online dikerjakan menggunakan ponsel pintar, pastikan jaringan akses internet bagus dan paket data tersedia<
        //     <br>
        //     2.Waktu pengerjaan psikotes adalah 30 menit sehingga pastikan anda bebas dari gangguan selama mengerjakan psikotes
        //     <br>
        //     3.Untuk memulai psikotes online, silahkan klik http://app.hipotest.com
        //     <br>
        //     4.Selanjutnya anda diminta untuk melakukan Registrasi & Login sesuai dengan ketentuan pada website tersebut
        //     <br>
        //     5.Untuk memulai Tes, masukkan kode token : Token
        //     <br>
        //     6.Anda diminta untuk mengerjakan seluruh rangkaian psikotes
        //     <br>
        //     <br>
        //     <i>  PERHATIAN !</i>
        //     <br>
        //     <br>
        //     <i>  Pengerjaan psikotes ini WAJIB DISELESAIKAN sebelum (H+2 dari Tanggal Pengajuan) dan pukul 24.00. </i>
        //     <br>
        //     <br>
        //     <i>  Selamat Mengerjakan.. </i>
        //     <br>
        //     Salam,
        //     <br>
        //     <br>
        //     HR Process - PT Infomedia Solusi Humanika (ISH)
        //     <br>
        //     <br>
        //     <br>
        //     <b>
        //     Talented and Qualified People| Solid-Speed-Smart
        //     </b>
        //     ';

        // $body = 'Yth Fullname .. ,
        // <br>
        // Sdr/i PT. Infomedia Solusi Humanika Mengundang anda untuk Note:keperluan posisi "Jabatan", Pada :

        //     <br>
        //     <br>
        //     <table>
        //     <tr>
        //     <td valign="top">No Undangan</td>
        //     <td valign="top">:</td>
        //     <td valign="top">Nomor</td>
        //     </tr>
        //     <tr>
        //     <td valign="top">Hari</td>
        //     <td valign="top">:</td>
        //     <td valign="top">Hari</td>
        //     </tr>
        //     <tr>
        //     <td valign="top">Pukul</td>
        //     <td valign="top">:</td>
        //     <td valign="top">Pukul 00:00</td>
        //     </tr>
        //     <tr>
        //     <td valign="top">Bertemu</td>
        //     <td valign="top">:</td>
        //     <td valign="top">Nama PIC</td>
        //     </tr>
        //     <tr>
        //     <td valign="top">Alamat</td>
        //     <td valign="top">:</td>
        //     <td valign="top">Office Link Office</td>
        //     </tr>
        //     <tr>
        //     <td valign="top">Ruangan</td>
        //     <td valign="top">:</td>
        //     <td valign="top">Room</td>
        //     </tr>
        //     <tr>
        //     <td valign="top">Lantai</td>
        //     <td valign="top">:</td>
        //     <td valign="top">Lantai</td>
        //     </tr>

        //     </table>
        //     <br>
        //     <br>
        //     <i>  -- Note : Dgn Menggunakan Pakaian Formal Rapih ( No Jeans ) dan Membawa CV dan Lamaran Kerja Lengkapnya . -- </i>
        //     <br>
        //     <i>  Konfirmasi dengan sms ke no :Nomor Telepon  </i>
        //     <br>
        //     <i> Info Kelengkapan Data</i>
        //     ';
        // 
        $subject = 'Informasi hasil seleksi PT Infomedia Solusi Humanika';
        $body = 'Yth Fullname .. ,
            <br>
            Sdr/i PT. Infomedia Solusi Humanika ingin menginformasikan bahwa anda lolos tahap seleksi Interview dan Psikotest untuk posisi "Nama Jabatan".
            <br>
            <br>

            Sebelumnya mohon untuk melengkapi data Kelengkapan Data pada sistem kami dengan melakukan login pada http://gojobs.id/
            ';
        // 
        // $body = str_replace('{fullname}', 'User Demo', $body);
        $verification = Yii::$app->utils->sendmail($to, $subject, $body, 11); //11 -> Candidate Feedback
        if ($verification) {
            echo 'succesfully';
        } else {
            echo 'not succesfully';
        }
    }

    public function actionGetcity()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            $provinsiid = empty($parents[0]) ? null : $parents[0];
            $model = Mastercity::find()->asArray()->where(['provinsiid' => $provinsiid])->all();
            $selected  = null;
            if ($parents != null && count($model) > 0) {
                $selected = '';
                $id1 = '';
                if (!empty($_POST['depdrop_params'])) {
                    $params = $_POST['depdrop_params'];
                    $id1 = $params[0]; // get the value of model_id1
                    foreach ($model as $key => $value) {
                        $out[] = ['id' => $value['kotaid'], 'name' => $value['kota']];
                        $oc[] = $value['kotaid'];
                        if ($key == 0) {
                            $aux = $value['kotaid'];
                        }
                    }
                    ((in_array($id1, $oc))) ? $selected = $id1 : $selected = $aux;
                }
                echo Json::encode(['output' => $out, 'selected' => $selected]);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
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
