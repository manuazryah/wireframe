<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "service_payment".
 *
 * @property int $id
 * @property int $appointment_id
 * @property int $transaction_type
 * @property string $transaction_no
 * @property string $amount
 * @property string $cheque_no
 * @property string $date
 * @property string $comment
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class ServicePayment extends \yii\db\ActiveRecord {

	/**
	 * {@inheritdoc}
	 */
	public static function tableName() {
		return 'service_payment';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules() {
		return [
			[['transaction_type', 'status', 'CB', 'UB', 'appointment_id'], 'integer'],
			[['amount'], 'number'],
			[['date', 'DOC', 'DOU'], 'safe'],
			[['comment'], 'string'],
			[['transaction_no', 'cheque_no'], 'string', 'max' => 100],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels() {
		return [
		    'id' => 'ID',
		    'transaction_type' => 'Transaction Type',
		    'transaction_no' => 'Transaction No',
		    'amount' => 'Amount',
		    'cheque_no' => 'Cheque No',
		    'date' => 'Date',
		    'comment' => 'Comment',
		    'status' => 'Status',
		    'CB' => 'C B',
		    'UB' => 'U B',
		    'DOC' => 'D O C',
		    'DOU' => 'D O U',
		];
	}

}
