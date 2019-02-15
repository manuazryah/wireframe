<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cheque_details".
 *
 * @property int $id
 * @property int $master_id
 * @property string $cheque_no
 * @property string $due_date
 * @property string $amount
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property RealEstateMaster $master
 */
class ChequeDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cheque_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['master_id', 'status', 'CB', 'UB'], 'integer'],
            [['due_date', 'DOC', 'DOU'], 'safe'],
            [['amount'], 'number'],
            [['cheque_no'], 'string', 'max' => 200],
            [['master_id'], 'exist', 'skipOnError' => true, 'targetClass' => RealEstateMaster::className(), 'targetAttribute' => ['master_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'master_id' => 'Master ID',
            'cheque_no' => 'Cheque No',
            'due_date' => 'Due Date',
            'amount' => 'Amount',
            'status' => 'Status',
            'CB' => 'C B',
            'UB' => 'U B',
            'DOC' => 'D O C',
            'DOU' => 'D O U',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaster()
    {
        return $this->hasOne(RealEstateMaster::className(), ['id' => 'master_id']);
    }
}
