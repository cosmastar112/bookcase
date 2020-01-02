<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Book;
use app\modules\admin\models\Author;
use app\modules\admin\models\BookSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
     * Параметр author в POST-массиве используется для поиска значения, которое 
     * будет загружено в модель и в дальнейшем сохранено.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Book();

        $params = Yii::$app->request->post();
        // var_dump($params);

        // Проверяю значение поля формы, в котором хранится название книги
        $title = $params['Book']['title'];
        $isBookExist = Book::find()
            ->where(['title' => $title])
            ->one();

        // Если книга уже есть в таблице, возвращаю ошибку
        if ($isBookExist !== null) {
            $err = "Книга '{$title}' уже существует в таблице";
            // значения введенных полей для заполнения полей формы после ошибки
            if ( isset($params['author']) ) {
                $formParams = $this->getFormParams($title, $params['author']);
            }
            // вывод формы с ошибкой; также передаю значения введенных ранее полей
            return $this->renderError($model, $err, $formParams);
        }
        // var_dump($isBookExist);

        // Проверяю значение поля формы, в котором хранится имя автора
        if (isset($params['author']) && $params['author'] !== '') {
            // Получаю код автора (если есть)
            $authorId = $this->getAuthorId($params['author']);

            if ($authorId !== null) {
                // Подстановка результата
                $params['Book']['author_id'] = $authorId;
                // var_dump($params['Book']);

                // Загружаю данные в модель
                $model->attributes = $params['Book'];
                // сохраняю модель и возвращаю ответ
                return $this->saveModel($model);
            } else {
                // В случае если автор не был найден вернуть ошибку
                $err = "Не найдено автора по имени '{$params['author']}'";
                // значения введенных ранее полей
                $formParams = $this->getFormParams($title, $params['author']);
                // вывод формы с ошибкой;также передаю значений введенных ранее полей
                return $this->renderError($model, $err, $formParams);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
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
            'author' => $author
        ];
        return $formParams;
    }

    /**
     * Вывод формы с ошибкой, а также передача значений введенных ранее полей
     *
     * @param app\modules\admin\models\Book $model
     * @param string $err
     * @param array $formParams
     *
     * @return string The rendering resul
     */
    private function renderError($model, $err, $formParams) 
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
     * Произвести операцию сохранения модели и вернуть ответ
     *
     * @param app\modules\admin\models\Book $model
     *
     * @return yii\web\Response
     */
    private function saveModel($model) 
    {
        if ($model->save()) {
            return $this->redirect([
                'view', 
                'id' => $model->id
            ]);
        }

        return $this->redirect([
            'view', 
            'id' => $model->id,
            'error' => 'Ошибка при сохранении результата'
        ]);
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
        $authorId = Author::find()
            ->select('id')
            ->where([ 'name' => $author ])
            ->one();

        if ($authorId !== null) {
            return $authorId->id;
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
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
