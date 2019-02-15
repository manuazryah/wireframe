<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\NewStamp;

/**
 * NewStampSearch represents the model behind the search form about `common\models\NewStamp`.
 */
class NewStampSearch extends NewStamp
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'licensing_master_id', 'status', 'CB'], 'integer'],
            [['payment'], 'number'],
            [['receipt', 'date', 'next_step', 'comment'], 'safe'],
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
        $query = NewStamp::find();

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
            'status' => $this->status,
            'CB' => $this->CB,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'receipt', $this->receipt])
            ->andFilterWhere(['like', 'next_step', $this->next_step])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
