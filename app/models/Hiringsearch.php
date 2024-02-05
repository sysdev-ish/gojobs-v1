<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Hiring;

/**
 * Hiringsearch represents the model behind the search form of `app\models\Hiring`.
 */
class Hiringsearch extends Hiring
{
  public $fullname;
  public $nojo;
  public $typejorincian;
  public $areasap;
  public $jabatansap;
  public $status;
  public $userpm;
  /**
   * @inheritdoc
   */
  public function rules()
  {
    return [
      [['id', 'userid', 'perner', 'statushiring', 'statusbiodata', 'typejo', 'typejorincian', 'status'], 'integer'],
      [['createtime', 'updatetime', 'fullname', 'areasap', 'jabatansap', 'nojo', 'userpm', 'tglinput'], 'safe'],
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
    $query = Hiring::find();
    $query->joinWith("userprofile");
    // $query->joinWith("recrequest");

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
      'hiring.id' => $this->id,
      // 'userid' => $this->userid,
      'createtime' => $this->createtime,
      'updatetime' => $this->updatetime,
      'perner' => $this->perner,
      'typejo' => $this->typejo,
      // 'typejorincian' => $this->typejorincian,
    ]);

    if ($this->userid) {
      $query->andFilterWhere(['=', 'userprofile.userid', $this->userid]);
    }

    if ($this->status) {
      $query->andWhere([
        'or',
        ['statushiring' => $this->status],
        ['statusbiodata' => $this->status]
      ]);
    }
    $query->andFilterWhere(['like', 'fullname', $this->fullname]);
    // add by kaha 23/9/2023 -> filtering data
    $query->andFilterWhere(['like', 'tglinput', date("$this->tglinput")]);

    if ($this->nojo) {
      $getJoId = $this->joBynojo();
      // var_dump($getJoId);die;
      if ($getJoId) {
        $getJoid = implode(',', $getJoId);
        $query->andWhere('recruitreqid IN (' . $getJoid . ')');
      } else {
        $query->andWhere('recruitreqid IN (null)');
      }
    }

    if ($this->typejorincian) {
      $getJoId = $this->joBytype();
      // var_dump($getJoId);die;
      if ($getJoId) {
        $getJoid = implode(',', $getJoId);
        $query->andWhere('recruitreqid IN (' . $getJoid . ')');
      } else {
        $query->andWhere('recruitreqid IN (null)');
      }
    }
    if ($this->areasap) {
      $getJoId = $this->joByarea();
      // var_dump($getJoId);die;
      if ($getJoId) {
        $getJoid = implode(',', $getJoId);
        $query->andWhere('recruitreqid IN (' . $getJoid . ')');
      } else {
        $query->andWhere('recruitreqid IN (null)');
      }
    }
    if ($this->jabatansap) {
      $getJoId = $this->joByjabatan();
      // var_dump($getJoId);die;
      if ($getJoId) {
        $getJoid = implode(',', $getJoId);
        $query->andWhere('recruitreqid IN (' . $getJoid . ')');
      } else {
        $query->andWhere('recruitreqid IN (null)');
      }
    }
    if ($this->userpm) {
      $getJoId = $this->joByuserpm();
      // var_dump($getJoId);die;
      if ($getJoId) {
        $getJoid = implode(',', $getJoId);
        $query->andWhere('recruitreqid IN (' . $getJoid . ')');
      } else {
        $query->andWhere('recruitreqid IN (null)');
      }
    }

    return $dataProvider;
  }
  protected function joBynojo()
  {
    $ret = null;
    $nojo = $this->nojo;
    if ($nojo) {
      $transRincian = Transrincian::find()->andWhere('nojo like "%' . $nojo . '%"')->all();
      if ($transRincian) {
        $transRincianIds = array();
        foreach ($transRincian as $tr) {
          $transRincianIds[] = $tr->id;
        }
        $ret = $transRincianIds;
      }
    }
    return $ret;
  }
  protected function joBytype()
  {
    $ret = null;
    $typejo = $this->typejorincian;
    if ($typejo) {
      $transRincian = Transrincian::find()->andWhere(['typejo' => $typejo])->all();
      if ($transRincian) {
        $transRincianIds = array();
        foreach ($transRincian as $tr) {
          $transRincianIds[] = $tr->id;
        }
        $ret = $transRincianIds;
      }
    }
    return $ret;
  }
  protected function joByarea()
  {
    $ret = null;
    $areasap = $this->areasap;
    if ($areasap) {
      $getArea = Saparea::find()->andWhere('value2 LIKE :value2', [':value2' => '%' . $areasap . '%'])->all();
      if ($getArea) {
        $areaIds = array();
        foreach ($getArea as $value) {
          $areaIds[] = $value->value1;
        }

        if (count($areaIds) > 0) {
          //$transRincian = Transrincian::find()->andWhere('lokasi = :lokasi', [':lokasi' => $getCity->city_id])->all();
          $transRincian = Transrincian::find()->andWhere('area_sap IN ("' . implode('","', $areaIds) . '")', [])->all();
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
  protected function joByjabatan()
  {
    $ret = null;
    $jabatansap = $this->jabatansap;
    if ($jabatansap) {
      $getJabatan = Sapjob::find()->andWhere('value2 LIKE :value2', [':value2' => '%' . $jabatansap . '%'])->all();
      if ($getJabatan) {
        $jabatanIds = array();
        foreach ($getJabatan as $value) {
          $jabatanIds[] = $value->value1;
        }

        if (count($jabatanIds) > 0) {
          //$transRincian = Transrincian::find()->andWhere('lokasi = :lokasi', [':lokasi' => $getCity->city_id])->all();
          $transRincian = Transrincian::find()->andWhere('hire_jabatan_sap IN ("' . implode('","', $jabatanIds) . '")', [])->all();
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
  protected function joByuserpm()
  {
    $ret = null;
    $userpm = $this->userpm;
    if ($userpm) {
      $getuserpm = Userlogin::find()->andWhere('name LIKE :name', [':name' => '%' . $userpm . '%'])->all();
      if ($getuserpm) {
        $userpmIds = array();
        foreach ($getuserpm as $value) {
          $userpmIds[] = $value->username;
          $userpmOthersIds[] = $value->othersid;
        }

        if (count($userpmIds) > 0) {
          //$transRincian = Transrincian::find()->andWhere('lokasi = :lokasi', [':lokasi' => $getCity->city_id])->all();

          $transRincian = Transrincian::find()->andWhere('userpm IN ("' . implode('","', $userpmIds) . '")OR userpm IN ("' . implode('","', $userpmOthersIds) . '")', [])->all();

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
}
