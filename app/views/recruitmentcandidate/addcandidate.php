<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Recruitmentcandidate */

?>
<div class="recruitmentcandidate-create">

    <?= $this->render('_formaddcandidate', [
    'model' => $model,
    'modeluprofile' => $modeluprofile,
    'recruitreq' => $recruitreq,
    ]) ?>

</div>
