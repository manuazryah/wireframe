<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Rta;

/**
 * RtaSearch represents the model behind the search form about `common\models\Rta`.
 */
class RtaSearch extends Rta
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'licensing_master_id', 'CB'], 'integer'],
            [['online_refrerence_number', 'payment_receipt', 'approval_fees_receipt', 'approval_certificate', 'date', 'next_step', 'comment'], 'safe'],
            [['online_application_fees', 'rta_approval_fees'], 'number'],
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
        $query = Rta::find();

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
            'online_application_fees' => $this->online_application_fees,
            'rta_approval_fees' => $this->rta_approval_fees,
            'CB' => $this->CB,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'online_refrerence_number', $this->online_refrerence_number])
            ->andFilterWhere(['like', 'payment_receipt', $this->payment_receipt])
            ->andFilterWhere(['like', 'approval_fees_receipt', $this->approval_fees_receipt])
            ->andFilterWhere(['like', 'approval_certificate', $this->approval_certificate])
            ->andFilterWhere(['like', 'next_step', $this->next_step])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
