<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Register;
use app\modules\admin\models\Book;
use app\modules\admin\models\RegisterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\modules\admin\components\Log\Log;

/**
 * RegisterController implements the CRUD actions for Register model.
 */
class RegisterController extends Controller
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
     * Lists all Register models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RegisterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Register model.
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
     * Creates a new Register model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Register();

        $params = Yii::$app->request->post('Register');
        // var_dump($params);
        if ( isset($params) ) {

            // Искать книгу по введенному имени
            $bookId = $this->getBookId($params['book_title']);
            // var_dump($params['book_title']);

            if ($bookId === null) {
                // Вернуть ошибку если книга не была найдена
                $err = "Не найдено книги с названием '{$params['book_title']}'";
                // найти введенные раннее значения полей формы
                $formParams = $this->getFormParams($params['book_title'], $params['date_start'], $params['date_end']);
                return $this->renderCreateError($model, $err, $formParams);
            }

            // привести даты к формату, который можно сохранить в БД 
            $date_start = $this->formatDateToDBFormat($params['date_start']);
            $date_end = $this->formatDateToDBFormat($params['date_end']);
            // var_dump($date_start);
            // var_dump($date_end);
            // var_dump($date_start > $date_end);
            // Вывести ошибку в случае если дата прочтения меньше даты начала чтения
            if ($date_start > $date_end) {
                $err = 'Дата прочтения должна быть меньше даты начала чтения';
                // найти введенные раннее значения полей формы
                $formParams = $this->getFormParams($params['book_title'], $params['date_start'], $params['date_end']);
                return $this->renderCreateError($model, $err, $formParams);
            }

            // Загрузить данные в модель
            $updatedParams = [
                'book_id' => $bookId,
                'date_start' => $date_start,
                'date_end' => $date_end,
                'book_title' => 'mock'
            ];
            $model->attributes = $updatedParams;
            // и вернуть результат сохранения модели
            return $this->saveModelResult($model, null /* для логирования */ );
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Произвести операцию сохранения модели и вернуть ответ
     *
     * @param app\modules\admin\models\Register $model
     *
     * @return yii\web\Response
     */
    private function saveModelResult($model, $oldValues) 
    {
        if ($model->save()) {

            // логируемое действие: изменение или создание записи
            $logAction = $oldValues ? 2 : 1;
            // логирование сохранения модели книги
            Log::log('Register', $logAction, $model->id, $oldValues, $model->toArray());

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
     * Привести формат даты к формату, который может быть сохранен в БД
     * date => 'YYYY-MM-DD'
     *
     * @param string $date
     *
     * @return string
     */
    private function formatDateToDBFormat($date)
    {
        $dateObject = date_create($date);
        $dateInDBFormat = date_format($dateObject, 'Y-m-d');
        return $dateInDBFormat;
    }

    /**
     * Привести формат даты к формату, который может быть отображен в форме
     * date => 'DD-MM-YYYY'
     *
     * @param string $date
     *
     * @return string
     */
    private function formatDateToViewFormat($date)
    {
        // var_dump($date);
        $dateObject = date_create($date);
        $dateInDBFormat = date_format($dateObject, 'd-m-Y');
        return $dateInDBFormat;
    }

    /**
     * Вывести представление 'create' с ошибкой, а также передать значения 
     * введенных ранее полей 
     *
     * @param app\modules\admin\models\Register $model
     * @param string $err
     * @param array $formParams
     *
     * @return string The rendering result
     */
    private function renderCreateError($model, $err, $formParams)
    {
        return $this->render('create', [
            'model' => $model,
            'error' => [
                'descr' => $err,
                'form' => $formParams
            ]
        ]);
    }

    /**
     * Вывести представление 'update' с ошибкой, а также передать значения 
     * введенных ранее полей 
     *
     * @param app\modules\admin\models\Register $model
     * @param string $err
     * @param array $formParams
     *
     * @return string The rendering result
     */
    private function renderUpdateError($model, $err, $formParams)
    {
        return $this->render('update', [
            'model' => $model,
            'error' => [
                'descr' => $err,
                'form' => $formParams
            ]
        ]);
    }

    /**
     * Создать массив введенных ранее значений формы для повторного заполнения 
     * формы при появлении ошибки.
     *
     * @param string $title
     * @param string $date_start
     * @param string $date_end
     *
     * @return array
     */
    private function getFormParams($title, $date_start, $date_end) 
    {
        $formParams = [
            'book_title' => $title,
            'date_start' => $date_start,
            'date_end' => $date_end
        ];
        return $formParams;
    }

    /**
     * Получить ID книги по её названию (точное совпадение)
     *
     * @param string $book название книги
     *
     * @return integer|null
     */
    private function getBookId($book) {
        $book = Book::find()
            ->select('id')
            ->where(['title' => $book])
            ->one();
        if ($book !== null) {
            return $book->id;
        }
        return null;
    }

    /**
     * Получить название книги по её ID (точное совпадение)
     *
     * @param string $book ID книги
     *
     * @return integer|null
     */
    private function getBookTitle($book) {
        $book = Book::find()
            ->select('title')
            ->where(['id' => $book])
            ->one();
        if ($book !== null) {
            return $book->title;
        }
        return null;
    }

    /**
     * Updates an existing Register model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $params = Yii::$app->request->post('Register');

        if ( isset($params) ) {
      
            // Проверить название книги
            $book_title = $params['book_title'];
            // Есть книга с таким названием в таблице в БД?
            $existingBook = Book::find()
                ->where(['title' => $book_title])
                ->one();

            // Запомнить ID книги
            $bookId = $existingBook->id;

            // Если книга с таким названием уже есть в таблице, и при этом она не 
            // равна самой себе (название было изменено), вернуть ошибку.
            if ($existingBook !== null && $model->book_id !== $existingBook->id) {
                $err = "Книга '{$book_title}' уже существует в таблице";
                // передать ранее введенные в форму значения для повторного заполнения
                // после рендеринга ошибки
                $formParams = $this->getFormParams($params['book_title'], $params['date_start'], $params['date_end']);
                return $this->renderUpdateError($model, $err, $formParams);
            }

            // В случае если книги с таким названием нет в таблице
            if ($bookId === null) {
                // вернуть ошибку
                $err = "Не найдено книги с названием '{$params['book_title']}'";
                // найти введенные раннее значения полей формы
                $formParams = $this->getFormParams($params['book_title'], $params['date_start'], $params['date_end']);
                return $this->renderUpdateError($model, $err, $formParams);
            }

            // Если название книги осталось прежним, не возвращать ошибку.
            // Привести даты к формату, который можно сохранить в БД 
            $date_start = $this->formatDateToDBFormat($params['date_start']);
            $date_end = $this->formatDateToDBFormat($params['date_end']);
            // Вывести ошибку в случае если дата прочтения меньше даты начала чтения
            if ($date_start > $date_end) {
                $err = 'Дата прочтения должна быть меньше даты начала чтения';
                // найти введенные раннее значения полей формы
                $formParams = $this->getFormParams($params['book_title'], $params['date_start'], $params['date_end']);
                return $this->renderUpdateError($model, $err, $formParams);
            }

            // Загрузить данные в модель
            $updatedParams = [
                'book_id' => $bookId,
                'date_start' => $date_start,
                'date_end' => $date_end,
                'book_title' => 'mock'
            ];
            // старые значения модели для логирования
            $old_values = $model->toArray();
            $model->attributes = $updatedParams;
            // и вернуть результат сохранения модели
            return $this->saveModelResult($model, $old_values);
        }

        // Подставить название книги в соответствующее поле формы (вместо ID)
        $book_title = $this->getBookTitle($model->book_id);
        // привести даты к формату, который можно подставить в поля формы
        $date_start = $this->formatDateToViewFormat($model->date_start);
        $date_end = $this->formatDateToViewFormat($model->date_end);

        return $this->render('update', [
            'model' => $model,
            'params' => [
                'book_title' => $book_title,
                'date_start' => $date_start,
                'date_end' => $date_end
            ]
        ]);
    }

    /**
     * Deletes an existing Register model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        // логирование удаления записи о книге
        Log::log('Register', 3, $id, null, null);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Register model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Register the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Register::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
