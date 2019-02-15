<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AppointmentService;

/**
 * AppointmentServiceSearch represents the model behind the search form about `common\models\AppointmentService`.
 */
class AppointmentServiceSearch extends AppointmentService
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'appointment_id', 'service', 'tax', 'type', 'tax_percentage', 'payment_type', 'status', 'CB', 'UB'], 'integer'],
            [['comment', 'due_amount', 'amount_paid', 'DOC', 'DOU'], 'safe'],
            [['amount', 'total', 'tax_amount'], 'number'],
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
        $query = AppointmentService::find();

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
            'service' => $this->service,
            'amount' => $this->amount,
            'tax' => $this->tax,
            'type' => $this->type,
            'total' => $this->total,
            'tax_percentage' => $this->tax_percentage,
            'tax_amount' => $this->tax_amount,
            'payment_type' => $this->payment_type,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'due_amount', $this->due_amount])
            ->andFilterWhere(['like', 'amount_paid', $this->amount_paid]);

        return $dataProvider;
    }
}
