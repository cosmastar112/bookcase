<?php

namespace app\modules\admin\components\Log;

use app\modules\admin\components\Log\models\LogActions;
use app\modules\admin\components\Log\models\LogValues;

class Log
{
    /**
     * Логирование действия и значений
     *
     * @param string     $section   логируемый подраздел
     * @param integer    $action    логируемое действие
     * @param integer    $modelId   ID логируемой модели
     * @param null|array $oldValues массив старых значений
     * @param null|array $newValues массив новых значений
     *
     * action = [1|2|3]  1 - create, 2- update, 3 - delete
     *
     * @example: 
     * log('Author', 1, $model->id, null, [ 'name' => 'Дюма']) // => создание записи
     * 
     * @return true|array true или массив ошибок
     */
    public static function log($section, $action, $modelId, $oldValues, $newValues)
    {
        // return 
        $logActionResult = self::logAction($section, $action, $modelId);
        if ( is_int($logActionResult) ) {
            $logValuesResult = self::logValues($logActionResult, $oldValues, $newValues);
            var_dump($logActionResult);
            var_dump($logValuesResult);
        } else {
            // Ошибка валидации или сохранения; TODO: throw exception
            var_dump($logActionResult);
        }
    }

    /**
     * Логирование действия
     *
     * @param string  $section логируемый подраздел
     * @param integer $action  логируемое действие
     * @param integer $modelId ID логируемой модели
     *
     * action = [1|2|3]  1 - create, 2- update, 3 - delete
     * user = 0 (default)
     *
     * @example: logAction('Author', 1, 1) /=> создание записи
     * @example: logAction('Author', 3, 1) /=> удаление записи
     * @return   integer|array ID сохраненной модели или массив ошибок
     */
    private static function logAction($section, $action, $modelId)
    {
        $model = new LogActions();
    
        $model->user = 0;
        $model->date = self::formatDateTimeToDBFormat();
        $model->section = $section;
        $model->model_id = $modelId;
        $model->action = $action;
    
        if ($model->validate() && $model->save()) {
            // ID сохраненной модели
            return $model->id;
        }
    
        // var_dump($model->errors());
        // массив ошибок валидации/сохранения
        return $model->getErrorSummary(true);
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

    /**
     * Логирование значений
     *
     * @param integer    $id_log_action ID связанного логируемого действия
     * @param null|array $oldValues     массив старых значений
     * @param null|array $newValues     массив новых значений
     *
     * @example: logValues(1, null, 'name' => 'Дюма']) /=> создание записи
     * @return   true|array true или массив ошибок
     */
    private static function logValues($id_log_action, $oldValues, $newValues)
    {
        $model = new LogValues();    
        $model->id_log_action = $id_log_action;

        $isCreate = !isset($oldValues) && isset($newValues);
        $isDelete = !isset($oldValues) && !isset($newValues);
        $saveModelResult = null;
        if ($isCreate) {
            $saveModelResult = self::saveModelCreate($model, $newValues, $oldValues);
        } else if ($isDelete) {
            $deleteModelResult = self::saveModelDelete($model, $newValues, $oldValues);
        }
        return $saveModelResult;    
    }

    private static function saveModelCreate($model, $newValues, $oldValues)
    {
        // Логирование значений
        foreach ($newValues as $key => $value) {
            $model->field_name = $key;
            $model->old_value = null;
            $model->new_value = $value;
    
            if ($model->validate() && $model->save()) {
            } else {
                var_dump($model->getErrorSummary(true));
                return $model->getErrorSummary(true);
            }
        }
        return true;
    }

    private static function saveModelDelete($model, $newValues, $oldValues)
    {
        return true;
    }


    // $model->new_value = isset($newValues) ? $value : null
}

?>