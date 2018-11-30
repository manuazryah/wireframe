<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SideAgreementAdding;

/**
 * SideAgreementAddingSearch represents the model behind the search form about `common\models\SideAgreementAdding`.
 */
class SideAgreementAddingSearch extends SideAgreementAdding {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'sponsor_amount', 'status', 'CB', 'UB'], 'integer'],
            [['represented_by', 'second_party_name', 'date', 'office_no', 'office_address', 'location', 'activity', 'payment_details', 'ejari_start_date', 'ejari_end_date', 'contract_start_date', 'contract_end_date', 'DOC', 'DOU'], 'safe'],
            [['amount'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = SideAgreementAdding::find();

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
            'represented_by' => $this->represented_by,
            'date' => $this->date,
            'amount' => $this->amount,
            'ejari_start_date' => $this->ejari_start_date,
            'ejari_end_date' => $this->ejari_end_date,
            'sponsor_amount' => $this->sponsor_amount,
            'contract_start_date' => $this->contract_start_date,
            'contract_end_date' => $this->contract_end_date,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'second_party_name', $this->second_party_name])
                ->andFilterWhere(['like', 'office_no', $this->office_no])
                ->andFilterWhere(['like', 'office_address', $this->office_address])
                ->andFilterWhere(['like', 'location', $this->location])
                ->andFilterWhere(['like', 'activity', $this->activity])
                ->andFilterWhere(['like', 'payment_details', $this->payment_details]);

        return $dataProvider;
    }

}
