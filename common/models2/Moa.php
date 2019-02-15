<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "moa".
 *
 * @property int $id
 * @property int $licensing_master_id
 * @property string $aggrement
 * @property string $typing_fee
 * @property string $court_fee
 * @property string $moa_document
 * @property int $status
 * @property int $CB
 * @property string $date
 * @property string $next_step
 * @property string $comment
 */
class Moa extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'moa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['licensing_master_id', 'status', 'CB'], 'integer'],
            [['typing_fee', 'court_fee'], 'required'],
            [['aggrement', 'moa_document'], 'required', 'on' => 'create'],
            [['typing_fee', 'court_fee'], 'number'],
            [['date'], 'safe'],
            [['comment'], 'string'],
            [['aggrement', 'moa_document'], 'string', 'max' => 100],
            [['next_step'], 'string', 'max' => 200],
            [['aggrement', 'moa_document'], 'file', 'extensions' => 'png, jpg, jpeg, gif, bmp, pdf, doc, docx'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'licensing_master_id' => 'Licensing Master ID',
            'aggrement' => 'Aggrement',
            'typing_fee' => 'Typing Fee',
            'court_fee' => 'Court Fee',
            'moa_document' => 'Moa Document',
            'status' => 'Status',
            'CB' => 'C B',
            'date' => 'Date',
            'next_step' => 'Next Step',
            'comment' => 'Comment',
        ];
    }

}
