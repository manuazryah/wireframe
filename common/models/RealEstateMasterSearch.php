<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RealEstateMaster;

/**
 * RealEstateMasterSearch represents the model behind the search form about `common\models\RealEstateMaster`.
 */
class RealEstateMasterSearch extends RealEstateMaster {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'company', 'total_square_feet', 'sponsor', 'number_of_license', 'number_of_plots', 'no_of_cheques', 'status', 'CB', 'UB', 'type'], 'integer'],
            [['reference_code', 'comany_name_for_ejari', 'comment', 'attachments', 'DOC', 'DOU'], 'safe'],
            [['rent_total', 'commission', 'deposit', 'sponser_fee', 'furniture_expense', 'office_renovation_expense', 'other_expense'], 'number'],
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
        $query = RealEstateMaster::find();

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
            'company' => $this->company,
            'type' => $this->type,
            'total_square_feet' => $this->total_square_feet,
            'sponsor' => $this->sponsor,
            'number_of_license' => $this->number_of_license,
            'number_of_plots' => $this->number_of_plots,
            'rent_total' => $this->rent_total,
            'no_of_cheques' => $this->no_of_cheques,
            'commission' => $this->commission,
            'deposit' => $this->deposit,
            'sponser_fee' => $this->sponser_fee,
            'furniture_expense' => $this->furniture_expense,
            'office_renovation_expense' => $this->office_renovation_expense,
            'other_expense' => $this->other_expense,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'reference_code', $this->reference_code])
                ->andFilterWhere(['like', 'comany_name_for_ejari', $this->comany_name_for_ejari])
                ->andFilterWhere(['like', 'comment', $this->comment])
                ->andFilterWhere(['like', 'attachments', $this->attachments]);

        return $dataProvider;
    }

}
