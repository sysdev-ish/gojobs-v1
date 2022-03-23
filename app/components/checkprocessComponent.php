<?php
namespace app\components;

use Yii;
use yii\base\Component;

use app\models\Interview;


class checkprocessComponent extends Component {


    public function proccompleted($userid, $recanid){
        $ret = null;
        $interview = $this->interview($userid, $recanid);


        if($interview){
          $ret = 1;
        }else{
          $ret = 0;
        }

        return $ret;
    }
    public function interview($userid, $recanid){
        $ret = null;
        $interview = Interview::find()->where(['userid'=>$userid, 'recruitmentcandidateid'=>$recanid])->one();


        if($interview){
          $ret = 1;
        }else{
          $ret = 0;
        }

        return $ret;
    }



}
