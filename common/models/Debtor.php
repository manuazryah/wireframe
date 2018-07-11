<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "debtor".
 *
 * @property int $id
 * @property string $company_name
 * @property string $reference_code
 * @property string $email
 * @property string $phone_number
 * @property string $address
 * @property string $contact_person
 * @property string $contact_person_email
 * @property string $contact_person_phone
 * @property int $nationality
 * @property string $comment
 * @property string $TRN
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property Country $nationality0
 */
class Debtor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'debtor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reference_code', 'email', 'contact_person', 'contact_person_email', 'TRN','company_name','phone_number','address','nationality'], 'required'],
            [['address', 'comment'], 'string'],
            [['nationality', 'status', 'CB', 'UB'], 'integer'],
            [['DOC', 'DOU'], 'safe'],
            [['company_name'], 'string', 'max' => 200],
            [['reference_code', 'email', 'contact_person', 'contact_person_email', 'TRN'], 'string', 'max' => 100],
            [['phone_number', 'contact_person_phone'], 'string', 'max' => 25],
            [['nationality'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['nationality' => 'id']],
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
            'contact_person_email' => 'Contact Person Email',
            'contact_person_phone' => 'Contact Person Phone',
            'nationality' => 'Nationality',
            'comment' => 'Comment',
            'TRN' => 'T R N',
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
    public function getNationality0()
    {
        return $this->hasOne(Country::className(), ['id' => 'nationality']);
    }
}
