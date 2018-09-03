<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LicencingMaster;

/**
 * LicencingMasterSearch represents the model behind the search form about `common\models\LicencingMaster`.
 */
class LicencingMasterSearch extends LicencingMaster
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'appointment_id', 'customer_id', 'sponsor', 'plot', 'space_for_licence', 'no_of_partners', 'status', 'CB'], 'integer'],
            [['appointment_no', 'stage', 'comment', 'DOC'], 'safe'],
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
        $query = LicencingMaster::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'appointment_id' => $this->appointment_id,
            'customer_id' => $this->customer_id,
            'sponsor' => $this->sponsor,
            'plot' => $this->plot,
            'space_for_licence' => $this->space_for_licence,
            'no_of_partners' => $this->no_of_partners,
            'status' => $this->status,
            'CB' => $this->CB,
            'DOC' => $this->DOC,
        ]);

        $query->andFilterWhere(['like', 'appointment_no', $this->appointment_no])
            ->andFilterWhere(['like', 'stage', $this->stage])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
