<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "new_stamp".
 *
 * @property int $id
 * @property int $licensing_master_id
 * @property string $payment
 * @property string $receipt
 * @property int $status
 * @property int $CB
 * @property string $date
 * @property string $next_step
 * @property string $comment
 */
class NewStamp extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'new_stamp';
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
            [['receipt', 'next_step'], 'string', 'max' => 100],
            [['payment'], 'required'],
            [['receipt'], 'required', 'on' => 'create'],
            [['receipt'], 'file', 'extensions' => 'png, jpg, jpeg, gif, bmp, pdf, doc, docx'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'licensing_master_id' => 'Licensing Master ID',
            'payment' => 'Payment',
            'receipt' => 'Receipt',
            'status' => 'Status',
            'CB' => 'C B',
            'date' => 'Date',
            'next_step' => 'Next Step',
            'comment' => 'Comment',
        ];
    }

}
