<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PaymentVoucher;

/**
 * PaymentVoucherSearch represents the model behind the search form about `common\models\PaymentVoucher`.
 */
class PaymentVoucherSearch extends PaymentVoucher {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'status', 'CB', 'licensing_master_id'], 'integer'],
            [['ejari', 'main_license', 'noc', 'service_receipt', 'voucher_attachment', 'date', 'next_step', 'comment'], 'safe'],
            [['service_cost'], 'number'],
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
        $query = PaymentVoucher::find();

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
            'licensing_master_id' => $this->licensing_master_id,
            'service_cost' => $this->service_cost,
            'status' => $this->status,
            'CB' => $this->CB,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'ejari', $this->ejari])
                ->andFilterWhere(['like', 'main_license', $this->main_license])
                ->andFilterWhere(['like', 'noc', $this->noc])
                ->andFilterWhere(['like', 'service_receipt', $this->service_receipt])
                ->andFilterWhere(['like', 'voucher_attachment', $this->voucher_attachment])
                ->andFilterWhere(['like', 'next_step', $this->next_step])
                ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }

}
