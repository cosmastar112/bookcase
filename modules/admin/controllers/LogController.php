<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use app\modules\admin\components\Log\models\LogActions;
use app\modules\admin\components\Log\models\LogValues;

class LogController extends Controller
{
    public function actionIndex()
    {
        $query = LogActions::find();

        $logDataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20
            ]
        ]);

        return $this->render('index', [
            'logDataProvider' => $logDataProvider
        ]);
    }

    public function actionView($id)
    {
        $query = LogValues::find()->where(['id_log_action' => $id]);

        $logDataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20
            ]
        ]);

        return $this->render('view', [
            'logDataProvider' => $logDataProvider
        ]);
    }
}

?>