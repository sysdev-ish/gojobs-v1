<?php

use yii\widgets\ListView;
use kartik\select2\Select2Asset;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\MappingCity;
use app\models\MappingJob;
use app\models\Masterjobfamily;
use app\models\Mastersubjobfamily;
use app\models\Transrincian;
use Codeception\Lib\Di;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
/* @var $this yii\web\View */

$this->title = 'Search Job';

$baseUrl = Yii::$app->request->baseUrl;

if (Yii::$app->session->hasFlash('showBanner')) {
    $this->registerJs('$("#modal-banner").modal("show");');
}

if (Yii::$app->user->isGuest) {
} else {
    // Display dynamic content from the database
    if ($bannerContent) {
    Modal::begin([
        'header' => '<h4 class="modal-title"></h4>',
        'id' => 'modal-banner',
        'size' => 'modal-xl',
    ]);
        echo '<img src="' . Yii::$app->request->baseUrl . '/app/assets/upload/cms/' . $bannerContent->assets_path . '" alt="Banner Image" class="img-responsive" />';
        Modal::end();
    } else {
    }
}

?>
<div class="careerfy-banner careerfy-typo-wrap">
    <span class="careerfy-banner-transparent"></span>
    <div class="careerfy-banner-caption">
        <div class="container">
            <h1><?= Yii::t('app', 'Aim Higher. Reach Further. Dream Bigger') ?>.</h1>
            <p><?= Yii::t('app', "A better career is out there. We'll help you find it to use") ?>.</p>
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
            <div class="careerfy-banner-btn">
                <?= Html::button('<i class="careerfy-icon careerfy-up-arrow"></i> Upload Your Resume', ['id' => 'signinButton', 'value' => \yii\helpers\Url::to(['site/login']), 'class' => 'careerfy-bgcolorhover']) ?>
            </div>
        </div>
    </div>
</div>
<!-- Banner -->

<!-- Main Content -->
<div class="careerfy-main-content">

    <!-- Main Section -->
    <div class="careerfy-main-section careerfy-counter-full">
        <div class="container">
            <div class="row">

                <div class="col-md-12">
                    <!-- Counter -->
                    <div class="careerfy-counter">
                        <ul class="row">
                            <li class="col-md-4">
                                <span class="word-counter"><?php echo $totaljo; ?></span>
                                <small><?= Yii::t('app', 'Jobs Added') ?></small>
                            </li>
                            <li class="col-md-4">
                                <span class="word-counter"><?php echo $totalapplicant; ?></span>
                                <small><?= Yii::t('app', 'Active Resumes') ?></small>
                            </li>
                            <li class="col-md-4">
                                <span class="word-counter"><?php echo $joblocation; ?></span>
                                <small><?= Yii::t('app', 'Job Location') ?></small>
                            </li>
                        </ul>
                    </div>
                    <!-- Counter -->
                </div>

            </div>
        </div>
    </div>
    <!-- Main Section -->

    <!-- Main Section -->
    <div class="careerfy-main-section">
        <div class="container">
            <div class="row">

                <div class="col-md-12 careerfy-typo-wrap">
                    <!-- Fancy Title -->
                    <section class="careerfy-fancy-title">
                        <h2><?= Yii::t('app', "Popular Job Categories") ?></h2>
                        <p><?= Yii::t('app', "A better career is out there. We'll help you find it to use") ?>.</p>
                    </section>
                    <!-- Categories -->

                    <div class="categories-list">
                        <ul class="careerfy-row">

                            <?php foreach ($jobcategory as $data) : ?>
                                <a href="/rekrut/site/searchjob?Transrinciansearch%5Bstatus_rekrut%5D=1&Transrinciansearch%5Bjobfamily%5D=<?php echo $data['id']; ?>">
                                    <li class="careerfy-column-4" style="margin-bottom: 0px;">
                                        <div class="careerfy-joblisting-classic-wrap" style="box-shadow: none; border-color: #d1d1d1;">
                                            <!-- <div class="container"> -->
                                            <div class="row" style="text-align: center; margin-bottom: 0px;">
                                                <div class="col-xs-3">
                                                    <figure><i class="careerfy-icon careerfy-<?php echo $data['icon']; ?>"></i></figure>
                                                </div>
                                                <div class="col-xs-9" style="text-align: left;">
                                                    <h1 style="font-size: 18px; margin-bottom: 5px;">
                                                        <a class="btn-link" href="/rekrut/site/searchjob?Transrinciansearch%5Bstatus_rekrut%5D=1&Transrinciansearch%5Bjobfamily%5D=<?php echo $data['id']; ?>"> <?php echo $data['jobfamily']; ?> </a>
                                                    </h1>
                                                    <span>Open Vacancies</span>
                                                </div>
                                            </div>
                                            <!-- </div> -->
                                        </div>
                                    </li>
                                </a>
                            <?php endforeach; ?>

                        </ul>
                    </div>
                    <div class="careerfy-plain-btn"> <a href="/rekrut/site/searchjob"><?= Yii::t('app', "Browse All Categories") ?></a> </div>
                    <!-- Categories -->
                </div>

            </div>
        </div>
    </div>
    <!-- Main Section -->

    <!-- Main Section -->
    <div class="careerfy-main-section careerfy-parallex-full">
        <div class="container">
            <div class="row">

                <aside class="col-md-6 careerfy-typo-wrap">
                    <div class="careerfy-parallex-text">
                        <h2><?= Yii::t('app', "Millions of jobs") ?>. <br> <?= Yii::t('app', "Find the one that’s right for you") ?>.</h2>
                        <p><?= Yii::t('app', "Search all the open positions on the web") ?>. <?= Yii::t('app', "Get your own personalized salary estimate") ?>. <?= Yii::t('app', "Read reviews on over 600,000 companies worldwide") ?>. <?= Yii::t('app', "The right job is out there") ?>.</p>
                        <!-- <a href="#" class="careerfy-static-btn careerfy-bgcolor"><span>Search Jobs</span></a> -->
                    </div>
                </aside>
                <aside class="col-md-6 careerfy-typo-wrap">
                    <div class="careerfy-right"><img width="600" height="400" src="<?php echo $baseUrl; ?>/images/search-illustration.webp" alt=""></div>
                </aside>

            </div>
        </div>
    </div>
    <!-- Main Section -->
</div>
<!-- Main Content -->
<!-- Footer -->

<!-- </div> -->
<!-- Wrapper -->