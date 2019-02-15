<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "payment_details".
 *
 * @property int $id
 * @property int $master_id
 * @property int $appointment_id
 * @property int $payment_type 1->cash, 2->cheque
 * @property string $cheque_no
 * @property string $cheque_date
 * @property double $amount
 * @property string $comment
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class PaymentDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['master_id', 'appointment_id', 'payment_type', 'status', 'CB', 'UB'], 'integer'],
            [['cheque_date', 'DOC', 'DOU'], 'safe'],
            [['amount'], 'number'],
            [['comment'], 'string'],
            [['cheque_no'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'master_id' => 'Master ID',
            'appointment_id' => 'Appointment ID',
            'payment_type' => 'Payment Type',
            'cheque_no' => 'Cheque No',
            'cheque_date' => 'Cheque Date',
            'amount' => 'Amount',
            'comment' => 'Comment',
            'status' => 'Status',
            'CB' => 'C B',
            'UB' => 'U B',
            'DOC' => 'D O C',
            'DOU' => 'D O U',
        ];
    }
}
