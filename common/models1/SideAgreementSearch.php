<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SideAgreement;

/**
 * SideAgreementSearch represents the model behind the search form about `common\models\SideAgreement`.
 */
class SideAgreementSearch extends SideAgreement
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'appointment_id', 'status', 'CB', 'UB'], 'integer'],
            [['date', 'company_name', 'represented_by', 'office_no', 'offfice_address', 'activity', 'office_statrt_date', 'office_end_date', 'payment_details', 'DOC', 'DOU'], 'safe'],
            [['payment', 'sponsor_amount'], 'number'],
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
        $query = SideAgreement::find();

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
            'date' => $this->date,
            'payment' => $this->payment,
            'office_statrt_date' => $this->office_statrt_date,
            'office_end_date' => $this->office_end_date,
            'sponsor_amount' => $this->sponsor_amount,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'represented_by', $this->represented_by])
            ->andFilterWhere(['like', 'office_no', $this->office_no])
            ->andFilterWhere(['like', 'offfice_address', $this->offfice_address])
            ->andFilterWhere(['like', 'activity', $this->activity])
            ->andFilterWhere(['like', 'payment_details', $this->payment_details]);

        return $dataProvider;
    }
}
