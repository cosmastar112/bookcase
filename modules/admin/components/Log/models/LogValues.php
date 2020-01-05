<?php

namespace app\modules\admin\components\Log\models;

use Yii;

/**
 * This is the model class for table "log_values".
 *
 * @property int $id
 * @property int $id_log_action
 * @property string $field_name
 * @property string|null $old_value
 * @property string $new_value
 */
class LogValues extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log_values';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_log_action', 'field_name', 'new_value'], 'required'],
            [['id_log_action'], 'integer'],
            [['field_name'], 'string', 'max' => 25],
            [['old_value', 'new_value'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_log_action' => 'Id Log Action',
            'field_name' => 'Field Name',
            'old_value' => 'Old Value',
            'new_value' => 'New Value',
        ];
    }
}
