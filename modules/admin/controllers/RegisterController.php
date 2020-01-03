<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Register;
use app\modules\admin\models\RegisterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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

            $bookId = $params['book_id'];

            // привожу даты к формату, который можно сохранить в БД 
            $date_start = $this->formatDateToDBFormat($params['date_start']);
            $date_end = $this->formatDateToDBFormat($params['date_end']);
            // var_dump($date_start);
            // var_dump($date_end);
            // var_dump($date_start > $date_end);
            // Выводить ошибку в случае если дата прочтения меньше даты начала чтения
            if ($date_start > $date_end) {
                $err = 'Дата прочтения должна быть меньше даты начала чтения';
                // введенные раннее значения полей формы
                $formParams = $this->getFormParams($bookId, $params['date_start'], $params['date_end']);
                return $this->renderCreateError($model, $err, $formParams);
            }

            // Загрузить данные в модель
            $updatedParams = [
                'book_id' => $bookId,
                'date_start' => $date_start,
                'date_end' => $date_end
            ];
            $model->attributes = $updatedParams;
            // и вернуть результат сохранения модели
            $this->saveModelResult($model);
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
    private function saveModelResult($model) {
        if ($model->save()) {
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
     * @return yii\web\Response
     */
    private function formatDateToDBFormat($date)
    {
        $dateObject = date_create($date);
        $dateInDBFormat = date_format($dateObject, 'Y-m-d');
        return $dateInDBFormat;
    }

    /**
     * Вывести представление 'create' с ошибкой, а также передать значения 
     * введенных ранее полей 
     * @param app\modules\admin\models\Register $model
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
            'book_id' => $title,
            'date_start' => $date_start,
            'date_end' => $date_end
        ];
        return $formParams;
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
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
