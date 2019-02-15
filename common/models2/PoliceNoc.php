<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "police_noc".
 *
 * @property int $id
 * @property int $licensing_master_id
 * @property string $passport_copy
 * @property string $payment
 * @property string $receipt
 * @property string $certificate
 * @property int $status
 * @property int $CB
 * @property string $date
 * @property string $next_step
 * @property string $comment
 */
class PoliceNoc extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'police_noc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['licensing_master_id', 'status', 'CB'], 'integer'],
            [['payment'], 'number'],
            [['date'], 'safe'],
            [['comment'], 'string'],
            [['passport_copy', 'receipt', 'certificate'], 'string', 'max' => 100],
            [['next_step'], 'string', 'max' => 200],
            [['payment'], 'required'],
            [['passport_copy', 'receipt', 'certificate'], 'required', 'on' => 'create'],
            [['passport_copy', 'receipt', 'certificate'], 'file', 'extensions' => 'png, jpg, jpeg, gif, bmp, pdf, doc, docx'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'licensing_master_id' => 'Licensing Master ID',
            'passport_copy' => 'Passport Copy',
            'payment' => 'Payment',
            'receipt' => 'Receipt',
            'certificate' => 'Certificate',
            'status' => 'Status',
            'CB' => 'C B',
            'date' => 'Date',
            'next_step' => 'Next Step',
            'comment' => 'Comment',
        ];
    }

}
