<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "payment_voucher".
 *
 * @property int $id
 * @property string $ejari
 * @property string $main_license
 * @property string $noc
 * @property string $service_cost
 * @property string $service_receipt
 * @property string $voucher_attachment
 * @property int $status
 * @property int $CB
 * @property string $date
 * @property string $next_step
 * @property string $comment
 */
class PaymentVoucher extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_voucher';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_cost'], 'number'],
            [['status', 'CB'], 'integer'],
            [['date'], 'safe'],
            [['comment'], 'string'],
            [['ejari', 'main_license', 'noc', 'service_receipt', 'voucher_attachment', 'next_step'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ejari' => 'Ejari',
            'main_license' => 'Main License',
            'noc' => 'Noc',
            'service_cost' => 'Service Cost',
            'service_receipt' => 'Service Receipt',
            'voucher_attachment' => 'Voucher Attachment',
            'status' => 'Status',
            'CB' => 'C B',
            'date' => 'Date',
            'next_step' => 'Next Step',
            'comment' => 'Comment',
        ];
    }
}
