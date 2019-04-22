<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sales_payment".
 *
 * @property int $id
 * @property int $salesman
 * @property int $appointment_id
 * @property int $customer_id
 * @property double $amount
 * @property double $balance
 * @property int $type 1=> Credit , 2 => Debit
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class SalesPayment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sales_payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['salesman', 'appointment_id', 'customer_id', 'type', 'status', 'CB', 'UB'], 'integer'],
            [['amount', 'balance'], 'number'],
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
            'salesman' => 'Salesman',
            'appointment_id' => 'Appointment ID',
            'customer_id' => 'Customer ID',
            'amount' => 'Amount',
            'balance' => 'Balance',
            'type' => 'Type',
            'status' => 'Status',
            'CB' => 'C B',
            'UB' => 'U B',
            'DOC' => 'D O C',
            'DOU' => 'D O U',
        ];
    }
}
