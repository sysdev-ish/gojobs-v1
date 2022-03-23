<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Recruitmentcandidate;
use app\models\Hiring;

/**
 * Recruitmentcandidatesearch represents the model behind the search form of `app\models\Recruitmentcandidate`.
 */
class Recruitmentcandidatefhsearch extends Recruitmentcandidate
{
  public $fullname;
  public $nojo;
  public $city;
  public $jabatans;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid', 'recruitreqid', 'status','typeinterview'], 'integer'],
            [['createtime', 'updatetime','fullname','nojo','city','invitationnumber','jabatans'], 'safe'],
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
        $query = Recruitmentcandidate::find( Yii::$app->get('db'));
        $query->joinWith("userprofile");
        // $query->With(array('hiringproc'));
        // $query->condition('hiringproc.id IS NULL');

        // $query->where('statushiring = 4');
        //$query->joinWith("recrequest");
        // $query->joinWith("recrequest")->all(Yii::$app->get('dbjo'));
        // $query->leftJoin('hiring', 'hiring.userid = recruitmentcandidate.userid');
        $subQuery = Hiring::find()->select('userid')->where('statushiring <> 5 AND statushiring <> 6 AND statushiring <> 7');
        $query->where(['not in', 'recruitmentcandidate.userid', $subQuery]);
        $query->andWhere('recruitmentcandidate.status = 4');

        // $query->where('recruitmentcandidate.userid IN(select userid from hiring where statushiring <> 5) ');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'userid' => $this->userid,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
            'recruitreqid' => $this->recruitreqid,
            'recruitreqid' => $this->nojo,
            'status' => $this->status,
            'typeinterview' => $this->typeinterview,

        ]);

        $query->andFilterWhere(['like', 'fullname', $this->fullname])
              ->andFilterWhere(['like', 'invitationnumber', $this->invitationnumber]);

        if($this->city){
          $getJoId = $this->joByCity($this->city);
          if($getJoId){
            $getJoid = implode(',', $getJoId);
            $query->andWhere('recruitreqid IN (' . $getJoid . ')');
          }
        }
        // var_dump($this->jabatans);die;

        if($this->jabatans){
          $getJoId = $this->joByJabatansap($this->jabatans);
          if($getJoId){
            $getJoid = implode(',', $getJoId);
            $query->andWhere('recruitreqid IN (' . $getJoid . ')');
          }
        }

        return $dataProvider;
    }


    protected function joByCity($city=null){
      $ret = null;

      if($city){
        $getCity = MappingCity::find()->andWhere('city_name LIKE :city_name', [':city_name' => '%' . $city . '%'])->all();
        if($getCity){
          $cityIds = array();
          foreach($getCity as $gc){
            $cityIds[] = $gc->city_id;
          }

          if(count($cityIds) > 0){
            //$transRincian = Transrincian::find()->andWhere('lokasi = :lokasi', [':lokasi' => $getCity->city_id])->all();
            $transRincian = Transrincian::find()->andWhere('lokasi IN ("' . implode('","', $cityIds) . '")', [])->all();
            if($transRincian){
                $transRincianIds = array();
                foreach($transRincian as $tr){
                  $transRincianIds[] = $tr->id;
                }

                $ret = $transRincianIds;
            }
          }
        }
      }
      return $ret;
    }
    protected function joByJabatansap($jabatan=null){
      $ret = null;

      if($jabatan){
        $getJabatan = Sapjob::find()->andWhere('value2 LIKE :value2', [':value2' => '%' . $jabatan . '%'])->all();
        if($getJabatan){
          $jabatanid = array();
          foreach($getJabatan as $gj){
            $jabatanid[] = $gj->value1;
          }

          if(count($jabatanid) > 0){
            //$transRincian = Transrincian::find()->andWhere('lokasi = :lokasi', [':lokasi' => $getCity->city_id])->all();
            $transRincian = Transrincian::find()->andWhere('hire_jabatan_sap IN ("' . implode('","', $jabatanid) . '")', [])->all();
            if($transRincian){
                $transRincianIds = array();
                foreach($transRincian as $tr){
                  $transRincianIds[] = $tr->id;
                }

                $ret = $transRincianIds;
            }
          }
        }
      }
      return $ret;
    }
}
