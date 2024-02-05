<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */
//
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Terms & Condition';
?>
<div class="careerfy-main-content">
    <div class="careerfy-main-section careerfy-about-text-full">
        <?php if ($bannerContent) {
            echo '<div class="container">' . $bannerContent->content . '</div>';
            // echo $bannerContent->content;
        } else {
            echo '
            <div class="container">
                <div class="careerfy-typo-wrap">
                    <div class="careerfy-about-text">
                        <h2>Ketentuan Penggunaan</h2>
                        <span class="careerfy-about-sub">Ketentuan Penggunaan Aplikasi Gojobs.</span>
                        <h5>Selamat datang di Gojobs.id yang disediakan oleh Infomedia Solusi Humanika ("ISH"). Ketentuan Penggunaan (“Ketentuan”) ini mengatur penggunaan layanan yang disediakan situs domain https://gojobs.id/ beserta seluruh situs sub-domain tersebut (“Situs”). Gojobs.id merupakan portal mencari pekerjaan.</h5>
                        <h5> Ketentuan ini merupakan perjanjian yang harus dibaca, dipahami, dan disetujui oleh pengunjung (selanjutnya disebut “Anda” atau “Pengguna”) sebelum mengakses dan/atau menggunakan Gojobs.id. Ketentuan ini dapat diubah dengan versi yang lebih baru sesuai dengan situasi dan kondisi yang terjadi. Perubahan yang dimaksud akan diinformasikan kepada Pengguna. Dengan mengakses dan menggunakan layanan manapun dari Gojobs.id, Anda setuju untuk terikat dengan Ketentuan ini. Anda dapat mengakses dan menggunakan Gojobs.id dengan cara yang diizinkan berdasarkan Ketentuan ini. Jika Pengguna tidak setuju dengan versi terbaru dari Ketentuan Pengguna, maka mohon untuk tidak menggunakan Gojobs.id.</h5>
                        <h5>Harap baca Ketentuan ini dengan cermat karena ketidakpatuhan apa pun dapat mengakibatkan tanggung jawab perdata atau pidana.</h5>
                    </div>
                </div>

                <div class="careerfy-section-title">
                    <h2>Ketentuan Penggunaan:</h2>
                </div>
                <div class="panel-group careerfy-accordion" id="accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="collapsed">
                                    <i class="careerfy-icon careerfy-arrows"></i>1. Penggunaan Umum
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                            <div class="panel-body" style="margin-left: 32px;">
                                <h6>
                                    Kecuali jika diizinkan oleh Infomedia Solusi Humanika, kami memberi Anda hak non-eksklusif, terbatas, dapat dibatalkan, tidak dapat disublisensikan, dan tidak dapat dialihkan untuk menggunakan Gojobs.id hanya untuk penggunaan non-komersial pribadi Anda.<br>
                                    Anda setuju bahwa Anda tidak akan, secara langsung atau tidak langsung:<br>
                                </h6>
                                <div style="margin-left: 12px">
                                    <ul>
                                        <li>
                                            <h6>
                                                Menggunakan Gojobs.id untuk tujuan komersial apa pun atau untuk kepentingan pihak ketiga mana pun (kecuali diizinkan oleh Infomedia Solusi Humanika), termasuk namun tidak terbatas pada menyewakan, menjual, menyewakan, atau secara langsung atau tidak langsung membebankan biaya kepada orang lain untuk penggunaan Gojobs.id;
                                            </h6>
                                        </li>
                                        <li>
                                            <h6>
                                                Menghapus, menghindari, merusak, memotong, menonaktifkan atau mengganggu fitur Gojobs.id;
                                            </h6>
                                        </li>
                                        <li>
                                            <h6>
                                                Mengakses, mengirimkan, atau menggunakan data apa pun yang bukan milik Anda, atau yang Anda tidak diizinkan secara sah untuk mengakses, mengirimkan, atau menggunakan;
                                            </h6>
                                        </li>
                                        <li>
                                            <h6>
                                                Menggambarkan secara salah atau membuat klaim palsu atau menyesatkan tentang Gojobs.id;
                                            </h6>
                                        </li>
                                        <li>
                                            <h6>
                                                Menggunakan Gojobs.id untuk aktivitas ilegal, tujuan yang melanggar hukum, atau tujuan yang dilarang oleh Ketentuan ini atau melanggar Ketentuan ini;
                                            </h6>
                                        </li>
                                        <li>
                                            <h6>
                                                Menyebarluaskan celah keamanan yang ditemukan pada Gojobs.id kepada siapa pun selain kami atas dasar apa pun;
                                            </h6>
                                        </li>
                                        <li>
                                            <h6>
                                                Memanfaatkan celah keamanan sebagaimana dimaksud untuk kepentingan pribadi atau kelompok tertentu.
                                            </h6>
                                        </li>
                                        <li>
                                            <h6>
                                                Mengembangkan, mendukung, atau menggunakan perangkat lunak, perangkat, skrip, robot, atau cara dan proses lainnya (termasuk perayap, plug-in dan add-on browser, atau teknologi lainnya) untuk mengambil secara melawan hukum sebagian atau seluruh data yang terdapat dalam Situs;
                                            </h6>
                                        </li>
                                        <li>
                                            <h6>
                                                Mengganti atau mengubah tampilan di Situs;
                                            </h6>
                                        </li>
                                        <li>
                                            <h6>
                                                Melakukan deep-link pada seluruh produk dan layanan kami untuk tujuan apa pun, tanpa persetujuan kami; dan
                                            </h6>
                                        </li>
                                        <li>
                                            <h6>
                                                Menggunakan Gojobs.id, mengunggah, memposting, atau mengirimkan materi apa pun yang bertentangan dengan hukum dan kesusilaan.
                                            </h6>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <i class="careerfy-icon careerfy-arrows"></i> 2. Pembatasan Tanggung Jawab dan Jaminan
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" aria-expanded="false">
                            <div class="panel-body" style="margin-left: 32px;">
                                <h6>
                                    Kami tidak bertanggung jawab atas masalah langsung, tidak langsung, insidental, khusus, konsekuensial, termasuk tetapi tidak terbatas, pada masalah informasi, data pribadi, atau kerugian lainnya (bahkan jika kami telah diberitahu tentang kemungkinan masalah tersebut), yang dihasilkan dari: <br>
                                </h6>
                                <div style="margin-left: 12px">
                                    <ul>
                                        <li>
                                            <h6>
                                                Pelanggaran atau akses tidak sah terhadap Gojobs.id, termasuk namun tidak terbatas pada hal-hal ataupun fitur yang terdapat dalam Gojobs.id yang dilakukan oleh Anda dengan cara yang bertentangan dengan Ketentuan ini maupun ketentuan hukum yang berlaku di wilayah Republik Indonesia; dan
                                            </h6>
                                        </li>
                                        <li>
                                            <h6>
                                                Penggunaan informasi yang diperoleh dari pihak ketiga yang terhubung dengan Gojobs.id.
                                            </h6>
                                        </li>
                                    </ul>
                                </div>
                                <h6>
                                    <br>Kami tidak menjamin bahwa: <br>
                                </h6>
                                <div style="margin-left: 12px">
                                    <ul>
                                        <li>
                                            <h6>
                                                Gojobs.id akan selalu dapat diakses atau digunakan oleh Anda;
                                            </h6>
                                        </li>
                                        <li>
                                            <h6>
                                                Gojobs.id tidak akan mengalami gangguan, selalu tepat waktu, aman, dan bebas dari kerusakan atau serangan ilegal secara langsung atau pun tidak langsung; dan
                                            </h6>
                                        </li>
                                        <li>
                                            <h6>
                                                Gojobs.id pada pelaksanaannya selalu berhasil dalam memberikan informasi yang akurat.
                                            </h6>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <i class="careerfy-icon careerfy-arrows"></i> 3. Ganti Rugi
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse" aria-expanded="false">
                            <div class="panel-body" style="margin-left: 32px;">
                                <h6>
                                    Anda melepaskan Gojobs.id dan pihak ketiga yang terlibat di dalamnya dari setiap klaim atau tuntutan, termasuk namun tidak terbatas pada biaya hukum yang wajar, yang diakibatkan kelalaian Anda dalam mematuhi isi Ketentuan ini, penggunaan fitur dan/atau layanan Gojobs.id yang tidak semestinya, dan/atau pelanggaran lainnya terhadap hukum atau hak-hak pihak lain. <br>
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    <i class="careerfy-icon careerfy-arrows"></i> 4. Hak Kekayaan Intelektual
                                </a>
                            </h4>
                        </div>
                        <div id="collapseFour" class="panel-collapse collapse" aria-expanded="false">
                            <div class="panel-body" style="margin-left: 32px;">
                                <h6>
                                    Anda mengakui bahwa kami memiliki semua kepemilikan, hak, dan kepentingan, termasuk hak kekayaan intelektual, di dalam dan atas Gojobs.id, termasuk perangkat lunak apa pun di dalamnya. Anda tidak akan melakukan atau mengizinkan tindakan apa pun yang secara langsung atau tidak langsung mungkin membatasi kepemilikan, hak, atau kepentingan kami. Kecuali secara tegas diizinkan oleh hukum atau kami, Anda setuju untuk tidak mengubah, mengadaptasi, menerjemahkan, menyiapkan karya turunan dari, merekayasa, membongkar, atau mencoba mengambil kode sumber dari Gojobs.id. Tanpa membatasi hal tersebut di atas, Anda tidak akan menggunakan dengan cara apa pun dan tidak akan mereproduksi kekayaan intelektual serupa apa pun terkait dengan Gojobs.id, tanpa persetujuan tertulis sebelumnya dari kami. <br>
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    <i class="careerfy-icon careerfy-arrows"></i> 5. Pengubahan Layanan
                                </a>
                            </h4>
                        </div>
                        <div id="collapseFive" class="panel-collapse collapse" aria-expanded="false">
                            <div class="panel-body" style="margin-left: 32px;">
                                <h6>
                                    Kami berhak setiap saat dan dari waktu ke waktu untuk mengubah atau menghentikan, sementara atau secara permanen, layanan atau bagian lainnya dengan atau tanpa pemberitahuan. Kami tidak akan bertanggung jawab kepada Anda atau kepada pihak ketiga lainnya terhadap perubahan apa pun, penangguhan, atau penghentian layanan. <br>
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                    <i class="careerfy-icon careerfy-arrows"></i> 6. Peraturan yang Berlaku
                                </a>
                            </h4>
                        </div>
                        <div id="collapseSix" class="panel-collapse collapse" aria-expanded="false">
                            <div class="panel-body" style="margin-left: 32px;">
                                <h6>
                                    Ketentuan ini diatur oleh dan ditafsirkan sesuai dengan hukum Republik Indonesia. <br>
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionTwo" href="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
                                    <i class="careerfy-icon careerfy-arrows"></i> 7. Penyelesaian Perselisihan
                                </a>
                            </h4>
                        </div>
                        <div id="collapseSeven" class="panel-collapse collapse">
                            <div class="panel-body" style="margin-left: 32px;">
                                <div style="margin-left: 12px">
                                    <ul>
                                        <li>
                                            <h6>
                                                Anda sepakat untuk menyelesaikan perselisihan dalam mengenai pelaksanaan Ketentuan ini secara musyawarah dan mufakat.
                                            </h6>
                                        </li>
                                        <li>
                                            <h6>
                                                Apabila musyawarah dan mufakat tidak tercapai dalam waktu 30 (tiga puluh) hari kalender, maka Para Pihak sepakat bahwa penyelesaian perselisihan tersebut akan diteruskan dan diselesaikan di Kantor Pengadilan Negeri Jakarta.
                                            </h6>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="careerfy-section-title">
                    <h2>Kontak Informasi & Kebijakan Privasi</h2>
                </div>
                <div class="panel-group careerfy-accordion" id="accordionTwo">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionTwo" href="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                    <i class="careerfy-icon careerfy-arrows"></i>1. Kontak Informasi
                                </a>
                            </h4>
                        </div>
                        <div id="collapseEight" class="panel-collapse collapse">
                            <div class="panel-body" style="margin-left: 32px;">
                                <h6>
                                    Dalam hal terdapat pertanyaan, keluhan dan/atau pengaduan sehubungan dengan penggunaan Gojobs.id, Anda dapat mengajukan pertanyaan, keluhan dan/atau pengaduan tersebut melalui email ke info@ish.co.id dengan melampirkan identitas Anda.
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionTwo" href="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                    <i class="careerfy-icon careerfy-arrows"></i> 2. Kebijakan Privasi
                                </a>
                            </h4>
                        </div>
                        <div id="collapseNine" class="panel-collapse collapse">
                            <div class="panel-body" style="margin-left: 32px;">
                                <h6>
                                    Ketentuan lebih lanjut mengenai penggunaan data Anda dalam penggunaan situs Gojobs.id diatur melalui dokumen Kebijakan Privasi. Untuk informasi selengkapnya tentang pendekatan Gojobs terhadap GDPR, CCPA, dan privasi secara umum, kunjungi Pertanyaan yang Kerap Diajukan tentang Privasi Gojobs.id
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="careerfy-section-title">
                    <span class="careerfy-about-sub">Diperbaharui per tanggal: 11 November 2023.</span>
                </div>
            </div>';
        } ?>
    </div>
    <!-- Main Section -->
</div>