<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "services".
 *
 * @property int $id
 * @property int $service_category
 * @property int $type
 * @property string $service_name
 * @property string $service_code
 * @property string $supplier
 * @property string $estimated_cost
 * @property int $tax_id
 * @property int $tax_percentage
 * @property string $comment
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class Services extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'services';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_category', 'type', 'service_name', 'service_code'], 'required'],
            [['service_category', 'type', 'tax_id', 'tax_percentage', 'status', 'CB', 'UB'], 'integer'],
            [['estimated_cost'], 'number'],
            [['comment'], 'string'],
            [['DOC', 'DOU'], 'safe'],
            [['service_name', 'service_code', 'supplier'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'service_category' => 'Service Category',
            'type' => 'Type',
            'service_name' => 'Service Name',
            'service_code' => 'Service Code',
            'supplier' => 'Supplier',
            'estimated_cost' => 'Estimated Cost',
            'tax_id' => 'Tax',
            'tax_percentage' => 'Tax Percentage',
            'comment' => 'Comment',
            'status' => 'Status',
            'CB' => 'C B',
            'UB' => 'U B',
            'DOC' => 'D O C',
            'DOU' => 'D O U',
        ];
    }
}
