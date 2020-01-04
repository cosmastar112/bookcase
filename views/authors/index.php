<h2>Авторы</h2>
<?php
    use yii\grid\GridView;

    // поля таблицы
    $columns = getColumns();

    echo GridView::widget([
        'dataProvider' => $authorsProvider,
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
                'value' => 'id'
            ],
            [
                // автор
                'attribute' => 'name',
                'value' => 'name'
            ],
        ];
    }

?>

