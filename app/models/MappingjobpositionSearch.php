<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Mappingjobposition;

/**
 * MappingjobpositionSearch represents the model behind the search form of `app\models\Mappingjobposition`.
 */
class MappingjobpositionSearch extends Mappingjobposition
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'subjobfamilyid'], 'integer'],
            [['jabatansap', 'kodejabatan', 'status','createtime', 'updatetime'], 'safe'],
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
        $query = Mappingjobposition::find();
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
            'subjobfamilyid' => $this->subjobfamilyid,
            // 'kodejabatan' => $this->kodejabatan,
            'status' => $this->status,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
        ]);

        $query->andFilterWhere(['like', 'kodejabatan', $this->kodejabatan])
        ->andFilterWhere(['like', 'jabatansap', $this->jabatansap]);
            // ->andFilterWhere(['like', 'kodeposisi', $this->kodeposisi]);
        if ($this->kodejabatan) {
            $getkodejabatan = $this->bykodejab();
            if ($getkodejabatan) {
                $getkodejabatan = '"' . implode('","', $getkodejabatan) . '"';
                $query->andWhere('kodejabatan IN (' . $getkodejabatan . ')');
            }
        }
        if ($this->jabatansap) {
            $getjabatansap = $this->byjabsap();
            if ($getjabatansap) {
                $getjabatansap = implode(',', $getjabatansap);
                $query->andWhere('jabatansap IN (' . $getjabatansap . ')');
            }
        }
        return $dataProvider;
    }


    // public static function getJabsap()
    // {
    //     $dataJabsap = Sapjob::find()
    //         ->select(['value2 as value', 'value2 as label', 'value1 as id'])
    //         ->asArray()
    //         ->all();

    //     return $dataJabsap;
    // }

    protected function bykodejab()
    {
        $ret = null;
        // $kodejabatan = Sapjob::find();
        if ($this->kodejabatan) {
            $getkodejabatan = Sapjob::find()->andWhere('value1 LIKE :value1', [':value1' => '%' . $this->kodejabatan . '%'])->all();
            if ($getkodejabatan) {
                $kodejabatan = array();
                foreach ($getkodejabatan as $value) {
                    $kodejabatan[] = $value->value1;
                }
                $ret = $kodejabatan;
            }
        }
        return $ret;
    }
    protected function byjabsap()
    {
        $ret = null;
        // $jabatansap = Sapjob::find();
        if ($this->jabatansap) {
            $getjabatansap = Sapjob::find()->andWhere('value2 LIKE :value2', [':value2' => '%' . $this->jabatansap . '%'])->all();
            if ($getjabatansap) {
                $jabatansap = array();
                foreach ($getjabatansap as $value) {
                    $jabatansap[] = $value->value1;
                }
                $ret = $jabatansap;
            }
        }
        return $ret;
    }
}
