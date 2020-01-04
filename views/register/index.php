<h2>Регистр</h2>
<?php
    use yii\grid\GridView;

    // поля таблицы
    $columns = getColumns();

    echo GridView::widget([
        'dataProvider' => $registerProvider,
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
                'attribute' => 'book_id',
                'value' => 'book.title'
            ],
            [
                'attribute' => 'date_start',
                'value' => 'date_start'
            ],
            [
                'attribute' => 'date_end',
                'value' => 'date_end'
            ]
        ];
    }

?>

