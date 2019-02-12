<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partner_details".
 *
 * @property int $id
 * @property int $appointment_id
 * @property string $name
 * @property string $email
 * @property string $phone_no
 * @property string $address
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class PartnerDetails extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'partner_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['appointment_id', 'status', 'CB', 'UB'], 'integer'],
            [['name', 'email', 'appointment_id', 'phone_no', 'address'], 'required'],
            [['address'], 'string'],
            [['DOC', 'DOU'], 'safe'],
            [['email'], 'email'],
            [['name'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 255],
            [['phone_no'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'appointment_id' => 'Appointment ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone_no' => 'Phone No',
            'address' => 'Address',
            'status' => 'Status',
            'CB' => 'C B',
            'UB' => 'U B',
            'DOC' => 'D O C',
            'DOU' => 'D O U',
        ];
    }

}
