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
 * @property int $customer_id
 * @property int $availability
 * @property string $cost
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property RealEstateMaster $master
 */
class RealEstateDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'real_estate_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['master_id', 'category', 'customer_id', 'availability', 'status', 'CB', 'UB'], 'integer'],
            [['cost'], 'number'],
            [['DOC', 'DOU'], 'safe'],
            [['code'], 'string', 'max' => 100],
            [['master_id'], 'exist', 'skipOnError' => true, 'targetClass' => RealEstateMaster::className(), 'targetAttribute' => ['master_id' => 'id']],
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
            'category' => 'Category',
            'code' => 'Code',
            'customer_id' => 'Customer ID',
            'availability' => 'Availability',
            'cost' => 'Cost',
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
    public function getMaster()
    {
        return $this->hasOne(RealEstateMaster::className(), ['id' => 'master_id']);
    }
}
