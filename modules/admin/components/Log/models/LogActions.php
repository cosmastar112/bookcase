<?php

namespace app\modules\admin\components\Log\models;

use Yii;

/**
 * This is the model class for table "log_actions".
 *
 * @property int $id
 * @property int $user
 * @property string $date
 * @property string $section
 * @property int $action 1 - create, 2- update, 3 - delete
 * @property int $model_id
 */
class LogActions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log_actions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user', 'date', 'section', 'action', 'model_id'], 'required'],
            [['user', 'action', 'model_id'], 'integer'],
            [['date'], 'safe'],
            [['section'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'User',
            'date' => 'Date',
            'section' => 'Section',
            'action' => 'Action',
            'model_id' => 'Model ID',
        ];
    }
}
