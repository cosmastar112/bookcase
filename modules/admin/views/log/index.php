<h1>Логи</h1>
<?php
    use yii\grid\GridView;

    echo GridView::widget([
        'dataProvider' => $logDataProvider
    ]);
?>