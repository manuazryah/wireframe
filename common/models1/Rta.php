<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "rta".
 *
 * @property int $id
 * @property int $licensing_master_id
 * @property string $online_refrerence_number
 * @property string $online_application_fees
 * @property string $payment_receipt
 * @property string $rta_approval_fees
 * @property string $approval_fees_receipt
 * @property string $approval_certificate
 * @property int $CB
 * @property string $date
 * @property string $next_step
 * @property string $comment
 */
class Rta extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'rta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['licensing_master_id', 'CB'], 'integer'],
            [['online_application_fees', 'rta_approval_fees'], 'number'],
            [['date'], 'safe'],
            [['comment'], 'string'],
            [['online_refrerence_number'], 'string', 'max' => 200],
            [['payment_receipt', 'approval_fees_receipt', 'approval_certificate', 'next_step'], 'string', 'max' => 100],
            [['online_refrerence_number', 'online_application_fees', 'rta_approval_fees'], 'required'],
            [['payment_receipt', 'approval_fees_receipt', 'approval_certificate'], 'required', 'on' => 'create'],
            [['payment_receipt', 'approval_fees_receipt', 'approval_certificate'], 'file', 'extensions' => 'png, jpg, jpeg, gif, bmp, pdf, doc, docx'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'licensing_master_id' => 'Licensing Master ID',
            'online_refrerence_number' => 'Online Refrerence Number',
            'online_application_fees' => 'Online Application Fees',
            'payment_receipt' => 'Payment Receipt',
            'rta_approval_fees' => 'Rta Approval Fees',
            'approval_fees_receipt' => 'Approval Fees Receipt',
            'approval_certificate' => 'Approval Certificate',
            'CB' => 'C B',
            'date' => 'Date',
            'next_step' => 'Next Step',
            'comment' => 'Comment',
        ];
    }

}
