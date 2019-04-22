<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "appointment".
 *
 * @property int $id
 * @property int $customer
 * @property int $service_type
 * @property int $plot
 * @property int $space_for_license
 * @property string $service_id
 * @property string $estimated_cost
 * @property int $sponsor
 * @property int $tax
 * @property int $supplier
 * @property string $comment
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property Debtor $customer0
 * @property AppointmentServices $serviceType
 * @property RealEstateDetails $plot0
 * @property RealEstateDetails $spaceForLicense
 * @property Sponsor $sponsor0
 * @property Tax $tax0
 */
class Appointment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'appointment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer', 'service_type','sponsor'], 'required'],
            [['customer', 'service_type', 'plot', 'space_for_license', 'sponsor', 'tax', 'supplier', 'status', 'CB', 'UB'], 'integer'],
            [['estimated_cost'], 'number'],
            [['DOC', 'DOU'], 'safe'],
            [['service_id'], 'string', 'max' => 100],
            [['comment'], 'string', 'max' => 1000],
            [['customer'], 'exist', 'skipOnError' => true, 'targetClass' => Debtor::className(), 'targetAttribute' => ['customer' => 'id']],
            [['service_type'], 'exist', 'skipOnError' => true, 'targetClass' => AppointmentServices::className(), 'targetAttribute' => ['service_type' => 'id']],
            [['plot'], 'exist', 'skipOnError' => true, 'targetClass' => RealEstateDetails::className(), 'targetAttribute' => ['plot' => 'id']],
            [['space_for_license'], 'exist', 'skipOnError' => true, 'targetClass' => RealEstateDetails::className(), 'targetAttribute' => ['space_for_license' => 'id']],
            [['sponsor'], 'exist', 'skipOnError' => true, 'targetClass' => Sponsor::className(), 'targetAttribute' => ['sponsor' => 'id']],
            [['tax'], 'exist', 'skipOnError' => true, 'targetClass' => Tax::className(), 'targetAttribute' => ['tax' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer' => 'Customer',
            'service_type' => 'Service Type',
            'plot' => 'Plot',
            'space_for_license' => 'Space For License',
            'service_id' => 'Service ID',
            'estimated_cost' => 'Estimated Cost',
            'sponsor' => 'Sponsor',
            'tax' => 'Tax',
            'supplier' => 'Supplier',
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
    public function getCustomer0()
    {
        return $this->hasOne(Debtor::className(), ['id' => 'customer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceType()
    {
        return $this->hasOne(AppointmentServices::className(), ['id' => 'service_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlot0()
    {
        return $this->hasOne(RealEstateDetails::className(), ['id' => 'plot']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpaceForLicense()
    {
        return $this->hasOne(RealEstateDetails::className(), ['id' => 'space_for_license']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSponsor0()
    {
        return $this->hasOne(Sponsor::className(), ['id' => 'sponsor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTax0()
    {
        return $this->hasOne(Tax::className(), ['id' => 'tax']);
    }
}
