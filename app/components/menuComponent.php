<?php
namespace app\components;

use Yii;
use yii\base\Component;

use app\models\Personaldata;
use app\models\Datakeluarga;
use app\models\Formulirsekolah;
use app\models\Aktalahir;
use app\models\Passport;
use app\models\Ijazahsmasmk;
use app\models\Transkipnilaismasmk;
use app\models\Ijazahpt;
use app\models\Transkipnilaipt;
use app\models\Datapenjamin;
use app\models\Skck;


class menuComponent extends Component {



    public function pdatacomp($userid){
        $ret = null;
        $personaldata = Personaldata::find()->where(['userid'=>$userid])->one();


        if($personaldata){
          $ret = '<a href="{url}">{icon} {label} <span class="pull-right-container"><small class="fa fa-check-square-o pull-right" style="color:#33cc33"></small></span></a>';
        }else{
          $ret = '<a href="{url}">{icon} {label}';
        }

        return $ret;
    }
    public function dkelcomp($userid){
        $ret = null;
        $datakeluarga = Datakeluarga::find()->where(['userid'=>$userid])->one();

        if($datakeluarga){
          $ret = '<a href="{url}">{icon} {label} <span class="pull-right-container"><small class="fa fa-check-square-o pull-right" style="color:#33cc33"></small></span></a>';
        }else{
          $ret = '<a href="{url}">{icon} {label}';
        }

        return $ret;
    }
    public function fsekolahcomp($userid){
        $ret = null;
        $formulirsekolah = formulirsekolah::find()->where(['userid'=>$userid])->one();

        if($formulirsekolah){
          $ret = '<a href="{url}">{icon} {label} <span class="pull-right-container"><small class="fa fa-check-square-o pull-right" style="color:#33cc33"></small></span></a>';
        }else{
          $ret = '<a href="{url}">{icon} {label}';
        }

        return $ret;
    }
    public function alahircomp($userid){
        $ret = null;
        $aktalahir = Aktalahir::find()->where(['userid'=>$userid])->one();

        if($aktalahir){
          $ret = '<a href="{url}">{icon} {label} <span class="pull-right-container"><small class="fa fa-check-square-o pull-right" style="color:#33cc33"></small></span></a>';
        }else{
          $ret = '<a href="{url}">{icon} {label}';
        }

        return $ret;
    }
    public function passportcomp($userid){
        $ret = null;
        $passport = Passport::find()->where(['userid'=>$userid])->one();

        if($passport){
          $ret = '<a href="{url}">{icon} {label} <span class="pull-right-container"><small class="fa fa-check-square-o pull-right" style="color:#33cc33"></small></span></a>';
        }else{
          $ret = '<a href="{url}">{icon} {label}';
        }

        return $ret;
    }
    public function ijazahsmacomp($userid){
        $ret = null;
        $ijazahsma = Ijazahsmasmk::find()->where(['userid'=>$userid])->one();

        if($ijazahsma){
          $ret = '<a href="{url}">{icon} {label} <span class="pull-right-container"><small class="fa fa-check-square-o pull-right" style="color:#33cc33"></small></span></a>';
        }else{
          $ret = '<a href="{url}">{icon} {label}';
        }

        return $ret;
    }
    public function transkipsmacomp($userid){
        $ret = null;
        $transkipsma = Transkipnilaismasmk::find()->where(['userid'=>$userid])->one();

        if($transkipsma){
          $ret = '<a href="{url}">{icon} {label} <span class="pull-right-container"><small class="fa fa-check-square-o pull-right" style="color:#33cc33"></small></span></a>';
        }else{
          $ret = '<a href="{url}">{icon} {label}';
        }

        return $ret;
    }
    public function ijazahptcomp($userid){
        $ret = null;
        $ijazahpt = Ijazahpt::find()->where(['userid'=>$userid])->one();
        if($ijazahpt){
          $ret = '<a href="{url}">{icon} {label} <span class="pull-right-container"><small class="fa fa-check-square-o pull-right" style="color:#33cc33"></small></span></a>';
        }else{
          $ret = '<a href="{url}">{icon} {label}';
        }

        return $ret;
    }
    public function transkipptcomp($userid){
        $ret = null;
        $transkippt = Transkipnilaipt::find()->where(['userid'=>$userid])->one();

        if($transkippt){
          $ret = '<a href="{url}">{icon} {label} <span class="pull-right-container"><small class="fa fa-check-square-o pull-right" style="color:#33cc33"></small></span></a>';
        }else{
          $ret = '<a href="{url}">{icon} {label}';
        }

        return $ret;
    }
    public function dpenjamincomp($userid){
        $ret = null;
        $datapenjamin = Datapenjamin::find()->where(['userid'=>$userid])->one();

        if($datapenjamin){
          $ret = '<a href="{url}">{icon} {label} <span class="pull-right-container"><small class="fa fa-check-square-o pull-right" style="color:#33cc33"></small></span></a>';
        }else{
          $ret = '<a href="{url}">{icon} {label}';
        }

        return $ret;
    }
    public function skckcomp($userid){
        $ret = null;
        $dataskck = Skck::find()->where(['userid'=>$userid])->one();

        if($dataskck){
          $ret = '<a href="{url}">{icon} {label} <span class="pull-right-container"><small class="fa fa-check-square-o pull-right" style="color:#33cc33"></small></span></a>';
        }else{
          $ret = '<a href="{url}">{icon} {label}';
        }

        return $ret;
    }

}
