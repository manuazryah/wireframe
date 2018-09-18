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
 * @property int $payment_type 1=>'yearly',2=>'halfly',3=>'quarterly',4=>'monthly
 * @property string $due_amount
 * @property string $amount_paid
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
			[['appointment_id', 'service', 'tax', 'type', 'tax_percentage', 'payment_type', 'status', 'CB', 'UB'], 'integer'],
			[['comment'], 'string'],
			[['amount', 'total', 'tax_amount', 'amount_paid'], 'number'],
			[['DOC', 'DOU'], 'safe'],
			[['due_amount'], 'string', 'max' => 100],
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
		    'payment_type' => 'Payment Type',
		    'due_amount' => 'Due Amount',
		    'amount_paid' => 'Amount Paid',
		    'status' => 'Status',
		    'CB' => 'C B',
		    'UB' => 'U B',
		    'DOC' => 'D O C',
		    'DOU' => 'D O U',
		];
	}

}
