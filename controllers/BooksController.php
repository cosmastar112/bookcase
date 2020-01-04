<?php

namespace app\controllers;

use yii\web\Controller;
use yii\data\ActiveDataProvider;

use app\modules\admin\models\Book;

class BooksController extends Controller 
{
    /**
     * Главная страница
     */
    public function actionIndex() 
    {
        $booksProvider = new ActiveDataProvider([
            'query' => Book::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'booksProvider' => $booksProvider
        ]);
    }
}

?>