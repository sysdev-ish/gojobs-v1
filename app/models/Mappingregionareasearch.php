<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Mappingregionarea;

/**
 * Mappingregionareasearch represents the model behind the search form of `app\models\Mappingregionarea`.
 */
class Mappingregionareasearch extends Mappingregionarea
{
  public $area;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'areaishid', 'createdby', 'updatedby'], 'integer'],
            [['regionid', 'areaid', 'createtime', 'updatetime','area'], 'safe'],
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
        $query = Mappingregionarea::find();
        // $query->joinWith('masterarea');

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
            'areaishid' => $this->areaishid,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
            'createdby' => $this->createdby,
            'updatedby' => $this->updatedby,
        ]);

        $query->andFilterWhere(['like', 'regionid', $this->regionid])
            ->andFilterWhere(['like', 'areaid', $this->areaid]);

        if($this->area){
          $getareaid = $this->byarea();
          // var_dump($getareaid);die;
          if($getareaid){
            $getareaid = '"'.implode('","', $getareaid).'"';
            $query->andWhere('areaid IN (' . $getareaid . ')');
          }
        }

        return $dataProvider;
    }
    protected function byarea(){
        $ret = null;
            $saparea = Saparea::find();
            if($this->area){
              $getareaid = Saparea::find()->andWhere('value2 LIKE :value2', [':value2' => '%' . $this->area . '%'])->all();
              if($getareaid){
                $areaid = array();
                foreach($getareaid as $value){
                  $areaid[] = $value->value1;
                }
                $ret = $areaid;
              }
            }
      return $ret;
    }
}
