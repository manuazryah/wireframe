<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "others".
 *
 * @property int $id
 * @property int $licensing_master_id
 * @property string $personal_detail
 * @property string $online_refrerence_number
 * @property string $online_application_fees
 * @property string $payment_receipt
 * @property string $sira_approval_fees
 * @property string $approval_fees_receipt
 * @property string $police_report
 * @property string $approval_certificate
 * @property int $CB
 * @property string $date
 * @property string $next_step
 * @property string $comment
 */
class Others extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'others';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['licensing_master_id', 'CB'], 'integer'],
            [['online_application_fees', 'sira_approval_fees'], 'number'],
            [['date'], 'safe'],
            [['comment'], 'string'],
            [['personal_detail', 'online_refrerence_number'], 'string', 'max' => 200],
            [['payment_receipt', 'approval_fees_receipt', 'police_report', 'approval_certificate', 'next_step'], 'string', 'max' => 100],
            [['online_refrerence_number', 'online_application_fees', 'sira_approval_fees'], 'required'],
            [['payment_receipt', 'approval_fees_receipt', 'police_report', 'approval_certificate'], 'required', 'on' => 'create'],
            [['payment_receipt', 'approval_fees_receipt', 'police_report', 'approval_certificate'], 'file', 'extensions' => 'png, jpg, jpeg, gif, bmp, pdf, doc, docx'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'licensing_master_id' => 'Licensing Master ID',
            'personal_detail' => 'Personal Detail',
            'online_refrerence_number' => 'Online Refrerence Number',
            'online_application_fees' => 'Online Application Fees',
            'payment_receipt' => 'Payment Receipt',
            'sira_approval_fees' => 'SIRA Approval Fees',
            'approval_fees_receipt' => 'Approval Fees Receipt',
            'police_report' => 'Police Report',
            'approval_certificate' => 'Approval Certificate',
            'CB' => 'C B',
            'date' => 'Date',
            'next_step' => 'Next Step',
            'comment' => 'Comment',
        ];
    }

}
