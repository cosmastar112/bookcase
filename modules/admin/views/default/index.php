<div class="admin-default-index">
<?php 
    use yii\helpers\Html;
    use yii\helpers\Url;

    echo Html::tag('a', 'Авторы', [ 
        'href' => Url::toRoute('author/index')
    ]);
?>
</div>
