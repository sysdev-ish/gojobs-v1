<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */
//
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contact';
?>
<div class="careerfy-subheader">
    <span class="careerfy-banner-transparent"></span>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="careerfy-page-title">
                    <!-- <h1>Contact US</h1> -->
                    <!-- <p>Yes! You make or may not find the right job for you, but that’s ok.</p> -->
                    <h1>Hubungi Kami</h1>
                    <p>Ya! Kami mungkin membuat atau tidak menemukan pekerjaan yang tepat untuk Anda, tapi tidak apa-apa.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="careerfy-main-content">

    <!-- Main Section -->
    <!-- <div class="careerfy-main-section map-full">
        <div class="container-fluid">
            <div class="row">

                <div id="map"></div>

            </div>
        </div>
    </div> -->
    <!-- Main Section -->

    <!-- Main Section -->
    <div class="careerfy-main-section careerfy-contact-form-full-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="careerfy-contact-info-sec">
                        <h2>Kontak Informasi</h2>
                        <p>PT Infomedia Solusi Humanika atau dikenal dengan ISH merupakan anak perusahaan PT Infomedia Nusantara yang bergerak dalam bidang Human Capital Services.</p>
                        <ul class="careerfy-contact-info-list">
                            <li><i class="careerfy-icon careerfy-placeholder"></i> Gedung Graha Mandiri, Jl. RS Fatmawati No.75, RT.6/RW.5, North Cipete, Kebayoran Baru, South Jakarta City, Jakarta 12150</li>
                            <li><i class="careerfy-icon careerfy-mail"></i> <a href="#">Email: recruitment@ish.co.id</a></li>
                            <li><i class="careerfy-icon careerfy-technology"></i> Call: 021 - 7237928</li>
                            <!-- <li><i class="careerfy-icon careerfy-fax"></i> Fax: (800) 123 4567 89</li> -->
                        </ul>
                        <div class="careerfy-contact-media">
                            <a href="https://www.facebook.com/infomedia.recuitment" class="careerfy-icon careerfy-facebook-logo" target="_blank"></a>
                            <a href="#" class="careerfy-icon careerfy-twitter-logo"></a>
                            <a href="#" class="careerfy-icon careerfy-linkedin-button"></a>
                            <a href="#" class="careerfy-icon careerfy-dribbble-logo"></a>
                        </div>
                    </div>
                    <div class="careerfy-contact-form">
                        <!-- <h2>We want to hear form you!</h2> -->
                        <h2>Kami Ingin Mendengar Masukkan Anda!</h2>
                        <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
                        <ul>
                            <li>
                                <input value="Masukkan Nama" onblur="if(this.value == '') { this.value ='Masukkan Nama'; }" onfocus="if(this.value =='Masukkan Nama') { this.value = ''; }" type="text">
                                <i class="careerfy-icon careerfy-user"></i>
                            </li>
                            <li>
                                <input value="Subject" onblur="if(this.value == '') { this.value ='Subject'; }" onfocus="if(this.value =='Subject') { this.value = ''; }" type="text">
                                <i class="careerfy-icon careerfy-user"></i>
                            </li>
                            <li>
                                <input value="Masukkan Alamat Email" onblur="if(this.value == '') { this.value ='Masukkan Alamat Email'; }" onfocus="if(this.value =='Masukkan Alamat Email') { this.value = ''; }" type="text">
                                <i class="careerfy-icon careerfy-mail"></i>
                            </li>
                            <li>
                                <input value="Masukkan Nomor Telepon" onblur="if(this.value == '') { this.value ='Masukkan Nomor Telepon'; }" onfocus="if(this.value =='Masukkan Nomor Telepon') { this.value = ''; }" type="text">
                                <i class="careerfy-icon careerfy-technology"></i>
                            </li>
                            <li class="careerfy-contact-form-full">
                                <textarea>Track your results on the local or global market , depending on your needs. You can track everything in the most popular search engines - Google, Bing, Yahoo and Yandex. Improve your search performance and increase traffic with our turn-key. Positionly is the only solution on the market that provides a simple and transparent way to monitor.the effectiveness.</textarea>
                            </li>
                            <li><input type="submit" value="Submit"></li>
                            <li><?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                                    'template' => '<div class="row"><div class="col-lg-4">{image}</div><div class="col-lg-8">{input}</div></div>',
                                ])->label(false) ?></li>
                        </ul>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Section -->



    <!-- Main Section -->
    <div class="careerfy-main-section contact-service-full" style="margin-top:100px;">
        <div class="container">
            <div class="row">

                <div class="col-md-12">
                    <div class="contact-service">
                        <ul class="row">
                            <li class="col-md-4">
                                <h2>Want to join us?</h2>
                                <i class="careerfy-icon careerfy-user-2"></i>
                                <a href="#">Careers</a>
                            </li>
                            <li class="col-md-4">
                                <h2>Read our latest news</h2>
                                <i class="careerfy-icon careerfy-newspaper"></i>
                                <a href="#">Our Blog</a>
                            </li>
                            <li class="col-md-4">
                                <h2>Have questions?</h2>
                                <i class="careerfy-icon careerfy-discuss-issue"></i>
                                <a href="#">Our FAQ</a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Main Section -->

</div>
<!-- Main Content -->