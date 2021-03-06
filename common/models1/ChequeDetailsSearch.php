<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ChequeDetails;

/**
 * ChequeDetailsSearch represents the model behind the search form about `common\models\ChequeDetails`.
 */
class ChequeDetailsSearch extends ChequeDetails {

    public $created_at_range;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'master_id', 'status', 'CB', 'UB'], 'integer'],
            [['cheque_no', 'due_date', 'DOC', 'DOU', 'created_at_range'], 'safe'],
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
        $query = ChequeDetails::find();

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
            'due_date' => $this->due_date,
            'amount' => $this->amount,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'cheque_no', $this->cheque_no]);
        if (isset($this->created_at_range) && $this->created_at_range != '') { //you dont need the if function if yourse sure you have a not null date
            $date_explode = explode(" - ", $this->created_at_range);
            $date1 = trim($date_explode[0]);
            $date2 = trim($date_explode[1]);
            $query->andFilterWhere(['between', 'due_date', $date1, $date2]);
        }

        return $dataProvider;
    }

}
