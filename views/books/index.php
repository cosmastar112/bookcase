<h2>Книги</h2>
<?php
    use yii\grid\GridView;

    // поля таблицы
    $columns = getColumns();

    echo GridView::widget([
        'dataProvider' => $booksProvider,
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
                'attribute' => 'title',
                'value' => 'title'
            ],
            [
            	// автор
                'attribute' => 'author_id',
                'value' => 'author.name'
            ],
        ];
    }

?>

