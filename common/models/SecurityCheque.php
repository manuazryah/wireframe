<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "security_cheque".
 *
 * @property int $id
 * @property int $appointment_id
 * @property string $cheque_no
 * @property string $cheque_date
 * @property double $amount
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class SecurityCheque extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'security_cheque';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['appointment_id', 'status', 'CB', 'UB'], 'integer'],
            [['cheque_date', 'DOC', 'DOU'], 'safe'],
            [['amount'], 'number'],
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
            'appointment_id' => 'Appointment ID',
            'cheque_no' => 'Cheque No',
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
