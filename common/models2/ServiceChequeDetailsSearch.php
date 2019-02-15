<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ServiceChequeDetails;

/**
 * ServiceChequeDetailsSearch represents the model behind the search form about `common\models\ServiceChequeDetails`.
 */
class ServiceChequeDetailsSearch extends ServiceChequeDetails {

    public $created_at_range;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'type', 'appointment_id', 'appointment_service_id', 'service_id', 'status', 'CB', 'UB'], 'integer'],
            [['cheque_number', 'cheque_date', 'DOC', 'DOU', 'created_at_range'], 'safe'],
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
        $query = ServiceChequeDetails::find()->orderBy(['cheque_date' => SORT_ASC]);

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
            'type' => $this->type,
            'appointment_id' => $this->appointment_id,
            'appointment_service_id' => $this->appointment_service_id,
            'service_id' => $this->service_id,
            'cheque_date' => $this->cheque_date,
            'amount' => $this->amount,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'cheque_number', $this->cheque_number]);
        if (isset($this->created_at_range) && $this->created_at_range != '') { //you dont need the if function if yourse sure you have a not null date
            $date_explode = explode(" - ", $this->created_at_range);
            $date1 = trim($date_explode[0]);
            $date2 = trim($date_explode[1]);
            $query->andFilterWhere(['between', 'cheque_date', $date1, $date2]);
        }

        return $dataProvider;
    }

}
