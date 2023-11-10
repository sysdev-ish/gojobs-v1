<?php

use yii\widgets\ListView;
/* @var $this yii\web\View */

$this->title = 'Search Job';
?>
<!-- SubHeader -->
<div class="careerfy-subheader">
    <span class="careerfy-banner-transparent"></span>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="careerfy-page-title">
                    <h1><?= Yii::t('app', 'Search all the open positions on the web') ?></h1>
                    <!-- <p>Yes! You make or may not find the right job for you, but that’s ok.</p> -->
                    <p><?= Yii::t('app', 'Thousands of jobs') ?></p>
                    <p><?= Yii::t('app', 'Find the one that’s right for you') ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- SubHeader -->
<div class="careerfy-main-content">
    <div class="careerfy-main-section careerfy-subheader-form-full">
        <div class="container">
            <div class="row">

                <div class="col-md-12 careerfy-typo-wrap">
                    <!-- Sub Header Form -->
                    <div class="careerfy-subheader-form">
                        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                    </div>
                    <!-- Sub Header Form -->
                </div>

            </div>
        </div>
    </div>
    <div class="careerfy-main-section" style="margin-bottom: 20px;">
        <div class="container">
            <div class="col-md-12">
                <?php echo ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_item',
                    'options' => ['class' => 'row'],
                    'itemOptions' => [
                        'class' => 'col-xs-12 col-md-6 col-lg-6',
                    ],
                    'layout' => "<div class='row'>{items}</div><div class='row'><div class='col-xs-12 col-md-6 col-lg-6'>{summary}</div><div class='col-xs-12 col-md-6 col-lg-6' style='text-align:right;'>{pager}</div></div>",
                    'pager' => [
                        'firstPageLabel' => 'first',
                        'lastPageLabel' => 'last',
                        'prevPageLabel' => '<',
                        'nextPageLabel' => '>',
                        'maxButtonCount' => 8,
                    ],
                ])
                ?>
            </div>
        </div>
    </div>
</div>