<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "licence".
 *
 * @property int $id
 * @property int $licensing_master_id
 * @property string $payment_for_voucher
 * @property string $licence_attachment
 * @property string $expiry_date
 * @property int $status
 * @property int $CB
 * @property string $date
 * @property string $next_step
 * @property string $comment
 */
class Licence extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'licence';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['licensing_master_id', 'status', 'CB'], 'integer'],
            [['payment_for_voucher'], 'number'],
            [['expiry_date', 'date'], 'safe'],
            [['comment'], 'string'],
            [['licence_attachment', 'next_step'], 'string', 'max' => 100],
            [['payment_for_voucher', 'expiry_date'], 'required'],
            [['licence_attachment'], 'required', 'on' => 'create'],
            [['licence_attachment'], 'file', 'extensions' => 'png, jpg, jpeg, gif, bmp, pdf, doc, docx'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'licensing_master_id' => 'Licensing Master ID',
            'payment_for_voucher' => 'Payment For Voucher',
            'licence_attachment' => 'Licence Attachment',
            'expiry_date' => 'Expiry Date',
            'status' => 'Status',
            'CB' => 'C B',
            'date' => 'Date',
            'next_step' => 'Next Step',
            'comment' => 'Comment',
        ];
    }

}
