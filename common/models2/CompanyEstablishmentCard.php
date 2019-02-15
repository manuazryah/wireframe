<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company_establishment_card".
 *
 * @property int $id
 * @property int $licensing_master_id
 * @property string $license
 * @property string $typing_service
 * @property string $service_reciept
 * @property string $payment
 * @property string $payment_reciept
 * @property string $card_attachment
 * @property string $expiry_date
 * @property int $status
 * @property int $CB
 * @property string $date
 * @property string $next_step
 * @property string $comment
 */
class CompanyEstablishmentCard extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'company_establishment_card';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['licensing_master_id', 'status', 'CB'], 'integer'],
            [['payment'], 'number'],
            [['expiry_date', 'date'], 'safe'],
            [['comment'], 'string'],
            [['typing_service'], 'string', 'max' => 200],
            [['service_reciept', 'payment_reciept', 'card_attachment', 'next_step', 'license'], 'string', 'max' => 100],
            [['typing_service', 'payment', 'expiry_date'], 'required'],
            [['service_reciept', 'payment_reciept', 'card_attachment', 'license'], 'required', 'on' => 'create'],
            [['service_reciept', 'payment_reciept', 'card_attachment', 'license'], 'file', 'extensions' => 'png, jpg, jpeg, gif, bmp, pdf, doc, docx'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'licensing_master_id' => 'Licensing Master ID',
            'license' => 'License',
            'typing_service' => 'Typing Service',
            'service_reciept' => 'Service Reciept',
            'payment' => 'Payment',
            'payment_reciept' => 'Payment Reciept',
            'card_attachment' => 'Card Attachment',
            'expiry_date' => 'Expiry Date',
            'status' => 'Status',
            'CB' => 'C B',
            'date' => 'Date',
            'next_step' => 'Next Step',
            'comment' => 'Comment',
        ];
    }

}
