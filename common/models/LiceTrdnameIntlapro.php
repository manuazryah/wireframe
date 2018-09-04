<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lice_trdname_intlapro".
 *
 * @property int $id
 * @property int $licensing_master_id
 * @property string $payment_amount
 * @property string $payment_receipt
 * @property string $certificate
 * @property int $status
 * @property int $CB
 * @property string $date
 * @property string $next_step
 * @property string $sponsor_family_book
 * @property string $comment
 */
class LiceTrdnameIntlapro extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'lice_trdname_intlapro';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['licensing_master_id', 'status', 'CB'], 'integer'],
            [['payment_amount'], 'required'],
            [['payment_receipt', 'certificate', 'sponsor_family_book'], 'required', 'on' => 'create'],
            [['payment_amount'], 'number'],
            [['date'], 'safe'],
            [['comment'], 'string'],
            [['payment_receipt', 'certificate', 'sponsor_family_book'], 'string', 'max' => 100],
            [['next_step'], 'string', 'max' => 200],
            [['payment_receipt', 'certificate', 'sponsor_family_book'], 'file', 'extensions' => 'png, jpg, jpeg, gif, bmp, pdf, doc, docx'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'licensing_master_id' => 'Licensing Master ID',
            'payment_amount' => 'Payment Amount',
            'payment_receipt' => 'Payment Receipt',
            'certificate' => 'Certificate',
            'status' => 'Status',
            'CB' => 'C B',
            'date' => 'Date',
            'next_step' => 'Next Step',
            'sponsor_family_book' => 'Sponsor Family Book',
            'comment' => 'Comment',
        ];
    }

}
