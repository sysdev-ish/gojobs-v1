<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Interview;

/**
 * Interviewsearch represents the model behind the search form of `app\models\Interview`.
 */
class Interviewsearch extends Interview
{
  public $fullname;
  public $jabatansap;
  public $city;
  public $nojo;
  /**
   * @inheritdoc
   */
  public function rules()
  {
    return [
      [['id', 'userid', 'status', 'recruitmentcandidateid', 'pic'], 'integer'],
      [['createtime', 'updatetime', 'scheduledate', 'date', 'fullname', 'jabatansap', 'city', 'nojo'], 'safe'],
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
    $query = Interview::find();
    $query->joinWith("userprofile");
    $query->joinWith("reccandidate");

    // add conditions that should always apply here
    if (Yii::$app->user->isGuest) {
      $userid = null;
      $role = null;
    } else {
      $userid = Yii::$app->user->identity->id;
      $role = Yii::$app->user->identity->role;
    }
    if ($role == 7) {
      $query->where(['pic' => $userid]);
    }

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

    // add by kaha 23/9/2023 -> filtering data
    if ($this->city) {
      $getJoId = $this->joByCity($this->city);
      if ($getJoId) {
        $getJoid = implode(',', $getJoId);
        $query->andWhere('recruitreqid IN (' . $getJoid . ')');
      } else {
        $query->andWhere('recruitreqid IN (null)');
      }
    }

    // add by kaha 23/9/2023 -> filtering data
    if ($this->jabatansap) {
      $getJoId = $this->joByJabatansap($this->jabatansap);
      if ($getJoId) {
        $getJoid = implode(',', $getJoId);
        $query->andWhere('recruitreqid IN (' . $getJoid . ')');
      }
    }

    if ($this->nojo) {
      $getJoId = $this->joBynojo($this->nojo);

      if ($getJoId) {
        $getJoid = implode(',', $getJoId);
        $query->andWhere('recruitreqid IN (' . $getJoid . ')');
      } else {
        $query->andWhere('recruitreqid IN (null)');
      }
    }

    // grid filtering conditions
    $query->andFilterWhere([
      'id' => $this->id,
      'userid' => $this->userid,
      'createtime' => $this->createtime,
      'updatetime' => $this->updatetime,
      // 'scheduledate' => $this->scheduledate,
      'date' => $this->date,
      'interview.status' => $this->status,
      'recruitmentcandidateid' => $this->recruitmentcandidateid,
      'pic' => $this->pic,
    ]);

    $query->andFilterWhere(['like', 'fullname', $this->fullname]);
    // add by kaha 23/9/2023 -> filtering data
    $query->andFilterWhere(['like', 'scheduledate', date("$this->scheduledate")]);

    return $dataProvider;
  }

  // add by kaha 23/9/2023 -> filtering data
  protected function joByCity($city = null)
  {
    $ret = null;

    if ($city) {
      $getCity = MappingCity::find()->andWhere('city_name LIKE :city_name', [':city_name' => '%' . $city . '%'])->all();
      if ($getCity) {
        $cityIds = array();
        foreach ($getCity as $gc) {
          $cityIds[] = $gc->city_id;
        }

        if (count($cityIds) > 0) {
          //$transRincian = Transrincian::find()->andWhere('lokasi = :lokasi', [':lokasi' => $getCity->city_id])->all();
          $transRincian = Transrincian::find()->andWhere('lokasi IN ("' . implode('","', $cityIds) . '")', [])->all();
          if ($transRincian) {
            $transRincianIds = array();
            foreach ($transRincian as $tr) {
              $transRincianIds[] = $tr->id;
            }

            $ret = $transRincianIds;
          }
        }
      }
    }
    return $ret;
  }

  // add by kaha 23/9/2023 -> filtering data
  protected function joByJabatansap($jabatan = null)
  {
    $ret = null;

    if ($jabatan) {
      // $getJabatan = Sapjob::find()->andWhere('value2 LIKE :value2', [':value2' => '%' . $jabatan . '%'])->all();
      // var_dump($jabatan);die;
      $getJabatan = Sapjob::find()->andWhere('value2 like "%' . $jabatan . '%"')->all();
      if ($getJabatan) {
        $jabatanid = array();
        foreach ($getJabatan as $gj) {
          $jabatanid[] = $gj->value1;
        }

        if (count($jabatanid) > 0) {
          //$transRincian = Transrincian::find()->andWhere('lokasi = :lokasi', [':lokasi' => $getCity->city_id])->all();
          $transRincian = Transrincian::find()->andWhere('hire_jabatan_sap IN ("' . implode('","', $jabatanid) . '")', [])->all();
          if ($transRincian) {
            $transRincianIds = array();
            foreach ($transRincian as $tr) {
              $transRincianIds[] = $tr->id;
            }

            $ret = $transRincianIds;
          }
        }
      }
    }
    return $ret;
  }

  protected function joBynojo($nojo = null)
  {
    $ret = null;
    $nojo = $this->nojo;
    // var_dump($nojo);die;
    if ($nojo) {
      $transRincian = Transrincian::find()->andWhere('nojo like "%' . $nojo . '%" ')->all();
      // var_dump($transRincian);die();
      if ($transRincian) {
        $transRincianIds = array();
        foreach ($transRincian as $tr) {
          $transRincianIds[] = $tr->id;
        }
        $ret = $transRincianIds;
      }
    }
    // var_dump($ret);die();
    return $ret;
  }
}
