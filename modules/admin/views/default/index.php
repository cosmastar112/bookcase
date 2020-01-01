<div class="admin-default-index">
<?php 
    use yii\helpers\Html;
    use yii\helpers\Url;

    $authors = Html::tag('a', 'Авторы', [ 
        'href' => Url::toRoute('author/index')
    ]);

    $books = Html::tag('a', 'Книги', [ 
        'href' => Url::toRoute('book/index')
    ]);

    echoLink($authors);
    echoLink($books);

    /**
     * Выводит строку, оборачивая вывод в тэг <p>
     * 
     * @param {string} $a 
     */
    function echoLink($a)
    {
        echo Html::beginTag('p');
        echo $a;
        echo Html::endTag('p');
    }
?>
</div>