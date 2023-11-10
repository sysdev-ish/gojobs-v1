<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Recruitmentcandidate */

?>
<div class="recruitmentcandidate-create">

    <?= $this->render('_formaddcandidate2', [
    'model' => $model,
    // 'modeluprofile' => $modeluprofile,
    // 'recruitreq' => $recruitreq,
    'searchModelprofile' => $searchModelprofile,
    'dataProviderprofile' => $dataProviderprofile,
    'transrincianid' => $transrincianid,
    'modelrecreq' => $modelrecreq,
    ]) ?>

</div>
