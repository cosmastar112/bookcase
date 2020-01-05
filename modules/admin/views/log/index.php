<h1>Лог действий</h1>
<?php
    use yii\grid\GridView;
    use yii\helpers\Html;
    use yii\helpers\Url;

    // поля таблицы
    $columns = getColumns();

    echo GridView::widget([
        'dataProvider' => $logDataProvider,
        'columns' => $columns
    ]);

    /*
     * Отображаемые поля в таблице
     *
     * @return array
     */
    function getColumns()
    {
        return [
            [
                'attribute' => 'id',
                // 'value' => 'id'
                'content' => function($model, $key, $index) 
                {
                    // var_dump($key, $index);
                    // Детализация действия
                    return Html::a($key, Url::to(['/admin/log/view', 'id' => $key]));
                }
            ],
            [
                'attribute' => 'user',
                'value' => 'user'
            ],
            [
                'attribute' => 'date',
                'value' => 'date'
            ],
            [
                'attribute' => 'section',
                'value' => 'section'
            ],
            [
                'attribute' => 'action',
                'value' => 'action'
            ],
            [
                'attribute' => 'model_id',
                'value' => 'model_id'
            ]
        ];
    }
?>