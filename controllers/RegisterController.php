<?php

namespace app\controllers;

use yii\web\Controller;
use yii\data\ActiveDataProvider;

use app\modules\admin\models\Register;

class RegisterController extends Controller 
{
    /**
     * Главная страница
     */
    public function actionIndex() 
    {
        $registerProvider = new ActiveDataProvider([
            'query' => Register::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'registerProvider' => $registerProvider
        ]);
    }
}

?>