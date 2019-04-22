<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "licencing_master".
 *
 * @property int $id
 * @property int $appointment_id
 * @property string $appointment_no
 * @property int $customer_id
 * @property int $sponsor
 * @property int $plot
 * @property int $space_for_licence
 * @property int $no_of_partners
 * @property int $status
 * @property string $stage
 * @property string $comment
 * @property int $CB
 * @property string $DOC
 */
class LicencingMaster extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'licencing_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['appointment_id', 'customer_id', 'sponsor', 'plot', 'space_for_licence', 'no_of_partners', 'status', 'CB'], 'integer'],
            [['DOC'], 'safe'],
            [['appointment_no', 'stage', 'comment'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'appointment_id' => 'Appointment ID',
            'appointment_no' => 'Appointment No',
            'customer_id' => 'Customer',
            'sponsor' => 'Sponsor',
            'plot' => 'Plot',
            'space_for_licence' => 'Space For Licence',
            'no_of_partners' => 'No Of Partners',
            'status' => 'Status',
            'stage' => 'Stage',
            'comment' => 'Comment',
            'CB' => 'C B',
            'DOC' => 'D O C',
        ];
    }

}
