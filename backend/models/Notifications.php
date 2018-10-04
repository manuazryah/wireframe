<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notifications".
 *
 * @property int $id
 * @property string $notification_type
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
            [['notification_content'], 'string'],
            [['date', 'doc'], 'safe'],
            [['status'], 'integer'],
            [['notification_type'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'notification_type' => 'Notification Type',
            'notification_content' => 'Notification Content',
            'date' => 'Date',
            'status' => 'Status',
            'doc' => 'Doc',
        ];
    }
}
