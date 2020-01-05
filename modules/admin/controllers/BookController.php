<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Book;
use app\modules\admin\models\Author;
use app\modules\admin\models\BookSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\modules\admin\components\Log\Log;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Book models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Book model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Создать модель книги (Book).
     * Если создание прошло успешно, происходит перенаправление на страницу 'view'.
     * Иначе рендерится форма ввода с ошибкой, при этом введенные ранее поля формы 
     * заполняются.
     *
     * Описание алгоритма:
     * Сначала проверяется поле "Название книги": ошибка возникает если книга уже 
     * существует. В случае успеха проверяется имя автора книги: если автор не 
     * существует, выводится ошибка. Попытка сохранения модели предпринимается при 
     * соблюдении условий: книга НЕ СУЩЕСТВУЕТ и автор СУЩЕСТВУЕТ
     *
     * В модели Book создано поле author_name, которого нет в таблице в БД.
     * Значение этого параметра передается вместе формой и используется для поиска
     * значения, которое будет загружено в модель и в дальнейшем сохранено.
     *
     * @return mixed
     */
    public function actionCreate() 
    {
        $model = new Book();

        $params = Yii::$app->request->post('Book');

        if (isset($params)) {

            // Проверяю значение поля формы с названием книги
            $title = $params['title'];
            // Есть книга с таким названием в таблице в БД?
            $isBookExist = Book::find()
                ->where(['title' => $title])
                ->one();

            // Если книга уже есть в таблице, возвращаю ошибку
            if ($isBookExist !== null) {
                $err = "Книга '{$title}' уже существует в таблице";
                // передаю ранее введенные в форму значения для повторного заполнения
                // полей формы после рендеринга ошибки
                $formParams = $this->getFormParams($title, $params['author_name']);
                return $this->renderCreateError($model, $err, $formParams);
            }

            // Ищу автора по введенному имени
            $authorId = $this->getAuthorId($params['author_name']);
            if ($authorId === null) {
                // Возвращаю ошибку если автор не был найден 
                $err = "Не найдено автора по имени '{$params['author_name']}'";
                // передаю ранее введенные в форму значения для повторного заполнения
                // полей формы после рендеринга ошибки
                $formParams = $this->getFormParams($title, $params['author_name']);
                return $this->renderCreateError($model, $err, $formParams);
            }

            // Если автор найден
            $params['author_id'] = $authorId;
            // var_dump($params);
            // загружаю значение (ID автора) в модель
            $model->attributes = $params;
            // и возвращаю результат сохранения модели
            return $this->saveModelResult($model, null /* для логирования */);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Вывести представление 'create' с ошибкой, а также передать значения 
     * введенных ранее полей 
     *
     * @param app\modules\admin\models\Book $model
     * @param string $err
     * @param array $formParams
     *
     * @return string The rendering resul
     */
    private function renderCreateError($model, $err, $formParams) 
    {
        return $this->render('create', [
            'model' => $model,
            'error' => [
                'descr' => $err,
                'form' => $formParams,
            ]
        ]);
    }

    /**
     * Вывести представление 'update' с ошибкой, а также передать значения 
     * введенных ранее полей 
     * @param app\modules\admin\models\Book $model
     * @param string $err
     * @param array $formParams
     *
     * @return string The rendering resul
     */
    private function renderUpdateError($model, $err, $formParams) 
    {
        return $this->render('update', [
            'model' => $model,
            'error' => [
                'descr' => $err,
                'form' => $formParams,
            ]
        ]);
    }

    /**
     * Произвести операцию сохранения модели и вернуть ответ
     *
     * @param app\modules\admin\models\Book $model
     * @param null|array старые значения модели для логирования 
     *
     * @return yii\web\Response
     */
    private function saveModelResult($model, $oldValues) 
    {
        if ($model->save()) {

            // логируемое действие: изменение или создание записи
            $logAction = $oldValues ? 2 : 1;
            // логирование сохранения модели книги
            Log::log('Book', $logAction, $model->id, $oldValues, $model->toArray());

            return $this->redirect([
                'view', 
                'id' => $model->id
            ]);
        } else {
            // TODO: сделать вывод ошибки на странице
            return json_encode($model->errors, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Создать массив введенных ранее значений формы для повторного заполнения 
     * формы при появлении ошибки.
     *
     * @param string $title
     * @param string $author
     *
     * @return array
     */
    private function getFormParams($title, $author) 
    {
        $formParams = [
            'title' => $title,
            'author_name' => $author
        ];
        return $formParams;
    }

    /**
     * Получить ID автора по его имени (точное совпадение)
     *
     * @param string $author имя автора
     *
     * @example getAuthorId("Александр Дюма"); // => 2
     *
     * @return integer|null
     */
    private function getAuthorId($author) 
    {
        $author = Author::find()
            ->select('id')
            ->where([ 'name' => $author ])
            ->one();

        if ($author !== null) {
            return $author->id;
        }
        return null;
    }

    /**
     * Получить имя автора по его ID (точное совпадение)
     *
     * @param string $author имя автора
     *
     * @example getAuthorName(2); // => "Александр Дюма"
     *
     * @return integer|null
     */
    private function getAuthorName($authorId) 
    {
        $author = Author::find()
            ->select('name')
            ->where([ 'id' => $authorId ])
            ->one();

        if ($author !== null) {
            return $author->name;
        }
        return null;
    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $params = Yii::$app->request->post('Book');

        // Обновление модели
        if (isset($params)) {

            // Проверяю значение поля формы с названием книги
            $title = $params['title'];
            // Есть книга с таким названием в таблице в БД?
            $existingBook = Book::find()
                ->where(['title' => $title])
                ->one();

            // Если книга с таким названием уже есть в таблице, и при этом она не 
            // равна самой себе (название было изменено), возвращаю ошибку.
            // Если название книги осталось прежним, ошибка не будет возвращена.
            if ($existingBook !== null && $model->title !== $existingBook->title) {
                $err = "Книга '{$title}' уже существует в таблице";
                // передаю ранее введенные в форму значения для повторного заполнения
                // полей формы после рендеринга ошибки
                $formParams = $this->getFormParams($title, $params['author_name']);
                return $this->renderUpdateError($model, $err, $formParams);
            }

            // Ищу автора по введенному имени
            $authorId = $this->getAuthorId($params['author_name']);
            if ($authorId === null) {
                // Возвращаю ошибку если автор не был найден 
                $err = "Не найдено автора по имени '{$params['author_name']}'";
                // передаю ранее введенные в форму значения для повторного заполнения
                // полей формы после рендеринга ошибки
                $formParams = $this->getFormParams($title, $params['author_name']);
                return $this->renderUpdateError($model, $err, $formParams);
            }

            // Если автор найден
            $params['author_id'] = $authorId;
            // var_dump($params);
            // старые значения модели для логирования
            $oldValues = $model->toArray();
            // загружаю значение (ID автора) в модель
            $model->attributes = $params;
            // и возвращаю результат сохранения модели
            return $this->saveModelResult($model, $oldValues);
        }

        // Подстановка имени автора в соответствующее поле формы (вместо ID)
        $author_name = $this->getAuthorName($model->author_id);

        return $this->render('update', [
            'model' => $model,
            'author_name' => $author_name
        ]);
    }

    /**
     * Deletes an existing Book model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        // логирование удаления записи о книге
        Log::log('Book', 3, $id, null, null);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
