<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Userprofile;

/**
 * Userprofilesearch represents the model behind the search form of `app\models\Userprofile`.
 */
class Userprofilesearch extends Userprofile
{
  public $cityname;
  public $industry;
  public $lastposition;
  public $jobfamily;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid'], 'integer'],
            [['createtime', 'updatetime', 'fullname', 'nickname', 'gender', 'birthdate', 'birthplace', 'address', 'postalcode', 'phone', 'domicilestatus', 'domicilestatusdescription', 'addressktp', 'nationality', 'religion', 'maritalstatus', 'weddingdate', 'bloodtype', 'identitynumber', 'jamsosteknumber', 'npwpnumber', 'drivinglicencecarnumber', 'drivinglicencemotorcyclenumber','cityname'
            ,'jobfamily','lastposition','industry'], 'safe'],
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
        $query->joinWith("city");
        $query->joinWith("userworkexperience");
        $query->leftJoin('mastersubjobfamily', 'mastersubjobfamily.subjobfamily = userworkexperience.lastposition');
        // add conditions that should always apply here

        //addbykaha
        $subQuery = 'SELECT lastposition FROM userworkexperience LEFT JOIN mastersubjobfamily ON mastersubjobfamily.subjobfamily = userworkexperience.lastposition';

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // var_dump($subQuery);die;
        //adbykaha
        // if($this->lastposition) {
        //     $subQuery .= ' WHERE mastersubjobfamily.id';
        //     $subQuery = Yii::$app->db->createCommand($subQuery)->bindValue(':id', $this->lastposition);
        //     if($subQuery) {
        //         $arrValue = [];
        //         foreach ($subQuery as $sub) {
        //             $arrValue = $sub['lastposition'];
        //         }
        //         if(count($arrValue) > 0) $query->andWhere('masterjobfamily.id IN (' . implode(',', $array). ')', []);
        //     }
        //     else {
        //         $query->andWhere('masterjobfamily.id IN (null)');
        //     }
        // }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'userid' => $this->userid,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
            'birthdate' => $this->birthdate,
            'weddingdate' => $this->weddingdate,
            'gender' => $this->gender,
        ]);

        $query->andFilterWhere(['like', 'fullname', $this->fullname])
            ->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'birthplace', $this->birthplace])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'postalcode', $this->postalcode])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'domicilestatus', $this->domicilestatus])
            ->andFilterWhere(['like', 'domicilestatusdescription', $this->domicilestatusdescription])
            ->andFilterWhere(['like', 'addressktp', $this->addressktp])
            ->andFilterWhere(['like', 'nationality', $this->nationality])
            ->andFilterWhere(['like', 'religion', $this->religion])
            ->andFilterWhere(['like', 'maritalstatus', $this->maritalstatus])
            ->andFilterWhere(['like', 'bloodtype', $this->bloodtype])
            ->andFilterWhere(['like', 'identitynumber', $this->identitynumber])
            ->andFilterWhere(['like', 'jamsosteknumber', $this->jamsosteknumber])
            ->andFilterWhere(['like', 'npwpnumber', $this->npwpnumber])
            ->andFilterWhere(['like', 'drivinglicencecarnumber', $this->drivinglicencecarnumber])
            ->andFilterWhere(['like', 'drivinglicencemotorcyclenumber', $this->drivinglicencemotorcyclenumber])
            ->andFilterWhere(['like', 'kota', $this->cityname])
            ->andFilterWhere(['like', 'userworkexperience.industry', $this->industry])
            // ->andFilterWhere(['like', 'userworkexperience.lastposition', $this->lastposition])
            ->andFilterWhere(['like', 'mastersubjobfamily.id', $this->lastposition])
            ->andFilterWhere(['like', 'mastersubjobfamily.jobfamily_id', $this->jobfamily]);

        return $dataProvider;
    }
}
