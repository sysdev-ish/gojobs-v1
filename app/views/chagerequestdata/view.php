<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use linslin\yii2\curl;
use app\models\Hiring;
use app\models\Transrincian;

/* @var $this yii\web\View */
/* @var $model app\models\Chagerequestdata */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Chagerequestdatas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chagerequestdata-view box box-solid">
<div class="row">
<div class="col-md-5">
    <div class="box-body table-responsive">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'userprofile.fullname',
                [
                  'label' => 'Perner',
                  'format' => 'html',
                  'value'=>function ($data) {

                    return ($data->perner)?$data->perner:"";
                }

                ],
                [
                  'label' => 'Personal Area',
                  'format' => 'html',
                  'value'=>function ($data) {
                    if($data->userid){
                      $cekhiring = Hiring::find()->where(['userid'=>$data->userid,'statushiring'=>4])->one();
                      $getjo = Transrincian::find()->where(['id'=>$cekhiring->recruitreqid])->one();
                      $persa = (Yii::$app->utils->getpersonalarea($getjo->persa_sap))?Yii::$app->utils->getpersonalarea($getjo->persa_sap): "";
                    }else{
                      $curl = new curl\Curl();
                      $getdatapekerjabyperner =  $curl->setPostParams([
                        'perner' => $data->perner,
                        'token' => 'ish**2019',
                      ])
                      ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerja');
                      $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
                      $persa = $datapekerjabyperner[0]->WKTXT;
                    }
                    return $persa;
                }

                ],
                [
                  'label' => 'Area',
                  'format' => 'html',
                  'value'=>function ($data) {
                    if($data->userid){
                      $cekhiring = Hiring::find()->where(['userid'=>$data->userid,'statushiring'=>4])->one();
                      $getjo = Transrincian::find()->where(['id'=>$cekhiring->recruitreqid])->one();
                      $area = (Yii::$app->utils->getarea($getjo->area_sap))?Yii::$app->utils->getarea($getjo->area_sap): "";
                    }else{
                      $curl = new curl\Curl();
                      $getdatapekerjabyperner =  $curl->setPostParams([
                        'perner' => $data->perner,
                        'token' => 'ish**2019',
                      ])
                      ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerja');
                      $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
                      $area = $datapekerjabyperner[0]->BTRTX;
                    }
                    return $area;
                }

                ],
                [
                  'label' => 'Skill Layanan',
                  'format' => 'html',
                  'value'=>function ($data) {
                    if($data->userid){
                      $cekhiring = Hiring::find()->where(['userid'=>$data->userid,'statushiring'=>4])->one();
                      $getjo = Transrincian::find()->where(['id'=>$cekhiring->recruitreqid])->one();
                      $skilllayanan = (Yii::$app->utils->getskilllayanan($getjo->skill_sap))?Yii::$app->utils->getskilllayanan($getjo->skill_sap): "";
                    }else{
                      $curl = new curl\Curl();
                      $getdatapekerjabyperner =  $curl->setPostParams([
                        'perner' => $data->perner,
                        'token' => 'ish**2019',
                      ])
                      ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerja');
                      $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
                      $skilllayanan = $datapekerjabyperner[0]->PEKTX;
                    }
                    return $skilllayanan;
                }

                ],
                [
                  'label' => 'Payroll Area',
                  'format' => 'html',
                  'value'=>function ($data) {
                    if($data->userid){
                      $cekhiring = Hiring::find()->where(['userid'=>$data->userid,'statushiring'=>4])->one();
                      $getjo = Transrincian::find()->where(['id'=>$cekhiring->recruitreqid])->one();
                      $payrollarea = (Yii::$app->utils->getpayrollarea($getjo->abkrs_sap))?Yii::$app->utils->getpayrollarea($getjo->abkrs_sap): "";
                    }else{
                      $curl = new curl\Curl();
                      $getdatapekerjabyperner =  $curl->setPostParams([
                        'perner' => $data->perner,
                        'token' => 'ish**2019',
                      ])
                      ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerja');
                      $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
                      $payrollarea = $datapekerjabyperner[0]->ABTXT;
                    }
                    return $payrollarea;
                }

                ],
                [
                  'label' => 'Jabatan',
                  'format' => 'html',
                  'value'=>function ($data) {
                    if($data->userid){
                      $cekhiring = Hiring::find()->where(['userid'=>$data->userid,'statushiring'=>4])->one();
                      $getjo = Transrincian::find()->where(['id'=>$cekhiring->recruitreqid])->one();
                      $jabatan = (Yii::$app->utils->getjabatan($getjo->hire_jabatan_sap))?Yii::$app->utils->getjabatan($getjo->hire_jabatan_sap): "";
                    }else{
                      $curl = new curl\Curl();
                      $getdatapekerjabyperner =  $curl->setPostParams([
                        'perner' => $data->perner,
                        'token' => 'ish**2019',
                      ])
                      ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerja');
                      $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
                      $jabatan = $datapekerjabyperner[0]->PLATX;
                    }
                    return $jabatan;
                }

                ],
                [
                  'label' => 'Level',
                  'format' => 'html',
                  'value'=>function ($data) {
                    if($data->userid){
                      $cekhiring = Hiring::find()->where(['userid'=>$data->userid,'statushiring'=>4])->one();
                      $getjo = Transrincian::find()->where(['id'=>$cekhiring->recruitreqid])->one();
                      $curl = new curl\Curl();
                      $getlevels = $curl->setPostParams([
                        'level' => $getjo->level_sap,
                        'token' => 'ish**2019',
                      ])
                      ->post('http://192.168.88.5/service/index.php/sap_profile/getlevel');
                      $level  = json_decode($getlevels);
                      $level = ($level)?$level : "";
                    }else{
                      $curl = new curl\Curl();
                      $getdatapekerjabyperner =  $curl->setPostParams([
                        'perner' => $data->perner,
                        'token' => 'ish**2019',
                      ])
                      ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerja');
                      $datapekerjabyperner  = json_decode($getdatapekerjabyperner);
                      $level = $datapekerjabyperner[0]->TRFAR_TXT;
                    }
                    return $level;
                }

                ],
                'createtime',
                'updatetime',
                'approvedtime',
                [
                  'label' => 'Created By',
                  'format' => 'html',
                  'value'=>function ($data) {

                    return ($data->createduser)?$data->createduser->name:"";
                }

                ],
                [
                  'label' => 'Updated By',
                  'format' => 'html',
                  'value'=>function ($data) {

                    return ($data->updateduser)?$data->updateduser->name:"";
                }

                ],
                [
                  'label' => 'Approved By',
                  'format' => 'html',
                  'value'=>function ($data) {

                    return ($data->approveduser)?$data->approveduser->name:"";
                }

                ],
                // 'kategorydata',
            ],
        ]) ?>
    </div>
</div>
<div class="col-md-7">
  <div class="box-body table-responsive">
    <table class="table no-border">
      <tbody>
        <?php if ($npwpnumberoldval) : ?>
          <tr>
            <td width="30%" style="text-align:right;"><b>No NPWP</b></td>
            <td width="25%" ><?php
            echo $npwpnumberoldval.'<br>'.
            (($npwpfileolddoc)?Html::a('<i class="fa fa-download"></i> '.$npwpfileolddoc , ['/app/assets/upload/npwp/'.$npwpfileolddoc],['target'=>'_blank', 'class' => 'btn btn-sm btn-default text-muted']):'-');?></td>
            <td style="font-size:14pt;"><span class="fa fa-retweet"></span></td>
            <td width="25%" class="text-red" ><?php echo $npwpnumbernewval.'<br>'.
            (($npwpfilenewdoc)?Html::a('<i class="fa fa-download"></i> '.$npwpfilenewdoc , ['/app/assets/upload/npwp/'.$npwpfilenewdoc],['target'=>'_blank', 'class' => 'btn btn-sm btn-default text-muted']):'-'); ?></td>
          </tr>
        <?php else : ?>
          <tr>
            <td width="30%" style="text-align:right;"><b>No NPWP</b></td>
            <td width="25%" ><?php
            echo $userprofile->npwpnumber.'<br>'.
            (($document->npwp)?Html::a('<i class="fa fa-download"></i> '.$document->npwp , ['/app/assets/upload/npwp/'.$document->npwp],['target'=>'_blank', 'class' => 'btn btn-sm btn-default text-muted']):'-');?></td>
            <td style="font-size:14pt;"><span class="fa fa-retweet"></span></td>
            <td width="25%" class="text-red" ><?php echo $npwpnumbernewval.'<br>'.
            (($npwpfilenewdoc)?Html::a('<i class="fa fa-download"></i> '.$npwpfilenewdoc , ['/app/assets/upload/npwp/'.$npwpfilenewdoc],['target'=>'_blank', 'class' => 'btn btn-sm btn-default text-muted']):'-'); ?></td>
          </tr>
        <?php endif; ?>

        <?php if ($bpjsnumberoldval) : ?>
          <tr>
            <td style="text-align:right;"><b>No BPJS Kesehatan</b></td>
            <td><?php echo $bpjsnumberoldval.'<br>'.
            (($bpjsfileolddoc)?Html::a('<i class="fa fa-download"></i> '.$bpjsfileolddoc , ['/app/assets/upload/bpjskesehatan/'.$bpjsfileolddoc],['target'=>'_blank', 'class' => 'btn btn-sm btn-default text-muted']):'-'); ?></td>
            <td style="font-size:14pt;"><span class="fa fa-retweet"></span></td>
            <td class="text-red"><?php echo $bpjsnumbernewval.'<br>'.
            (($bpjsfilenewdoc)?Html::a('<i class="fa fa-download"></i> '.$bpjsfilenewdoc , ['/app/assets/upload/bpjskesehatan/'.$bpjsfilenewdoc],['target'=>'_blank', 'class' => 'btn btn-sm btn-default text-muted']):'-'); ?></td>
          </tr>
        <?php else : ?>
          <tr>
            <td style="text-align:right;"><b>No BPJS Kesehatan</b></td>
            <td><?php echo $userprofile->bpjsnumber.'<br>'.
            (($document->bpjskesehatan)?Html::a('<i class="fa fa-download"></i> '.$document->bpjskesehatan , ['/app/assets/upload/bpjskesehatan/'.$document->bpjskesehatan],['target'=>'_blank', 'class' => 'btn btn-sm btn-default text-muted']):'-'); ?></td>
            <td style="font-size:14pt;"><span class="fa fa-retweet"></span></td>
            <td class="text-red"><?php echo $bpjsnumbernewval.'<br>'.
            (($bpjsfilenewdoc)?Html::a('<i class="fa fa-download"></i> '.$bpjsfilenewdoc , ['/app/assets/upload/bpjskesehatan/'.$bpjsfilenewdoc],['target'=>'_blank', 'class' => 'btn btn-sm btn-default text-muted']):'-'); ?></td>
          </tr>
        <?php endif; ?>

        <?php if ($jamsosteknumberoldval) : ?>
          <tr>
            <td style="text-align:right;"><b>No BPJS Tenaga Kerja</b></td>
            <td><?php echo $jamsosteknumberoldval.'<br>'.
            (($jamsostekfileolddoc)?Html::a('<i class="fa fa-download"></i> '.$jamsostekfileolddoc , ['/app/assets/upload/jamsostek/'.$jamsostekfileolddoc],['target'=>'_blank', 'class' => 'btn btn-sm btn-default text-muted']):'-'); ?></td>
            <td style="font-size:14pt;"><span class="fa fa-retweet"></span></td>
            <td class="text-red"><?php echo $jamsosteknumbernewval.'<br>'.
            (($jamsostekfilenewdoc)?Html::a('<i class="fa fa-download"></i> '.$jamsostekfilenewdoc , ['/app/assets/upload/jamsostek/'.$jamsostekfilenewdoc],['target'=>'_blank', 'class' => 'btn btn-sm btn-default text-muted']):'-'); ?></td>
          </tr>
        <?php else : ?>
          <tr>
            <td style="text-align:right;"><b>No BPJS Tenaga Kerja</b></td>
            <td><?php echo $userprofile->jamsosteknumber.'<br>'.
            (($document->jamsostek)?Html::a('<i class="fa fa-download"></i> '.$document->jamsostek , ['/app/assets/upload/jamsostek/'.$document->jamsostek],['target'=>'_blank', 'class' => 'btn btn-sm btn-default text-muted']):'-'); ?></td>
            <td style="font-size:14pt;"><span class="fa fa-retweet"></span></td>
            <td class="text-red"><?php echo $jamsosteknumbernewval.'<br>'.
            (($jamsostekfilenewdoc)?Html::a('<i class="fa fa-download"></i> '.$jamsostekfilenewdoc , ['/app/assets/upload/jamsostek/'.$jamsostekfilenewdoc],['target'=>'_blank', 'class' => 'btn btn-sm btn-default text-muted']):'-'); ?></td>
          </tr>
        <?php endif; ?>
    </tbody></table>
  </div>
</div>
</div>
</div>
