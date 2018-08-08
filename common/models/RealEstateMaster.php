<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "real_estate_master".
 *
 * @property int $id
 * @property int $company
 * @property string $reference_code
 * @property string $total_square_feet
 * @property int $sponsor
 * @property string $comany_name_for_ejari
 * @property int $number_of_license
 * @property int $number_of_plots
 * @property string $comment
 * @property string $rent_total
 * @property int $no_of_cheques
 * @property string $commission
 * @property string $deposit
 * @property string $sponser_fee
 * @property string $furniture_expense
 * @property string $office_renovation_expense
 * @property string $other_expense
 * @property string $attachments
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property CompanyManagement $company0
 * @property Sponsor $sponsor0
 */
class RealEstateMaster extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'real_estate_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['company', 'total_square_feet', 'sponsor', 'number_of_license', 'number_of_plots', 'reference_code', 'comany_name_for_ejari'], 'required'],
            [['company', 'total_square_feet', 'sponsor', 'number_of_license', 'number_of_plots', 'no_of_cheques', 'status', 'CB', 'UB'], 'integer'],
            [['comment'], 'string'],
            [['rent_total', 'commission', 'deposit', 'sponser_fee', 'furniture_expense', 'office_renovation_expense', 'other_expense'], 'number'],
            [['DOC', 'DOU'], 'safe'],
            [['aggrement', 'ejari', 'cheque_copy'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, pdf, doc, docx'],
            [['reference_code', 'comany_name_for_ejari'], 'string', 'max' => 500],
            [['company'], 'exist', 'skipOnError' => true, 'targetClass' => CompanyManagement::className(), 'targetAttribute' => ['company' => 'id']],
            [['sponsor'], 'exist', 'skipOnError' => true, 'targetClass' => Sponsor::className(), 'targetAttribute' => ['sponsor' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'company' => 'Company',
            'reference_code' => 'Reference Code',
            'total_square_feet' => 'Total Square Feet',
            'sponsor' => 'Sponsor',
            'comany_name_for_ejari' => 'Comany Name For Ejari',
            'number_of_license' => 'Number Of License',
            'number_of_plots' => 'Number Of Plots',
            'comment' => 'Comment',
            'rent_total' => 'Rent Total',
            'no_of_cheques' => 'No Of Cheques',
            'commission' => 'Commission',
            'deposit' => 'Deposit',
            'sponser_fee' => 'Sponser Fee',
            'furniture_expense' => 'Furniture Expense',
            'office_renovation_expense' => 'Office Renovation Expense',
            'other_expense' => 'Other Expense',
            'attachments' => 'Attachments',
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
    public function getCompany0() {
        return $this->hasOne(CompanyManagement::className(), ['id' => 'company']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSponsor0() {
        return $this->hasOne(Sponsor::className(), ['id' => 'sponsor']);
    }

}
