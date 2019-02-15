<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CompanyEstablishmentCard;

/**
 * CompanyEstablishmentCardSearch represents the model behind the search form about `common\models\CompanyEstablishmentCard`.
 */
class CompanyEstablishmentCardSearch extends CompanyEstablishmentCard
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'licensing_master_id', 'status', 'CB'], 'integer'],
            [['typing_service', 'service_reciept', 'payment_reciept', 'card_attachment', 'expiry_date', 'date', 'next_step', 'license', 'comment'], 'safe'],
            [['payment'], 'number'],
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
        $query = CompanyEstablishmentCard::find();

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
            'payment' => $this->payment,
            'expiry_date' => $this->expiry_date,
            'status' => $this->status,
            'CB' => $this->CB,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'typing_service', $this->typing_service])
            ->andFilterWhere(['like', 'service_reciept', $this->service_reciept])
            ->andFilterWhere(['like', 'payment_reciept', $this->payment_reciept])
            ->andFilterWhere(['like', 'card_attachment', $this->card_attachment])
            ->andFilterWhere(['like', 'next_step', $this->next_step])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
