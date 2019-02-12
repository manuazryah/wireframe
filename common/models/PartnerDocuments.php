<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partner_documents".
 *
 * @property int $id
 * @property int $appointment_id
 * @property string $document_name
 * @property int $partner
 * @property string $file
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class PartnerDocuments extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'partner_documents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['appointment_id', 'partner', 'status', 'CB', 'UB'], 'integer'],
            [['DOC', 'DOU'], 'safe'],
            [['document_name', 'partner'], 'required'],
            [['document_name'], 'string', 'max' => 100],
            [['file'], 'string', 'max' => 255],
            [['file'], 'required', 'on' => 'create'],
            [['file'], 'file', 'extensions' => 'jpg, png,jpeg,pdf,txt,doc,docx'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'appointment_id' => 'Appointment ID',
            'document_name' => 'Document',
            'partner' => 'Partner',
            'file' => 'File',
            'status' => 'Status',
            'CB' => 'C B',
            'UB' => 'U B',
            'DOC' => 'D O C',
            'DOU' => 'D O U',
        ];
    }

}
