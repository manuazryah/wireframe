<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "side_agreement_adding".
 *
 * @property int $id
 * @property string $second_party_name
 * @property int $represented_by
 * @property string $date
 * @property string $office_no
 * @property string $office_address
 * @property string $location
 * @property string $activity
 * @property double $amount
 * @property string $payment_details
 * @property string $ejari_start_date
 * @property string $ejari_end_date
 * @property int $sponsor_amount
 * @property string $contract_start_date
 * @property string $contract_end_date
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class SideAgreementAdding extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'side_agreement_adding';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['sponsor_amount', 'status', 'CB', 'UB', 'appointment_id'], 'integer'],
            [['date', 'ejari_start_date', 'ejari_end_date', 'contract_start_date', 'contract_end_date', 'DOC', 'DOU'], 'safe'],
            [['amount'], 'number'],
            [['payment_details'], 'string'],
            [['represented_by', 'second_party_name', 'office_address'], 'string', 'max' => 255],
            [['office_no', 'location', 'activity'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'second_party_name' => 'Second Party Name',
            'represented_by' => 'Represented By',
            'date' => 'Date',
            'office_no' => 'Office No',
            'office_address' => 'Office Address',
            'location' => 'Location',
            'activity' => 'Activity',
            'amount' => 'Amount',
            'payment_details' => 'Payment Details',
            'ejari_start_date' => 'Ejari Start Date',
            'ejari_end_date' => 'Ejari End Date',
            'sponsor_amount' => 'Sponsor Amount',
            'contract_start_date' => 'Contract Start Date',
            'contract_end_date' => 'Contract End Date',
            'status' => 'Status',
            'CB' => 'C B',
            'UB' => 'U B',
            'DOC' => 'D O C',
            'DOU' => 'D O U',
        ];
    }

}
