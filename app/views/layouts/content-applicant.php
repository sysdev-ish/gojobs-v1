<?php

use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;
use yii\helpers\Html;

$baseUrl = Yii::$app->request->baseUrl;
?>
<?= $content ?>

<footer id="careerfy-footer" class="careerfy-footer-one">
  <div class="container">
    <!-- Footer Widget -->
    <div class="careerfy-footer-widget">
      <div class="row">
        <aside class="widget col-md-4 widget_contact_info">
          <div class="widget_contact_wrap">
            <a class="careerfy-footer-logo" href="<?php echo $baseUrl; ?>"><img src="<?php echo $baseUrl; ?>/images/logo-gojobs.webp" alt="" width="250" height="100"></a>
            <p>Mencari dan menyalurkan kandidat yang spesifik sesuai dengan kebutuhan perusahaan.
          </div>
        </aside>
        <aside class="widget col-md-8 widget_nav_manu">
          <div class="footer-widget-title">
            <h2>Gojobs.id</h2>
          </div>
          <div class="col-md-4">
            <ul>
              <li><a href="http://gojobs.id/rekrut/site/searchjob">Cari Pekerjaan</a></li>
              <li><a href="http://gojobs.id/rekrut/site#category">Cari Berdasarkan Kategori</a></li>
            </ul>
          </div>
          <div class="col-md-4">
            <ul>
              <li><a href="#">Notifikasi Pekerjaan</a></li>
              <li><a href="http://gojobs.id/rekrut/site/contact">Kontak</a></li>
            </ul>
          </div>
          <div class="col-md-4">
            <ul>
              <li><a href="http://gojobs.id/rekrut/site/privacypolicy">Kebijakan Privasi</a></li>
              <li><a href="http://gojobs.id/rekrut/site/termscondition">Ketentuan Pengguna</a></li>
            </ul>
          </div>
        </aside>

      </div>
    </div>
    <!-- Footer Widget -->

  </div>
  <!-- CopyRight -->
  <div class="careerfy-copyright">
    <div class="container">
      <p>Copyrights © <?php echo date('Y'); ?> All Rights Reserved by <a href="https://ish.co.id/" class="careerfy-color" target="_blank">Infomedia Solusi Humanika</a></p>
      <ul class="careerfy-social-network">
        <li><a href="#" class="careerfy-bgcolorhover fa fa-facebook"></a></li>
        <li><a href="#" class="careerfy-bgcolorhover fa fa-twitter"></a></li>
        <li><a href="#" class="careerfy-bgcolorhover fa fa-dribbble"></a></li>
        <li><a href="#" class="careerfy-bgcolorhover fa fa-linkedin"></a></li>
        <li><a href="#" class="careerfy-bgcolorhover fa fa-instagram"></a></li>
      </ul>
    </div>
  </div>
  <!-- CopyRight -->
</footer>
<!-- Footer -->