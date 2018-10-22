<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "service_cheque_details".
 *
 * @property int $id
 * @property int $type 1=>Multiple, 2=>One Time
 * @property int $appointment_id
 * @property int $appointment_service_id
 * @property int $service_id
 * @property string $cheque_number
 * @property string $cheque_date
 * @property double $amount
 * @property int $status 1=>Clear, 2=> Bounced
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class ServiceChequeDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service_cheque_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'appointment_id', 'appointment_service_id', 'service_id', 'status', 'CB', 'UB'], 'integer'],
            [['cheque_date', 'DOC', 'DOU'], 'safe'],
            [['amount'], 'number'],
            [['cheque_number'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'appointment_id' => 'Appointment ID',
            'appointment_service_id' => 'Appointment Service ID',
            'service_id' => 'Service ID',
            'cheque_number' => 'Cheque Number',
            'cheque_date' => 'Cheque Date',
            'amount' => 'Amount',
            'status' => 'Status',
            'CB' => 'C B',
            'UB' => 'U B',
            'DOC' => 'D O C',
            'DOU' => 'D O U',
        ];
    }
}
