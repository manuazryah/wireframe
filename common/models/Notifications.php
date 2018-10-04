<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "notifications".
 *
 * @property int $id
 * @property int $data_id
 * @property int $master_id
 * @property int $notification_type 1=>real_estate_cheque_expiry,2->account_cheque_expiry,3->appointment_generation
 * @property string $notification_content
 * @property string $date
 * @property int $status
 * @property string $doc
 */
class Notifications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notifications';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data_id', 'master_id', 'notification_type', 'status'], 'integer'],
            [['notification_content'], 'string'],
            [['date', 'doc'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'data_id' => 'Data ID',
            'master_id' => 'Master ID',
            'notification_type' => 'Notification Type',
            'notification_content' => 'Notification Content',
            'date' => 'Date',
            'status' => 'Status',
            'doc' => 'Doc',
        ];
    }
}
