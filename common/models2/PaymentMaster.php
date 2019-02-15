<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "payment_master".
 *
 * @property int $id
 * @property int $appointment_id
 * @property double $total_amount
 * @property double $amount_paid
 * @property double $balance_amount
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class PaymentMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['appointment_id', 'status', 'CB', 'UB'], 'integer'],
            [['total_amount', 'amount_paid', 'balance_amount'], 'number'],
            [['DOC', 'DOU'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'appointment_id' => 'Appointment ID',
            'total_amount' => 'Total Amount',
            'amount_paid' => 'Amount Paid',
            'balance_amount' => 'Balance Amount',
            'status' => 'Status',
            'CB' => 'C B',
            'UB' => 'U B',
            'DOC' => 'D O C',
            'DOU' => 'D O U',
        ];
    }
}
