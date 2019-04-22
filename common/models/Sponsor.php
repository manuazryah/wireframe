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

    public $total;
    public $paid;
    public $balance;

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
            [['DOC', 'DOU', 'yearly_charge', 'emirate_id_expiry', 'passport_expiry', 'family_book_expiry'], 'safe'],
            [['name', 'email', 'phone_number', 'address', 'yearly_charge'], 'required'],
            [['name', 'reference_code', 'email', 'emirate_id', 'passport', 'family_book', 'photo'], 'string', 'max' => 100],
            [['phone_number'], 'string', 'max' => 25],
            [['emirate_id', 'passport', 'family_book', 'photo'], 'file', 'extensions' => 'jpg, gif, png, jpeg, pdf, txt, doc, docx'],
            [['others'], 'file', 'extensions' => 'jpg, gif, png, jpeg, pdf, txt, doc, docx', 'maxFiles' => 100],
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
            'yearly_charge' => 'Yearly Charge',
            'CB' => 'C B',
            'UB' => 'U B',
            'DOC' => 'D O C',
            'DOU' => 'D O U',
        ];
    }

    public static function getTotal($id) {
        if ($id != '') {
            $sponsor_total = SponsorPayment::find()->where(['sponsor_id' => $id, 'type' => 1])->sum('amount');
            if ($sponsor_total < 1) {
                $sponsor_total = 0;
            }
        } else {
            $sponsor_total = 0;
        }
        return $sponsor_total;
    }

    public static function getPaid($id) {
        if ($id != '') {
            $paid_total = SponsorPayment::find()->where(['sponsor_id' => $id, 'type' => 2])->sum('amount');
            if ($paid_total < 1) {
                $paid_total = 0;
            }
        } else {
            $paid_total = 0;
        }
        return $paid_total;
    }

    public static function getBalance($id) {
        if ($id != '') {
            $sponsor_total = SponsorPayment::find()->where(['sponsor_id' => $id, 'type' => 1])->sum('amount');
            $paid_total = SponsorPayment::find()->where(['sponsor_id' => $id, 'type' => 2])->sum('amount');
            $sponsor_balance = $sponsor_total - $paid_total;
        } else {
            $sponsor_balance = 0;
        }
        return $sponsor_balance;
    }

}
