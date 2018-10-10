<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "service_cheque_details".
 *
 * @property int $id
 * @property int $appointment_id
 * @property int $service_id
 * @property string $cheque_number
 * @property string $cheque_date
 * @property string $amount
 * @property int $status 1=>Clear, 2=> Bounced
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property AppointmentService $service
 */
class ServiceChequeDetails extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'service_cheque_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['appointment_id', 'service_id', 'status', 'CB', 'UB'], 'integer'],
            [['cheque_date', 'DOC', 'DOU'], 'safe', 'type'],
            [['amount'], 'number'],
            [['cheque_number'], 'string', 'max' => 100],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => AppointmentService::className(), 'targetAttribute' => ['service_id' => 'service']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'appointment_id' => 'Appointment ID',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService() {
        return $this->hasOne(AppointmentService::className(), ['id' => 'service_id']);
    }

}
