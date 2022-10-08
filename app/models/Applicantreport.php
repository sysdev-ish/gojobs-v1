<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Userprofile;
use app\models\Hiring;

/**
 * Hiringsearch represents the model behind the search form of `app\models\Hiring`.
 */
class Applicantreport extends Hiring
{

  public $education;
  public $jurusan;
  public $havenpwp;
  public $applicantstatus;
  public $registerstart;
  public $registerend;
  public $cityid;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['startawalkontrak','endawalkontrak'], 'required'],
            [['education','havenpwp','applicantstatus','cityid'], 'integer'],
            [['jurusan','registerstart','registerend'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Userprofile::find();
        // $query->leftJoin('mastersubjobfamily', 'mastersubjobfamily.subjobfamily = userworkexperience.lastposition');

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['fullname' => SORT_DESC]]
        ]);


        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $datenow = date('Y-m-d');

        if($this->registerstart and $this->registerend){
          $query->andFilterWhere(['between', 'createtime', $this->registerstart, $this->registerend]);
        }
        else{
          $this->registerstart = $datenow;
          $this->registerend = $datenow;
          $query->andFilterWhere(['between', 'createtime', $datenow, $datenow]);
        }
        $query->andFilterWhere([
            'cityid' => $this->cityid,

        ]);
        if($this->education OR $this->jurusan ){
          $getUserid = $this->byLasteducation($params,$dataProvider);
          if($getUserid){
            $getUserid = implode(',', $getUserid);
          }else{
            $getUserid = 0;
          }
          $query->andWhere('userid IN (' . $getUserid . ')');
        }

        if($this->havenpwp){
          if($this->havenpwp == 1){
            $query->andFilterWhere([
                'havenpwp' => 1,
            ]);
          }else if($this->havenpwp == 2){
            $query->andFilterWhere([
                'havenpwp' => 0,
            ]);
          }
        }



        $alldata = [
          'dataProvider' => $dataProvider,
        ];

        return $alldata;
    }
    protected function byLasteducation($param,$dataProvider){

          $ret = null;
          $edu = $dataProvider->query->all();
          $useredu = array();
          if($edu){
              foreach($edu as $val){
                  $useredu[] = $val->userid;
              }
              $usereducations = implode(',', $useredu);
          }else{
              $usereducations = 0;
          }

          $useridInwAppstatusQuery = Recruitmentcandidate::find();
          $useridInwAppstatusQuery->andWhere('userid IN (' . $usereducations . ')');

          $resultappstatus = $useridInwAppstatusQuery->all();
          $useridInappstatus = array();

          if($resultappstatus){
              foreach($resultappstatus as $value){
                  $resultarr[] = $value->userid;
              }
              $useridInappstatus = implode(',', $resultarr);

            $usereducation = Userformaleducation::find()->select('id, max(educationallevel) as maxedu, userid');
            if($this->applicantstatus){
              if($this->applicantstatus == 1){
              $usereducation->andWhere('userid IN (' . $useridInappstatus . ')');
              }
              if($this->applicantstatus == 2){
                $usereducation->andWhere('userid NOT IN (' . $useridInappstatus . ')');
              }
            }else{
              $usereducation->andWhere('userid IN (' . $usereducations . ')');
            }




            // if($this->jurusan){
            //   $usereducation->andWhere('majoring like "%' . $this->jurusan . '%"');
            // }
            $usereducation->groupBy('userid');
            if($this->education){
              $usereducation->having('maxedu = '.$this->education);
            }

          $educationquery = $usereducation->all();
          if($educationquery){
              $educationids = array();
              foreach($educationquery as $value){
                  $educationids[] = $value->id;
              }
              $useridInwLastedu = implode(',', $educationids);
              $useridInwMajorQuery = Userformaleducation::find();
              $useridInwMajorQuery->andWhere('id IN (' . $useridInwLastedu . ')');
              if($this->jurusan){
                $useridInwMajorQuery->andWhere('majoring like "%' . $this->jurusan . '%"');
              }
              $resultedu = $useridInwMajorQuery->all();
              $resulteduarr = array();
              if($resultedu){
                  foreach($resultedu as $value){
                      $resulteduarr[] = $value->userid;
                  }
                }

                $ret = $resulteduarr;
                }
          }
    return $ret;
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => 'Userid',
            'createtime' => 'Hiring time',
            'updatetime' => 'Updatetime',
            'perner' => 'Perner',
            'statushiring' => 'Hiring Status',
            'statusbiodata' => 'Update Data Status',
            'message' => 'SAP Message',
            'keterangan' => 'Remarks',
            'fullname' => 'Full Name',
            'tglinput' => 'Join Date',
            'awalkontrak' => 'Awal Kontrak',
            'akhirkontrak' => 'Akhir Kontrak',
            'createdby' => 'Created by',
            'updateby' => 'Updated by',
            'approvedby' => 'Approve by',
            'startawalkontrak' => 'Periode Awal Kontrak',
            'havenpwp' => 'NPWP',
            'jurusan' => 'Majoring',
            'applicantstatus' => 'Applicant Status',
            'registerstart' => 'Registration Period',
            'cityid' => 'Domicile City',
        ];
    }
}
