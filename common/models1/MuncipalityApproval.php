<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "muncipality_approval".
 *
 * @property int $id
 * @property int $licencing_master_id
 * @property string $online_reference_number
 * @property string $online_application_fees
 * @property string $payment_receipt
 * @property int $status
 * @property int $CB
 * @property string $date
 * @property string $next_step
 * @property string $comment
 */
class MuncipalityApproval extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'muncipality_approval';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['licencing_master_id', 'status', 'CB'], 'integer'],
            [['online_application_fees'], 'number'],
            [['date'], 'safe'],
            [['comment'], 'string'],
            [['online_reference_number'], 'string', 'max' => 250],
            [['payment_receipt'], 'string', 'max' => 100],
            [['next_step'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'licencing_master_id' => 'Licencing Master ID',
            'online_reference_number' => 'Online Reference Number',
            'online_application_fees' => 'Online Application Fees',
            'payment_receipt' => 'Payment Receipt',
            'status' => 'Status',
            'CB' => 'C B',
            'date' => 'Date',
            'next_step' => 'Next Step',
            'comment' => 'Comment',
        ];
    }
}
