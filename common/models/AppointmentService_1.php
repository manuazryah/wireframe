<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "appointment_service".
 *
 * @property int $id
 * @property int $appointment_id
 * @property int $service
 * @property string $comment
 * @property string $amount
 * @property int $tax
 * @property int $type
 * @property string $total
 * @property int $tax_percentage
 * @property string $tax_amount
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class AppointmentService extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'appointment_service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['service'], 'required'],
            [['appointment_id', 'service', 'tax', 'type', 'tax_percentage', 'status', 'CB', 'UB'], 'integer'],
            [['comment'], 'string'],
            [['amount', 'total', 'tax_amount'], 'number'],
            [['DOC', 'DOU'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'appointment_id' => 'Appointment ID',
            'service' => 'Service',
            'comment' => 'Comment',
            'amount' => 'Amount',
            'tax' => 'Tax',
            'type' => 'Type',
            'total' => 'Total',
            'tax_percentage' => 'Tax Percentage',
            'tax_amount' => 'Tax Amount',
            'status' => 'Status',
            'CB' => 'C B',
            'UB' => 'U B',
            'DOC' => 'D O C',
            'DOU' => 'D O U',
        ];
    }

}
