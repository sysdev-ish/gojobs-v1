<?php

use yii\widgets\ListView;
use kartik\select2\Select2Asset;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\MappingCity;
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
                            <!-- <li class="careerfy-column-3">
                                <i class="careerfy-icon careerfy-engineer"></i>
                                <a href="#"><?= Yii::t('app', "construction / facilities") ?>.</a>
                                <span>(15 Open Vacancies)</span>
                            </li>
                            <li class="careerfy-column-3">
                                <i class="careerfy-icon careerfy-car"></i>
                                <a href="#">automotive jobs</a>
                                <span>(12 Open Vacancies)</span>
                            </li>
                            <li class="careerfy-column-3">
                                <i class="careerfy-icon careerfy-accounting"></i>
                                <a href="#">Accounting / Finance</a>
                                <span>(8 Open Vacancies)</span>
                            </li>
                            <li class="careerfy-column-3">
                                <i class="careerfy-icon careerfy-hospital"></i>
                                <a href="#">Health Care</a>
                                <span>(5 Open Vacancies)</span>
                            </li>
                            <li class="careerfy-column-3">
                                <i class="careerfy-icon careerfy-antenna"></i>
                                <a href="#">Telecommunications</a>
                                <span>(7 Open Vacancies)</span>
                            </li>
                            <li class="careerfy-column-3">
                                <i class="careerfy-icon careerfy-books"></i>
                                <a href="#">education training</a>
                                <span>(22 Open Vacancies)</span>
                            </li>
                            <li class="careerfy-column-3">
                                <i class="careerfy-icon careerfy-fast-food"></i>
                                <a href="#">Restaurant / food services</a>
                                <span>(30 Open Vacancies)</span>
                            </li>
                            <li class="careerfy-column-3">
                                <i class="careerfy-icon careerfy-business"></i>
                                <a href="#">Sales & Marketing</a>
                                <span>(40 Open Vacancies)</span>
                            </li> -->

                            <?php
                            foreach ($jobcategory as $data) :
                            ?>
                                <li class="careerfy-column-4">
                                    <i class="careerfy-icon careerfy-business"></i>
                                    <a href="#"> <?php echo $data['jobfamily']; ?> </a>
                                    <span><?php // echo $listjob; ?></span>
                                </li>
                            <?php endforeach; ?>

                        </ul>
                    </div>
                    <div class="careerfy-plain-btn"> <a href="#"><?= Yii::t('app', "Browse All Categories") ?></a> </div>
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