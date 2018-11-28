<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "side_agreement".
 *
 * @property int $id
 * @property int $appointment_id
 * @property string $date
 * @property string $company_name
 * @property string $represented_by
 * @property string $office_no
 * @property string $offfice_address
 * @property string $activity
 * @property double $payment
 * @property string $office_statrt_date
 * @property string $office_end_date
 * @property string $payment_details
 * @property double $sponsor_amount
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class SideAgreement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'side_agreement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['appointment_id', 'status', 'CB', 'UB'], 'integer'],
            [['date', 'office_statrt_date', 'office_end_date', 'DOC', 'DOU'], 'safe'],
            [['payment', 'sponsor_amount'], 'number'],
            [['payment_details'], 'string'],
            [['company_name', 'represented_by', 'offfice_address', 'activity'], 'string', 'max' => 255],
            [['office_no'], 'string', 'max' => 100],
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
            'date' => 'Date',
            'company_name' => 'Company Name',
            'represented_by' => 'Represented By',
            'office_no' => 'Office No',
            'offfice_address' => 'Offfice Address',
            'activity' => 'Activity',
            'payment' => 'Payment',
            'office_statrt_date' => 'Office Statrt Date',
            'office_end_date' => 'Office End Date',
            'payment_details' => 'Payment Details',
            'sponsor_amount' => 'Sponsor Amount',
            'status' => 'Status',
            'CB' => 'C B',
            'UB' => 'U B',
            'DOC' => 'D O C',
            'DOU' => 'D O U',
        ];
    }
}
