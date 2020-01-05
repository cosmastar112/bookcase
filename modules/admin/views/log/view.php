<h1>Лог значений действия</h1>
<?php
    use yii\grid\GridView;

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
                'value' => 'id'
            ],
            [
                'attribute' => 'id_log_action',
                'value' => 'id_log_action'
            ],
            [
                'attribute' => 'field_name',
                'value' => 'field_name'
            ],
            [
                'attribute' => 'old_value',
                'value' => 'old_value'
            ],
            [
                'attribute' => 'new_value',
                'value' => 'new_value'
            ]
        ];
    }
?>