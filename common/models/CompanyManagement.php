<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company_management".
 *
 * @property int $id
 * @property string $company_name
 * @property string $reference_code
 * @property string $email
 * @property string $phone_number
 * @property string $address
 * @property string $contact_person
 * @property string $comment
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class CompanyManagement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company_management';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address', 'comment'], 'string'],
            [['contact_person','address','company_name','reference_code', 'email','phone_number'], 'required'],
            [['status', 'CB', 'UB'], 'integer'],
            [['DOC', 'DOU'], 'safe'],
            [['company_name'], 'string', 'max' => 200],
            [['reference_code', 'email', 'contact_person'], 'string', 'max' => 100],
            [['phone_number'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_name' => 'Company Name',
            'reference_code' => 'Reference Code',
            'email' => 'Email',
            'phone_number' => 'Phone Number',
            'address' => 'Address',
            'contact_person' => 'Contact Person',
            'comment' => 'Comment',
            'status' => 'Status',
            'CB' => 'C B',
            'UB' => 'U B',
            'DOC' => 'D O C',
            'DOU' => 'D O U',
        ];
    }
}
