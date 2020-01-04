<?php

namespace app\controllers;

use yii\web\Controller;
use yii\data\ActiveDataProvider;

use app\modules\admin\models\Author;

class AuthorsController extends Controller 
{
    /**
     * Главная страница
     */
    public function actionIndex() 
    {
        $authorsProvider = new ActiveDataProvider([
            'query' => Author::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'authorsProvider' => $authorsProvider
        ]);
    }
}

?>