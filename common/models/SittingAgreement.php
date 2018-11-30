<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sitting_agreement".
 *
 * @property int $id
 * @property int $appointment_id
 * @property string $company_name
 * @property string $represented_by
 * @property string $date
 * @property string $office_no
 * @property string $office_address
 * @property string $location
 * @property string $activity
 * @property string $contract_start_date
 * @property string $contract_end_date
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class SittingAgreement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sitting_agreement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['appointment_id', 'status', 'CB', 'UB'], 'integer'],
            [['date', 'contract_start_date', 'contract_end_date', 'DOC', 'DOU'], 'safe'],
            [['company_name', 'represented_by', 'office_address'], 'string', 'max' => 255],
            [['office_no', 'location', 'activity'], 'string', 'max' => 100],
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
            'company_name' => 'Company Name',
            'represented_by' => 'Represented By',
            'date' => 'Date',
            'office_no' => 'Office No',
            'office_address' => 'Office Address',
            'location' => 'Location',
            'activity' => 'Activity',
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
