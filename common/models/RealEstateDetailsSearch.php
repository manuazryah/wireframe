<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RealEstateDetails;

/**
 * RealEstateDetailsSearch represents the model behind the search form about `common\models\RealEstateDetails`.
 */
class RealEstateDetailsSearch extends RealEstateDetails {

    public $total_amount;
    public $paid_amount;
    public $balance_amount;
    public $contract_expiry;
    public $next_payment;
    public $contract_start;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'master_id', 'category', 'availability', 'customer_id', 'square_feet', 'status', 'CB', 'UB', 'appointment_id', 'sponsor', 'sales_person', 'office_type',], 'integer'],
            [['code', 'comment', 'DOC', 'DOU'], 'safe'],
            [['cost', 'rent_cost', 'off_rent'], 'number'],
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
        $query = RealEstateDetails::find();
//        $query->joinWith(['master']);
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
            'master_id' => $this->master_id,
            'category' => $this->category,
            'availability' => $this->availability,
            'customer_id' => $this->customer_id,
            'appointment_id' => $this->appointment_id,
            'sponsor' => $this->sponsor,
            'sales_person' => $this->sales_person,
            'office_type' => $this->office_type,
            'cost' => $this->cost,
            'rent_cost' => $this->rent_cost,
            'off_rent' => $this->off_rent,
            'square_feet' => $this->square_feet,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
                ->andFilterWhere(['like', 'real_estate_master.id', $this->master_id])
                ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }

}
