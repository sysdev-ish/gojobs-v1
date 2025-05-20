<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;
use app\models\RequestHoldJob;
use app\models\Transrincian;
use app\models\User;
use yii\db\Connection;

class HoldJobController extends Controller
{
    /**
     * Kirim email notifikasi ke PM jika end_date = hari ini
     */
    public function actionNotifyEndToday()
    {
        error_reporting(E_ALL);
        ini_set('memory_limit', '1028M');
        ini_set('max_execution_time', 300);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Asia/Jakarta');

        $db = new Connection(Yii::$app->db);
        $db->open();
        
        $dbjo = new Connection(Yii::$app->dbjo);
        $dbjo->open();

        $today = date('Y-m-d');

        $holdJobs = RequestHoldJob::find()
            ->where(['status' => 3]) // hanya status approved
            ->andWhere(['scheme_date_end' => $today])
            ->andWhere(['send_email_at' => null])
            ->all();

        if (empty($holdJobs)) {
            Console::output("✅ Tidak ada data hold job yang berakhir hari ini.");
            return;
        }

        foreach ($holdJobs as $value) {
            // relasi ke job order, pastikan sudah didefinisikan
            $dataJob = Transrincian::findOne($value->recruitreqid);
            $nojo = $dataJob->nojo ?? 'JO-UNKNOWN';
            $layanan = $dataJob->client->name ?? 'Client';
            $area = $dataJob->area->name ?? 'Area';
            $jabatan = $dataJob->position->name ?? 'Posisi';
            $stopReason = $value->getReasonText(); // atau mapping manual reason ID ke string

            $to = $value->recipient ?? 'khusnul.hisyam@ish.co.id';
            $subject = 'Notifikasi Re-Open Hold Job Order';

            // Template dari params
            $body = Yii::$app->params['notificationReOpenJob'];
            $body = str_replace('{nojo}', $nojo, $body);
            $body = str_replace('{client}', $layanan, $body);
            $body = str_replace('{area}', $area, $body);
            $body = str_replace('{job}', $jabatan, $body);
            $body = str_replace('{scheme_date_old}', $value->scheme_date_old, $body);
            $body = str_replace('{scheme_date_start}', $value->scheme_date_start, $body);
            $body = str_replace('{scheme_date_end}', $value->scheme_date_end, $body);
            $body = str_replace('{remarks}', $value->remarks, $body);
            $body = str_replace('{reason}', $stopReason, $body);

            $sendMail = Yii::$app->utils->sendmail($to, $subject, $body, 12);

            // update status hold job
            $this->updateFlagJobs($dataJob->id);

            if ($sendMail) {
                $value->restored_at = date('Y-m-d H:i:s');
                $value->send_email_at = date('Y-m-d H:i:s');
                $value->save(false);
                Console::output("📧 Email terkirim ke {$to} untuk Hold Job ID: {$value->id}");
            } else {
                Console::output("❌ Gagal mengirim email ke {$to} untuk Hold Job ID: {$value->id}");
            }
        }

        // Add this before the return statement
        $db->close();
        $dbjo->close();

        Console::output("🎯 Selesai proses notifikasi email hold job.");
    }

    public function getReasonName()
    {
        $reasons = [
            1 => 'Permintaan User/ Client',
            2 => 'Proyek Terkait Ditunda',
            3 => 'Kebutuhan Sumber Daya Manusia Ditinjau Ulang',
            4 => 'Prioritas Rekrutmen Berubah'
        ];

        return $reasons[$this->reason] ?? 'Lainnya';
    }

    private function updateFlagJobs($jobId)
    {
        Yii::$app->dbjo->createCommand()->update(
            'trans_rincian_rekrut',
            [
                'is_hold_jobs' => 0
            ],
            'id = :jobId'
        )->bindValue(':jobId', $jobId)->execute();
    }
}
