<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "payment_master".
 *
 * @property int $id
 * @property int $appointment_id
 * @property double $total_amount
 * @property double $amount_paid
 * @property double $balance_amount
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class ChequeFiles extends \yii\db\ActiveRecord {

    public $cheque_files;
    public $appointment_id;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['appointment_id'], 'integer'],
            [['cheque_files'], 'required'],
            [['cheque_files'], 'file', 'extensions' => 'png, jpg, jpeg, pdf, doc, docx', 'maxFiles' => 100, 'skipOnEmpty' => true],
        ];
    }

}
