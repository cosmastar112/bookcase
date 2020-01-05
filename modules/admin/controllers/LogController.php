<?php
namespace app\modules\admin\controllers;

use yii\web\Controller;
use yii\data\ActiveDataProvider;
use app\modules\admin\components\Log\models\LogActions;

class LogController extends Controller
{
    public function actionIndex()
    {
        $logDataProvider = new ActiveDataProvider([
            'query' => LogActions::find(),
            'pagination' => [
                'pageSize' => 20
            ]
        ]);

        return $this->render('index', [
            'logDataProvider' => $logDataProvider
        ]);
    }
}

?>