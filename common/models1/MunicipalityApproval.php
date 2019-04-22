<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "municipality_approval".
 *
 * @property int $id
 * @property int $licensing_master_id
 * @property string $online_reference_no
 * @property string $online_application_fee
 * @property string $payment_receipt
 * @property int $status
 * @property int $CB
 * @property string $date
 * @property string $next_step
 * @property string $comment
 */
class MunicipalityApproval extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'municipality_approval';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['licensing_master_id', 'status', 'CB'], 'integer'],
            [['online_application_fee'], 'number'],
            [['date'], 'safe'],
            [['comment'], 'string'],
            [['online_reference_no', 'payment_receipt'], 'string', 'max' => 100],
            [['next_step'], 'string', 'max' => 200],
            [['online_application_fee', 'online_reference_no'], 'required'],
            [['payment_receipt'], 'required', 'on' => 'create'],
            [['payment_receipt'], 'file', 'extensions' => 'png, jpg, jpeg, gif, bmp, pdf, doc, docx'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'licensing_master_id' => 'Licensing Master ID',
            'online_reference_no' => 'Online Reference No',
            'online_application_fee' => 'Online Application Fee',
            'payment_receipt' => 'Payment Receipt',
            'status' => 'Status',
            'CB' => 'C B',
            'date' => 'Date',
            'next_step' => 'Next Step',
            'comment' => 'Comment',
        ];
    }

}
