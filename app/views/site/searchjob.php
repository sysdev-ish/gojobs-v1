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
                    <h1>Jobs For Good Programmers</h1>
                    <p>Yes! You make or may not find the right job for you, but that’s ok.</p>
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
  <div class="careerfy-main-section">
      <div class="container">

<div class="col-md-12">

  <?php
echo  ListView::widget([
  'dataProvider' => $dataProvider,
  'itemView' => '_item',
    'pager' => [
        'firstPageLabel' => 'first',
        'lastPageLabel' => 'last',
        'prevPageLabel' => '<',
        'nextPageLabel' => '>',
        'maxButtonCount' => 3,


    ],
    
])
?>
</div>
</div>
</div>
</div>
