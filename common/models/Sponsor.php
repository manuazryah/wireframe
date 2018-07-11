<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sponsor".
 *
 * @property int $id
 * @property string $name
 * @property string $reference_code
 * @property string $email
 * @property string $phone_number
 * @property string $address
 * @property string $comment
 * @property string $emirate_id
 * @property string $passport
 * @property string $family_book
 * @property string $photo
 * @property string $others
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class Sponsor extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'sponsor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['address', 'comment'], 'string'],
                [['status', 'CB', 'UB'], 'integer'],
                [['DOC', 'DOU'], 'safe'],
                [['name', 'reference_code', 'email', 'phone_number', 'address'], 'required'],
                [['name', 'reference_code', 'email', 'emirate_id', 'passport', 'family_book', 'photo', 'others'], 'string', 'max' => 100],
                [['phone_number'], 'string', 'max' => 25],
                [['emirate_id'], 'file', 'extensions' => 'jpg, png,jpeg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'reference_code' => 'Reference Code',
            'email' => 'Email',
            'phone_number' => 'Phone Number',
            'address' => 'Address',
            'comment' => 'Comment',
            'emirate_id' => 'Emirate ID',
            'passport' => 'Passport',
            'family_book' => 'Family Book',
            'photo' => 'Photo',
            'others' => 'Others',
            'status' => 'Status',
            'CB' => 'C B',
            'UB' => 'U B',
            'DOC' => 'D O C',
            'DOU' => 'D O U',
        ];
    }

}
