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
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
/* @var $this yii\web\View */

$this->title = 'Search Job';

$baseUrl = Yii::$app->request->baseUrl;

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
                                <li class="careerfy-column-4">
                                    <i class="careerfy-icon careerfy-<?php echo $data['icon']; ?>"></i>
                                    <a href="/rekrut/site/searchjob?Transrinciansearch%5Bstatus_rekrut%5D=1&Transrinciansearch%5Bjobfamily%5D=<?php echo $data['id']; ?>"> <?php echo $data['jobfamily']; ?> </a>
                                    <span>(<?php echo $totaljocategory; ?> Open Vacancies)</span>
                                </li>
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
                    <div class="careerfy-right"><img src="<?php echo $baseUrl; ?>/extra-images/search-illustration.png" alt=""></div>
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