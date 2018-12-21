<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Notifications;

/**
 * NotificationsSearch represents the model behind the search form about `common\models\Notifications`.
 */
class NotificationsSearch extends Notifications
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'data_id', 'master_id', 'notification_type', 'status'], 'integer'],
            [['notification_content', 'users', 'link', 'date', 'doc'], 'safe'],
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
        $query = Notifications::find();

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
            'data_id' => $this->data_id,
            'master_id' => $this->master_id,
            'notification_type' => $this->notification_type,
            'date' => $this->date,
            'status' => $this->status,
            'doc' => $this->doc,
        ]);

        $query->andFilterWhere(['like', 'notification_content', $this->notification_content])
            ->andFilterWhere(['like', 'users', $this->users])
            ->andFilterWhere(['like', 'link', $this->link]);

        return $dataProvider;
    }
}
