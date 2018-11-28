<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "real_estate_details".
 *
 * @property int $id
 * @property int $master_id
 * @property int $category 1->license , 2->plots
 * @property string $code
 * @property int $availability 0=>'occupied',1=>'not occupied'
 * @property int $customer_id
 * @property string $cost
 * @property double $rent_cost
 * @property double $off_rent
 * @property string $square_feet
 * @property string $comment
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property Appointment[] $appointments
 * @property Appointment[] $appointments0
 * @property RealEstateMaster $master
 */
class RealEstateDetails extends \yii\db\ActiveRecord {

    public $customer;
    public $appointment;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'real_estate_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['type', 'master_id', 'category', 'availability', 'customer_id', 'square_feet', 'status', 'CB', 'UB'], 'integer'],
            [['cost', 'rent_cost', 'off_rent'], 'number'],
            [['comment'], 'string'],
            [['DOC', 'DOU', 'code'], 'safe'],
            [['master_id'], 'exist', 'skipOnError' => true, 'targetClass' => RealEstateMaster::className(), 'targetAttribute' => ['master_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'master_id' => 'Master ID',
            'category' => 'Category',
            'code' => 'Code',
            'availability' => 'Availability',
            'customer_id' => 'Customer ID',
            'cost' => 'Cost',
            'rent_cost' => 'Rent Cost',
            'off_rent' => 'Off Rent',
            'square_feet' => 'Square Feet',
            'comment' => 'Comment',
            'status' => 'Status',
            'CB' => 'C B',
            'UB' => 'U B',
            'DOC' => 'D O C',
            'DOU' => 'D O U',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppointments() {
        return $this->hasMany(Appointment::className(), ['plot' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppointments0() {
        return $this->hasMany(Appointment::className(), ['space_for_license' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaster() {
        return $this->hasOne(RealEstateMaster::className(), ['id' => 'master_id']);
    }

}
