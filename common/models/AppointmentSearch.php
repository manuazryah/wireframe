<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Appointment;

/**
 * AppointmentSearch represents the model behind the search form about `common\models\Appointment`.
 */
class AppointmentSearch extends Appointment {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'customer', 'service_type', 'sponsor', 'tax', 'supplier', 'no_partners', 'approval_status', 'sales_employee_id', 'accounts_employee_id', 'operations_employee_id', 'status', 'CB', 'UB'], 'integer'],
            [['service_id', 'start_date', 'expiry_date', 'total_amount', 'paid_amount', 'comment', 'DOC', 'DOU', 'plot', 'space_for_license'], 'safe'],
            [['estimated_cost'], 'number'],
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
        $query = Appointment::find()->orderBy(['id' => SORT_DESC]);

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
            'customer' => $this->customer,
            'service_type' => $this->service_type,
            'plot' => $this->plot,
            'space_for_license' => $this->space_for_license,
            'estimated_cost' => $this->estimated_cost,
            'sponsor' => $this->sponsor,
            'tax' => $this->tax,
            'supplier' => $this->supplier,
            'no_partners' => $this->no_partners,
            'start_date' => $this->start_date,
            'expiry_date' => $this->expiry_date,
            'approval_status' => $this->approval_status,
            'sales_employee_id' => $this->sales_employee_id,
            'accounts_employee_id' => $this->accounts_employee_id,
            'operations_employee_id' => $this->operations_employee_id,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'service_id', $this->service_id])
                ->andFilterWhere(['like', 'total_amount', $this->total_amount])
                ->andFilterWhere(['like', 'paid_amount', $this->paid_amount])
                ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }

}
