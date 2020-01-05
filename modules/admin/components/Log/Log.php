<?php

namespace app\modules\admin\components\Log;

use app\modules\admin\components\Log\models\LogActions;
use app\modules\admin\components\Log\models\LogValues;

class Log
{
    public static function log($section, $action, $modelId, $values)
    {
        return self::logAction($section, $modelId, $action);
    }

    // $action = 1; // =>'create'
    private static function logAction($section, $modelId, $action)
    {
        $model = new LogActions();
    
        $model->user = 0;    // 0 - 'default'
        $model->date = self::formatDateTimeToDBFormat();
        $model->section = $section;
        $model->model_id = $modelId;
        $model->action = $action;
    
        if ($model->validate() && $model->save()) {
            return true;
        }
    
        // var_dump($model->errors());
        return $model->getErrorSummary(true);
        // return false;
    }

    /**
     * Привести формат даты к формату, который может быть сохранен в БД
     * date => 'YYYY-MM-DD HH:MM:SS'
     *
     * @return string
     */
    private static function formatDateTimeToDBFormat()
    {
        $dateInDBFormat = date('Y-m-d H:i:s');
        return $dateInDBFormat;
    }
}

?>